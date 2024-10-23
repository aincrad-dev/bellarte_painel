

<div id="form-container"></div>
<button type="button" class="btn adcionar" id="btn-form-upholstery">
  Adicionar
  <img src="/public/add_icon.svg" height="26px" />
</button>

<script>
  document.querySelector('button.btn.adcionar').addEventListener('click', () => {
    let randomId = Math.random().toString(36).substr(2, 9);
    let newForm = document.createElement('div')
    newForm.innerHTML = 
    `<form action="./?c=acabamento&t=cadastrar" 
      class="acabamento" 
      method="POST" 
      enctype="multipart/form-data">
      <div>
        <label for="">Nome:</label>
        <input type="text" name="name" required />
        <label for="">Tipo:</label>
        <input type="text" name="type" required />
        <label for="">Cód:</label>
        <input type="text" name="reference_code" required/>
      </div>
      <div>
        <label for="">Anexar Imagem:</label>
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
          <img src="/public/icon_check.svg" height="26px" />
        </button>
      </div>

    </form>`

    document.getElementById('form-container').appendChild(newForm)
    newForm.scrollIntoView({
      behavior: 'smooth'
    })
  })
</script>
