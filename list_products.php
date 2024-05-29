<?php
include 'config.php';

$sql = "SELECT p.id, p.title, p.price, p.payment_mode, p.contact, MIN(ph.photo_url) as photo_url 
        FROM products p 
        LEFT JOIN product_photos ph ON p.id = ph.product_id 
        GROUP BY p.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        $photo_url = $row['photo_url'] ? htmlspecialchars($row['photo_url']) : 'placeholder.png';
        echo "<li>";
        echo "<img src='$photo_url' alt='Product Image'>";
        echo "<a href='view_product.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["title"]) . "</a>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "0 results";
}
$conn->close();
?>
