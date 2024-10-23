<?php
  require_once 'app/config/database.php';

  $order = $_GET['c']  ?? 'revestimento';

  $rotas_dashboard = [
    'produto' => 'app/view/dashboard/product.php',
    'revestimento' => 'app/view/dashboard/upholstery.php',
    'acabamento' => 'app/view/dashboard/trim.php',
    '404' => 'app/view/404.php'
  ];

  if (!key_exists($order, $rotas_dashboard)) {
    $order = '404';
    $dashboard_view = $rotas_dashboard[$order];
  } else {
    $dashboard_view = $rotas_dashboard[$order];
  }
  


?>

<div class="container" id="dashboard">
  
  <aside>
    <div>
      <span>Usuário:</span>
      <a href="./?p=logout">Sair</a>
    </div>
    
    <ul>
      <li>
        <a href="./?c=produto">Produto</a>
      </li>
      <li>
        <a href="./?c=revestimento">Revestimento</a>
      </li>
      <li>
        <a href="./?c=acabamento">Acabamento</a>
      </li>
    </ul>
  </aside>
  
  <main>
    <?php
      include_once($dashboard_view);
    ?>

    
   
  </main>


</div>
