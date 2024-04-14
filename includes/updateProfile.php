<?php
// updateProfile

if (session_status() === PHP_SESSION_NONE || !isset($_SESSION['user'])) {
  exit();
}


include('connect.php');


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
