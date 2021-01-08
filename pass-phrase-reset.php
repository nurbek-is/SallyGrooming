pass-phrase-reset.php
<?php
  //Require config file for sending mail
  require 'mail-config.php';
  $pageTitle = 'Pass Phrase Reset';// set page title
 //reuireing importing this docs we can use variables from this file.
  require 'includes/header.php';
  //this calls log out function from utilities folder// Ask instruction we don't require it?
  logout();
  $errors = [];// Set empty errors array
 // Set $email to posted email.
  // If form not submitted, set to empty string.
  $email = trim($_POST['email'] ?? '');
?>
<main id="pass-phrase-reset" class="narrow">
<?php
//submit button The form has been submitted
if (isset($_POST['submit'])) { 
  // if filter doesn't pass the validation,display error msg
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'You must enter a valid email.';
  } else {
     // The email is valid.
    // Check if there is a user with that email.
    $selUser = "SELECT first_name, last_name, user_id 
                FROM users WHERE email = ?";
    // try-catch block is needed because we're connecting to database
    try {
      // Prepare and execute query checking for user with email
      $stmt = $db->prepare($selUser);
      $stmt->execute([$email]);
      //storing the result that was fetched from server to $row
      $row = $stmt->fetch(); 
      // $row will contain first_name, last_name, and user_id of user
    } catch (PDOException $e) {
         // There was a problem, probably with the database connection.
      // Log the error.
      logError($e);
      // Add error to $errors to report to user later
      $errors[] = nl2br(POEM_GENERIC_ERROR);
    }
    //if row/selUser has the fetched values, // If $row exists, user matched to email. 
    // Set some simpler variables.
    if (!empty($row)) {
      $userId = $row['user_id'];
      $firstName = $row['first_name'];
      $lastName = $row['last_name'];
       // Generate token, which we will insert into tokens table
      // And email as part of a link to the user.
      $token = generateToken(); 
       // Construct SQL query to insert token associated with this
      // user id and set to expire in one hour.
      $qInsert = "INSERT INTO tokens
        (token, user_id, token_expires)
        VALUES ('$token', ?, DATE_ADD(now(), INTERVAL 1 HOUR))";
      //we prepare qInsert query string in try {} and store in var $stmtInsert
      try {
         // Prepare insert statement
        $stmtInsert = $db->prepare($qInsert);
        // Attempt to execute insert statement
        // If successful, send email with link
        //
        if ($stmtInsert->execute( [$userId] )) {
          // Build pass phrase reset link
          $qs = http_build_query(['token' => $token]);
          $confPath = getFullPath('pass-phrase-reset-confirm.php');
          $href = $confPath . '?' . $qs;
          
          // Set email variables
          $to = $email;
          $toName = $firstName . ' ' . $lastName;
          //assigning 'Pass phrase reset' to $subject var
          $subject = 'Pass phrase reset';
          //creating a reset-pass-phrase request msg and a link using $href and assign to $html
          $html = "<p>A reset-pass-phrase request has been made
          for your account for phppoetry.com. If you didn't make the
          request, you can ignore this email. If you did, reset your
          pass phrase by <a href='$href'>clicking here</a>.</p>";
       
          $text = "A reset-pass-phrase request has been made
          for your account for phppoetry.com. If you didn't make the
          request, you can ignore this email. If you did, visit $href
          to reset your pass phrase.";

          // Set up $mail using createMailer() 
          $mail = createMailer();
          $mail->addAddress($to, $toName);
          $mail->Subject = $subject;
          $mail->Body = $html;
          //adding Altbody and assigning $text var(which has our msg) to it. 
          $mail->AltBody = $text;
          
          // Attempt to send email.
          if (!$mail->send()) {
            // If email fails to send, provide error.
            echo '<p class="error">
              We could not send you a pass-phrase-reset email.</p>';
            echo "Mailer Error: " . $mail->ErrorInfo;
          } else {
            // If email sends, let user know.
            echo '<p class="success">We have sent you an email with
            instructions. Check your email.</p>';
          }
        } else {
        // Likely SQL error. Log and redirect to error page.        
          logError($stmtInsert->errorinfo()[2], true);
        }
      } catch (PDOException $e) {
        // Some database error. Log and report it.
        logError($e);
        $errors[] = nl2br(POEM_GENERIC_ERROR);
      }
      //after if $row was empty and No user with that email address.
    } else {
      
      $errors[] = "Sorry. We don't recognize that email.";
    }
  }
}
// If the form wasn't submitted or we found errors, show the form
if (!isset($_POST['submit']) || $errors) {
// If there are errors, report them.
  if ($errors) {
    echo '<h3>Uh oh!</h3>';
    foreach ($errors as $error) {
      echo "<p class='error'>$error</p>";
    }
  }
// Output the form.
  echo "<p>Use the form below to reset your pass phrase:</p>
  <form method='post' novalidate>
    <label for='email'>Email:</label>
    <input type='email' name='email' id='email'
      value='$email' required> 
    <button name='submit' value='1' class='wide'>
      Reset Pass Phrase</button>
  </form>";
}
?>
</main>
<?php
  require 'includes/footer.php';
?>