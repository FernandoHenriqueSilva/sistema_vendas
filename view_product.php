<?php
include('config.php');

// Verificar se o ID do produto foi passado via GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Product ID not provided.");
}

$product_id = $_GET['id'];

// Buscar informações do produto
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("Product not found.");
}

// Buscar fotos do produto
$sql = "SELECT * FROM product_photos WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute(); // Esta é a linha que estava faltando
$result = $stmt->get_result();
$photos = [];
while ($row = $result->fetch_assoc()) {
    $photos[] = $row['photo_url'];
}
$stmt->close();
?>

<?php include('templates/header.php'); ?>

<h1><?php echo htmlspecialchars($product['title']); ?></h1>
<p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
<p>Payment Mode: <?php echo ucfirst(htmlspecialchars($product['payment_mode'])); ?></p>
<p>Contact: <?php echo htmlspecialchars($product['contact']); ?></p>

<?php if (!empty($photos)): ?>
    <img src="<?php echo htmlspecialchars($photos[0]); ?>" alt="Product Image" class="product-img">
    <?php if (count($photos) > 1): ?>
        <button id="show-more-photos">Show More Photos</button>
        <?php include('templates/modal.php'); ?>
    <?php endif; ?>
<?php else: ?>
    <p>No photos available for this product.</p>
<?php endif; ?>

<?php include('templates/footer.php'); ?>
