<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $productId = $_POST['productId'];
    $customerId = $_POST['customerId'];
    $orderDate = $_POST['orderDate'];
    $quantity = $_POST['quantity'];

    // Check if product_id exists
    $product_check = $conn->prepare("SELECT product_id FROM product WHERE product_id = ?");
    $product_check->bind_param("i", $productId);
    $product_check->execute();
    $product_check->store_result();

    if ($product_check->num_rows == 0) {
        echo "Error: Product ID does not exist.";
        exit();
    }

    // Check if customer_id exists
    $customer_check = $conn->prepare("SELECT customer_id FROM customer WHERE customer_id = ?");
    $customer_check->bind_param("i", $customerId);
    $customer_check->execute();
    $customer_check->store_result();

    if ($customer_check->num_rows == 0) {
        echo "Error: Customer ID does not exist.";
        exit();
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO orders (product_id, customer_id, order_date, quantity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $productId, $customerId, $orderDate, $quantity);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New order placed successfully";
        // Redirect back to the order form or another page
        header("Location: ../pages/order.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $product_check->close();
    $customer_check->close();
    $stmt->close();
    $conn->close();
}
?>