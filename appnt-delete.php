<?php
  $pageTitle = 'Delete Appointment';
  require 'includes/header.php';
  
  if (!isset($_REQUEST['GroomingID'] )) {
    header("Location: index.php");
  }
  $groomId=$_REQUEST['GroomingID'];

  if (!isAppntAuthor($groomId)) {
    header("Location: index.php");
  }

  $confirmDelete = isset($_POST['GroomingID']);

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
    $deleteResultMsg = nl2br(APPOINTMENT_DELETE_SUCCESS);
    $cls = 'success';
  } elseif (isset($deleteResult)) {
    logError("Failed to delete appointment");
    $deleteResultMsg = nl2br(APPOINTMENT_DELETE_FAIL);
    $cls = 'error';
  }

  if (isset( $deleteResultMsg )) {
?>

<main id="appnt-delete" class="narrow">
  <h1><?= $pageTitle ?></h1>
 
    <article class="poem <?= $cls ?>">
      <?= $deleteResultMsg ?>
    </article>
  <?php
    } else {
      // Output delete form
  ?>
    <form method="post" action="appnt-delete.php">
      <p>Are you sure you want to delete  your appointment for your
        <em><?= $petType ?>&nbsp;<em><?= $petName ?></em>?</p> 
      <button name="GroomingID" value="<?=$groomId?>" class="wide">
        Confirm Delete
      </button>
    </form>
  <?php
    }
  ?>
</main>
<?php
  require 'includes/footer.php';
?>
</body>
</html>