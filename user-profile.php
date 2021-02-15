<?php
  $pageTitle = 'My Profile';
  require 'includes/header.php';

  if (!isAuthenticated()) {
    header("Location: login.php");
  }

  $f = [];

  $f['first-name'] = trim($_POST['first-name'] ?? '');
  $f['last-name'] = trim($_POST['last-name'] ?? '');
  $f['email'] = trim($_POST['email'] ?? '');
  $f['username'] = trim($_POST['username'] ?? '');

  if (!empty($_POST['update'])) {
    $errors = [];

    // Validate Form Entries
    if (!$f['first-name']) {
      $errors[] = 'You must enter a first name.';
    }

    if (!$f['last-name']) {
      $errors[] = 'You must enter a last name.';
    }

    if (!$f['username'] || strlen($f['username']) < 8) {
      $errors[] = 'Your username must be at least 8 characters.';
    }

    if (!$f['email']) {
      $errors[] = 'Email is required.';
    } elseif (!filter_var($f['email'], FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'Email is not valid.';
    }

    $passPhrase1 = $_POST['pass-phrase-1'];
    $passPhrase2 = $_POST['pass-phrase-2'];
    if ($passPhrase1) {
      if (strlen($passPhrase1) < 20) {
        $errors[] = 'Your pass phrase must be at least 20 characters.';
      } elseif ($passPhrase1 !== $passPhrase2) {
        $errors[] = 'Your pass phrases don\'t match.';
      }
    }

    // Check if username exists if changing username
    $usernameCheck = "SELECT user_id
      FROM users
      WHERE username = ? AND user_id != ?";

    try {
      $stmt = $db->prepare($usernameCheck);
      $stmt->execute([$f['username'], $currentUserId]);
    } catch (PDOException $e) {
      logError($e);
      $errors[] = nl2br(POEM_GENERIC_ERROR);
    }

    if ($stmt->fetch()) {
      $errors[] = 'That username is already taken.<br>
        Please try a different one.';
    }

    // Check if email exists
    $emailCheck = "SELECT user_id
      FROM users
      WHERE email = ? AND user_id != ?";

    try {
      $stmtEmail = $db->prepare($emailCheck);
      $stmtEmail->execute([ $f['email'], $currentUserId ]); 

      if ($stmtEmail->fetch()) {
        $errors[] = 'That email is associated with another account';
      }
    } catch (PDOException $e) {
      logError($e);
      $errors[] = 'Oops! Our bad. We cannot register you right now.';
    }

    // Check if uploading profile picture
    $pic = $_FILES['profile-pic'] ?? NULL;
    if ($pic['error'] === UPLOAD_ERR_NO_FILE) {
      // File intentionally not uploaded
      $pic = NULL;
    }

    if (!$errors) {
      // If there are no errors yet, try to upload pic
      if ($pic) {
        // Try to upload pic
        if (!$picFileName = uploadProfilePic($pic)) {
          $errors[] = 'Could not upload profile picture. It must
            be a jpg or png and cannot be larger than 3 MB.';
        }
      }

      if (!$errors) {
        // Update user
        $hashedPhrase = password_hash($passPhrase1, PASSWORD_DEFAULT);
        $qUpdate = "UPDATE users
          SET first_name  = ?,
              last_name   = ?,
              email       = ?,
              username    = ?";
        
        $params = [$f['first-name'], $f['last-name'],
                    $f['email'], $f['username']];

        if ($passPhrase1) {
          $qUpdate .= ", pass_phrase = ?";
          $params[] = $hashedPhrase;
        }
        if (!empty($picFileName)) {
          $qUpdate .= ", profile_pic = ?";
          $params[] = $picFileName;
        }
        $qUpdate .= " WHERE user_id = ?";
        $params[] = $currentUserId;

        try {
          $stmtUpdate = $db->prepare($qUpdate);
          $stmtUpdate->execute($params);
          if ($stmtUpdate->execute()) {
            $accountUpdated = true;
          } else {
            $errors[] = 'Account update failed. Please try again.';
            logError($stmtUpdate->errorInfo()); 
          }
        } catch (PDOException $e) {
          $errors[] = 'Update failed. Please try again.';
          logError($e);
        }

      }
    }
  }
  $selUser = "SELECT first_name, last_name, email, 
    username, profile_pic
    FROM users
    WHERE user_id = ?";

  try {
    $stmt = $db->prepare($selUser);
    $stmt->execute([$currentUserId]);
    $row = $stmt->fetch();
    $firstName = $row['first_name'];
    $lastName = $row['last_name'];
    $email = $row['email'];
    $username = $row['username'];
    if ($row['profile_pic']) {
      $pathToProfilePic = '../../../static/images/profile-pics/' .
                          $row['profile_pic'];
    } else {
      $pathToProfilePic = null;
    }
  } catch (PDOException $e) {
    $errors[] = nl2br(POEM_GENERIC_ERROR);
    logError($e);
  }
?>
<main class="narrow">
  <h1><?= $pageTitle ?></h1>
  <?php
    if (!empty($errors)) {
      echo '<h3>Please correct the following errors:</h3>
      <ol class="error">';
      foreach ($errors as $error) {
        echo "<li>$error</li>";
      }
      echo '</ol>';
    }

    if (!empty($accountUpdated)) {
      echo '<h3 class="success">Your account has been updated</h3>';
    }
  ?>
  <!-- novalidate set so that PHP validation can be tested -->
  <form method="post" action="user-profile.php" novalidate
    enctype="multipart/form-data">
    <label for="first-name">First Name*:</label>
    <input name="first-name" id="first-name" 
      value="<?= $firstName ?>" required>
    <label for="last-name">Last Name*:</label>
    <input name="last-name" id="last-name" 
      value="<?= $lastName ?>" required> 
    <label for="email">Email*:</label>
    <input type="email" name="email" id="email" 
      value="<?= $email ?>" required> 
    <label for="username">Username*:</label>
    <input name="username" id="username" 
      value="<?= $username ?>" required minlength="8"> 
    <label for="profile-pic">Profile Picture:</label>
    <?php if (file_exists($pathToProfilePic)) { ?>
      <img src="<?=$pathToProfilePic?>" alt="Profile Picture">
    <?php } ?>
    <p><em>For best results, choose a 200px by 200px image.</em></p>
    <input type="file" name="profile-pic" id="profile-pic"
      accept=".jpg, .jpeg, .png">
    <fieldset>
      <legend>Pass Phrase:</legend>
        <strong>Leave blank to keep same pass phrase.</strong>
        <input type="password" placeholder="Pass Phrase"
          name="pass-phrase-1" id="pass-phrase-1"
          required minlength="20"> 
        <input type="password" placeholder="Repeat Pass Phrase"
          name="pass-phrase-2" id="pass-phrase-2"
          required minlength="20">
    </fieldset>
    <button name="update" value="1">Update</button>
  </form>
</main>
<?php
  require 'includes/footer.php';
?>