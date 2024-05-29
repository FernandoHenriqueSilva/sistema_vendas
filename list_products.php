<?php
include 'config.php';

$sql = "SELECT id, title, price, payment_mode, contact FROM products LIMIT 10"; // Limitar a consulta para os 10 primeiros itens
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='product-list'>";
    while($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        echo "<h3>" . $row["title"]. "</h3>";
        echo "<p>Price: $" . $row["price"]. "</p>";
        echo "<p>Payment Mode: " . ucfirst($row["payment_mode"]). "</p>";
        echo "<p>Contact: " . $row["contact"]. "</p>";
        // Adicionar a imagem com uma classe para pré-visualização
        echo "<img src='product_images/{$row["id"]}.jpg' alt='Product Image' class='preview-img'>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "0 results";
}
$conn->close();
?>
