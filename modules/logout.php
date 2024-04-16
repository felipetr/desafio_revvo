<?php
// logout

  session_start();
  session_destroy();

$response = array('success' => true);
  echo json_encode($response);
