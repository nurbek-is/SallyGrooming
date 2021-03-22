function toggleMenu() {
    var x = document.querySelector('nav ul');
    if (x.style.display === 'block') {
      x.style.display = 'none';
    } else {
      x.style.display = 'block';
    }
  }
  
  window.addEventListener('load', (e) => {
    var mobileMenuIcon = document.getElementById('mobile-menu-icon');
    mobileMenuIcon.addEventListener('click', (e) => {
      toggleMenu(e);
    });
  });
  
  window.addEventListener('resize', (e) => {
    var x = document.querySelector('nav ul');
    var width = parseInt(window.getComputedStyle(document.body).width);
    if (width >= 445) {
      x.style.display = 'block';
    } else {
      x.style.display = "none";
    }
  });