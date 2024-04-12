<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

if (isset($_SESSION['user'])) {
    
    unset($_SESSION['user']);

  session_destroy();

  $response = array('success' => true);
  echo json_encode($response);
} else {
  $response = array('success' => false, 'message' => 'Nenhuma sessão encontrada.');
  echo json_encode($response);
}
