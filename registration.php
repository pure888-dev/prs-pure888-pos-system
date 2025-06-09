<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PURE888 - สมัครสมาชิก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style_register.css">
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <div class="logo">PURE888</div>
            <h2>สมัครสมาชิก</h2>
            <form action="register.php" method="POST">
                <div class="form-group">
                    <label for="username">ชื่อผู้ใช้</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">อีเมล</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">ยืนยันรหัสผ่าน</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <button type="submit" class="submit-btn">สมัครสมาชิก</button>
            </form>
            <div class="login-link">
                <p>มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
            </div>
            <div class="terms-link">
                <p>โดยการสมัคร คุณยอมรับ <a href="#">ข้อกำหนดและเงื่อนไข</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน');
            }
        });
    </script>
</body>
</html>