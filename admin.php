<?php
  $dsn = 'mysql:host=localhost;dbname=pet_shop';
  $username = 'root';
  $password = 'pwdpwd';
  $db = new PDO($dsn, $username, $password);
  $breed = $_GET['breed'];
  $query = "SELECT Breed,FirstName
    FROM grooming
    WHERE Breed = ?";
  $stmt = $db->prepare($query);
  $stmt->execute([$breed]);
  $row = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../../static/styles/normalize.css">
<link rel="stylesheet" href="../../static/styles/styles.css">
<title><?= $row['Breed'] ?></title>
</head>
<body>
<main>
<?php if ($row) { ?>
  <h1><?= 'breedname: '.$row['Breed'] ?></h1>
  <div><?= nl2br('Pet-Owner\'s Name: '. $row['FirstName']) ?></div>
<?php } else { ?>
  <h1>No Results</h1>
  <p>Sorry, we couldn't find a breed by that name.</p>
<?php } ?>
</main>
</body>
</html>