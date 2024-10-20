<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $reference_code  = $_POST['reference_code'];
        $type  = $_POST['type'];
        $composition = $_POST['composition'];
        $differentials = $_POST['differentials'] ?? null;
        $color_pallete = $_POST['color_pallete'];
        $user_id = $_SESSION['user_id'];

        $uuid = uniqid('', true);

        // Processe o upload da imagem
        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
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
                echo "Falha ao fazer upload da imagem.";
                exit;
            }
        } else {
            $imageUrl = null;
        }
        var_dump($imageUrl);
        die();
        /*
        // Prepare a declaração SQL
        $sql = "INSERT INTO upholsteries (cod, type, composition, diferentials, color_pallete, image_url) 
        VALUES (:cod, :type, :composition, :diferentials, :color_pallete, :image_url)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':cod' => $cod,
                ':type' => $type,
                ':composition' => $composition,
                ':diferentials' => $diferentials,
                ':color_pallete' => $color_pallete,
                ':image_url' => $imageUrl
            ]);
            echo "Revestimento cadastrado com sucesso!";
        } catch (PDOException $e) {
            echo "Erro ao cadastrar revestimento: " . $e->getMessage();
        }

        */

        


    }
?>

<h2>CADASTRO DE REVESTIMENTO</h2>
<form action="" id="revestimento">
    <div>
        <div>
            <label for="reference_code">Cod:</label>
            <input type="text" name="reference_code" id="reference_code" required>
        </div>
        <div>
            <label for="">Tipo</label>
            <input type="text" name="type" id="type" required>
        </div>
    </div>
    <div>
        <label for="composition">Composição</label>
        <input type="text" id="composition" name="composition" required>
    </div>
    <div>
        <label for="differentials">Diferenciais</label>
        <input type="text" name="differentials" id="differentials">
    </div>
    <div>
        <label for="color_pallete">Cartela:</label>
        <input type="text" name="color_pallete" id="color_pallete">
        <label for="image_url">Anexar Imagem:</label>
        <input type="file" name="image_url" id="image_url">
    </div>

    <div>
        <button type="submit" class="btn cadastrar">
            Gravar
            <img src="/public/icon_check.svg" height="26px" />
        </button>

        <button class="btn excluir">
            <img src="/public/trash-solid.svg" height="26px" />
        </button>
    </div>

</form>



