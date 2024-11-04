<?php

function setProductToCompany(PDO $pdo, string $product_id,  string $company_id, int $user_id): array
{
  $sql = "SELECT * FROM company_product WHERE product_id = :product_id AND company_id = :company_id";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ':product_id' => $product_id,
      ':company_id' =>   $company_id
    ]);
    if ($stmt->rowCount() > 0) {
      return [
        'status' => 'error',
        'message' =>  'Product already exists in this company',
        'data' => []
      ];
    } else {
      $uuid =  guidv4();
      $sql = "INSERT INTO company_product (id, product_id, company_id, created_at, user_id) 
      VALUES (:uuid, :product_id, :company_id, NOW(), :user_id)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ':uuid' => $uuid,
        ':product_id' => $product_id,
        ':company_id' => $company_id,
        ':user_id' => $user_id
      ]);
      if ($stmt->rowCount() > 0) {
        $insertedId = $pdo->lastInsertId();
        return [
          'status' => 'sucess',
          'message' =>  'Product added to company',
          'data' => [
            'id' => $insertedId,
          ]
        ];
      } else {
        return [
          'status' => 'error',
          'message' =>  'Error adding product to company',
          'data' => []
        ];
      }
    }
  } catch (PDOException $e) {
    return [
      'status' => 'error',
      'message' => 'Error preparing SQL statement' . $e->getMessage(),
      'data' => []
    ];
  }
}

if ($parts[3] == 'company') {
  $product_id =  $parts[2];
  $company_id =  $parts[4];

  setProductToCompany($pdo, $product_id, $company_id, $user_id);
}
