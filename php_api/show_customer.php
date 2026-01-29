<?php
include 'condb.php';

try {
    $stmt = $conn->prepare("SELECT * FROM customers ORDER BY customer_id DESC");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["success" => true, "data" => $result]);
    
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>


