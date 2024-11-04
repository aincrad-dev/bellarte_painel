<?php

function setProductToCompany(PDO $pdo, string $product_id,  string $company_id, int $user_id, bool $status): array
{
  $sql = "SELECT * FROM company_product WHERE product_id = :product_id AND company_id = :company_id";
  try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ':product_id' => $product_id,
      ':company_id' =>   $company_id
    ]);
    if ($stmt->rowCount() > 0) {
      $sql = "UPDATE company_product 
        SET updated_at = now(), 
            deleted_at = CASE 
                WHEN :status THEN null 
                ELSE now()
            END, 
            user_id = :user_id 
        WHERE product_id = :product_id AND company_id = :company_id";

      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ':status' => (int)$status,
        ':user_id' => $user_id,
        ':product_id' => $product_id,
        ':company_id' => $company_id,
      ]);

      if ($stmt->rowCount() > 0) {
        return [
          'status' => 'success',
          'message' => 'Produto atualizado com sucesso',
          'data' => []
        ];
      } else {
        return [
          'status' => 'error',
          'message' => 'Erro ao atualizar produto',
          'data' => []
        ];
      }
    } else {
      $uuid = guidv4();
      $sql = "INSERT INTO company_product (id, product_id, company_id, created_at, deleted_at, user_id) 
        VALUES (:uuid, :product_id, :company_id, NOW(), CASE
                                                          WHEN :status THEN null
                                                          ELSE NOW()
                                                        END, :user_id)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ':uuid' => $uuid,
        ':product_id' => $product_id,
        ':company_id' => $company_id,
        ':status' => (int)$status,
        ':user_id' => $user_id
      ]);

      if ($stmt->rowCount() > 0) {
        $insertedId = $pdo->lastInsertId();
        return [
          'status' => 'success',
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
  $request_data = json_decode(file_get_contents('php://input'), true);

  $status = $request_data['status'] ?? null;
  $user_id = $request_data['user_id'] ?? null;

  return $data = setProductToCompany($pdo, $product_id, $company_id, $user_id, $status);
} else {
  $data = [
    'status' => 'error',
    'message' => 'Invalid request',
    'data' => []
  ];
}

return $data;
