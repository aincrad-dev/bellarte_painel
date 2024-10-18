<?php
require_once 'app/config/error_log.php';
session_start();
define('CONTROL', true);

require_once 'app/config/routes.php';



$logged_in_user = $_SESSION['user_id'] ?? null;

if (empty($logged_in_user)) {
  if (!empty($_GET['p']) && $_GET['p'] == 'signup') {
    $rota = 'signup';
  } else {
    $rota = 'login';
  }
} else {
  $rota = $_GET['p'] ?? 'dashboard';
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bellarte <?= $rota ? ' - ' . $rota : ''; ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./reset.css">
  <link rel="stylesheet" href="./style.css">
</head>

<body>

  <?php
  if (!key_exists($rota, $routes)) {
    $rota = '404';
    $view = $routes[$rota];
  } else {
    $view = $routes[$rota];
  }

  require_once $view;


  ?>

</body>

</html>
<?php
/*

include_once 'app/config/error_log.php';
require_once 'app/config/database.php';
echo 'teste';
include_once 'app/view/layout.php';
*/
/*
require_once 'app/models/UserModel.php';
require_once 'app/controllers/LoginController.php';

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

$userModel = new UserModel($conn);
$loginController = new LoginController($userModel);

if ($loginController->login('username', 'password')) {
    echo 'Login successful!';
} else {
    echo 'Invalid credentials';
}

if ($loginController->verify_token()) {
    echo 'Token is valid!';
} else {
    echo 'Token is invalid';
} */
?>

