<?php include('templates/header.php'); ?>

<div class="container">
    <div class="sidebar">
        <a href="index.php">Tela Inicial</a>
        <a href="add_product.php">Cadastrar Itens</a>
        <a href="list_products.php">Visualizar Itens</a> <!-- Ajuste aqui -->
    </div>
    <div class="content">
        <h1>Products for Sale</h1>
        <a href="add_product.php" class="add-project-button">Add New Product</a>
        <?php include('list_products.php'); ?>
    </div>
</div>

<?php include('templates/footer.php'); ?>


