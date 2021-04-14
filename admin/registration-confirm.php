<?php
  if (!isset($_GET['token'])) {
    // How did you get here?
    header("Location: index.php");
  }

  $pageTitle = 'Registration Confirmation';
  require 'includes/header.php';
//   logout(); // In case a different user has logged in

  $token = $_GET['token'];
?>

<?php
  $qUpdate = "UPDATE users
  SET registration_confirmed = 1
  WHERE user_id = (SELECT user_id
    FROM tokens
    WHERE token = ?
    AND token_expires > now() );";

  try {
    $stmtUpdate = $db->prepare($qUpdate);
  
    if (!$stmtUpdate->execute( [$token] )) {
      // Query failed to execute
      logError($stmtUpdate->errorInfo()[2], true);
    } elseif ($stmtUpdate->rowCount()) {
      // Redirect user to login page
      header("Location: login.php?just-registered=1");
    } // Else no rows were updated. Continue to error message.
  } catch (PDOException $e) {
    logError($e);
  }
?>
<!-- Won't get her unless something went wrong -->
<main class="narrow">
  <h1><?= $pageTitle ?></h1>
  <article class='error'>
    <?= nl2br(INVALID_TOKEN_REGISTRATION) ?>
  </article>
</main>
<?php
  require 'includes/footer.php';
?>