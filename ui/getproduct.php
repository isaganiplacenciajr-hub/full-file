<?php
include_once 'connectdb.php';

header('Content-Type: application/json; charset=utf-8');

// validate id
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product id']);
    exit;
}

try {
    // use prepared statement and parameter binding to avoid SQL injection
    $stmt = $pdo->prepare('SELECT pid, product, saleprice, stock, brand, expirydate, description, image FROM tbl_product WHERE pid = :id LIMIT 1');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // return the product row (keeps compatibility with existing JS expecting pid, product, saleprice, stock, etc.)
        echo json_encode($row);
    } else {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    // do not leak exception details in production
    echo json_encode(['success' => false, 'message' => 'Server error']);
}
?>