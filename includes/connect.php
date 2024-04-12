<?php


try {
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
  
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    echo "<script>console.log('Connected to MySQL database successfully!')</script>";
  
  
  } catch(PDOException $e) {
    echo  "<script>console.log('Database connection failed: ".$e->getMessage()."')</script>";
  }

