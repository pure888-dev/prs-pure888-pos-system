<?php
session_start();
include 'Database.php';

// Create instance of Database and connect
$database = new Database();
$conn = $database->getConnection();
$statusMsg = '';

// File upload path
$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
    $statusMsg .= "สร้างโฟลเดอร์ uploads เรียบร้อย<br>";
}

if (isset($_POST['submit'])) {
    if (!empty($_FILES["file"]["name"])) {
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                try {
                    $productName = $_POST['productName'];
                    $productBrand = $_POST['productBrand'];
                    $productType = $_POST['productType'];
                    $price = $_POST['price'];

                    $insert = $conn->prepare("INSERT INTO products (name, brand, type, price, image, uploaded_on) VALUES (?, ?, ?, ?, ?, NOW())");
                    if ($insert->execute([$productName, $productBrand, $productType, $price, $fileName])) {
                        $_SESSION['statusMsg'] = "อัพโหลดไฟล์ <b>$fileName</b> และข้อมูลสินค้าเรียบร้อย";
                        header("Location: index.php");
                        exit();
                    } else {
                        $statusMsg .= "ล้มเหลวในการบันทึกข้อมูล<br>";
                    }
                } catch (PDOException $e) {
                    $statusMsg .= "ข้อผิดพลาดฐานข้อมูล: " . $e->getMessage() . "<br>";
                }
            } else {
                $statusMsg .= "ไม่สามารถย้ายไฟล์ได้<br>";
            }
        } else {
            $statusMsg .= "ประเภทไฟล์ไม่ถูกต้อง อนุญาตเฉพาะ JPG, JPEG, PNG, GIF<br>";
        }
    } else {
        $statusMsg .= "ไม่ได้เลือกไฟล์<br>";
    }
    echo $statusMsg;
}

// Debug: Check data in database
try {
    $stmt = $conn->prepare("SELECT * FROM products ORDER BY uploaded_on DESC");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($products) > 0) {
        foreach ($products as $product) {
            echo "ID: " . $product['id'] . ", ชื่อ: " . $product['name'] . ", รูป: " . $product['image'] . ", วันที่: " . $product['uploaded_on'] . "<br>";
        }
    } else {
        echo "ไม่มีสินค้าในฐานข้อมูล<br>";
    }
} catch (PDOException $e) {
    echo "ข้อผิดพลาดในการตรวจสอบฐานข้อมูล: " . $e->getMessage() . "<br>";
}
?>