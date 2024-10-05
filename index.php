<?php
session_start();
define('CONTROLE', true);
include_once 'app/config/error_log.php';
require_once 'app/config/database.php';
echo 'teste';
require_once 'app/config/routes.php';
include_once 'app/view/layout.php';

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

