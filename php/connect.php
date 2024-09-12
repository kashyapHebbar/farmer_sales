<?php
// Database configuration
$host = "127.0.0.1"; // since it's localhost
$username = "farmer"; // the username you granted privileges
$password = "Farmer@123"; // the password you set for the user
$database = "farm_management"; // the database you want to connect to

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else 
{ 
echo "Connected successfully";
}
// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS farmer (
    farmer_id INT AUTO_INCREMENT PRIMARY KEY,
    farmer_name VARCHAR(255) NOT NULL,
    faddress VARCHAR(255) NOT NULL,
    fdob DATE NOT NULL,
    kisan_card_no VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'farmer' created successfully or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}
