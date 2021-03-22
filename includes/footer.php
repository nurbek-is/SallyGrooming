<footer>
  <nav id='footer'>
  <h2>Find us below!</h2>
      <a href="https://www.facebook.com/">
        <img alt="Facebook Logo" src="images/facebook-logo.png"></a>
      <a href="https://www.instagram.com/">
        <img alt="Instagram Logo" src="images/instagram-logo.png"></a>
      <a href="https://twitter.com/">
        <img alt="Twitter Logo" src="images/twitter-logo.png"></a>
      <a href="https://www.pinterest.com/#">
 <img alt="Pinterest Logo" src="images/pinterest-logo.png"></a>
    <span>Copyright &copy; 2019 Sandys Grooming Co.</span>
    <p>Monday-Saturday 8 am-8pm </p>
    <?php
      if ($currentUserId) {
        echo '<a href="logout.php">Log out</a>';
      }
    ?>
  <div class="dropup">
  <button class="dropbtn">Admin</button>
      <div class="dropup-content">
           <a href='admin/admin.php'>View</a>
           <a href='admin/admin-apnt-edit.php'>Edit</a>
           <a href='admin/admin-apnt-delete.php'>Delete</a>  
      </div>
  </div>
  <a href="logout.php">About Us</a>
  </nav>
</footer>
</body>
</html>