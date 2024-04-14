<?php
require_once 'settings.php';

function getModule($moduleName, $props = null) {
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

function resizeImage($imageUrl, $width, $height) {
    $image = imagecreatefromstring(file_get_contents($imageUrl));
    $originalWidth = imagesx($image);
    $originalHeight = imagesy($image);
    $scale = min($width / $originalWidth, $height / $originalHeight);
    $newWidth = $originalWidth * $scale;
    $newHeight = $originalHeight * $scale;
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
    $croppedImage = imagecrop($newImage, ['x' => 0, 'y' => 0, 'width' => $width, 'height' => $height]);
    imagedestroy($image);
    imagedestroy($newImage);
    if ($croppedImage !== FALSE) {
        ob_start();
        imagejpeg($croppedImage);
        $imageData = ob_get_clean();
        $base64Image = 'data:image/jpeg;base64,' . base64_encode($imageData);
        imagedestroy($croppedImage);
        return $base64Image;
    } else {
        return false;
    }
}


function loadContent($url) {
    

    $modules = array(
        '' => 'homePage',
        'profile' => 'profilePage'
    );

    if (array_key_exists($url, $modules)) {
        getModule($modules[$url]);
        
    } else {
        getModule('404');
    }

}

?>