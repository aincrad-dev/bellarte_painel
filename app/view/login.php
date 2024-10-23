<?php

require_once './app/config/database.php';

defined('CONTROL') or die('<p class="alert-access">Acesso negado</p>');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username'] ?? null;
	$password = $_POST['password'] ?? null;
	$error = null;

	if (empty($username) || empty($password)) {
		$error = 'Usuário e senha são obrigatório';
		echo "<script>showToast(`$error`, 'error'); </script>";
		$error = null;
	} else {
		// Query the users table to check the username and password
		$stmt = $pdo->prepare('SELECT * FROM users WHERE name = :username');
		$stmt->bindParam(':username', $username);
		$stmt->execute();

		$user = $stmt->fetch(PDO::FETCH_ASSOC);


		if ($user && password_verify($password, $user['password'])) {
			// User authenticated, generate a session token
			// You can use PHP's built-in session handling or implement your own
			session_start();
			$_SESSION['user_id'] = $user['id'];
			//var_dump($_SESSION['user_name']);
			//die();

			// Redirect to the dashboard
			header('Location:./?p=dashboard');
			exit();
		} else {
			echo "Erro de login<br/>\n";
			$error = 'Usuário ou senha inválidos';
			echo "<script>showToast(`$error`, 'error'); </script>";
			$error = null;
		}
	}
}

?>


<form action="./?p=login" method="post">
	<h1>Login</h1>
	<div>
		<label for="username">Usuário</label>
		<input type="text" name="username" id="username" value="<?= $username ?>" />
	</div>
	<div>
		<label for="password">Usuário</label>
		<input type="password" name="password" id="password" value="<?= $password ?>" />
	</div>
	<div>
		<button type="submit">Entrar</button>
		<a href="./?p=signup">Cadastrar-se</a>
	</div>
</form>