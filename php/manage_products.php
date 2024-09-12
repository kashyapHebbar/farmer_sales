<?php
require 'connect.php';

// Message variable
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        // Add Product
        $name = htmlspecialchars($_POST['name']);
        $price = htmlspecialchars($_POST['price']);

        $stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
        $stmt->bind_param("sd", $name, $price);

        if ($stmt->execute()) {
            $message = "Product added successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Update Product
        $id = $_POST['id'];
        $name = htmlspecialchars($_POST['name']);
        $price = htmlspecialchars($_POST['price']);

        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ? WHERE id = ?");
        $stmt->bind_param("sdi", $name, $price, $id);

        if ($stmt->execute()) {
            $message = "Product updated successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        // Delete Product
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $message = "Product deleted successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all products
$result = $conn->query("SELECT * FROM products");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; }
        th, td { padding: 10px; }
        th { text-align: left; }
    </style>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>
<body>
    <h1>Product Management</h1>
    <p><?= $message ?></p>
    <form method="post">
        <input type="hidden" name="id" value="" id="prodId">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required><br><br>
        <button type="submit" name="add">Add Product</button>
        <button type="submit" name="update">Update Product</button>
        <button type="submit" name="delete">Delete Product</button>
    </form>
    <h2>All Products</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['price'] ?></td>
                <td>
                    <button onclick="editProduct(<?= $row['id'] ?>, '<?= $row['name'] ?>', '<?= $row['price'] ?>')">Edit</button>
                    <button onclick="deleteProduct(<?= $row['id'] ?>)">Delete</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button onclick="printPage()">Print Products</button>
    <script>
        function editProduct(id, name, price) {
            document.getElementById('prodId').value = id;
            document.getElementById('name').value = name;
            document.getElementById('price').value = price;
        }

        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                document.getElementById('prodId').value = id;
                document.getElementsByName('delete')[0].click();
            }
        }
    </script>
</body>
</html>