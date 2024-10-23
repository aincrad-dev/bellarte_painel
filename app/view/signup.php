<?php
defined('CONTROL') or die('<p class="alert-access">Acesso negado</p>');

require_once 'app/config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $erro = null;
  $username = $_POST['username'];
  $email = $_POST['email'];

  if ($_POST['password'] != $_POST['confirm-password']) {
    $erro = 'Senhas não conferem';
    echo "<script>showToast(`$erro`, 'error'); </script>";
  }

  if (empty($erro)) {
    $erro = null;

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


    // Check if username or email already exists
    $stmt = $pdo->prepare('SELECT COUNT(*) as count FROM users WHERE name = :username OR email = :email');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
      $erro = 'Usuário ou email já cadastrado';
      echo "<script>showToast(`$erro`, 'error'); </script>";
    }

    if (empty($erro)) {
      // Insert the new user into the database
      $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:username, :email, :password)');
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':password', $password);
      $stmt->execute();

      // Verificar se o cadastro foi feito e se foi mudar de página, caso não  exibir um erro na variável erro
      if ($stmt->rowCount() > 0) {
        // Cadastro realizado com sucesso
        header('Location: ./');
        exit();
      } else {
        $erro = "Erro ao cadastrar usuário";
        echo "<script>showToast(`$erro`, 'error'); </script>";
        $erro = null;
      }
    }
  }
} else {
  $username = null;
  $email = null;
}


?>

<h1>Cadastro de usuário</h1>

<form action="./?p=signup" method="post">
  <div>
    <label for="username">Nome</label>
    <input
      type="text"
      id="username"
      name="username"
      value="<?= $username ?? '' ?>"
      required>
  </div>
  <div>
    <label for="email">Email</label>
    <input
      type="email"
      name="email"
      id="email"
      value="<?= $email ?? '' ?>"
      required>
  </div>
  <div>
    <label for="password">Senha</label>
    <input type="password" id="password" name="password" required>
  </div>
  <div>
    <label for="confirm-password">Confirmar Senha</label>
    <input type="password" name="confirm-password" id="confirm-password">
  </div>
  <div>
    <button type="submit" class="btn cadastrar">Cadastrar</button>
    <a href="./">Voltar</a>
  </div>

</form>