<?php
ini_set('display_errors', '1');
$pageTitle = 'Contact Us';
require 'includes/header.php';

$f = [];

// Trim and Assign Form Entries
$f['first-name'] = trim($_POST['first-name'] ?? '');
$f['last-name'] = trim($_POST['last-name'] ?? '');
$f['email'] = trim($_POST['email'] ?? '');
$f['message'] = trim($_POST['message'] ?? '');
$f['placeholder'] = 'Be it poetry. Be it prose.
This is where your message goes.';

echo '<main id="contact-form">';
echo "<h1>$pageTitle</h1>";

if (isset($_POST['send'])) {
  require_once 'mail-config.php';
  
  $errors = [];

  if (!$f['first-name']) {
    $errors[] = 'First name is required.';
  }

  if (!$f['last-name']) {
    $errors[] = 'Last name is required.';
  }

  if (!$f['email']) {
    $errors[] = 'Email is required.';
  } elseif (!filter_var($f['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = nl2br(POEM_INVALID_EMAIL);
  }

  if (strlen($f['message']) < 10) {
    $errors[] = 'Your message must be at least 10 characters long.';
  }

  if ($errors) {
    echo '<h3>Please correct the following errors:</h3>
    <ol class="error">';
    foreach ($errors as $error) {
      echo "<li>$error</li>";
    }
    echo '</ol>';
  } else {
    $to = $f['email'];
    $toName = $f['first-name'] . ' ' . $f['last-name'];
    $subject = 'Contact Form Submission';

    $html = "<p>Oh, happy day, we are touched<br>
    You took the time to contact us<br>
    We <em>will</em> take note<br>
    Of what you wrote<br>
    Thank you <em>very</em>, very much!</p>
    <p>Name: $toName</p>
    <p>Email: " . $f['email'] . "</p>
    <h3>Your Message</h3>" . nl2br($f['message']);

    $text = "Oh, happy day, we are touched
You took the time to contact us
We will take note
Of what you wrote
Thank you very, very much!
    
* Name: $toName
* Email: " . $f['email'] . "
* Your Message: " . $f['message'];

    echo '<article class="poem">';
    try {
      // Pass true to createMailer() to enable debugMode
      $mail = createMailer();
      $mail->addAddress($to, $toName);
      // $mail->addBcc('you@example.com');
      $mail->Subject = $subject;
      $mail->Body = $html;
      $mail->AltBody = $text;
  
      $mail->send();
      echo '<p class="success">' . nl2br(POEM_MAIL_SUCCESS) . '</p>';
    } catch (Exception $e) {
      echo '<p class="error">' . nl2br(POEM_MAIL_FAIL) . '</p>';
      logError($e);
    }
    echo '</article>';
  }
}
?>
  <form method="post" action="contact.php" novalidate>
    <label for="first-name">First Name*:</label>
    <input name="first-name" id="first-name"
      value="<?= $f['first-name'] ?>" required>
    <label for="last-name">Last Name*:</label>
    <input name="last-name" id="last-name"
      value="<?= $f['last-name'] ?>" required>
    <label for="email">Email*:</label>
    <input type="email" name="email" id="email"
      value="<?= $f['email'] ?>" required>
    <label for="message">Message*:</label>
    <textarea placeholder="<?= $f['placeholder'] ?>" id="message"
      name="message"><?= $f['message'] ?></textarea>
    <button name="send" class="wide">Send</button>
  </form>
</main>
<?php
  require 'includes/footer.php';
?>