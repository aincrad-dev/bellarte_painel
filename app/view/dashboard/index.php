<?php


?>

<div class="container" id="dashboard">
  
  <aside class="colapse">
    <div>
      <span>Usuário:</span>
      <a href="./?p=logout">Sair</a>
    </div>
    
    <ul>
      <li>
        <a href="#">Produto</a>
      </li>
      <li>
        <a href="#">Revestimento</a>
      </li>
      <li>
        <a href="#">Revestimentos</a>
      </li>
    </ul>
  </aside>
  
  <main>
    <?php
      include_once('app/view/dashboard/upholstery.php')
    ?>
  </main>


</div>
