<?php
include '../php/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Data</title>
    <!-- Include Bootstrap CSS and your custom CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body class="body-sales">
    <!-- Navigation bar -->
    <!-- [Your existing navigation code, update the link to sales.php if necessary] -->

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Sales Data</h2>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Product ID</th>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Quantity</th>
                    <th>Income</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to retrieve sales data
                $sql = "SELECT 
                            orders.product_id,
                            orders.order_id,
                            customer.customer_name,
                            orders.quantity,
                            (orders.quantity * product.unit_price) as income
                        FROM orders
                        JOIN customer ON orders.customer_id = customer.customer_id
                        JOIN product ON orders.product_id = product.product_id";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['product_id'] . "</td>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['customer_name'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['income'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No sales data available</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- Include jQuery and Bootstrap JS -->
    <!-- [Your existing scripts] -->
</body>
</html>