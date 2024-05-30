<?php
require 'config.php';

// Executa a consulta SQL para obter os produtos e suas fotos
$query = "SELECT p.id, p.title, p.price, p.payment_mode, MIN(ph.photo_url) AS photo_url
          FROM products p
          LEFT JOIN product_photos ph ON p.id = ph.product_id
          GROUP BY p.id
          ORDER BY p.id DESC
          LIMIT 10";

$result = $conn->query($query);

// Verifica se a consulta retornou resultados
if (!$result) {
    echo "Erro na consulta: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="styles.css"> <!-- Certifique-se de ter um arquivo CSS para estilização -->
</head>
<body>
    <ul class="product-list">
        <?php while ($row = $result->fetch_assoc()): ?>
        <li class="product-item">
            <?php if ($row['photo_url']): ?>
            <img src="<?php echo htmlspecialchars($row['photo_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="product-image" />
            <?php endif; ?>
            <div class="product-details">
                <h2 class="product-title"><?php echo htmlspecialchars($row['title']); ?></h2>
                <p class="product-price">Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                <p class="product-payment-mode">Payment Mode: <?php echo htmlspecialchars($row['payment_mode']); ?></p>
                <a href="product_details.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="product-link">View Details</a>
            </div>
        </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
