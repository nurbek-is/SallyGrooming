<?php
  require_once 'includes/utilities.php';
  session_start();
  logout();
  header("Location: index.php");
?>