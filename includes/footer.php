<footer>
  <span>Copyright &copy; 2019 Sally's Grooming Co.</span>
  <nav>
    <?php
      if ($currentUserId) {
        echo '<a href="logout.php">Log out</a>';
      }
    ?>
    <a href="admin/index.php">Admin</a>
    <a href="about-us.php">About us</a>
  </nav>
</footer>
</body>
</html>