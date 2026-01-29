<?php
include 'condb.php';
header("Content-Type: application/json");

// ❌ ห้ามใช้ json_decode เมื่อเป็น FormData

// ตรวจสอบข้อมูล text
if (
    empty($_POST['product_name']) ||
    empty($_POST['description']) ||
    empty($_POST['price']) ||
    empty($_POST['stock'])
) {
    echo json_encode([
        "success" => false,
        "message" => "ข้อมูลไม่ครบ"
    ]);
    exit;
}

try {

    // ตรวจสอบไฟล์รูป
    if (!isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        echo json_encode([
            "success" => false,
            "message" => "กรุณาเลือกรูปภาพ"
        ]);
        exit;
    }

    // รับค่าจาก POST
    $product_name = $_POST['product_name'];
    $description  = $_POST['description'];
    $price        = $_POST['price'];
    $stock        = $_POST['stock'];

    // จัดการไฟล์รูป
    $upload_dir = "./image/";
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $filename = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $upload_dir . $filename;

    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // บันทึก DB
    $sql = "INSERT INTO products
            (product_name, description, price, image, stock)
            VALUES
            (:product_name, :description, :price, :image, :stock)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':product_name' => $product_name,
        ':description'  => $description,
        ':price'        => $price,
        ':image'        => $filename, // ✅ ถูกต้อง
        ':stock'        => $stock
    ]);

    echo json_encode([
        "success" => true,
        "message" => "เพิ่มข้อมูลเรียบร้อย"
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
