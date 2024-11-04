<?php
ob_start();
require_once 'app/config/error_log.php';
session_start();
define('CONTROL', true);

require_once 'app/config/routes.php';
require_once 'app/config/load_env.php';


include_once 'app/config/util.php';


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