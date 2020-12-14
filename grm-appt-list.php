<?php
  $dsn = 'mysql:host=localhost;dbname=pet_shop';
  $username = 'root';
  $password = 'pwdpwd';
  $db = new PDO($dsn, $username, $password);

  $query = "SELECT FirstName,LastName,PetName,Breed,PetBirthday
    FROM grooming";
  $stmt = $db->prepare($query);
  $stmt ->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../../static/styles/normalize.css">
<link rel="stylesheet" href="../../static/styles/styles.css">
<title>Grooming Appointment List</title>
</head>
<body>
<main>
  <h1>Grooming Pet Appointment List</h1>
  <ol>
  <?php
    while ($row = $stmt->fetch()) {
      echo '<li>' . $row['FirstName'] . ' '
            . $row['LastName'] .  ',  Pet Name -'
            . $row['PetName'] .  ',  Breed - '
            . $row['Breed'] .  ',  Pet Birthday -'
            . $row['PetBirthday'] .  '</li>';
    }
  ?>
  </ol>
</main>
</body>
</html>