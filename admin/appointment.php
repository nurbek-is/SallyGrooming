<?php
    require_once 'config.php';
    require_once 'includes/utilities.php';
    require 'includes/header.php';
    $pageTitle= 'Appointment';
    $db = dbConnect();

    if (!isAuthenticated()) {
      header("Location: login.php?no-access=1");
    }
   $groomId=$_GET['GroomingID'];
  $query = "SELECT GroomingID,DateSubmitted,FirstName, LastName,Address, City, State, Zip, PhoneNumber, 
  Email, PetType, Breed, PetName, NeuteredOrSpayed,PetBirthday
  FROM grooming
  WHERE GroomingID = ?";

  $stmt = $db->prepare($query);
  $stmt->execute([$groomId]);
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
    $phone = $row ['PhoneNumber'];
    $email = $row ['Email'];
    $petType = $row['PetType'];
    $breed = $row['Breed'];
    $petName = $row['PetName'];
    $neuteredOrSpayed = $row['NeuteredOrSpayed'];
    $fixingStatus = (int) $neuteredOrSpayed;
    $petBirthdayInSec = strtotime($row['PetBirthday']);
    $petBirthday = date('m/d/Y', $petBirthdayInSec);
  } else {
    $title = "There is no pet appointment for this groomingID";
  }
 
?>

<main class='mustard-container'>
<?php if ($row) { ?>
  <h1><?= 'Thank you for your submission for appointment' ?></h1>
  <div><?= nl2br('Date Submitted: '. $dateSubmitted) ?></div>
  
  <?= nl2br('Pending Review') ?>

 
<table>
  <tr>
    <td><?= '$groomingID is ' ?></td>
    <td><?= $groomingID ?></td>
  <tr>
    <td><?= "Pet-Owner\'s Name: " ?></td>
    <td><?= $firstName ?></td>
  </tr>
  <tr>
    <td><?= "Last Name:" ?></td>
    <td><?= $lastName?></td>
  </tr>
  <tr>
    <td><?='address: '  ?></td>
    <td><?= $address?></td>
  </tr>
  <tr>
    <td><?= 'City: ' ?></td>
    <td><?=$city ?></td>
  </tr>
  <tr>
    <td><?= 'State: ' ?></td>
    <td><?=$state ?></td>
  </tr>
  <tr>
    <td><?= 'Zip code: ' ?></td>
    <td><?=$zip ?></td>
  </tr>
  <tr>
  <tr>
    <td><?= 'Phone Number: ' ?></td>
    <td><?=$phone ?></td>
  </tr>
  <tr>
    <td><?= 'Email: ' ?></td>
    <td><?= $email?></td>
  </tr>
  <tr>
    <td><?= 'Type of Pet: ' ?></td>
    <td><?= $petType?></td>
  </tr>
  <tr>
    <?php if(!empty($breed) ) {?>
      <tr>
      <td><?= 'Type of Breed: ' ?></td>
      <td><?= $breed?></td>
    </tr>
    <?php }?>
    <td><?= 'Name of Pet: ' ?></td>
    <td><?=$petName ?></td>
  </tr>
  
  <?php if($fixingStatus >=0) {?>
  <tr>
    <td><?= 'Your Pet is fixed? 1 for Yes or 0 for No: ' ?></td>
    <td><?= $fixingStatus?></td>
  </tr>
  <?php }?>
  <?php if(!empty($petBirthday) ) {?>
  <tr>
    <td><?= 'Pet Birthday: '?></td>
    <td><?= $petBirthday?></td>
  </tr>
  <?php }?>
  </table>
<?php } else { ?>
  <h1>No Results</h1>
  <p><?= $title?></p>
<?php } ?>
</main>
</body>
</html>

<?php
  require 'includes/footer.php';
?>