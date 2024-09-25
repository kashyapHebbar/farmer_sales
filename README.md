
# Farm Management System






## Table of contents 
    •	Introduction
	•	Features
	•	Project Structure
	•	Installation
	•	Database Setup
	•	Usage
	•	Screenshots
	•	Technologies Used
	•	Contributing
	•	License
	•	Contact

    
## Introduction

The Farm Management System is a web application designed to help manage farm-related data, including farmers, products, customers, orders, and sales. It provides an interface for farmers to register their details, enter products, place orders, and view sales data.
## Features

	•	Farmer Registration: Allows farmers to register their details, including Kisan Card Number, name, date of birth, and address.
	•	Product Entry: Farmers can enter products they offer, specifying product type and unit price.
	•	Customer Management: Register customers with their details, including name, type, and location.
	•	Order Placement: Customers can place orders for products, specifying quantity and order date.
	•	Sales Data Display: View sales data, including income generated from orders.
	•	Responsive Design: The application is responsive and works across different devices.

## Installation

	1.	Clone the repository:  git clone https://github.com/yourusername/farmer_sales.git

    2.	Navigate to the project directory: cd farmer_sales

    3.	Set up a web server: 
    •	Use XAMPP or WAMP for Windows.
	•	Use MAMP for macOS.
	•	Alternatively, set up Apache and PHP manually.

    4.	Place the project folder in the web server directory:
	•	For XAMPP: C:\xampp\htdocs\farmer_sales
	•	For WAMP: C:\wamp\www\farmer_sales
    
	5.	Start the web server and MySQL service.



## Database Setup

1.	Create the database:

    •	Access phpMyAdmin.

2.	Create the tables:

    •	Run the following SQL commands in phpMyAdmin’s SQL tab:

CREATE TABLE farmer (
    farmer_id INT AUTO_INCREMENT PRIMARY KEY,
    kisan_card_no VARCHAR(255) NOT NULL UNIQUE,
    farmer_name VARCHAR(255) NOT NULL,
    fdob DATE NOT NULL,
    faddress VARCHAR(255) NOT NULL
);

CREATE TABLE customer (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    customer_type VARCHAR(50) NOT NULL,
    customer_location VARCHAR(255) NOT NULL
);

CREATE TABLE product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    kisan_card_no VARCHAR(255) NOT NULL,
    product_type VARCHAR(50) NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (kisan_card_no) REFERENCES farmer(kisan_card_no)
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    customer_id INT NOT NULL,
    order_date DATE NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(product_id),
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id)
);


3.	Update connect.php with your database credentials:

    <?php
    // Database configuration
    $host = "127.0.0.1";
    $username = "your_database_username";
    $password = "your_database_password";
    $database = "farm_management";

    // Create connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    ?>


## Usage

	1.	Access the application:

    Open your web browser and navigate to:
    http://localhost/farm-management-system/index.html

    2.	Register a Farmer:
	•	Go to the Farmer page.
	•	Fill out the farmer registration form.
	•	Submit the form to store the farmer’s details.

	3.	Enter a Product:
	•	Go to the Product page.
	•	Fill out the product entry form (ensure the Kisan Card Number exists).
	•	Submit the form to add the product.

	4.	Register a Customer:
	•	Go to the Customer page.
	•	Fill out the customer registration form.
	•	Submit the form to store the customer’s details.

	5.	Place an Order:
	•	Go to the Order page.
	•	Fill out the order form (select existing Product ID and Customer ID).
	•	Submit the form to place the order.
    
	6.	View Sales Data:
	•	Go to the Sales page.
	•	View the sales data displayed in the table.


## Technologies Used

    •	Front-end:
	•	HTML5
	•	CSS3
	•	Bootstrap 4
    •	Back-end:
	•	PHP
	•	MySQL
    •	Tools:
	•	phpMyAdmin (for database management)
	•	Apache Web Server
    
