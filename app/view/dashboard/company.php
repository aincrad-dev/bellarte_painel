<?php
defined('CONTROL') or die('<p class="alert-access">Acesso negado</p>');

$type_order =  $_GET['t']  ?? null;
$user_id = $_SESSION['user_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && $order == "empresa") {
  $name = $_POST['name'];
  $uuid = $type_order == "atualizar" ? $_POST['id'] : guidv4();

  if ($type_order == 'cadastrar') {
    $sql = "INSERT INTO companies (id, name, user_id, created_at, updated_at ) 
            VALUES (:id, :name, :user_id, now(), now())";
    try {
      $stmt =  $pdo->prepare($sql);
      $stmt->execute([
        'id' => $uuid,
        ':name' => $name,
        ':user_id' => $user_id
      ]);

      if ($stmt->rowCount() > 0) {
        echo "<script>showToast('Empresa cadastrada com sucesso!', 'success');</script>";
      } else {
        echo "<script>showToast(`Não foi cadastrada a empresa: $name`, ''); </script>";
      }
    } catch (PDOException $e) {
      $tempMessage = "Erro ao cadastrar empresa: \n<br/>" . $e->getMessage();
      echo "<script>showToast(`$tempMessage`, 'error'); </script>";
      $tempMessage = null;
    }
  } elseif ($type_order == 'atualizar') {
    $id = $_POST['id'];
    try {
      $sql =  "UPDATE companies SET name = :name, updated_at = now(), user_id = :user_id WHERE id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ':id' => $uuid,
        ':name' => $name,
        ':user_id' => $user_id,
      ]);

      if ($stmt->rowCount() > 0) {
        echo "<script>showToast('Empresa atualizada com sucesso!', 'success');</script>";
      } else {
        echo "<script>showToast(`Não foi atualizada a empresa: $name`, ''); </script>";
      }
    } catch (PDOException $e) {
      $tempMessage = "Erro ao atualizar empresa: \n<br/>" . $e->getMessage();
      echo "<script>showToast(`$tempMessage`, 'error'); </script>";
      $tempMessage = null;
    }
  }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' &&  $type_order == 'excluir') {
  $uuid = $_GET['id'];
  $sql = "UPDATE companies SET deleted_at = now(), delete_by = :user_id WHERE id = :id";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ':id' => $uuid,
      ':user_id' => $user_id,
    ]);
    if ($stmt->rowCount() > 0) {
      echo "<script>showToast('Empresa excluído com sucesso!', 'success')</script>";
    } else {
      echo "<script>showToast('Empresa não encontrado!', 'error')</script>";
    }
  } catch (PDOException $e) {
    $tempMessage = "Erro ao excluir empresa: \n<br/>" . $e->getMessage();
    echo "<script>showToast(`$tempMessage`, 'error'); </script>";
    $tempMessage = null;
  }
}
$sql = "SELECT `id`, `name` FROM `companies` WHERE deleted_at is NULL ORDER BY `name`";
$stmt =  $pdo->prepare($sql);
$stmt->execute();
$companies = $stmt->fetchAll();
?>

<h2>Cadastro de empresas</h2>

<form action="./?c=empresa&t=cadastrar" method="post" class="revestimento">
  <div>
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" required>
  </div>
  <div>
    <button type="submit" class="btn cadastrar">Cadastrar</button>
  </div>
</form>

<?php foreach ($companies as $company): ?>
  <form action="./?c=empresa&t=atualizar" method="post" class="revestimento">
    <div>
      <label for="name">Nome:</label>
      <input type="text" name="name" id="name" value="<?= $company['name'] ?>" />
      <input type="hidden" name="id" value="<?= $company['id'] ?>">
    </div>
    <div>
      <button type="submit" class="btn cadastrar">
        Gravar
        <img src="./public/icon_check.svg" height="26px" />
      </button>

      <a href="./?c=empresa&t=excluir&id=<?= $company['id'] ?>">
        <button type="button" class="btn excluir">
          <img src="./public/trash-solid.svg" width="32px" height="26px" />
        </button>
      </a>
    </div>
  </form>
<?php endforeach; ?>