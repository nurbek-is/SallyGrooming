<?php
  $dsn = 'mysql:host=localhost;dbname=pet_shop';
  $username = 'root';
  $password = 'pwdpwd';
  $db = new PDO($dsn, $username, $password);

  $query = "SELECT GroomingID,FirstName,LastName,PetName,Breed,PetBirthday
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
  <table>
  <tbody>
  <thead>
      <tr style='border:2px solid-black;'>
        <th style='border:2px solid black;'>FirstName</th>
        <th style='border:2px solid black;'>LastName</th>
        <th style='border:2px solid black;'>PetName</th>
        <th style='border:2px solid black;'>Breed Name</th>
        <th style='border:2px solid black;'>Pet Birthday</th>
      </tr>
  </thead>
  
  <?php
    while ($row = $stmt->fetch()) {
  ?>
  <tr>
  <td style='border:2px solid black;'><?=$row['FirstName']?></td>
  <td style='border:2px solid black;'><?=$row['LastName']?></td>
  <td style='border:2px solid black;'><?=$row['PetName']?></td>
  <td style='border:2px solid black;'><?=$row['Breed']?></td>
  <td style='border:2px solid black;'><?=$row['PetBirthday']?></td>
  
    <?php
    }
    ?>
    </tr>
  <tbody>
  </table>
</main>
</body>
</html>