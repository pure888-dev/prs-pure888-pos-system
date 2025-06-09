<?php session_start(); include 'Database.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PURE888 : DataStock</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1 class="text-center mb-4 mt-4">PURE888 : DataStock</h1>
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th width="5%">ID</th>
                    <th width="30%">ชื่อสินค้า</th>
                    <th width="30%">ราคา (THB)</th>
                    <th width="30%">รูปภาพ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $database = new Database();
                $db = $database->getConnection();
                $stmt = $db->prepare("SELECT * FROM products ORDER BY id DESC");
                $stmt->execute();
                $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($menuItems)): 
                    $counter = 1;
                    foreach ($menuItems as $item): ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td class="price"><?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <?php if (!empty($item['image'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="max-width: 100px;">
                            <?php else: ?>
                                ไม่มีรูปภาพ
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">ไม่มีข้อมูลสินค้า</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>