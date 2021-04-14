<?php
session_start();
 require_once 'config.php';
 require_once 'utilities.php';
 require_once 'constants.php';

if (isDebugMode()) {
  ini_set('display_errors', '0');
}

// If $db isn't already set, set it.
if (!isset($db)) {
  $db = dbConnect();
}

$currentUserId = $_SESSION['user-id'] ?? 0;
  if (!$currentUserId) {
    // Do we remember this user?
    if (isset($_COOKIE['token'])) {
      $qSelect = "SELECT user_id 
      FROM tokens 
      WHERE token = ? AND token_expires > now()";

      try {
        $stmt = $db->prepare($qSelect);
        $stmt->execute([$_COOKIE['token']]);
    
        if ($row = $stmt->fetch()) {
          // Found unexpired matching token
          $_SESSION['user-id'] = $row['user_id'];
          $currentUserId = $row['user_id'];
        }
      } catch (PDOException $e) {
        logError($e->getMessage());
      }
    }
  }
  $pageTitleTag = empty($pageTitle)
  ? "The Sandy's Pet Grooming Co."
  : $pageTitle . ' | Your Trusted Pet Groomer in NW';
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">

<link rel="stylesheet" crossorigin="anonymous"
  href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
  integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU">
<link rel="stylesheet" href="styles/reset.css">
<link rel="stylesheet" href="styles/normalize.css">
<link rel="stylesheet" href="styles/styles.css">
<link rel="stylesheet" href="../styles/styles.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src='scripts/breakpoints-script.js'></script>
<!-- script src below is for subfolder, admin files -->
<script src='../scripts/breakpoints-script.js'></script>
<script> 
$(function(){
    $(".dog-div").hide();
  $("select:first()").on('change',function(){
    if($("#type-pet option:selected").text()=='dog') {
      $(".dog-div").show();
    } 
  })
  });

$(function(){
    $('#category-tabs li a').click(function(){
    $(this).next('ul').slideToggle('500');
    $(this).find('i').toggleClass('fa-plus-circle fa-minus-circle');
});
  });
// When the user clicks on Vendors in footer, open the popup
function footerPopUpFunction() {
  let popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>
<title><?= $pageTitleTag ?> | The Sandy's Pet Grooming Co.</title>
</head>
<body>
<header>
  <nav id="main-nav">
    <!-- Bar icon for mobile menu -->
    <i id="mobile-menu-icon" class="fas fa-bars"></i>
    <ul id='ul-nav'>
      <li><a href="index.php">Home</a></li>
      <?php if($currentUserId) {?>
      <li><a href="user-profile.php">My Account</a></li> 
      <?php } else { ?>
      <li><a href="login.php">Login</a></li>
      <?php } ?>
      <li><a href="grooming.php">Make an Appointment</a></li>  
      <li><a href="location.php">Location</a></li>
      <li><a href="contact.php">Contact us</a></li>
      <li class='contains'><a href="about.php">About Us</a>
          <ul>
            <li><a href='about.php'>Company</a></li>
            <li><a href='reviews.php'>Reviews</a></li>
            <li><a href='gallery.php'>Gallery</a></li>
          </ul>
      </li>
    </ul>
  </nav>
</header>
    <section id='header-title'>
    <h1>
        <a href="index.php">Sandy's Pet Shop, Your Trusted Pet Groomer</a>
      </h1>
      
    </section>
