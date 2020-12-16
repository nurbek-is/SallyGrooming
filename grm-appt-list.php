<?php
  $dsn = 'mysql:host=localhost;dbname=pet_shop';
  $username = 'root';
  $password = 'pwdpwd';
  $db = new PDO($dsn, $username, $password);

  $offset = $_GET['offset'] ?? 0; //if offset is null, default value will be 0;
  $offset = (int) $offset; //making the offset integer so we can use it later as ===
  $rowsToShow = 2;
  $query = "SELECT GroomingID,FirstName,LastName,PetName,Breed,PetBirthday
    FROM grooming
    ORDER BY PetBirthday ASC
    LIMIT $offset, $rowsToShow";
  $stmt = $db->prepare($query);
  $stmt ->execute();
  
    $qGroomingAppntCount = "SELECT COUNT(GroomingID) as num
    FROM grooming";
    $stmtAppntCount = $db->prepare($qGroomingAppntCount);
    $stmtAppntCount->execute();
    $row = $stmtAppntCount->fetch();
    $appntCount = $row['num'];
    
    $href = "grm-appt-list.php";
    $prevOffset = max(0, $offset - $rowsToShow); //max will return highest of 2 numbers
    $prev = "$href?offset=$prevOffset";
    $nextOffset = $offset + $rowsToShow;
    $next = "$href?offset=$nextOffset";

  $pageTitle = 'List of Appointments';
  require 'includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../../static/styles/normalize.css">
<!-- <link rel="stylesheet" href="../../static/styles/styles.css"> -->
<link rel="stylesheet" href="styles/styles.css">
<title>Grooming Appointment List</title>
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
  </tbody>
</table>
    <tfoot class="pagination">
        <tr>
          <?php 
            if($offset ===0) {
              echo "<td class='disabled'>Previous </td>";  
            } else {
              echo "<td><a href='$prev'>Previous</a></td>"; 
            }
          ?>
          <td colspan="2"></td>
          <?php
            if($nextOffset >= $appntCount) {
               echo "<td class='disabled'>Next</td>";
            } else {
              echo "<td><a href='$next'>Next</a></td>";
            }
          ?>
        </tr>
      </tfoot>
    <h2>Filtering</h2>
    <form method="get" action="grm-appt-list.php">
      <label for="cat">Breed:</label>
      <select name="cat" id="cat">
        <option value="0">GroomingID</option>
        <option value='2'>LastName (5)</option>
        <option value='1'>PetName (2)</option>
        <option value='4'>BreedName (1)</option>
      </select>
      <label for="user">PetName:</label>
      <select name="user" id="user">
        <option value="0">Roxy</option>
        <option value='3'>Angel (1)</option>
        <option value='2'>Rocky (2)</option>
        <option value='1'>Honey (5)</option>
      </select>
      <button name="filter" class="wide">Filter</button>
    </form>
  </table>
</main>
</body>
</html>
<?php
  require 'includes/footer.php';
?>