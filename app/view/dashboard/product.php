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

function getUpholsteryColorPallete(PDO $pdo)
{
  $sql = "SELECT color_pallete FROM upholsteries WHERE deleted_at IS NULL GROUP BY color_pallete ORDER BY color_pallete;";
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

function getUpholsteriesByColorPallete(PDO $pdo, String $color_pallete)
{
  $sql = "SELECT id, type, image_url FROM upholsteries WHERE deleted_at IS NULL AND color_pallete = :color_pallete ORDER BY type;";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':color_pallete', $color_pallete);
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

function getUpholsteries(PDO $pdo)
{
  $sql = "SELECT id, type, image_url FROM upholsteries WHERE deleted_at IS NULL ORDER BY type;";
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

$products = getProducts($pdo);
$upholsteriesColorPallete = getUpholsteryColorPallete($pdo);
$upholsteriesByPallete = getUpholsteriesByColorPallete($pdo, "a");
$upholsteries = getUpholsteries($pdo);


?>

<script>
  let upholsteries = []
  // Verifica se a consulta foi bem-sucedida no PHP
  <?php if ($upholsteries['status'] === 'success'): ?>
    // Passa os dados da consulta para uma variável JavaScript
    upholsteries = <?php echo json_encode($upholsteries['data']); ?>;
  <?php else: ?>
    // Em caso de erro, define uma variável vazia ou mostra a mensagem de erro
    upholsteries = [];
  <?php endif; ?>
</script>

<h2>Cadastro de produto</h2>

<form action="" class="flex flex-col gap-2">
  <div class="flex gap-3">
    <label for="name" class="my-auto">Nome:</label>
    <input type="text" name="name" id="name" class="flex-1 px-2 py-1 rounded-md" />
  </div>

  <!-- Seletor das empresas -->
  <div class="my-3 gap-4 flex flex-col">
    <h3>Empresas</h3>
    <div class="flex gap-3">
      <?php
      $companies = getCompanies($pdo);
      // var_dump($companies);
      foreach ($companies["data"] as $company) :
      ?>
        <div class="btn-checked">
          <input
            type="checkbox"
            name="new-product-company-<?= $company["id"] ?>"
            id="new-product-company-<?= $company["id"] ?>"
            class="peer" />
          <label
            for="new-product-company-<?= $company["id"] ?>"
            class="peer-checked:bg-sprout-300">
            <?= $company["name"] ?>
          </label>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Cadastro de acabamentos "nomes" -->
  <p>Onde se aplica os acabamentos:</p>
  <div class="flex flex-col w-full gap-4">
    <div class="flex flex-row gap-2">
      <label for="f_name01" class="m-auto">01</label>
      <input type="text" name="f_name01" id="f_name01" class="flex-1 px-5" />
      <button class="btn editar svgblack" type="button">
        <img alt="Editar" width="24" src="./public/edit.svg" class="">
      </button>
      <button class="btn excluir" type="button">
        <img alt="Excluir" width="24" src="./public/trash-solid.svg">
      </button>
    </div>

    <div class="flex flex-row h-8 gap-4">
      <button class="btn cadastrar" type="button">
        Gravar
        <img src="./public/icon_check.svg" alt="Icone check">
      </button>
      <button class="btn adcionar" type="button">
        Adcionar
        <img src="./public/add_icon.svg" alt="Icone editar">
      </button>
    </div>

  </div>

  <!-- Cadastro revestimento -->
  <details open>
    <summary>Seleção de revestimento</summary>
    <div>
      <div>
        <!-- Categorias -->
        <ul id="color-pallete-list" class="flex flex-row flex-wrap justify-between pt-2">
          <?php foreach ($upholsteriesColorPallete["data"] as $colorPallete) : ?>
            <li class="flex-1 rounded-t-md text-center">
              <div class="btn-checked-guide mb-3">
                <input
                  type="radio"
                  name="new-op-group-upholstery"
                  id="new-op-group-upholstery-<?= $colorPallete["color_pallete"] ?>"
                  class="peer" />
                <label
                  for="new-op-group-upholstery-<?= $colorPallete["color_pallete"] ?>"
                  class="peer-checked:bg-black-39">
                  <?= $colorPallete["color_pallete"] ?>
                </label>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>


        <ul class="bg-black-39 h-28 w-full flex flex-wrap gap-3">
          <?php foreach ($upholsteries['data'] as $upholtery) : ?>
            <li class="btn-checked">
              <input
                type="checkbox"
                name="new-upholstery-<?= $upholtery["id"] ?>"
                id="new-upholstery-<?= $upholtery["id"] ?>"
                class="peer" />
              <label
                for="new-upholstery-<?= $upholtery["id"] ?>"
                class="peer-checked:bg-sprout-300">
                <img src=".<?= $upholtery["image_url"] ?>" alt="<?= $upholtery["type"] ?>" width="16" height="16">
                <?= $upholtery["type"] ?>
              </label>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

    </div>
  </details>
</form>


<?php foreach ($products['data'] as $product): ?>
  <form id="<?= $product['id'] ?>">
    <div>
      <input type="hidden" name="id" value="<?= $product['id'] ?>">
      <label for="name">Nome:</label>
      <input type="text" name="name" value="<?= $product['name'] ?>" />
    </div>
  </form>


  <!-- Iniciando o cadastro das empresas -->

  <form class="companies">
    <a href="#">a</a>
    <?php
    $companies_product =  getProductOnCompany($pdo, $product['id']);
    var_dump($companies_product['data']);
    die();
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
        <!-- Local de cadastro para acabamento (Trim) -->
        <div class="">
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

        async function fetchUpholsteries() {

        }


        /* const listRevestimenos = document.querySelector('#revestimento-locais')
        const btnAddRevestimento = document.querySelector('button#btn-add-form-finishing')
        btnAddRevestimento.addEventListener('click', ) */
      </script>