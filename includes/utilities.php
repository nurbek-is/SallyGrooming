<?php 
require_once 'config.php';

  function dbConnect() {
    $dbConfig = getDbConfig();
    $dsn2 = $dbConfig['dsn2'];
    $username =  $dbConfig['un'];
    $password =  $dbConfig['pw'];  

    try {
      $db = new PDO($dsn2, $username, $password);
      return $db;
    } catch (PDOException $e) {
      // log error
      logError($e, true);
      return false;
    }
  }
  function isAuthenticated() {
    return isset($_SESSION['user-id']);
  }

  function isDebugMode() {
    // You may want to provide other ways for setting debug mode
    return !isProduction();
  }
  function isProduction() {
    // Provide way of knowing if the code is on production server
    return false ;
  }

  function generateToken($length = 64) {
    /*
      generate random token
    */
    if ($length % 2 !== 0) {
      throw new Exception('$length must be even.');
      return false;
    }
    return bin2hex(random_bytes($length/2));
  }

  function getFullPath($relativePath) {
    /*
      From http://php.net/manual/en/reserved.variables.server.php
        Note that when using ISAPI with IIS, the value will be
        off if the request was not made through the HTTPS protocol.
    */
    $protocol = ( !empty($_SERVER['HTTPS']) &&    // Non-empty if HTTPS
                  $_SERVER['HTTPS'] !== 'off' ||  // See note above
                  $_SERVER['SERVER_PORT'] == 443  // port used for SSL
                ) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];

    $relPathSplit = explode('/', $relativePath);
    $pathFromHost = dirname($_SERVER['REQUEST_URI']);
    $pathFromHostSplit = explode('/', $pathFromHost);
    while ($relPathSplit[0] === '..') {
      array_shift($relPathSplit);
      array_pop($pathFromHostSplit);
    }
  
    return $protocol.$domainName . 
            implode('/', $pathFromHostSplit) . '/' . 
            implode('/', $relPathSplit);
  }

  function logError($e, $redirect=false) { 
    $errorType = gettype($e);
    switch ($errorType) {
      case 'string':
        $msg = $e;
        break;
      default:
        $msg = $e->getMessage() . ' in ' . $e->getFile() . 
          ' on line ' . $e->getLine();
    }
    error_log($msg); //php_error.log
  
  if (isDebugMode()) {
    echo "<h3 class='error'>For Developers' Eyes Only</h3>
      <div class='error'>$msg</div>";
  }
 
  if ($redirect && !isDebugMode()) {
    // Redirect to error page
    header("Location: error-page.php");
    }
  }

  function logout() {
    unset($_SESSION['user-id']);
    unset($_COOKIE['token']); // unset on server
    setcookie('token', '', 0); // unset on client
  }
?>