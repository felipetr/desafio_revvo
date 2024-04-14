<?php
require_once 'connect.php';
require_once 'modules.php';

if (session_status() === PHP_SESSION_NONE && !isset($_SESSION)) {    
    
    session_start();
    session_destroy();    

}

$parentDir = dirname(__DIR__);

$dotenv = parse_ini_file($parentDir . '/.env');

foreach ($dotenv as $key => $value) {
    putenv("$key=$value");
}


function baseUrl()
{
    return getenv('BASE_URL').'/';
}

function serverPath()
{
   
    $baseUrl =  rtrim(getenv('BASE_URL'));
    $urlWithoutProtocol = preg_replace('#^https?://#', '', $baseUrl);
    if(strpos($urlWithoutProtocol, $baseUrl) === 0)
    {
        return '../';
    }else
    {
        $baseUrlArr =  explode('/',getenv('BASE_URL'));
        array_pop($baseUrlArr);
        return  implode('/',$baseUrlArr).'/';


    }

}



function pagination($page, $limit = null) {
    if ($limit === null) {
        $limit = getenv('PAGINATION_DEFAULT_LIMIT');
    }

    return array(
        'limit' => $limit,
        'page' => $page,
        'offset' => ($page - 1) * $limit,
    );
}

function  mountPaginationUrl($url, $i, $gets = null)
{
    $response = baseUrl().$url.'/'.$i;
    
    if($gets)
    {
        $response .= "?";
        $i = 0;
        foreach ($gets as $key => $value) {
            if($i)
            {
                $response .= '&';
            }
            $i++;
            $response .= $key.'='.$value;
        }
    }
    return $response;

}
function getModule($moduleName, $props = null)
{
    $modulePath = dirname(__DIR__) . '/modules/' . $moduleName . '.php';

    if (file_exists($modulePath)) {

        if ($props !== null) {
            extract($props);
        }
        require $modulePath;
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
    $dbHost = getenv('DB_HOST');
    $dbUser = getenv('DB_USER');
    $dbPass = getenv('DB_PASS');
    $dbName = getenv('DB_NAME');

    try {
        $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (PDOException $e) {
        echo  'Database connection failed: ' . htmlentities($e->getMessage());
        exit();
    }
}


function getTitle($url)
{
    $modules = modules();
    if (strstr($url, '/')) {
        $urlArr = explode('/', $url);
        foreach ($urlArr as $key => $value) {
            if ($key) {
                $urlArr[$key] = '$' . $key;
            }
            $url = implode('/', $urlArr);
        }
    }
    if(isset($modules[$url]))
    {
        return  $modules[$url]['title'];
    }else{
        return $modules['404']['title'];
    }
}
function getCourseDataBySlug($slug)
{
    $conn = connectServer();

    $sql = "SELECT * FROM cursos WHERE slug = :slug";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':slug', $slug);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0];

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

    $modules = modules();

    if (array_key_exists($url, $modules)) {

        getModule($modules[$url]['module']);
    } else {?>
         <meta http-equiv="refresh" content="0; URL=<?php echo baseUrl().'404' ?>">
    <?php
        exit;
    }
}
