ini_set('display_errors', 1);
error_reporting(E_ALL);
<?php
require './php/connect.php';

$message = "";

// Handle POST request for adding or updating farmer information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kisanCardNo = htmlspecialchars($_POST['kisanCardNo']);
    $farmerName = htmlspecialchars($_POST['farmerName']);
    $farmerDob = $_POST['farmerDob']; // Assuming a date input
    $farmerAddress = htmlspecialchars($_POST['farmerAddress']);

    if (isset($_POST['add'])) {
        $stmt = $conn->prepare("INSERT INTO farmer (kisan_card_no, farmer_name, fdob, faddress) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $kisanCardNo, $farmerName, $farmerDob, $farmerAddress);
            if ($stmt->execute()) {
                $message = "Farmer successfully added.";
            } else {
                $message = "Error adding farmer: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error preparing statement: " . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        $farmerId = $_POST['farmerId'];
        $stmt = $conn->prepare("UPDATE farmer SET kisan_card_no = ?, farmer_name = ?, fdob = ?, faddress = ? WHERE farmer_id = ?");
        if ($stmt) {
            $stmt->bind_param("ssssi", $kisanCardNo, $farmerName, $farmerDob, $farmerAddress, $farmerId);
            if ($stmt->execute()) {
                $message = "Farmer successfully updated.";
            } else {
                $message = "Error updating farmer: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Error preparing statement: " . $conn->error;
        }
    }
}

// Fetch all farmers for display
$result = $conn->query("SELECT * FROM farmer");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Farmers</title>
</head>
<body>
    <h1>Farmer Management</h1>
    <p><?= $message ?></p>
    <form action="farmer.php" method="post">
        <input type="hidden" name="farmerId" id="farmerId">
        <label for="kisanCardNo">Kisan Card No:</label>
        <input type="text" id="kisanCardNo" name="kisanCardNo" required><br>
        <label for="farmerName">Name:</label>
        <input type="text" id="farmerName" name="farmerName" required><br>
        <label for="farmerDob">Date of Birth:</label>
        <input type="date" id="farmerDob" name="farmerDob" required><br>
        <label for="farmerAddress">Address:</label>
        <input type="text" id="farmerAddress" name="farmerAddress" required><br>
        <button type="submit" name="add">Add Farmer</button>
        <button type="submit" name="update">Update Farmer</button>
    </form>

    <h2>All Farmers</h2>
    <table>
        <tr>
            <th>Kisan Card No</th>
            <th>Name</th>
            <th>Date of Birth</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php if ($result): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['kisan_card_no'] ?></td>
                <td><?= $row['farmer_name'] ?></td>
                <td><?= $row['fdob'] ?></td>
                <td><?= $row['faddress'] ?></td>
                <td>
                    <button onclick="editFarmer('<?= $row['farmer_id'] ?>', '<?= $row['kisan_card_no'] ?>', '<?= $row['farmer_name'] ?>', '<?= $row['fdob'] ?>', '<?= $row['faddress'] ?>')">Edit</button>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>

    <script>
        function editFarmer(id, kisanCardNo, name, dob, address) {
            document.getElementById('farmerId').value = id;
            document.getElementById('kisanCardNo').value = kisanCardNo;
            document.getElementById('farmerName').value = name;
            document.getElementById('farmerDob').value = dob;
            document.getElementById('farmerAddress').value = address;
            document.forms[0].action = 'farmer.php';
        }
    </script>
</body>
</html>
<?php
// Close connection at the very end of the script
$conn->close();
?>