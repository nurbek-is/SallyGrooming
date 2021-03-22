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
              ? 'Nurbekkos Awesome Grooming Co'
              : $pageTitle . ' | Your friends here';
  
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">

<link rel="stylesheet" crossorigin="anonymous"
  href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
  integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU">
<link rel="stylesheet" href="styles/normalize.css">
<link rel="stylesheet" href="styles/styles.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src='scripts/breakpoints-script.js'></script>
<title><?= $pageTitleTag ?> | The Nurbs Pet Grooming Co.</title>
</head>
<body>
<header>
  <nav id="main-nav">
    <!-- Bar icon for mobile menu -->
    <i id="mobile-menu-icon" class="fa fa-bars"></i>
    <ul id='ul-nav'>
      <li><a href="index.php">Home</a></li>
      <li><a href="services.php">Services</a></li>
      <?php if($currentUserId) {?>
      <li><a href="user-profile.php">My Account</a></li> 
      <?php } else { ?>
      <li><a href="login.php">Login</a></li>
      <?php } ?>
      <li><a href="grooming.php">Grooming</a></li>  
      <li><a href="location.php">Location</a></li>
      <li><a href="contact.php">Contact us</a></li>
      <li class='contains'><a href="about.php">About Us</a>
          <ul>
            <li><a href='about.php'>Company</a></li>
            <li><a href='reviews.php'>Reviews</a></li>
            <li><a href='blog.php'>Blog</a></li>
          </ul>
      </li>
    </ul>
    <img src="../images/logo.jpeg" alt="logo photo">
  </nav>
</header>
    <section id='header-title'>
    <h1>
        <a href="index.php">TheNurbs Pet Grooming Co</a>
      </h1>
      <!-- <h2> Enjoy your dogs beauty ...</h2> -->
    </section>
