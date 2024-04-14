<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  session_destroy();

$response = array('success' => true);
  echo json_encode($response);
