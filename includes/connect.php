<?php


try {
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
  
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  
  
  } catch(PDOException $e) {
    echo  "<script>console.log('Database connection failed: ".$e->getMessage()."')</script>";
  }

