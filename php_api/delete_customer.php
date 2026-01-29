<?php
include 'condb.php';

header('Content-Type: application/json');

try {
    $method = $_SERVER['REQUEST_METHOD'];

         // ✅ ดึงข้อมูลลูกค้าทั้งหมด
    if ($method === "GET") {
        $stmt = $conn->prepare("SELECT * FROM customers ORDER BY customer_id DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["success" => true, "data" => $result]);
    }
     elseif ($method === "DELETE") {
        // ✅ ลบข้อมูลลูกค้าตาม customer_id
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data["customer_id"])) {
            echo json_encode(["success" => false, "message" => "ไม่พบค่า customer_id"]);
            exit;
        }

        $customer_id = intval($data["customer_id"]);

        $stmt = $conn->prepare("DELETE FROM customers WHERE customer_id = :id");
        $stmt->bindParam(":id", $customer_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "ลบข้อมูลเรียบร้อย"]);
        } else {
            echo json_encode(["success" => false, "message" => "ไม่สามารถลบข้อมูลได้"]);
        }
    }

    else {
        echo json_encode(["success" => false, "message" => "Method ไม่ถูกต้อง"]);
    }
    
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
