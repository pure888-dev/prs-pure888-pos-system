<?php
session_start();

if (!isset($_SESSION['order_id'])) {
    header('Location: index.php');
    exit;
}

include_once 'Database.php';
include_once 'Order.php';

$database = new Database();
$db = $database->getConnection();

$order = new Order($db);
$order->id = $_SESSION['order_id'];

$stmt = $order->getOrderDetails();
$orderItems = [];
$orderDate = '';
$totalAmount = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (empty($orderDate)) {
        $orderDate = $row['order_date'];
        $totalAmount = $row['total_amount'];
    }
    $orderItems[] = [
        'id' => $row['product_id'],
        'name' => $row['name'],
        'price' => $row['price'],
        'count' => $row['quantity']
    ];
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRINT SLIP</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>
    <div class="container text-center">
        <h2>PURE888 FOOD</h2>
        <div class="text-center mb-3">
            <p>วันที่: <?php echo date('Y-m-d', strtotime($orderDate)); ?></p>
            <p>เวลา: <?php echo date('H:i:s', strtotime($orderDate)); ?></p>
        </div>
        <hr>
        <div id="list"></div>
        <div class="text-center mt-4">
            <button id="printReceipt" class="btn btn-primary">พิมพ์ใบเสร็จ</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="mainslip.js"></script>
</body>
</html>