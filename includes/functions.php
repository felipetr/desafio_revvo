<?php
// functions
require_once 'modules.php';


$parentDir = dirname(__DIR__);

$dotenv = parse_ini_file($parentDir . '/.env');

foreach ($dotenv as $key => $value) {
    putenv("$key=$value");
}

function checkLogin()
{
    if (!isset($_SESSION['user'])) {
        ?>
        <meta http-equiv="refresh" content="0; URL=<?php echo baseUrl(); ?>">
        <?php
        exit();
      }
    
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

function createSlug($string, $table, $column, $pdo) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));

    $query = "SELECT COUNT(*) AS total FROM $table WHERE $column = :slug";
    $statement = $pdo->prepare($query);
    $statement->execute(array(':slug' => $slug));
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if ($result['total'] > 0) {
        $i = 1;
        do {
            $newSlug = $slug . '-' . $i;
            $query = "SELECT COUNT(*) AS total FROM $table WHERE $column = :newSlug";
            $statement = $pdo->prepare($query);
            $statement->execute(array(':newSlug' => $newSlug));
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $i++;
        } while ($result['total'] > 0);

        $slug = $newSlug;
    }

    return $slug;
}

function getCursoBySlug($slug, $pdo) {
    try {

        $sql = "SELECT * FROM cursos WHERE slug = :slug";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':slug', $slug);

        $stmt->execute();

        $curso = $stmt->fetch(PDO::FETCH_ASSOC);

        return $curso;
    } catch(PDOException $e) {

        return null;
    }
}