<?php
require_once 'app/config/error_log.php';
session_start();
define('CONTROL', true);

require_once 'app/config/routes.php';
require_once 'app/config/load_env.php';


function guidv4($data = null)
{
  // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
  $data = $data ?? random_bytes(16);
  assert(strlen($data) == 16);

  // Set version to 0100
  $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
  // Set bits 6-7 to 10
  $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

  // Output the 36 character UUID.
  return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}


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
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <link rel="stylesheet" href="./reset.css">
  <link rel="stylesheet" href="./style.css">

  <script src="./preload.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

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

<script src="./script.js"></script>


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