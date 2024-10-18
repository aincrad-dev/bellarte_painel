<?php
$error = null;
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

