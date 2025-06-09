-- POS System Database Schema
-- =============================

-- 1. Users - ผู้ใช้งานระบบ
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'cashier', 'manager', 'staff') NOT NULL DEFAULT 'staff',
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 2. Categories - หมวดหมู่สินค้า
CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL,
    description TEXT,
    parent_id INT NULL,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(category_id) ON DELETE SET NULL
);

-- 3. Products - สินค้า
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_code VARCHAR(50) NOT NULL UNIQUE,
    product_name VARCHAR(200) NOT NULL,
    description TEXT,
    category_id INT,
    unit VARCHAR(20) NOT NULL DEFAULT 'pcs',
    cost_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    selling_price DECIMAL(10,2) NOT NULL,
    stock_quantity INT NOT NULL DEFAULT 0,
    min_stock_level INT DEFAULT 0,
    barcode VARCHAR(100),
    image_url VARCHAR(255),
    status ENUM('active', 'inactive', 'discontinued') NOT NULL DEFAULT 'active',
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL
);

-- 4. Customers - ลูกค้า
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_code VARCHAR(50) UNIQUE,
    customer_name VARCHAR(150) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    points INT DEFAULT 0,
    total_spent DECIMAL(12,2) DEFAULT 0.00,
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 5. Payment Methods - วิธีการชำระเงิน
CREATE TABLE payment_methods (
    payment_method_id INT AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(50) NOT NULL,
    description VARCHAR(200),
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active'
);

-- 6. Sales - การขาย (หัวบิล)
CREATE TABLE sales (
    sale_id INT AUTO_INCREMENT PRIMARY KEY,
    sale_number VARCHAR(50) NOT NULL UNIQUE,
    customer_id INT NULL,
    user_id INT NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    discount_amount DECIMAL(10,2) DEFAULT 0.00,
    discount_percent DECIMAL(5,2) DEFAULT 0.00,
    tax_amount DECIMAL(10,2) DEFAULT 0.00,
    tax_percent DECIMAL(5,2) DEFAULT 0.00,
    total_amount DECIMAL(12,2) NOT NULL,
    paid_amount DECIMAL(12,2) NOT NULL,
    change_amount DECIMAL(12,2) DEFAULT 0.00,
    payment_method_id INT NOT NULL,
    notes TEXT,
    status ENUM('completed', 'cancelled', 'refunded') NOT NULL DEFAULT 'completed',
    sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE SET NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(payment_method_id)
);

