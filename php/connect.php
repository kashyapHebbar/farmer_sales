<?php
// Database configuration
$host = "127.0.0.1";
$username = "farmer";
$password = "Farmer@123";
$database = "farm_management";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create 'farmer' table
$sql = "CREATE TABLE IF NOT EXISTS farmer (
    farmer_id INT AUTO_INCREMENT PRIMARY KEY,
    kisan_card_no VARCHAR(255) NOT NULL UNIQUE,
    farmer_name VARCHAR(255) NOT NULL,
    fdob DATE NOT NULL,
    faddress VARCHAR(255) NOT NULL
)";

$conn->query($sql);

// Create 'customer' table
$sql = "CREATE TABLE IF NOT EXISTS customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    customer_type VARCHAR(50) NOT NULL,
    customer_location VARCHAR(255) NOT NULL
)";

$conn->query($sql);

// Create 'product' table
$sql = "CREATE TABLE IF NOT EXISTS product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    kisan_card_no VARCHAR(255) NOT NULL,
    product_type VARCHAR(50) NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (kisan_card_no) REFERENCES farmer(kisan_card_no)
)";

$conn->query($sql);

// Create 'orders' table
$sql = "CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    customer_id INT NOT NULL,
    order_date DATE NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(product_id),
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
)";

$conn->query($sql);
?>