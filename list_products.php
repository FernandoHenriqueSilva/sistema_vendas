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
    <header>
        <h1>Product List</h1>
    </header>
    <div class="container">
        <div class="sidebar">
            <!-- Adicione links de navegação da sidebar aqui -->
        </div>
        <div class="content">
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <?php if ($row['photo_url']): ?>
                    <img src="<?php echo htmlspecialchars($row['photo_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" />
                    <?php endif; ?>
                    <div>
                        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                        <p>Price: $<?php echo htmlspecialchars($row['price']); ?></p>
                        <p>Payment Mode: <?php echo htmlspecialchars($row['payment_mode']); ?></p>
                        <a href="product_details.php?id=<?php echo htmlspecialchars($row['id']); ?>">View Details</a>
                    </div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 Your Company</p>
    </footer>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
