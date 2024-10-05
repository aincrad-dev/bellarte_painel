<?php


// Connect to the database
//$conn = new mysqli($db_host, $db_username, $db_password, $db_name);


try {
    $database = 'bellart-api';
    $dsn = 'mysql:host=localhost;dbname=' . $database;
    $username = 'root';
    $password = '';

    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>