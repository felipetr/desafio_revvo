<?php
// updatePass

session_start();
if (!isset($_SESSION['user'])) { 
  exit();
}


include('../connect.php');


$id = $_SESSION['user']['id'];
$errorMsg = '';

$pass = sha1(trim($_POST['pass']));
$pass2 = sha1(trim($_POST['pass2']));
$oldpass = sha1(trim($_POST['oldpass']));

$bankpass = $_SESSION['user']['pass'];

if($oldpass != $bankpass)
{
  $response = array(
    'success' => false,
    'msg' => 'Senha antiga não é válida!'
  );

  echo json_encode($response);
  exit();
}


if($pass != $pass2)
{
  $response = array(
    'success' => false,
    'msg' => 'Senhas não coindidem!'
  );

  echo json_encode($response);
  exit();
}
if($pass === $pass2 && $pass)
{



$sql = "UPDATE user SET pass = :pass WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':pass', $pass);
$stmt->bindParam(':id', $id);

}

if ($stmt->execute()) {
} else {
  $errorMsg .= 'Erro ao salvar senha';
}

if ($errorMsg) {
  $response = array(
    'success' => false,
    'msg' => $errorMsg
  );
} else {

   $_SESSION['user']['pass'] = $pass;

   $response = array(
    'success' => true
  );
}
echo json_encode($response);
