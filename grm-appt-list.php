<?php
  $dsn = 'mysql:host=localhost;dbname=pet_shop';
  $username = 'root';
  $password = 'pwdpwd';
  $db = new PDO($dsn, $username, $password);

  $query = "SELECT GroomingID,FirstName,LastName,PetName,Breed,PetBirthday
    FROM grooming
    ORDER BY PetBirthday ASC
    LIMIT 0, 3";
  $stmt = $db->prepare($query);
  $stmt ->execute();
  
    $qGroomingAppntCount = "SELECT COUNT(GroomingID) as num
    FROM grooming";
    $stmtAppntCount = $db->prepare($qGroomingAppntCount);
    $stmtAppntCount->execute();
    $row = $stmtAppntCount->fetch();
    $appntCount = $row['num'];

  $pageTitle = 'List of Appointments';
  require 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../../static/styles/normalize.css">
<link rel="stylesheet" href="../../static/styles/styles.css">
<title>Grooming Appointment List</title>
<style>
table,tr,th,td {
  border:2px solid black;
}
</style>
</head>
<body>


<main>
  <h1><?=$pageTitle?></h1>
  <table>
  <tbody>
  <caption>Total Appointments: <?= $appntCount ?> </caption>
  <thead>
      <tr>
        <th>GroomingID</th>
        <th>LastName</th>
        <th>PetName</th>
        <th>Breed Name</th>
        <th>Pet Birthday</th>
      </tr>
  </thead>
  
  <?php
    while ($row = $stmt->fetch()) {
      $petsBirthdayInSec = strtotime($row['PetBirthday']);
      $petsBirthday = date('m/d/Y',$petsBirthdayInSec);
  ?>
  <tr>
    <td>  
      <a href="admin.php?GroomingID=<?=$row['GroomingID']?>">
        <?=$row['GroomingID']?>
      </a>
    </td>
  <td><?=$row['LastName']?></td>
  <td><?=$row['PetName']?></td>
  <td><?=$row['Breed']?></td>
  <td><?= $petsBirthday ?></td>
  </tr>
    <?php
    }
    ?>
  <tbody>
  </table>
</main>
</body>
</html>