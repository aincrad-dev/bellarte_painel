const aside_bar = document.querySelector('aside')

if (aside_bar) {
  aside_bar.addEventListener(
    'click', () => {
      aside_bar.classList.toggle('colapse');
    }
  )
}

function previewImage(event, id) {
  const imagePreview = document.getElementById('image_preview_' + id);
  const file = event.target.files[0];

  if (file) {
    const reader = new FileReader();

    reader.onload = function (e) {
      imagePreview.src = e.target.result;
      imagePreview.style.display = 'block';
      document.getElementById('image_url_' + id).style.display = 'none'; // Oculta o input
    }

    reader.readAsDataURL(file);
  } else {
    imagePreview.src = '';
    imagePreview.style.display = 'none';
    document.getElementById('image_url_' + id).style.display = 'block'; // Mostra o input se não houver imagem
  }
}


function filterForms() {
  // Valor do campo de busca
  const searchTerm = document.getElementById('searchField').value.toLowerCase();
  
  // Selecionar todos os formulários dentro do main
  const forms = document.querySelectorAll('main form');
  console.log(searchTerm);
  
  forms.forEach(form => {
    // Selecionar todos os inputs de cada formulário
    const inputs = form.querySelectorAll('input[type="text"]');

    let match = false;

    // Verificar se algum valor do input contém o termo de busca
    inputs.forEach(input => {
      if (input.value.toLowerCase().includes(searchTerm)) {
        match = true;
      }
    });

    // Mostrar ou ocultar o formulário baseado na correspondência
    if (match) {
      form.style.display = '';
    } else {
      form.style.display = 'none';
    }
  });
}