<?php
  $pageTitle = 'Edit';
  require 'includes/header.php';
  if (!isset( $_REQUEST['GroomingID'] )) {
    header("Location: index.php");
  }
  $groomId=$_REQUEST['GroomingID'];

  if (!isAppntRequester($groomId)) {
    header("Location: index.php");
  }
  $errors = [];

  if (!isAuthenticated()) {
    header("Location: login.php?no-access=1");
  }
  $months = [
    'January', 'February', 'March', 'April', 'May', 'June', 'July',
    'August', 'September', 'October', 'November', 'December'
  ];
  $pets = ['dog', 'cat', 'monkey', 'lama', 'goat'];
  $dogBreed = ['dobermann','rotweiler','pug','husky','pitbull','boxer'];

// selecting what is was already entered and autopopulatig some of the fields. 
  $query = "SELECT GroomingID,DateSubmitted,FirstName,LastName,Address,City,State,Zip,Email,PhoneNumber,PetType,Breed,PetName
  FROM grooming
  WHERE GroomingID = ?";

  $stmt = $db->prepare($query);
  $stmt->execute([$groomId]);
  $row = $stmt->fetch();
  //storing retrived values to variables
  if($row) {
    $groomingID = $row['GroomingID'];
    $dateSubmitted = date('m/d/Y', strtotime($row['DateSubmitted']));
    $firstName= $row['FirstName']; 
    $lastName = $row['LastName'];
    $address = $row['Address'];
    $city = $row['City'];
    $state = $row['State'];
    $zip = $row ['Zip'];
    $cellphone = $row ['PhoneNumber'];
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
  $f = [];
  // validating fields
  $dateSubmitted = date('Y-m-d H:i:s');
  $f['first-name'] = trim($_POST['first-name'] ?? '');
  $f['last-name'] = trim($_POST['last-name'] ?? '');
  $f['address'] = trim($_POST['address'] ?? '');
  $f['city'] = trim($_POST['city'] ?? '');
  $f['state'] = trim($_POST['state'] ?? '');
  $f['zip-code'] = trim($_POST['zip-code'] ?? '');
  $f['cell-phone'] = trim($_POST['cell-phone'] ?? '');
  $f['email'] = trim($_POST['email'] ?? '');
  $f['pet-name'] = trim($_POST['pet-name'] ?? '');
  $fixing = (int)$_POST['fixing'];
  $f['type-dog']= filter_input(INPUT_POST, 'type-dog',
  FILTER_VALIDATE_INT);
  $f['type-pet'] = filter_input(INPUT_POST, 'type-pet',
  FILTER_VALIDATE_INT);
  $f['birth-month'] = filter_input(INPUT_POST, 'birth-month',
  FILTER_VALIDATE_INT);
  $f['birth-day'] = filter_input(INPUT_POST, 'birth-day',
  FILTER_VALIDATE_INT);
  $f['birth-year'] = filter_input(INPUT_POST, 'birth-year',
  FILTER_VALIDATE_INT);
  $birthDate = mktime(0, 0, 0, $f['birth-month'],
  $f['birth-day'], $f['birth-year']);
  $sBirthDate = date("Y-m-d", $birthDate);
 
// if Edit button is clicked, and if fields not filled, promp error msg.
  if (!empty($_POST['GroomingID'])) {
    $errors = [];
    if (!$f['type-pet']) {
      $errors[] = 'type of pet is required.';
    }
    if ($f['type-pet']===1 && !$f['type-dog']) {
      $errors[] = 'Type of dog is required';
    }
    if (!$f['first-name']) {
      $errors[] = 'First name is required.';
    }
    if (!$f['last-name']) {
      $errors[] = 'Last name is required.';
    }
    if (!$f['cell-phone']) {
      $errors[] = 'Cell phone is required.';
    }    
    if (!$f['pet-name']) {
      $errors[] = 'Please provide the name of your pet';
    }
    if (!$errors) {
      $dateApproved = 'null'; // For now
    
      // Update appointment in mySQL
      $qUpdate = "UPDATE grooming
        SET FirstName = :FirstName,
          LastName = :LastName,
          Address = :Address,
          City = :City,
          State = :State,
          PhoneNumber = :PhoneNumber,
          Email = :Email,
          PetType = :PetType,
          Breed = :Breed,
          PetName = :PetName,
          NeuteredOrSpayed = :NeuteredOrSpayed,
          PetBirthday = :PetBirthday
        WHERE GroomingID = :GroomingID";

      try {
        $stmtUpdate = $db->prepare($qUpdate);
        $stmtUpdate->bindParam(':FirstName', $f['first-name']);
        $stmtUpdate->bindParam(':LastName', $f['last-name']);
        $stmtUpdate->bindParam(':Address', $f['address']);
        $stmtUpdate->bindParam(':City', $f['city']);
        $stmtUpdate->bindParam(':State', $f['state']);
        $stmtUpdate->bindParam(':PhoneNumber', $f['cell-phone']);
        $stmtUpdate->bindParam(':Email', $f['email']);
        $stmtUpdate->bindParam(':PetType', $pets[$f['type-pet'] - 1]);
        $stmtUpdate->bindParam(':Breed', $dogBreed[$f['type-dog']- 1]);
        $stmtUpdate->bindParam(':PetName', $f['pet-name']);
        $stmtUpdate->bindParam(':NeuteredOrSpayed', $fixing);
        $stmtUpdate->bindParam(':PetBirthday', $sBirthDate);
        $stmtUpdate->bindParam(':GroomingID', $groomId);
        $appntUpdated = $stmtUpdate->execute();
      } catch (PDOException $e) {
        $errors[] = 'Update failed. Please try again.';
        logError($e);
      }
    }

    if (!empty($appntUpdated)) {
      echo '<p class="success">Your Appointment is updated.</p>';
      echo '<p>We will review your updated Appointment and confirm with you soon.</p>';
    }
  }
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="styles/normalize.css">
<link rel="stylesheet" href="styles/styles.css">
<script src='grm-form.js' rel='script'></script>
<title>Grooming Appointment Form</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script> 
$(function(){
    $(".dog-div").hide();
  $("select:first()").on('change',function(){
    if($("#type-pet option:selected").text()=='dog') {
      $(".dog-div").show();
      } 
    })
  });
</script>
</head>
<body>
<main>
  <h1>Make a Grooming Appointment for your pet!</h1>
  <?php
   
    if (!empty($errors)) {
      // Show form errors
      echo '<h3>Please correct the following errors:</h3>
      <ol class="error">';
      foreach ($errors as $error) {
        echo "<li>$error</li>";
      }
      echo '</ol>';
    } 
  ?>
<form method="post" action="appnt-edit.php"  id='ap-form' novalidate>
   
    <fieldset>
      <legend>Owner Info</legend>
      <label for="first-name">First Name*:</label>
      <input type='text' name="first-name" id="first-name"  value="<?=$firstName?>" required minlength="1" maxlength="25">
      <label for="last-name">Last Name*:</label>
      <input type='text' name="last-name" id="last-name" value="<?=$lastName?>" required minlength="1" maxlength="25">
      <label for="address">Address*:</label>
      <input type='text' name="address" id="address" value="<?=$address?>"required minlength="1" maxlength="25">
      <label for="city">City*:</label>
      <input type='text' name="city" id="city" value="<?=$city?>"required minlength="1" maxlength="25">
      <label for="state">State*:</label>
      <input type='text' name="state" id="state" value="<?=$state?>"required minlength="1" maxlength="15">
      <label for="zip-code">Zip Code*:</label>
      <input type='number' name="zip-code" id="zip-code" value="<?=$zip?>" required minlength="1" maxlength="8">
      <label for="cellphone">Phone Number*:</label>
      <input type="tel" name="cell-phone" id="cell-phone" value="<?=$cellphone?>" pattern="[1-9]\d{2}-\d{3}-\d{4}" required minlength="1" maxlength="14">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" value="<?=$email?>">   
    </fieldset>
    <fieldset>
      <legend>Pet Info</legend>
      <legend>Owner Info</legend>
    </fieldset>
    <fieldset>
      <legend>Pet 

<label for="type-pet">Type of Pet*:</label>

    <select name="type-pet" id="type-pet">
    <option value="0">--Select Pet--</option>
    <?php
          for($i=1;$i<=5;$i++) {
            echo "<option value='$i'";
            if($i===$f['type-pet']) {
              echo " selected";
            }
            echo ">"  . $pets[$i-1] . "</option>";
          }     
    ?>
    </select> 
    <div class='dog-div'>
    <label for="type-dog">Dog Breed*:</label>
    <select name="type-dog" id="type-dog">
        <option value="0">--Select Breed--</option>
        <?php
          for($i=1;$i<=6;$i++) {
            echo "<option value='$i'";
            if($i===$f['type-dog']) {
              echo " selected";
            }
            echo ">"  . $dogBreed[$i-1] . "</option>";
          }     
          ?>
    </select> 
    </div> 
      <label for="pet-name">Pet's Name:</label>
      <input type="text" name="pet-name" id="pet-name" value="<?=$f['pet-name']?>"required>   
      <legend id='fixing'>Neutered Or Spayed:</legend>
      <section id='checkboxsection'>
       <!-- if neutered radio button is not selected, it defaults to 0.  -->
          <input type="radio" name="fixing" <?php if (isset($_POST['fixing']) && $_POST['fixing']=="1") echo "checked";?> value="1">Yes
          <input type="radio" name="fixing" <?php if (isset($_POST['fixing']) && $_POST['fixing']=="0") echo "checked";?> value="0">No
    </section>
    </fieldset>
      <fieldset>
        <legend>Pet Birth date:</legend>
        <section id='petbirthday'>
        <label for="birthday">Pet Day of Birth*:</label>
        <input type="number" name="birth-day" id='birth-day' value="<?=$f['birth-day']?>">
        <label for="birth-month">Birth Month:</label>
        <select name="birth-month" id='birth-month'>
          <option value="0">--Select Month--</option>
          <?php
          for($i=1;$i<=12;$i++) {
            echo "<option value='$i'";
            if($i===$f['birth-month']) {
              echo " selected";
            }
            echo ">"  . $months[$i-1] . "</option>";
          }
          ?>
        </select>
        <label for="birthyear">Birth Year*:</label>
        <input type="number"  name="birth-year" id='birth-year' value="<?=$f['birth-year']?>">
      </section>
      </fieldset>
      <button name="GroomingID" value="<?=$groomId?>" class="wide"> Edit Appointment
      </button>
  </form>
</main>
</body>