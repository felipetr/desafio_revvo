<?php

include('connect.php');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['user'])) {
  
  unset($_SESSION['user']);

session_destroy();

}
$email = trim($_POST['email']);
$password = sha1(trim($_POST['password']));

$sql = "SELECT * FROM user WHERE email = :email AND pass = :password";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $password);
$stmt->execute();

if ($stmt->rowCount() === 1) {

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }
  $_SESSION['user'] = $stmt->fetch(); 
  $response = array(
    "success" => true,
    "message" => "Login efetuado com sucesso!",
    "user" => $_SESSION['user']
  );

  
  echo json_encode($response);
  $pdo = null;
  exit;
  
} else {

    $response = array(
        "success" => false,
        "message" => "Erro no login: Email ou senha inválidos."
      );
    
      echo json_encode($response);
      $pdo = null;
      exit;
  $errorMessage = "Erro no login: Email ou senha inválidos.";
}

$pdo = null;