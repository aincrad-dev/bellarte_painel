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

async function setCompanyToProduct(product_id, company_id, value, user_id) {
  console.log(product_id, company_id, value, user_id);
  try {
    const url = `/api/product/${product_id}/company/${company_id}`;
    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: JSON.stringify({ 'status': value, 'user_id': user_id })

    });

    if (!response.ok) {
      const errorData = await response.json();
      console.error('Erro na requisição:', errorData.message || 'Erro desconhecido');
      return;
    }

    const data = response.json();
    console.log('Sucesso:', data.message || 'Ação concluída com sucesso');
    showToast(data.message ?? 'Ação concluída com sucesso', 'success')

  } catch (error) {
    const tempMessage = "Erro ao excluir revestimento: \n<br/>" + error.message;
    showToast(tempMessage, 'error')
    console.error('Erro na requisição:', error);
  }
}

