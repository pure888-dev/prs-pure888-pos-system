<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PURE888 - รายงาน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">PURE888</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="#">📊 Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">👥 ผู้ใช้งาน (12)</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">🛒 คำสั่งซื้อ (5)</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">📦 สินค้า</a></li>
                        <li class="nav-item"><a class="nav-link active" href="#">📈 รายงาน</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">💬 ข้อความ (3)</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">⚙️ ตั้งค่า</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">🚪 ออกจากระบบ</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center">
                        <h5 class="card-title">ยินดีต้อนรับ, Admin!</h5>
                        <p class="card-text">ภาพรวมของระบบ PURE888 - วันนี้ (<?php echo date('Y-m-d H:i'); ?>)</p>
                        <p class="card-text">Admin User: [email protected]</p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>👥 +12%</h5>
                                <h4>2,847</h4>
                                <p class="card-text">ผู้ใช้งานทั้งหมด</p>
                                <p class="card-text">เป้าหมาย: 3,000 (95%)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>🛒 +8%</h5>
                                <h4>1,234</h4>
                                <p class="card-text">คำสั่งซื้อวันนี้</p>
                                <p class="card-text">เป้าหมาย: 1,500 (82%)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>💰 -3%</h5>
                                <h4>฿89,562</h4>
                                <p class="card-text">รายได้วันนี้</p>
                                <p class="card-text">เป้าหมาย: ฿100,000 (90%)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5>📦 +5%</h5>
                                <h4>456</h4>
                                <p class="card-text">สินค้าทั้งหมด</p>
                                <p class="card-text">สินค้าคงเหลือ: 78%</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">📈 รายงาน</h5>
                                <p class="card-text">กราฟรายงานจะแสดงที่นี่ (ใช้ Chart.js)</p>
                                <div class="btn-group mb-3" role="group">
                                    <button type="button" class="btn btn-outline-primary">ยอดขาย</button>
                                    <button type="button" class="btn btn-outline-primary">ผู้ใช้งาน</button>
                                </div>
                                <canvas id="chartContainer" style="height: 300px; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">🔔 กิจกรรมล่าสุด</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">👤 ผู้ใช้ใหม่สมัครสมาชิก (5 นาทีที่แล้ว)</li>
                                    <li class="list-group-item">🛍️ คำสั่งซื้อใหม่ #12345 (15 นาทีที่แล้ว)</li>
                                    <li class="list-group-item">💳 ได้รับชำระเงิน ฿2,500 (30 นาทีที่แล้ว)</li>
                                    <li class="list-group-item">⭐ รีวิวสินค้าใหม่ 5 ดาว (1 ชั่วโมงที่แล้ว)</li>
                                    <li class="list-group-item">📦 อัปเดตสต็อกสินค้า (2 ชั่วโมงที่แล้ว)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-3">➕ การจัดการ</h5>
                                <a href="add_products.php" class="btn btn-success mb-2 w-25">เพิ่มสินค้า</a>
                                <a href="index.php" class="btn btn-info mb-2 w-25">ดูคำสั่งซื้อ</a>
                                <button class="btn btn-primary mb-2 w-25">สร้างรายงาน</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Example Chart.js
        const ctx = document.getElementById('chartContainer').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['ยอดขาย', 'ผู้ใช้งาน'],
                datasets: [{
                    label: 'ข้อมูล',
                    data: [1200, 2847],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(75, 192, 192, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(75, 192, 192, 1)'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>
</body>
</html>