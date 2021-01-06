<footer>
  <span>Copyright &copy; 2019 Sally's Grooming Co.</span>
  <nav>
  <?php 
  if($currentUser) { 
    echo '<a href="logout.php">Log Out</a>';
    ?>
    <a href="index.php">Home</a>
    <a href="about.php">About us</a>
  </nav>
</footer>
</body>
</html>