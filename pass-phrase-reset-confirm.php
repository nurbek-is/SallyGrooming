<?php
  if (!isset($_REQUEST['token'])) {
     // If there is no token in the $_REQUEST, which
    // includes $_POST and $_GET, redirect to home page.
    header("Location: index.php");
  }
  $pageTitle = 'Reset Password Form';// Set page title
  require 'includes/header.php';// Include header
  logout();// In case a different user has logged in
  $showForm = true; // Default to showing form
?>
<main class="narrow">
<h1><?= $pageTitle ?></h1>
<?php

  if ($showForm && isset($_POST['token'])) {
    // This means they submitted the form
    // Set some simpler variables.
    $token = $_POST['token']; 
    $passPhrase1 = $_POST['pass-phrase-1'];
    $passPhrase2 = $_POST['pass-phrase-2'];
    // Error checking
    if (strlen($passPhrase1) < 20) {
      $error = 'Your pass phrase must be at least 20 characters.';
    } elseif ($passPhrase1 !== $passPhrase2) {
      $error = 'Your pass phrases don\'t match.';
    } else {
      // New pass phrase is good
      $showForm = false;// No need to show it again.
      // Hash pass phrase.
      $hashedPhrase = password_hash($passPhrase1, PASSWORD_DEFAULT);
      
      // Construct update to set new pass phrase for user
      $qUpdate = "UPDATE users
        SET pass_phrase = '$hashedPhrase',
          registration_confirmed = 1
        WHERE user_id = (SELECT user_id
                        FROM tokens
                        WHERE token = ?
                          AND token_expires > now() );";
      // try-catch block is needed because we're connecting to database
      try {
        // prepare update
        $stmtUpdate = $db->prepare($qUpdate);
        // Attempt to execute update statement
        if ($stmtUpdate->execute( [$token] )) {
          // If successful, provide link to log in.
          echo "<span class='success'>Success. 
            <a href='login.php'>Login</a></span>";
        } else {
          // Token expired between open and submit of form
          // Redirect to error page
          logError($stmtUpdate->errorinfo()[2], true); 
        }
      } catch (PDOException $e) {
        // Some database error. Log and report it.
        logError($e);
        $error = nl2br(POEM_GENERIC_ERROR) .
          '<p><a href="pass-phrase-reset.php">try again</a></p>';
      }
    }
  } elseif ($showForm) {
    // $_GET['token'] must exist
    // This means they got here via the link sent to their email
    $token = $_GET['token'];

  // Construct select statement to check if unexpired token exists
    $qSelect = "SELECT * 
      FROM tokens 
      WHERE token = ? AND token_expires > now()";

  // try-catch block is needed because we're connecting to database
    try {
      // Prepare and execute select statement.
      $stmt = $db->prepare($qSelect);
      $stmt->execute([$token]);
  //No unexpired matching token
      if (!$stmt->fetch()) {
        $error = nl2br(POEM_INVALID_TOKEN_PASS_PHRASE_RESET);
        $showForm = false;
      }
    } catch (PDOException $e) {
      // Some database error. Log and report it.
      logError($e);
      $error = nl2br(POEM_GENERIC_ERROR) .
        '<p><a href="pass-phrase-reset.php">try again</a></p>';
    }
  }
?>
<?php
  //$error has errors, echo <article with error
  if (isset($error)) {
    echo "<article class='poem error'>$error</article>";
  }
  //if $showForm is true, show the <form> element,</main>
  if ($showForm) {
?>
  <form method="post" action="pass-phrase-reset-confirm.php" novalidate>
    <input type="hidden" name="token" value="<?= $token ?>"> 
    <fieldset>
      <legend>Pass Phrase:</legend>
        <em>A hard-to-guess phrase at least 20 characters long.</em>
        <input type="password" placeholder="Pass Phrase"
          name="pass-phrase-1" id="pass-phrase-1"
          required minlength="20"> 
        <input type="password" placeholder="Repeat Pass Phrase"
          name="pass-phrase-2" id="pass-phrase-2"
          required minlength="20">
    </fieldset>
    <button>Change Pass Phrase</button>
  </form>
<?php
  }
  echo '</main>';
  require 'includes/footer.php';
?>