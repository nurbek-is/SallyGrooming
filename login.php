<?php
  $pageTitle = 'Login';
  require 'includes/header.php';
  logout(); // In case a different user has logged in

  // TODO: Set $username and $passPhrase
  //    These should be set to the values posted in the form
  //    If the form has not been posted, they should default to
  //      empty strings.
  $username = trim($_POST['username'] ?? '');
  $passPhrase = $_POST['pass-phrase'] ?? '';

  if ($username && $passPhrase) {
    
    $qLogin = "SELECT pass_phrase, registration_confirmed, user_id
      FROM users
      WHERE username = ?";

    try {
      // TODO: Prepare and execute the $qLogin query
      $stmt = $db->prepare($qLogin);
      $stmt->execute([$username]);
      
      if (!$row = $stmt->fetch()) {
        // username doesn't exist
        $loginFailed = true;
        $failureMessage = nl2br(POEM_LOGIN_FAILED);
      } elseif ( !$row['registration_confirmed']) {
        // user never confirmed registration
        $loginFailed = true;
        $failureMessage = nl2br(POEM_REGISTRATION_UNCONFIRMED);
      } elseif (password_verify($passPhrase, $row['pass_phrase'])) {
        // TODO: log user in and redirect to home page
        //
        //    Set 'user-id' session variable to user_id returned by
        //      query.
        $_SESSION['user-id'] = $row['user_id'];

        //    If the user checked the remember-me checkbox, create a
        //      'token' cookie for 30 days (in minutes).
        //      To do so, follow these steps:
        //        Use the generateToken() utility function to
        //          generate the token.
        //        Insert a new row into the tokens table with values
        //          for token, user_id, and token_expires set to the
        //          generated token, the current user id, and a date
        //          30 days (in minutes) in the future.
           // log user in and redirect to home page
       
 
        if (!empty($_POST['remember-me'])) {
          // Set cookie for 30 days
          $interval = 30 * 24 * 60; // 30 days
          $token = generateToken();
          $qInsert = "INSERT INTO tokens
          (token, user_id, token_expires)
          VALUES ( '$token', ?, DATE_ADD(now(),
                    INTERVAL $interval MINUTE) )";
 
          try {
            $stmtInsert = $db->prepare($qInsert);
 
            if ($stmtInsert->execute( [$_SESSION['user-id']] )) {
              $expiration = time() + 60 * $interval;
              if (!setcookie('token', $token, $expiration)) {
                // Could not set cookie on browser. Fail silently.
                logError("Could not set cookie for $username.");
              }
            } else {
              // Likely SQL error. Log and redirect to error page.
              logError($stmtInsert->errorinfo()[2], true);
            }
          } catch (PDOException $e) {
            // Could not insert cookie token. Fail silently.
            logError($e->getMessage());
          }
        }
        header("Location: index.php");
        //        If the insert fails due to a PDOException, log
        //          the error and fail silently.
        //        If the insert is successful, attempt to set a
        //          'token' cookie that expires in 30
        //          days (in seconds). If this fails (i.e.,
        //          set_cookie() returns false), log the error.
        //
        //    After (and separate from) the cookie code,
        //      redirect to the home page
      } else {
        // bad password
        $loginFailed = true;
        $failureMessage = nl2br(POEM_LOGIN_FAILED);
      }
    } catch (PDOException $e) {
      logError($e);
      $loginFailed = true;
      $failureMessage = nl2br(POEM_GENERIC_ERROR);
    }
  }
?>
<main class="narrow">
  <h1><?= $pageTitle ?></h1>
  <?php
    if (isset($loginFailed)) {
      echo "<article class='poem error'>$failureMessage</article>";
    }

    if (isset($_GET['just-registered'])) {
      echo '<article class="poem success">' .
          nl2br(POEM_REGISTRATION_SUCCESS) .
        '</article>';
    } else {
      echo '<p>Need an account? 
        <a href="register.php">Register</a></p>';
    }
  ?>
  <!-- novalidate set so that PHP validation can be tested -->
  <form method="post" action="login.php" novalidate>
    <label for="username">Username:</label>
    <input name="username" id="username" required
      value="<?= $username ?>"> 
    <label for="pass-phrase">Pass Phrase:</label>
    <input type="password" name="pass-phrase" id="pass-phrase"
      required>
    <input type="checkbox" name="remember-me" id="remember-me">
    <label for="remember-me" class="inline">Remember me</label>
    <button>Login</button>
  </form>
  <p class="clear">
    <a href="pass-phrase-reset.php">Forgot your pass phrase?</a>
  </p>
</main>
<?php
  require 'includes/footer.php';
?>