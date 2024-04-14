<?php
//DB Settings
session_start();

$dbHost = "localhost"; 
$dbName = "desafio_revvo";
$dbUser = "root";
$dbPass = "root";

//Host Settings
$serverUrl = 'http://localhost/';

function baseUrl()
{
    global $serverUrl;
    return $serverUrl.'desafio_revvo/';
}

function distUrl()
{
    global $serverUrl;
    return $serverUrl.'desafio_revvo/dist/';
}
//Includes
require_once 'connect.php';

