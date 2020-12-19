<?php
  $dsn = 'mysql:host=localhost;dbname=pet_shop';
  $username = 'root';
  $password = 'pwdpwd';
  $db = new PDO($dsn, $username, $password);

  $groomingID = $_GET['GroomingID'];
  $query = "SELECT Breed,FirstName,PetBirthday
    FROM grooming
    WHERE GroomingID = ?";
  $stmt = $db->prepare($query);
  $stmt->execute([$groomingID]);
  $row = $stmt->fetch();
  
  if($row) {
    $breed = $row['Breed'];
    $firstName = $row['FirstName'];
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
<title><?= $row['breed']?></title>
</head>
<body>
<main>
<?php if ($row) { ?>
  <h1><?= 'breedname: '.$breed ?></h1>
  <div><?= nl2br('Pet-Owner\'s Name: '. $firstName) ?></div>
  <div><?= nl2br('Pet\'s Birthday: '. $petBirthday) ?></div>
<?php } else { ?>
  <h1>No Results</h1>
  <p><?= $title?></p>
<?php } ?>
</main>
</body>
</html>