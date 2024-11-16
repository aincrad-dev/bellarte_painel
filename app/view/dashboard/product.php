<?php

function getFishinLocationByIdProduct(String  $idProduct, PDO $pdo): array
{
  $sql  = "SELECT * FROM finishing_locations WHERE product_id = :idProduct AND deleted_at IS NULL ORDER BY name";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idProduct', $idProduct);
    $stmt->execute();
    return [
      'status' => 200,
      'data' => $stmt->fetchAll(PDO::FETCH_ASSOC),
    ];
  } catch (PDOException $e) {
    return [
      'status' => 500,
      'data' => [],
      'message' => "Erro: "  . $e->getMessage(),
    ];
  }
}

function getProducts(PDO $pdo): array
{
  $sql = "SELECT * FROM products WHERE deleted_at IS NULL ORDER BY name";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return [
      'status' => 'success',
      'data' =>  $stmt->fetchAll(),
    ];
  } catch (PDOException $e) {
    return [
      'status' => 'error',
      'message' => "Erro: " . $e->getMessage(),
      'data' => [],
    ];
  }
}

function getCompanies(PDO $pdo): array
{
  $sql = "SELECT id, name FROM companies WHERE deleted_at IS NULL ORDER BY name";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return [
      'status' => 'success',
      'data' =>  $stmt->fetchAll(),
    ];
  } catch (PDOException $e) {
    return [
      'status' => 'error',
      'message' => "Erro: " . $e->getMessage(),
      'data' => [],
    ];
  }
}

function getProductOnCompany(PDO $pdo, String $productId): array
{
  $sql = "SELECT company_id FROM company_product WHERE deleted_at IS NULL and product_id = :product_id";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $productId);
    $stmt->execute();
    return [
      'status' => 'success',
      'data' =>  $stmt->fetchAll(),
    ];
  } catch (PDOException $e) {
    return [
      'status' => 'error',
      'message' => "Erro: " . $e->getMessage(),
      'data' => [],
    ];
  }
}

$products = getProducts($pdo);


?>

<h2>Cadastro de produto</h2>
<?php foreach ($products['data'] as $product): ?>
  <form id="<?= $product['id'] ?>" class="revestimento">
    <div>
      <input type="hidden" name="id" value="<?= $product['id'] ?>">
      <label for="name">Nome:</label>
      <input type="text" name="name" value="<?= $product['name'] ?>" />
    </div>
  </form>

  <!-- Iniciando o cadastro das empresas -->
  <form class="companies">
    <?php
    $companies_product =  getProductOnCompany($pdo, $product['id']);
    //var_dump($companies_product['data']);
    //die();
    foreach (getCompanies($pdo)['data'] as $company) {
      echo "<br/>" . var_dump($company) . "<br/>";
      $is_company_product = false;
      if (in_array($company['id'], $companies_product['data'])) {
        $is_company_product = true;
      }
    ?>
      <label for="check_<?= $company['id'] . "_" . $product['id'] ?>">
        <?= $company['name'] . '-' . $is_company_product . '-' . $company['id'] ?>
      </label>
      <input
        class="btn"
        id="check_<?= $company['id'] . "_" . $product['id'] ?>"
        type="checkbox"
        name="check_<?= $company['name'] ?>"
        <?= $is_company_product ? 'checked' : '' ?>
        onclick="setCompanyToProduct(
          '<?= $product['id'] ?>', 
          '<?= $company['id'] ?>', 
          this.checked,
          '<?= $logged_in_user ?>'
          )" />
    <?php } ?>
  </form>

  <div>
    <p>Onde você gostaria de aplicar o revestimento?</p>
    <div id="revestimento-locais" style="flex-direction: column;">
      <?php
      $locations = getFishinLocationByIdProduct($product['id'], $pdo);
      $ordemLocation = 1;
      foreach ($locations['data'] as $location) { ?>
        <div>
          <label for=""><?= $ordemLocation ?></label>
          <input type="text" name="<?= $location['name'] ?>" />
          <div>
          <?php
          $ordemLocation++;
        }
          ?>
          </div>
          <button type="button" class="btn adcionar" id="btn-add-form-finishing">
            Adcionar
            <img src="./public/add_icon.svg" height="26px" />
          </button>
        </div>
      <?php endforeach; ?>


      <form
        action="./?c=produto&t=cadastrar"
        method="POST"
        enctype="multipart/form-data"
        class="produto revestimento">
        <div>
          <label for="">Nome:</label>
          <input type="text" name="name" required />
        </div>
        <div class="acabamentos">
          <span>Aonde se aplicam os acabamentos:</span>
          <div>
            <label for="">01</label>
            <div>
              <input type="text" name="" id="">
              <button type="button" class="btn ">
                <img src="./public/edit.svg" height="26px" />
              </button>
              <button type="button" class="btn ">
                <img src="./public/trash-solid.svg" height="26px" />
              </button>


            </div>
            <div>
              <button type="button" class="btn cadastrar">
                Gravar
                <img src="./public/icon_check.svg" height="26px" />
              </button>
              <button type="button" class="btn adcionar">
                adcionar
                <img src="./public/add_icon.svg" height="26px" />
              </button>
            </div>
          </div>
        </div>

        <details>
          <summary>Seleção de revestimento</summary>
          <div>
            <div>
              <label for="couro">Couro</label>
              <input type="checkbox" name="couro" id="couro">
            </div>



          </div>
        </details>


      </form>

      <script>
        document.querySelector('button#btn-add-form-finishing').addEventListener('click', () => {
          const listFinishingLocation = document.querySelector('div#revestimento-locais');
          const randomUUID = Math.random().toString(36).substr(2, 9);

          const newForm = document.createElement('form')
          newForm.style = "display: flex; flex-direction: row; width: 100%; gap: 16px;"
          newForm.id = `form-finishing-${randomUUID}`;
          newForm.innerHTML = `
<div>
<input type="hidden" name="id"  value="${randomUUID}" />
<label for="name" style="margin: auto;">${++listFinishingLocation.childElementCount}</label>
<input type="text" name="name" style="flex: 1;" />
<button type="button" class="btn editar">Editar</button>
<button type="button" class="btn excluir">Excluir</button>
</div>
`
          listFinishingLocation.appendChild(newForm)
          newForm.scrollIntoView({
            behavior: 'smooth',
          })
        })
        /* const listRevestimenos = document.querySelector('#revestimento-locais')
        const btnAddRevestimento = document.querySelector('button#btn-add-form-finishing')
        btnAddRevestimento.addEventListener('click', ) */
      </script>