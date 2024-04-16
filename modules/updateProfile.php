<?php
// updateProfile


session_start();
if (!isset($_SESSION['user'])) { 
  exit();
}


include('../connect.php');
include('../functions.php');


$id = $_SESSION['user']['id'];
$errorMsg = '';

$name = $_POST['name'];
$avatar = $_POST['avatar'];
$gender = $_POST['gender'];


$sql = "UPDATE user SET gender = :gender WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':gender', $gender);
$stmt->bindParam(':id', $id);


if ($stmt->execute()) {
 
} else {
  $errorMsg .= 'Erro ao salvar o gênero/';
 
}

if ($name) {
  $sql = "UPDATE user SET name = :name WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':id', $id);

  if ($stmt->execute()) {
  } else {
    $errorMsg .= 'Erro ao salvar o nome/';
  }
}

if ($avatar) {
  $sql = "UPDATE user SET avatar = :avatar WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':avatar', $avatar);
  $stmt->bindParam(':id', $id);

  if ($stmt->execute()) {
  } else {
    $errorMsg .= 'Erro ao salvar o avatar/';
  }
}

$_POST['b64'] = resizeImage(baseUrl().'uploads/'.$_POST['avatar'], 43, 43);

$response = array(
  'success' => true,
  'data' => $_POST
);
if ($errorMsg) {
  $response = array(
    'success' => false,
    'msg' => $errorMsg
  );
} else {
  $sql = "SELECT * FROM user WHERE id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  $_SESSION['user'] = $stmt->fetch();

}
echo json_encode($response);
