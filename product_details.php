<?php
require 'config.php';

$id = $_GET['id'];

$query = "SELECT p.id, p.title, p.price, p.payment_mode, p.contact, ph.photo_url
          FROM products p
          LEFT JOIN product_photos ph ON p.id = ph.product_id
          WHERE p.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

?>

<?php include('templates/header.php'); ?>

<div class="container">
    <div class="sidebar">
        <a href="index.php">Tela Inicial</a>
        <a href="add_product.php">Cadastrar Itens</a>
        <a href="view_items.php">Visualizar Itens</a>
    </div>
    <div class="content">
        <h1><?php echo $product['title']; ?></h1>
        <p>Price: $<?php echo $product['price']; ?></p>
        <p>Payment Mode: <?php echo $product['payment_mode']; ?></p>
        <p>Contact: <?php echo $product['contact']; ?></p>
        <?php if ($product['photo_url']): ?>
        <img src="<?php echo $product['photo_url']; ?>" alt="<?php echo $product['title']; ?>" class="product-img" />
        <?php endif; ?>
    </div>
</div>

<?php include('templates/footer.php'); ?>
