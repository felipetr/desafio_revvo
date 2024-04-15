<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
include_once '../includes/functions.php';

$url = '';
if(isset($_GET['url'])) {
    $url = $_GET['url'];
}

getModule('header');

loadContent($url);



getModule('footer');

?>