<?php
// createCourse

if (session_status() === PHP_SESSION_NONE || !isset($_SESSION['user'])) {
  exit();
}

include_once '../functions.php';

$slug = $_POST['slug'];

$pdo = connectServer();


$response = array();

$response = array();

try {


    $sql = "DELETE FROM cursos WHERE slug = :slug";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':slug', $slug);

    if ($stmt->execute()) {
        $response = array(
            'success' => true,
            'slug' => $slug
        );
    } else {
        $errorMsg = 'Erro ao deletar a linha.';
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
