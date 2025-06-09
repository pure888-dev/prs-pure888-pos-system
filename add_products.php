<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Products - อัพโหลดสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Upload Products - อัพโหลดสินค้า</h2>
        <p class="text-warning">หมายเหตุ: รองรับไฟล์รูปภาพ JPEG, GIF, PNG เท่านั้น</p>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="productName" class="form-label">ชื่อสินค้า</label>
                <input type="text" class="form-control" id="productName" name="productName" required>
            </div>
            <div class="mb-3">
                <label for="productBrand" class="form-label">แบรนด์สินค้า</label>
                <input type="text" class="form-control" id="productBrand" name="productBrand" required>
            </div>
            <div class="mb-3">
                <label for="productType" class="form-label">ประเภทสินค้า</label>
                <input type="text" class="form-control" id="productType" name="productType" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">ราคา (THB)</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">อัพโหลดรูปภาพ</label>
                <input type="file" class="form-control" id="file" name="file" accept="image/jpeg,image/png,image/gif" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">อัพโหลด</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>