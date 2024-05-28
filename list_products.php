<?php
include 'config.php';

$sql = "SELECT id, title, price, payment_mode, contact FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Title</th><th>Price</th><th>Payment Mode</th><th>Contact</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"]. "</td><td>" . $row["title"]. "</td><td>" . $row["price"]. "</td><td>" . $row["payment_mode"]. "</td><td>" . $row["contact"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>
