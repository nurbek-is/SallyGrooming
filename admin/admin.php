<?php
  $pageTitle = 'Grooming Appointments';
  require '../includes/header.php';

  if (!isAuthenticated()) {
    header("Location: login.php?no-access=1");
  }
  if (!isAdmin($currentUserId)) {
     header("Location: index.php");
  }

  $offset = $_GET['offset'] ?? 0; //if offset is null, default value will be 0;
  $offset = (int) $offset; //making the offset integer so we can use it later as ===
  $rowsToShow = 5;
  $order = $_GET['order'] ?? 'PetBirthday';
  $dir = $_GET['dir'] ?? 'desc';
  
  //8 lines below(including if stmnt-!in_array) is just extra step,if someone messes with querystring 
  // and types in some string in $order or $dir fields, it won't mess the page
  $orderAllowed=['GroomingID','FirstName','LastName','PetName','Breed','PetBirthday'];
  $dirAllowed=['asc','desc'];
  if(!in_array($order, $orderAllowed)) {
    $order = 'date_approved';
  }
  if(!in_array($dir,$dirAllowed)) {
    $dir = 'asc';
  }

  $query = "SELECT GroomingID,FirstName,LastName,PetName,Breed,PetBirthday
    FROM grooming
    ORDER BY $order $dir
    LIMIT $offset, $rowsToShow";
  try {
    $stmt = $db->prepare($query);
    if (!$stmt->execute($params)) {
      $errorMsg = $stmt->errorInfo()[2] . ": $query";
      logError($errorMsg);
    }
  } catch (PDOException $e) {
    logError($e->getMessage(), true);
  }
    $qGroomingAppntCount = "SELECT COUNT(GroomingID) as num
    FROM grooming";
    try {
      $stmtAppntCount = $db->prepare($qGroomingAppntCount);
      if (!$stmtAppntCount->execute()) {
        $errorMsg = $stmtAppntCount->errorInfo()[2] . ": $query";
        logError($errorMsg);
      }
    } catch (PDOException $e) {
      logError($e->getMessage(), true);
    }

    $row = $stmtAppntCount->fetch();
    $appntCount = $row['num'];
    $href = "admin.php?";
    $prevOffset = max(0, $offset - $rowsToShow); 
    //max will return highest of 2 numbers
    $nextOffset = $offset + $rowsToShow;
    $prev = $href . "offset=$prevOffset&order=$order&dir=$dir";
    $next = $href . "offset=$nextOffset&order=$order&dir=$dir";

   /* CONSTRUCT THE LINKS FOR THE HEADERS */
  // Default all directions to ascending
  $dirGroomingID = 'asc';
  $dirFirstName ='asc';
  $dirLastName = 'asc';
  $dirPetName = 'asc';
  $dirBreed = 'asc';
  $dirPetBirthday = 'asc';
  
   // If the current direction is 'asc', switch the direction
  //  for the header that is currently being sorted on
  
  if ($dir === 'asc') {
    switch ($order) {
      case 'GroomingID':
        $dirGroomingID = 'desc';
        break;
      case 'FirstName':
        $dirFirstName = 'desc';
        break;
      case 'LastName':
        $dirLastName = 'desc';
        break;
      case 'PetName':
        $dirPetName = 'desc';
        break;
      case 'Breed':
        $dirBreed = 'desc';
        break;
      case 'PetBirthday':
        $dirPetBirthday = 'desc';
        break;
    }
  }

$groomingLink = $href . "order=GroomingID&dir=$dirGroomingID";
$FirstNameLink = $href . "order=FirstName&dir=$dirGroomingID";
$LastNameLink = $href . "order=LastName&dir=$dirLastName";
$PetNameLink = $href . "order=PetName&dir=$dirPetName";
$BreedNameLink = $href . "order=Breed&dir=$dirBreed";
$PetBirthdayLink = $href . "order=PetBirthday&dir=$dirPetBirthday";

 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="../../static/styles/normalize.css">
<link rel="stylesheet" href="../styles/styles.css">
<title>Grooming Appointment List</title>
</head>
<body>
<main id='appnt-table-main'>
  <h1><?=$pageTitle?></h1>
  <table>
  <tbody>
  <caption>Total Appointments: <?= $appntCount ?> </caption>
  <thead>
    <tr>
        <th>
          <a href="<?= $groomingLink ?>">GroomingID</a>
        </th>
        <th>
          <a href="<?= $FirstNameLink ?>">FirstName</a>
        </th>
        <th>
          <a href="<?= $LastNameLink ?>">LastName</a>
        </th>
        <th>
          <a href="<?= $PetNameLink ?>">PetName</a>
        </th>
        <th>
          <a href="<?= $BreedNameLink ?>">Breed </a>
        </th>
        <th>
        <a href="<?=$PetBirthdayLink ?>">PetBirthday</a>
        </th>
    </tr>
  </thead>
  <?php
    while ($row = $stmt->fetch()) {
      $petsBirthdayInSec = strtotime($row['PetBirthday']);
      $petsBirthday = date('m/d/Y',$petsBirthdayInSec);
  ?>
  <tr>
    <td>  
      <a href="admin-apnt-view.php?GroomingID=<?=$row['GroomingID']?>">
        <?=$row['GroomingID']?>
      </a>
    </td>
    <td><?=$row['FirstName']?></td>
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
  </table>
</main>
</body>
</html>
<?php
  require '../includes/footer.php';
?>