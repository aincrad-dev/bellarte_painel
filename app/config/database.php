<?php
try {
  $database = 'bellart-api';
  $dsn = 'mysql:host=localhost:3306;dbname=' . $database;
  $username = 'root';
  $password = '';

  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
}
