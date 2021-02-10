<?php
    require_once 'config.php';
    require_once 'includes/utilities.php';
    $db = dbConnect();

  $query = "SELECT GroomingID,DateSubmitted,FirstName,LastName,Address,City,State,Zip,Email,PetType,Breed,PetName
  FROM grooming
  WHERE GroomingID
  ORDER BY GroomingID DESC LIMIT 1";

  $stmt = $db->prepare($query);
  $stmt->execute();
  $row = $stmt->fetch();
  
  if($row) {
    $groomingID = $row['GroomingID'];
    $dateSubmitted = date('m/d/Y', strtotime($row['DateSubmitted']));
    $firstName= $row['FirstName']; 
    $lastName = $row['LastName'];
    $address = $row['Address'];
    $city = $row['City'];
    $state = $row['State'];
    $zip = $row ['Zip'];
    $email = $row ['Email'];
    $petType = $row['PetType'];
    $breed = $row['Breed'];
    $petName = $row['PetName'];
    $neuteredOrSpayed = $row['NeuteredOrSpayed'];
    $petBirthdayInSec = strtotime($row['PetBirthday']);
    $petBirthday = date('m/d/Y', $petBirthdayInSec);
  } else {
    $title = "There is no pet appointment for this groomingID";
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="styles/normalize.css">
<link rel="stylesheet" href="styles/styles.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type='text/javascript'>
$(document).ready(function() {
  $('#button').click(function() {
    window.open("http://localhost:8888/pet-shop/appnt-delete.php");
  })
})
</script>
<title><?= $row['breed']?></title>
</head>
<body>
<main>
<?php if ($row) { ?>
  <h1><?= 'Thank you for your submission for appointment' ?></h1>
  <div><?= nl2br('Date Submitted: '. $dateSubmitted) ?></div>
  <button id='button'>Delete</button>
  <?= nl2br('Pending Review') ?>
  <tr>
  <td><div><?= nl2br('GroomindId: '.  $groomingID) ?></td></tr>
  <div><?= nl2br('Pet-Owner\'s Name: '. $firstName) ?></div>
  <div><?= nl2br('Last Name: '. $lastName) ?></div>
  <div><?= nl2br('address: '.  $address) ?></div>
  <div><?= nl2br('City: '. $city) ?></div>
  <div><?= nl2br('State: '. $state) ?></div>
  <div><?= nl2br('Zip code: '. $zip) ?></div>
  <div><?= nl2br('Email: '. $email) ?></div>
  <div><?= nl2br('Type of Pet: '. $petType) ?></div>
  <div><?= nl2br('Name of Pet: '. $petName) ?></div>
  <?php if(!empty($breed) ) {?>
  <div><?= nl2br('Type of Breed: '. $breed) ?></div>
  <?php }?>
  <?php if(!empty($NeuteredOrSpayed) ) {?>
  <div><?= nl2br('Fixing Status: '. $NeuteredOrSpayed) ?></div>
  <?php }?>
  <?php if(!empty($petBirthday) ) {?>
  <div><?= nl2br('Pet Birthday: '. $petBirthday) ?></div>
  <?php }?>

<?php } else { ?>
  <h1>No Results</h1>
  <p><?= $title?></p>
<?php } ?>
</main>
</body>
</html>