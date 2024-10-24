<form action="./?c=revestimento&t=atualizar" class="revestimento" method="POST" enctype="multipart/form-data">
  <div>
    <input type="text" name="id" value="<?= $id ?>" hidden />
    <div>
      <label for="reference_code">Cód:</label>
      <input type="text" name="reference_code" id="reference_code" value="<?= $upholstery['reference_code'] ?>" required />
    </div>
    <div>
      <label for="">Tipo:</label>
      <input type="text" name="type" id="type"  value="<?= $upholstery['type'] ?>" required />
    </div>
  </div>
  <div>
    <label for="color">Cor:</label>
    <input type="text" id="color" name="color" value="<?=  $upholstery['color'] ?>" />
    <label for="composition">Composição:</label>
    <input type="text" id="composition" name="composition" value="<?= $upholstery['composition'] ?>" required />
  </div>
  <div>
    <label for="differentials">Diferenciais:</label>
    <input type="text" name="differentials" id="differentials" value="<?= $upholstery['differentials'] ?>" />
  </div>
  <div>
    <label for="color_pallete">Cartela:</label>
    <input type="text" name="color_pallete" id="color_pallete" value="<?= $upholstery['color_pallete'] ?>" />
    <?php
      include('app/view/dashboard/components/input-file.php');
    ?>
  </div>

  <div>
    <button type="submit" class="btn cadastrar">
      Gravar
      <img src="./public/icon_check.svg" height="26px" />
    </button>

    <a href="./?c=revestimento&t=excluir&id=<?=$id?>">
      <button type="button" class="btn excluir" >
        <img src="./public/trash-solid.svg" height="26px" />
      </button>
    </a>
  </div>

</form>