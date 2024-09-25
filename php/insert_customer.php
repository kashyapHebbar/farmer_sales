<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $customerName = $_POST['customerName'];
    $customerType = $_POST['customerType'];
    $customerLocation = $_POST['customerLocation'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO customer (customer_name, customer_type, customer_location) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $customerName, $customerType, $customerLocation);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New customer added successfully";
        // Redirect back to the customer form or another page
        header("Location: ../pages/customer.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>