<label for="image_url_<?= $id ?>">Anexar Imagem:</label>
<input
  type="file"
  name="image_url"
  id="image_url_<?= $id ?>"
  accept="image/*"
  onchange="previewImage(event, '<?= $id ?>')"
  style="display: <?= !empty($image_url) ? 'none' : 'block' ?>;" />
<div>
  <img
    id="image_preview_<?= $id ?>"
    class="image_preview"
    style="display: <?= empty($image_url) ? 'none' : 'block' ?>;"
    src=".<?= $image_url ?>"
    alt="Pré-visualização"
    onclick="document.getElementById('image_url_<?= $id ?>').click();" />
</div>
