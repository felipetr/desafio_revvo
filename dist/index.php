<?php

include_once '../includes/functions.php';

$url = '';
if(isset($_GET['url'])) {
    $url = $_GET['url'];
}

getModule('header');

loadContent($url);

getModule('firstModal'); 

getModule('footer');

?>