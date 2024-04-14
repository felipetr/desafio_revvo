<?php
$parentDir = dirname(__DIR__);

$dotenv = parse_ini_file($parentDir . '/.env');

foreach ($dotenv as $key => $value) {
    putenv("$key=$value");
}

    $dbHost = getenv('DB_HOST');
    $dbUser = getenv('DB_USER');
    $dbPass = getenv('DB_PASS');
    $dbName = getenv('DB_NAME');

    try {
        $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    } catch (PDOException $e) {
        echo  'Database connection failed: ' . htmlentities($e->getMessage());
        exit();
    }