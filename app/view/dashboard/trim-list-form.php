<form 
  action="./?c=acabamento&t=atualizar" 
  class="acabamento" 
  method="POST" 
  enctype="multipart/form-data">
  <div>
    <input type="hidden" name="id" value="<?= $id ?>">
    <label for="">Nome:</label>
    <input type="text" name="name" value="<?= $trim['name'] ?>" required />
    <label for="">Tipo:</label>
    <input type="text" name="type" value="<?= $trim['type'] ?>" required />
    <label for="">Cód:</label>
    <input type="text" name="reference_code" value="<?= $trim['reference_code'] ?>" required/>
  </div>
  <div>
    <?php
      include('app/view/dashboard/components/input-file.php');
    ?>
  </div>
  <div>
    <button type="submit" class="btn cadastrar">
      Gravar
      <img src="/public/icon_check.svg" height="26px" />
    </button>
    <button type="button" class="btn excluir">
      <img src="/public/trash-solid.svg" height="26px" />
    </button>
  </div>

</form>