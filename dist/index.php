<?php
include_once '../includes/functions.php';

getModule('header');

$url = '';
if(isset($_GET['url'])) {
    $url = $_GET['url'];
}


loadContent($url);

getModule('firstModal'); 

getModule('footer');

?>