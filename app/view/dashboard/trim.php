<?php
defined('CONTROL') or die('<p class="alert-access">Acesso negado</p>');
$user_id = $_SESSION['user_id'];
$type_order =  $_GET['t']  ?? null;

if ($order == "acabamento") {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($type_order == "cadastrar" || $type_order == "atualizar") {
      $uuid = $type_order == "atualizar" ? $_POST['id'] : guidv4();
      $name = $_POST['name'];
      $type = $_POST['type'];
      $reference_code = $_POST['reference_code'] ?? null;
      if ($reference_code === '') {
        $reference_code = null;
      }

      // Processe o upload da imagem
      if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $image = $_FILES['image_url'];
        $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageName = $uuid . '.' . $imageExtension;
        $uploadDir = 'public/trims/';
        $imagePath = $uploadDir . $imageName;

        // Certifique-se de que o diretório existe
        if (!file_exists($uploadDir)) {
          mkdir($uploadDir, 0777, true);
        }

        // Mova o arquivo enviado para o diretório de destino
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
          $imageUrl = '/public/trims/' . $imageName;
        } else {
          echo "<script>showToast('Falha ao fazer upload da imagem!', 'error'); </script>";
        }
      } else {
        if ( $_POST['old_image'] != null  && $_POST['old_image'] != '') {
          $imageUrl = $_POST['old_image'];
        } else {
          echo "<script>showToast('Nenhuma imagem foi enviada.', ''); </script>";
          $imageUrl = null;
        }
      }

      // Prepare a declaração SQL
      if ($type_order == "cadastrar") {
        $sql = "INSERT INTO trims (id, name, type, reference_code, image_url, user_id, created_at, updated_at) values (
                :id, :name, :type, :reference_code, :image_url, :user_id, now(), now())";

        try {
          $stmt = $pdo->prepare($sql);
          $stmt->execute([
            ':id' => $uuid,
            ':name' => $name,
            ':type' => $type,
            ':reference_code' => $reference_code,
            ':image_url' => $imageUrl,
            ':user_id' => $user_id
          ]);

          echo "<script>showToast('Acabamento cadastrado com sucesso!', 'success'); </script>";
        } catch (PDOException $e) {
          $tempMessage = "Erro ao cadastrar acabamento: \n<br/>" . $e->getMessage();
          echo "<script>showToast(`$tempMessage`, 'error'); </script>";
          $tempMessage = null;
        }
      } elseif ($type_order == "atualizar") {
        $sql = "UPDATE trims SET 
                  name = :name, 
                  type = :type, 
                  reference_code = :reference_code,
                  image_url = :image_url,
                  user_id = :user_id,
                  updated_at = now()
                WHERE id  = :id";
        try {
          $stmt = $pdo->prepare($sql);
          $stmt->execute([
            ':id' => $uuid,
            ':name' => $name,
            ':type' => $type,
            ':reference_code' => $reference_code,
            ':image_url' => $imageUrl,
            ':user_id' => $user_id
          ]);

          echo "<script>showToast('Acabamento atualizado com sucesso!', 'success'); </script>";
        } catch (PDOException $e) {
          $tempMessage = "Erro ao atualizar acabamento: \n<br/>" . $e->getMessage();
          echo "<script>showToast(`$tempMessage`, 'error'); </script>";
          $tempMessage = null;
        }
      }
    }
  } elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $type_order == 'excluir') {
    $uuid = $_GET['id'];
    $sql  = "UPDATE trims SET 
              deleted_at =  now(),
              delete_by = :user_id
            WHERE id = :id";
    try {
      $stmt = $pdo->prepare($sql);
      $stmt->execute([':id' => $uuid, ':user_id' => $user_id]);

      if ($stmt->rowCount()  > 0) {
        echo "<script>showToast('Acabamento excluído com sucesso!', 'success');</script>";
      } else {
        echo "<script>showToast('Erro ao excluir, nenhuma linha alterada!', 'error');</script>";
      }
    } catch (PDOException $e) {
      $tempMessage = "Erro ao excluir acabamento: \n<br/>" . $e->getMessage();
      echo "<script>showToast(`$tempMessage`, 'error');</script>";
      $tempMessage = null;
    }
  }
}

$sql =  "SELECT * FROM trims WHERE deleted_at is NULL ";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$trims = $stmt->fetchAll();
?>

<h2>Cadastro de acabamentos</h2>

<?php
foreach ($trims as $trim) {
  $id = $trim['id'];
  $image_url = str_replace("storage", "public", $trim['image_url']);
  include('app/view/dashboard/trim-list-form.php');
}
include_once('app/view/dashboard/trim-new-form.php');
?>