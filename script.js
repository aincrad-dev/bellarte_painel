const aside_bar = document.querySelector('aside')

aside_bar.addEventListener(
    'click', ()=> {
        aside_bar.classList.toggle('colapse');
    }
)

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
  