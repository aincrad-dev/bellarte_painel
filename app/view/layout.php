
<?php 
    //$title_page = 'Home';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bellarte <?php echo $title_page ? ' - ' . $title_page : ''; ?></title>
</head>
<body>
<?
    $url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    echo $url;



    echo ('a' .  $_SERVER['REQUEST_URI'] . 'a');
    echo $routes[$_SERVER['REQUEST_URI']];
    if (isset($routes[$_SERVER['REQUEST_URI']])) {
        
        require_once $routes[$_SERVER['REQUEST_URI']];

    } else {

        require_once 'app/view/404.php';

    }
?>
    
</body>
</html>