<form action="/?c=revestimento&t=cadastro" id="revestimento" method="PUT" enctype="multipart/form-data">
    <div>
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
      <label for="image_url">Anexar Imagem:</label>
      <input type="file" name="image_url" id="image_url" >
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