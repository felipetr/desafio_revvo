<?php
// createCourse

session_start();
if (!isset($_SESSION['user'])) { 
  exit();
}

include_once '../functions.php';

$title = $_POST['title'];
$text = $_POST['text'];
$image = $_POST['image'];
$destaque = $_POST['destaque'];
$isNew = $_POST['isNew'];
$modulo_title = $_POST['modulo_title'];
$modulo_content = $_POST['modulo_content'];
$slug = $_POST['slug'];

$modulosArr = [];

foreach ($modulo_title as $index => $value) {

  $title = $value;
  $content = $modulo_content[$index];

  $moduloObj = array(
    'title' => $title,
    'content' => $content
  );

  array_push($modulosArr, $moduloObj);
}

$content = json_encode($modulosArr);

$pdo = connectServer();


$response = array();

try {

   
    $sql = "UPDATE cursos SET title = :title, text = :text, image = :image, destaque = :destaque, isNew = :isNew, content = :content WHERE slug = :slug";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':text', $text);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':destaque', $destaque);
    $stmt->bindParam(':isNew', $isNew);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':slug', $slug);

    if ($stmt->execute()) {
        $response = array(
            'success' => true,
            'slug' => $slug
        );
    } else {
        $errorMsg = 'Erro ao atualizar a linha.';
        $response = array(
            'success' => false,
            'msg' => $errorMsg
        );
    }
} catch(PDOException $e) {
    $response = array(
        'success' => false,
        'msg' => 'Erro: ' . $e->getMessage()
    );
}

header('Content-Type: application/json');
echo json_encode($response);

?>