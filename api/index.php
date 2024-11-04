<?php
ob_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

session_start();
define('CONTROL', true);
require_once("../app/config/load_env.php");
require_once("../app/config/error_log.php");
require_once("../app/config/database.php");
require_once("../app/config/util.php");

$requestUri =  trim($_SERVER['REQUEST_URI'], '/');
$parts = explode('/', $requestUri);


// Exemplo de dados que você pode querer retornar
if (count($parts) < 2) {
  $data = [
    'version' => '2.0',
    'message' => 'Dados retornados com sucesso',
    'data' => [
      'request' =>  $parts,
    ]
  ];
} else {
  switch ($parts[1]) {
    case 'product':
      include_once("../api/controllers/ProductController.php");
      break;

    default:
      $data = [
        'version' => '2.0',
        'message' => 'Rota ainda não implementada',
        'data' => [
          'request' =>  $parts,
        ]
      ];
      break;
  }
}

// Converter os dados para JSON
echo json_encode($data);
