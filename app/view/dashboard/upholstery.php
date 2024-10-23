<?php

defined('CONTROL') or die('<p class="alert-access">Acesso negado</p>');

$user_id = $_SESSION['user_id'];
$type_order =  $_GET['t']  ?? null;

if ($order == "revestimento") {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($type_order == "cadastrar" || $type_order == "atualizar") {
      $reference_code  = $_POST['reference_code'];
      $type  = $_POST['type'];
      $composition = $_POST['composition'];
      $differentials = $_POST['differentials'] ?? null;
      $color_pallete =  $_POST['color_pallete'];

      // $uuid = uniqid('', true);
      $uuid = $type_order == "atualizar" ? $_POST['id'] : guidv4();

      // Processe o upload da imagem
      if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        echo "Início de imagem";
        $image = $_FILES['image_url'];
        $imageExtension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $imageName = $uuid . '.' . $imageExtension;
        $uploadDir = 'public/upholsteries/';
        $imagePath = $uploadDir . $imageName;

        // Certifique-se de que o diretório existe
        if (!file_exists($uploadDir)) {
          mkdir($uploadDir, 0777, true);
        }

        // Mova o arquivo enviado para o diretório de destino
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
          $imageUrl = '/public/upholsteries/' . $imageName;
        } else {
          echo "<script>showToast('Falha ao fazer upload da imagem!', 'error'); </script>";
          exit();
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
      if ($type_order == "atualizar") {
        $sql = "UPDATE upholsteries SET 
                  reference_code = :reference_code, 
                  type = :type,
                  composition = :composition, 
                  differentials = :differentials, 
                  color_pallete = :color_pallete, 
                  image_url = :image_url,
                  updated_at = now(),
                  user_id = :user_id
                  WHERE id = :id";
        try {
          $stmt = $pdo->prepare($sql);
          $stmt->execute([
            'id' => $uuid,
            ':reference_code' => $reference_code,
            ':type' => $type,
            ':composition' => $composition,
            ':differentials' => $differentials,
            ':color_pallete' => $color_pallete,
            ':image_url' => $imageUrl,
            ':user_id' => $user_id
          ]);

          if ($stmt->rowCount() > 0) {
            echo "<script>showToast('Revestimento atualizado com sucesso!', 'success'); </script>";
          } else {
            echo "<script>showToast('Erro inesperado ao atualizar id=$id!', 'error'); </script>";
          }

        } catch (PDOException $e) {
          $tempMessage = "Erro ao atualizar revestimento: \n<br/>" . $e->getMessage();
          echo "<script>showToast(`$tempMessage`, 'error'); </script>";
          $tempMessage = null;
        }

      } elseif ($type_order == "cadastrar") {
        $sql = "INSERT INTO upholsteries (
                    id, 
                    reference_code, 
                    type, 
                    composition, 
                    differentials, 
                    color_pallete, 
                    image_url, 
                    user_id, 
                    created_at, 
                    updated_at) 
                  VALUES (
                    :id, 
                    :reference_code, 
                    :type, 
                    :composition, 
                    :differentials, 
                    :color_pallete, 
                    :image_url,  
                    :user_id, 
                    now(), 
                    now())";
        try {
          $stmt = $pdo->prepare($sql);
          $stmt->execute([
            'id' => $uuid,
            ':reference_code' => $reference_code,
            ':type' => $type,
            ':composition' => $composition,
            ':differentials' => $differentials,
            ':color_pallete' => $color_pallete,
            ':image_url' => $imageUrl,
            ':user_id' => $user_id
          ]);

          echo "<script>showToast('Revestimento cadastrado com sucesso!', 'success'); </script>";
        } catch (PDOException $e) {
          $tempMessage = "Erro ao cadastrar revestimento: \n<br/>" . $e->getMessage();
          echo "<script>showToast(`$tempMessage`, 'error'); </script>";
          $tempMessage = null;
        }
      }



    } 
  } elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $type_order == "excluir")  {
    $uuid = $_GET['id'];
    $sql = "UPDATE upholsteries SET 
              deleted_at = now(),
              delete_by = :user_id
            WHERE id = :id";
    try {
      $stmt = $pdo->prepare($sql);
      $stmt->execute([':id' => $uuid, ':user_id' => $user_id]);
      if ($stmt->rowCount() > 0 ) {
        echo "<script>showToast('Revestimento excluído com sucesso!', 'success')</script>";
      }  else {
        echo "<script>showToast('Revestimento não encontrado!', 'error')</script>";
      }
    } catch (PDOException $e) {
      $tempMessage = "Erro ao excluir revestimento: \n<br/>" . $e->getMessage();
      echo "<script>showToast(`$tempMessage`, 'error'); </script>";
      $tempMessage = null;
    }


  }
}

$sql =  "SELECT * FROM upholsteries WHERE deleted_at is NULL ";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$upholsteries = $stmt->fetchAll();


?>

<h2>CADASTRO DE REVESTIMENTO</h2>



<?php foreach ($upholsteries as $upholstery):  ?>

<?php 
  $id = $upholstery['id'];
  $image_url =  str_replace("storage", "public", $upholstery['image_url']);
  include('./app/view/dashboard/upholstery-list-form.php')  
?>

<?php endforeach; ?>

<?php include('app/view/dashboard/upholstery-new-form.php') ?>


