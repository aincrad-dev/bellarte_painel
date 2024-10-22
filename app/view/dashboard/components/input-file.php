<label for="image_url_<?= $upholstery['id'] ?>">Anexar Imagem:</label>
<input
  type="file"
  name="image_url"
  id="image_url_<?= $upholstery['id'] ?>"
  accept="image/*"
  onchange="previewImage(event, '<?= $upholstery['id'] ?>')"
  style="display: <?= !empty($upholstery['image_url']) ? 'none' : 'block' ?>;" />
<div>
  <img
    id="image_preview_<?= $upholstery['id'] ?>"
    class="image_preview"
    style="display: <?= empty($upholstery['image_url']) ? 'none' : 'block' ?>;"
    src="<?= $upholstery['image_url'] ?>"
    alt="Pré-visualização"
    onclick="document.getElementById('image_url_<?= $upholstery['id'] ?>').click();" />
</div>
