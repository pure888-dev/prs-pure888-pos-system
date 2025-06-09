<?php
session_start();
include_once 'Database.php';

$database = new Database();
$db = $database->getConnection();


?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRSPOS : Index</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-7 h-100">
                <br>
                <h2 class="my-3">Products</h2>
                <div id="productbox" class="product-container h-100">
                    <?php 
                    if (!empty($products)) {
                        foreach ($products as $productItem): ?>
                            <div class="product-item" data-id="<?php echo htmlspecialchars($productItem['id']); ?>">
                                <?php if (!empty($productItem['image'])): ?>
                                    <img src="product-items/<?php echo htmlspecialchars($productItem['image']); ?>" alt="<?php echo htmlspecialchars($productItem['name']); ?>" class="img-fluid">
                                <?php else: ?>
                                    <div class="no-image">ไม่มีรูปภาพ</div>
                                <?php endif; ?>
                                <div class="product-info">
                                    <h4><?php echo htmlspecialchars($productItem['name']); ?></h4>
                                    <h5><?php echo number_format($productItem['price'], 2); ?> THB</h5>
                                    <button class="btn btn-add-cart add-to-cart" data-id="<?php echo htmlspecialchars($productItem['id']); ?>">
                                        เพิ่มลงตะกร้า
                                    </button>
                                </div>
                            </div>
                        <?php endforeach;
                    } else {
                        echo '<div class="col-12 alert alert-warning">ไม่พบข้อมูลสินค้าในระบบ กรุณาเพิ่มสินค้าก่อนใช้งาน</div>';
                        echo '<div class="col-12"><a href="add_products.php" class="btn btn-primary">เพิ่มสินค้า</a></div>';
                    } ?>
                </div>
            </div>
            <div class="col-md-5 h-100">
                <div class="list h-100">
                    <br>
                    <h2>Order Summary</h2>
                    <div id="listbox" class="list-box flex-grow-1">
                        <?php if (empty($_SESSION['cart'])): ?>
                            <p class="text-center">Your cart is empty</p>
                        <?php else: ?>
                            <?php 
                            $total = 0;
                            foreach ($_SESSION['cart'] as $index => $item): 
                                $itemTotal = $item['price'] * $item['quantity'];
                                $total += $itemTotal;
                            ?>
                                <div class="list-item" data-index="<?php echo htmlspecialchars($index); ?>">
                                    <div class="d-flex justify-content-between">
                                        <span><?php echo htmlspecialchars($item['name']); ?> x<?php echo htmlspecialchars($item['quantity']); ?></span>
                                        <span><?php echo number_format($itemTotal, 2); ?> THB</span>
                                    </div>
                                    <button class="btn btn-sm btn-danger remove-item" data-index="<?php echo htmlspecialchars($index); ?>">
                                        Remove
                                    </button>
                                </div>
                            <?php endforeach; ?>
                            <div class="list-item list-summary">
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong><?php echo number_format($total, 2); ?> THB</strong>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <br>
                    <a href="report.php"><button id="report-btn" class="btn btn-primary">Dashboard</button></a>
                    <div class="list-control mt-3">
                        <button id="print-btn" class="btn btn-success">PRINT</button>
                        <div class="print alert-modal" id="printModal">
                            <div class="modal-content">
                                <span class="close" onclick="closeModal()">×</span>
                                <p>Are you sure?</p>
                                <button id="confirm-print-btn" class="btn btn-success">OK</button>
                                <button id="confirm-clear-btn" class="btn btn-danger">CLEAR</button>
                            </div>
                        </div>
                        <button id="clear-btn" class="btn btn-danger">CLEAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add to cart functionality
            $(document).on('click', '.add-to-cart', function() {
                const productId = $(this).data('id');
                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: { action: 'add_to_cart', product_id: productId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error adding to cart:", error);
                    }
                });
            });

            // Remove item from cart
            $(document).on('click', '.remove-item', function() {
                const cartIndex = $(this).data('index');
                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: { action: 'remove_from_cart', cart_index: cartIndex },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error removing item:", error);
                    }
                });
            });

            // Clear cart
            $('#clear-btn').click(function() {
                $.ajax({
                    url: 'index.php',
                    type: 'POST',
                    data: { action: 'clear_cart' },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error clearing cart:", error);
                    }
                });
            });

            // Print modal
            $('#print-btn').click(function() {
                $('#printModal').show();
            });

            // Confirm print
            $('#confirm-print-btn').click(function() {
                window.print();
                $('#printModal').hide();
            });

            // Confirm clear
            $('#confirm-clear-btn').click(function() {
                $('#clear-btn').click();
                $('#printModal').hide();
            });

            // Close modal
            function closeModal() {
                $('#printModal').hide();
            }
        });
    </script>
</body>
</html>