<?php
try {
  $database = $env['DB_NAME'];
  $dsn = 'mysql:host=' . $env['DB_HOST'] . ':' . $env['DB_PORT'] . ';dbname=' . $database;
  $username = $env['DB_USERNAME'];
  $password = $env['DB_PASSWORD'];

  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
}
