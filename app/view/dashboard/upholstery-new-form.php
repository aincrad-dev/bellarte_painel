<?php
$t = "";
?>
<div id="form-container"></div>
<button type="button" class="btn adcionar" id="btn-form-upholstery">
  Adicionar
  <img src="./public/add_icon.svg" height="26px" />
</button>

<script>
  document.querySelector('button.btn.adcionar').addEventListener('click', () => {
    let randomId = Math.random().toString(36).substr(2, 9);
    let newForm = document.createElement('div')
    newForm.innerHTML = `
      <form action="./?c=revestimento&t=cadastrar" class="revestimento" method="POST" enctype="multipart/form-data">
        <div>
          <div>
            <label for="reference_code">Cód:</label>
            <input type="text" name="reference_code" id="reference_code" value="<?= $t; ?>" required />
          </div>
          <div>
            <label for="">Tipo:</label>
            <input type="text" name="type" id="type" value="<?= $t; ?>" required />
          </div>
        </div>
        <div>
          <label for="color">Cor:</label>
          <input type="text" id="color" name="color" />
          <label for="composition">Composição:</label>
          <input type="text" id="composition" name="composition" value="<?= $t; ?>" required />
        </div>
        <div>
          <label for="differentials">Diferenciais:</label>
          <input type="text" name="differentials" id="differentials" value="<?= $t; ?>" />
        </div>
        <div>
          <label for="color_pallete">Cartela:</label>
          <input type="text" name="color_pallete" id="color_pallete" value="<?= $t; ?>" />
          <label for="image_url_${randomId}">Anexar Imagem:</label>
          <input
            type="file"
            name="image_url"
            id="image_url_${randomId}"
            accept="image/*"
            onchange="previewImage(event, '${randomId}')"
            style="display: block" />
          <div>
            <img
              id="image_preview_${randomId}"
              class="image_preview"
              style="display: none"
              src=""
              alt="Pré-visualização"
              onclick="document.getElementById('image_url_${randomId}').click();" />
          </div>
        </div>

        <div>
          <button type="submit" class="btn cadastrar">
            Gravar
            <img src="./public/icon_check.svg" height="26px" />
          </button>
        </div>

      </form>`

    document.getElementById('form-container').appendChild(newForm)
    newForm.scrollIntoView({
      behavior: 'smooth'
    })
  })
</script>