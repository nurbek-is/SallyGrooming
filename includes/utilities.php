<?php 
require_once 'config.php';
  function isProduction() {
    // Provide way of knowing if the code is on production server
    return false ;
  }
  function dbConnect() {
    $dbConfig = getDbConfig();
    $dsn2 = $dbConfig['dsn2'];
    $username =  $dbConfig['un']; //intentionally removed username
    $password =  $dbConfig['pw']; //intentionally left blank

    try {
      $db = new PDO($dsn2, $username, $password);
      return $db;
    } catch (PDOException $e) {
      // log error
      logError($e, true);
      return false;
    }
  }

  function isDebugMode() {
    // You may want to provide other ways for setting debug mode
    return !isProduction();
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

?>