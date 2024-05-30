<?php include('templates/header.php'); ?>

<div class="container">
    <div class="sidebar">
        <a href="index.php">Tela Inicial</a>
        <a href="add_product.php">Cadastrar Itens</a>
        <a href="view_items.php">Visualizar Itens</a>
    </div>
    <div class="content">
        <h1>Products for Sale</h1>
        <a href="add_product.php">Add New Product</a>
        <?php include('list_products.php'); ?>
    </div>
</div>

<?php include('templates/footer.php'); ?>
