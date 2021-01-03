<?php
session_start();
 require_once 'config.php';
 require_once 'utilities.php';
 require_once 'constants.php';

if (isDebugMode()) {
  ini_set('display_errors', '1');
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
        logError($e);
      }
    }
  }
  $pageTitleTag = empty($pageTitle)
              ? 'Nurbekkos Awesome Grooming Co'
              : $pageTitle . ' | The 1 to call';
  
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Frank+Ruhl+Libre:300,400">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Assistant">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" crossorigin="anonymous"
  href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
  integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU">
<link rel="stylesheet" href="../../../static/styles/normalize.css">
<link rel="stylesheet" href="/styles/styles.css">
<script src="../../../static/scripts/scripts.js"></script>
<title><?= $pageTitle ?> | The Nurbs Pet Grooming Co.</title>
</head>
<body>
<header>
  <nav id="main-nav">
    <!-- Bar icon for mobile menu -->
    <div id="mobile-menu-icon">
      <i class="fa fa-bars"></i>
    </div>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="aboutus.php">AboutUs</a></li>
      <li><a href="admin.php">Store Location</a></li>
      <li><a href="grooming.php">Grooming</a></li>
      <li><a href="contact.php">Contact us</a></li>
    </ul>
  </nav>
  <h1>
    <a href="index.php">TheNurbs Pet Grooming Co</a>
  </h1>
  <h2> Enjoy your dogs beauty ...</h2>
</header>