-- 7. Sale Items - รายการสินค้าในการขาย
CREATE TABLE sale_items (
    sale_item_id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    discount_amount DECIMAL(10,2) DEFAULT 0.00,
    total_price DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(sale_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- 8. Suppliers - ผู้จำหน่าย
CREATE TABLE suppliers (
    supplier_id INT AUTO_INCREMENT PRIMARY KEY,
    supplier_code VARCHAR(50) UNIQUE,
    supplier_name VARCHAR(150) NOT NULL,
    contact_person VARCHAR(100),
    phone VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    tax_id VARCHAR(20),
    payment_terms VARCHAR(100),
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 9. Purchases - การสั่งซื้อ/รับสินค้า
CREATE TABLE purchases (
    purchase_id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_number VARCHAR(50) NOT NULL UNIQUE,
    supplier_id INT NOT NULL,
    user_id INT NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    discount_amount DECIMAL(10,2) DEFAULT 0.00,
    tax_amount DECIMAL(10,2) DEFAULT 0.00,
    total_amount DECIMAL(12,2) NOT NULL,
    paid_amount DECIMAL(12,2) DEFAULT 0.00,
    payment_status ENUM('pending', 'partial', 'paid') NOT NULL DEFAULT 'pending',
    delivery_date DATE,
    notes TEXT,
    status ENUM('pending', 'received', 'cancelled') NOT NULL DEFAULT 'pending',
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- 10. Purchase Items - รายการสินค้าที่สั่งซื้อ
CREATE TABLE purchase_items (
    purchase_item_id INT AUTO_INCREMENT PRIMARY KEY,
    purchase_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_cost DECIMAL(10,2) NOT NULL,
    total_cost DECIMAL(12,2) NOT NULL,
    received_quantity INT DEFAULT 0,
    FOREIGN KEY (purchase_id) REFERENCES purchases(purchase_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- 11. Inventory Movements - การเคลื่อนไหวสต็อก
CREATE TABLE inventory_movements (
    movement_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    movement_type ENUM('in', 'out', 'adjustment', 'return') NOT NULL,
    quantity INT NOT NULL,
    reference_type ENUM('sale', 'purchase', 'adjustment', 'return') NOT NULL,
    reference_id INT,
    user_id INT NOT NULL,
    notes TEXT,
    movement_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- 12. Promotions - โปรโมชั่น
CREATE TABLE promotions (
    promotion_id INT AUTO_INCREMENT PRIMARY KEY,
    promotion_name VARCHAR(150) NOT NULL,
    promotion_type ENUM('percentage', 'fixed_amount', 'buy_x_get_y') NOT NULL,
    discount_value DECIMAL(10,2) NOT NULL,
    min_purchase_amount DECIMAL(10,2) DEFAULT 0.00,
    max_discount_amount DECIMAL(10,2),
    applicable_products TEXT, -- JSON หรือ comma-separated product IDs
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    usage_limit INT,
    used_count INT DEFAULT 0,
    status ENUM('active', 'inactive', 'expired') NOT NULL DEFAULT 'active',
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 13. Branches/Stores - สาขา (สำหรับระบบหลายสาขา)
CREATE TABLE branches (
    branch_id INT AUTO_INCREMENT PRIMARY KEY,
    branch_code VARCHAR(20) NOT NULL UNIQUE,
    branch_name VARCHAR(100) NOT NULL,
    address TEXT,
    phone VARCHAR(20),
    email VARCHAR(100),
    manager_id INT,
    tax_id VARCHAR(20),
    status ENUM('active', 'inactive') NOT NULL DEFAULT 'active',
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (manager_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 14. Expenses - ค่าใช้จ่าย
CREATE TABLE expenses (
    expense_id INT AUTO_INCREMENT PRIMARY KEY,
    expense_category VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    receipt_number VARCHAR(50),
    vendor_name VARCHAR(100),
    user_id INT NOT NULL,
    branch_id INT,
    expense_date DATE NOT NULL,
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (branch_id) REFERENCES branches(branch_id) ON DELETE SET NULL
);

-- 15. System Settings - ตั้งค่าระบบ
CREATE TABLE system_settings (
    setting_id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL,
    data_type ENUM('string', 'number', 'boolean', 'json') NOT NULL DEFAULT 'string',
    description VARCHAR(255),
    updated_by INT,
    updated_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (updated_by) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 16. Audit Logs - บันทึกการใช้งาน
CREATE TABLE audit_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action ENUM('create', 'update', 'delete', 'login', 'logout') NOT NULL,
    table_name VARCHAR(50),
    record_id INT,
    old_values JSON,
    new_values JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
);

-- 17. Customer Points History - ประวัติการใช้คะแนนลูกค้า
CREATE TABLE customer_points_history (
    history_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    sale_id INT,
    points_earned INT DEFAULT 0,
    points_used INT DEFAULT 0,
    points_balance INT NOT NULL,
    transaction_type ENUM('earned', 'used', 'expired', 'adjustment') NOT NULL,
    description VARCHAR(255),
    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (sale_id) REFERENCES sales(sale_id) ON DELETE SET NULL
);

-- สร้าง Index สำหรับการค้นหาที่เร็วขึ้น
CREATE INDEX idx_products_code ON products(product_code);
CREATE INDEX idx_products_barcode ON products(barcode);
CREATE INDEX idx_sales_date ON sales(sale_date);
CREATE INDEX idx_sales_number ON sales(sale_number);
CREATE INDEX idx_customers_phone ON customers(phone);
CREATE INDEX idx_inventory_movements_date ON inventory_movements(movement_date);
CREATE INDEX idx_audit_logs_timestamp ON audit_logs(timestamp);

-- Insert ข้อมูลเริ่มต้น
INSERT INTO payment_methods (method_name, description) VALUES
('Cash', 'เงินสด'),
('Credit Card', 'บัตรเครดิต'),
('Debit Card', 'บัตรเดบิต'),  
('Bank Transfer', 'โอนเงิน'),
('QR Code', 'สแกน QR Code'),
('E-Wallet', 'กระเป๋าเงินอิเล็กทรอนิกส์');

INSERT INTO system_settings (setting_key, setting_value, data_type, description) VALUES
('tax_rate', '7.00', 'number', 'อัตราภาษีมูลค่าเพิ่ม (%)'),
('currency_symbol', '฿', 'string', 'สัญลักษณ์เงินตรา'),
('receipt_footer', 'ขอบคุณที่ใช้บริการ', 'string', 'ข้อความท้ายใบเสร็จ'),
('points_per_baht', '1', 'number', 'คะแนนต่อบาทที่ซื้อ'),
('allow_negative_stock', 'false', 'boolean', 'อนุญาตให้สต็อกติดลบ');