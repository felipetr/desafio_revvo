<?php
require_once 'settings.php';

function getModule($moduleName, $props = null)
{
    $modulePath = dirname(__DIR__) . '/modules/' . $moduleName . '.php';

    if (file_exists($modulePath)) {

        if ($props !== null) {
            extract($props);
        }
        require_once $modulePath;
    } else {
        throw new Exception("Module file '$modulePath' not found.");
    }
}

function resizeImage($imageUrl, $width, $height)
{
    $image = imagecreatefromstring(file_get_contents($imageUrl));
    $originalWidth = imagesx($image);
    $originalHeight = imagesy($image);

    $originalAspectRatio = $originalWidth / $originalHeight;
    $desiredAspectRatio = $width / $height;

    if ($originalAspectRatio > $desiredAspectRatio) {
        // Original image is wider than desired aspect ratio, crop width
        $newWidth = $originalHeight * $desiredAspectRatio;
        $newHeight = $originalHeight;
        $cropX = ($originalWidth - $newWidth) / 2;
        $cropY = 0;
    } else {
        // Original image is taller than desired aspect ratio, crop height
        $newWidth = $originalWidth;
        $newHeight = $originalWidth / $desiredAspectRatio;
        $cropX = 0;
        $cropY = ($originalHeight - $newHeight) / 2;
    }

    $resizedImage = imagecreatetruecolor($width, $height);
    imagecopyresampled($resizedImage, $image, 0, 0, $cropX, $cropY, $width, $height, $newWidth, $newHeight);

    imagedestroy($image);

    if ($resizedImage !== FALSE) {
        ob_start();
        imagejpeg($resizedImage);
        $imageData = ob_get_clean();
        $base64Image = 'data:image/jpeg;base64,' . base64_encode($imageData);
        imagedestroy($resizedImage);
        return $base64Image;
    } else {
        return false;
    }
}

function getUrlArray($url)
{
    $urlArr = explode('/', $url);
    array_shift($urlArr);
    return $urlArr;
}
function connectServer()
{
    global $dbHost;
    global $dbName;
    global $dbUser;
    global $dbPass;
    try {
        $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
      
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
      
      
      
      } catch(PDOException $e) {
        echo  "<script>console.log('Database connection failed: ".$e->getMessage()."')</script>";
      }
      

}
function loadContent($url)
{

    if (strstr($url, '/')) {
        $urlArr = explode('/', $url);
        foreach ($urlArr as $key => $value) {
            if ($key) {
                $urlArr[$key] = '$' . $key;
            }
            $url = implode('/', $urlArr);
        }
    }

    $modules = array(
        '' => 'homePage',
        'profile' => 'profilePage',
        'curso/$1' => 'cursoPage'
    );

    if (array_key_exists($url, $modules)) {
        getModule($modules[$url]);
    } else {
        getModule('404');
    }
}
