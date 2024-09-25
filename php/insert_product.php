<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the form
    $kisanCardNo = $_POST['kisanCardNo'];
    $productType = $_POST['productType'];
    $unitPrice = $_POST['unitPrice'];

    // Check if kisan_card_no exists
    $farmer_check = $conn->prepare("SELECT kisan_card_no FROM farmer WHERE kisan_card_no = ?");
    $farmer_check->bind_param("s", $kisanCardNo);
    $farmer_check->execute();
    $farmer_check->store_result();

    if ($farmer_check->num_rows == 0) {
        echo "Error: Kisan Card No does not exist.";
        exit();
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO product (kisan_card_no, product_type, unit_price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $kisanCardNo, $productType, $unitPrice);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New product added successfully";
        // Redirect back to the product form or another page
        header("Location: ../pages/product.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $farmer_check->close();
    $stmt->close();
    $conn->close();
}
?>