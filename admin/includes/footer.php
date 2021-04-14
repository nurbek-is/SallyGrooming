<footer>
  <nav id='footer'>
      <a href="https://www.facebook.com/">
        <img alt="Facebook Logo" src="../images/facebook-logo.png"></a>
      <a href="https://www.instagram.com/">
        <img alt="Instagram Logo" src="../images/instagram-logo.png"></a>
      <a href="https://twitter.com/">
        <img alt="Twitter Logo" src="../images/twitter-logo.png"></a>
      <a href="https://www.pinterest.com/#">
 <img alt="Pinterest Logo" src="../images/pinterest-logo.png"></a>
    <span>Copyright &copy; 2019 Sandys Grooming Co.</span>
    <p>Monday-Saturday 8 am-8pm </p>
    <?php
      if ($currentUserId) {
        echo '<a href="logout.php">Log out</a>';
      }
      ?>
      <span>206-432-5498.  ********* 400 W Garfield St, Seattle, WA 98119</span>
      <div class="dropup">
  <button class="dropbtn">Admin</button>
      <div class="dropup-content">
           <a href='admin.php'>View</a>
           <a href='login.php'>Log In</a>
      </div>
  </div>
      <div class="popup" onclick="footerPopUpFunction()">Need PetSitter or Vet etc?
  <span class="popuptext" id="myPopup"><div>Our Partner Pet Sitters/Walkers,Vets
    <br>  <a href='http://hotdiggitypetsitting.com/seattle/'>Pet Sitter/Walker</a>
    <br>  <a href='https://bluepearlvet.com/hospital/downtown-seattle-wa/'>Veterinarians</a>
    <br>  <a href='https://seattledogshow.org/'>Kennel</a>
  </div></span>
</div>
  </nav>
</footer>
</body>
</html>