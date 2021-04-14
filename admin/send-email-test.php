<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../../static/styles/normalize.css">
<link rel="stylesheet" href="../../static/styles/styles.css">
<title>Send Email Test</title>
</head>
<body>
<main>
<?php
  if (!isset($_POST['send'])) {
?>
  <form method="post" action="send-email-test.php">
    <label for="email">Email:</label>
    <input id="email" name="email">
    <button name="send">Send Test Email</button>
  </form>
<?php
  } else {
    require_once 'mail-config.php';

    $now = date('r'); // Formatted date / time
  
    try {
      $mail = createMailer(true);
      $mail->addAddress($_POST['email'], 'Webucator Student');
      $mail->Subject = 'Test Email';
      $mail->Body = "<p><strong>Email works!</strong> - $now</p>";
      $mail->AltBody = "Email works! - $now";
  
      $mail->send();
      echo "<p class='success'>Test email sent.</p>";
    } catch (Exception $e) {
      echo "<p class='error'>We could not send your email.</p>";
      logError($e);
    }
  }
?>
</main>
</body>
</html>