<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Assistant">
<link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" crossorigin="anonymous"
  href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
  integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU">
<link rel="stylesheet" href="styles/normalize.css">
<link rel="stylesheet" href="styles/styles.css">
<script src="scripts/scripts.js"></script>
<title>Pet-Shop </title>
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
  <main id="doh">
    <h1>Error Page!</h1>
    <article class="poem">
      We are sorry, there was technical problem with your request, we wil review adn try to solve this ASAP.
      thank you for your patience
    </article>
  </main>
  <footer>
    <p>
      <span>Copyright &copy; <?= date('Y')?> The Sally's Pet Shop.</span>
      <a href="logout.php">Log out</a>
      <a href="about-us.php">About us</a>
    </p>
  </footer>
</body>
</html>