<?php
  $pageTitle = 'Delete Appointment Request';
  require '../includes/header.php';

  $groomId = $_REQUEST['GroomingID'];

  if (!isAdmin($currentUserId)) {
    header("Location: index.php");
  }

  $confirmDelete = isset($_POST['GroomingID']);
  $cancelButton = isset($_POST['cancel']);
 
  if($cancelButton) {
    header("Location: admin.php");
  }

  if ($confirmDelete) {
    $qDelete = 'DELETE FROM grooming WHERE GroomingID = ?';
    try {
      $stmt = $db->prepare($qDelete);
      if (!$stmt->execute( [$groomId] )) {
        $errorMsg = $stmt->errorInfo()[2];
        logError($errorMsg , true); 
      }
      $deleteResult = 1;
    } catch (PDOException $e) {
      logError($e);
      $deleteResult = 0;
    }
  } 
  else {
    $qSelect = 'SELECT PetType,Breed,PetName FROM grooming WHERE GroomingID = ?';
    try {
      $stmt = $db->prepare($qSelect);
      if (!$stmt->execute( [$groomId] )) {
        $errorMsg = $stmt->errorInfo()[2];
        logError($errorMsg , true ); 
      } else {
        $row = $stmt->fetch();
        $petType = $row['PetType'];
        $petName = $row['PetName'];
      }
    } catch (PDOException $e) {
      logError( $e->getMessage(), true);
    }
  }
  if (!empty($deleteResult)) {
    $deleteResultMsg = nl2br(ADMIN_APPOINTMENT_DELETE_SUCCESS);
    $cls = 'success';
  } elseif (isset($deleteResult)) {
    logError("Failed to delete appointment");
    $deleteResultMsg = nl2br(APPOINTMENT_DELETE_FAIL);
    $cls = 'error';
  }

  if (isset( $deleteResultMsg )) {
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../styles/normalize.css">
<link rel="stylesheet" href="../styles/styles.css">
<!-- <script src='grm-form.js' rel='script'></script> -->
<title>Admin Appointment Delete</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script> 
<script src='../scripts/breakpoints-script.js'></script>
</script>
</head>
<main id="appnt-delete" class="small">
  <h1><?= $pageTitle ?></h1>
 
    <article class="success <?= $cls ?>">
      <?= $deleteResultMsg ?>
    </article>
  <?php
    } else {
      // Output delete form
  ?>
    <form method="post" action="admin-apnt-delete.php">
      <p class='white-font-purpleBg'>Are you sure you want to delete  this appointment for
        <em><?= $petType ?>&nbsp;<em><?= $petName ?></em>?</p> 
        <div class='mustard-container'>
      <button name="GroomingID" value="<?=$groomId?>" class="center-button">
        Confirm Delete
      </button>
      <button name="cancel" class="center-button">Cancel</button>
      </div>
    </form>
  <?php
    }
  ?>
</main>
<?php
  require '../includes/footer.php';
?>
</body>
</html>