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
  function isAppntRequester($groomId, $userId = null) {
    /*
      Check if user is requestr of Appointment
      $userID defaults to logged-in user id
    */
    $db = dbConnect();
    if (!$userId && !isAuthenticated()) {
      return false;
    }
    $userId = $userId ?? $_SESSION['user-id'];
    $q = 'SELECT user_id FROM grooming  WHERE GroomingID = ?';
    try {
      $stmt = $db->prepare($q);
      $stmt->execute([$groomId]);
      $row = $stmt->fetch();
    } catch (PDOException $e) {
      logError($e);
      return false;
    }

    return($row['user_id'] === $userId);
  }
  function isAdmin($userId) {
    /*
      Check if user is admin.
    */
    $db = dbConnect();
    $q = 'SELECT is_admin FROM users WHERE user_id = ?';

    try {
      $stmt = $db->prepare($q);
      $stmt->execute( [$userId] ); 
      if (!$row = $stmt->fetch()) {
        return false;
      }
    } catch (PDOException $e) {
      logError( $e->getMessage() );
      return false;
    }

    return $row['is_admin']; // Returns 0 or 1
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
  function uploadProfilePic($img) {
    // Get the temporary location
    $imgTmpLocation = $img['tmp_name'];
 
    // Check mime type and file error
    $fileError = $img['error'];
    $allowedTypes = ['image/png','image/jpeg'];
    $mimeType = mime_content_type($imgTmpLocation);
 
    if (!in_array($mimeType, $allowedTypes)) {
      return false;
    } elseif ($fileError) {
      logError($fileError);
      return false;
    }
 
    // Create new image name and path
    $ext = ($mimeType === 'image/png') ? 'png' : 'jpg';
    $time = time();
    $newImgFileName = "profile-$time.$ext";
    $fileSavePath = 'static/images/profile-pics/' .
                    $newImgFileName;
   // Try to move the passed-in image to the new path
   try {
     if ($mimeType === 'image/png') {
       if ($img = imagecreatefrompng($imgTmpLocation)) {
         $newImg = imagescale($img, 200, 200);
         imagesavealpha($newImg, true);
         imagepng($newImg, $fileSavePath);
         imagedestroy($img);
       } else {
         logError('imagecreatefrompng() failed: ' . $fileSavePath);
         return false;
       }
     } else { // jpg
       if ($img = imagecreatefromjpeg($imgTmpLocation)) {
         $newImg = imagescale($img, 200, 200);
         imagejpeg($newImg, $fileSavePath);
         imagedestroy($img);
       } else {
         logError('imagecreatefromjpeg() failed: ' . $fileSavePath);
         return false;
       }
     }
     return $newImgFileName;
   } catch (PDOException $e) {
     logError($e->getMessage());
     return false;
   }
  }
?>