<?php
  $pageTitle = 'Delete Appointment';
  require 'includes/header.php';

  $confirmDelete = isset($_POST['grooming-id']);
  $errors = [];
  $qSelect = "SELECT GroomingID,DateSubmitted,FirstName,LastName,Address,City,State,Zip,Email,PetType,Breed,PetName
  FROM grooming
  WHERE GroomingID
  ORDER BY GroomingID DESC LIMIT 1";
  $stmt = $db->prepare($qSelect);
  $stmt->execute();
  $row = $stmt->fetch();
  $petType = $row['PetType'];
  $petName = $row['PetName'];

  if ($confirmDelete) {
    $qDelete = "DELETE FROM grooming 
    WHERE GroomingID
    ORDER BY GroomingID DESC LIMIT 1";
     
    try { $stmt = $db->prepare($qDelete);
      $stmt->execute();
      $deleteResult = 1;
  } catch(PDOException $e) {
      logError($e->getMessage());
      $deleteResult = 0;
  }
}
?>
<main id="appnt-delete" class="narrow">
  <h1><?= $pageTitle ?></h1>
  <?php
 
 if (!empty($deleteResult)) {
  $deleteResultMsg = nl2br(APPOINTMENT_DELETE_SUCCESS);
  $cls = 'success';
} elseif (isset($deleteResult)) {
  logError("Failed to delete appntmnt");
  $deleteResultMsg = nl2br(APPOINTMENT_DELETE_FAIL);
  $cls = 'error';
}
    if (isset( $deleteResultMsg )) {
      // Output delete result
  ?>
    <article class="poem <?= $cls ?>">
      <?= $deleteResultMsg ?>
    </article>
  <?php
    } else {
      // Output delete form
  ?>
    <form method="post" action="appnt-delete.php">
      <p>Are you sure you want to delete  your appointment for your  <em><?= $petType ?>&nbsp;<em><?= $petName ?></em>?</p>
      <button name="grooming-id" value="<?=$GroomingID?>" class="wide">
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