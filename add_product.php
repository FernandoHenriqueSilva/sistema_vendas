<?php include('templates/header.php'); ?>

<div class="container">
    <div class="sidebar">
        <a href="index.php">Tela Inicial</a>
        <a href="add_product.php">Cadastrar Itens</a>
        <a href="list_products.php">Visualizar Itens</a>
    </div>
    <div class="content">
        <h1>Cadastrar Novo Produto</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require 'config.php';
            $title = $_POST['title'];
            $price = $_POST['price'];
            $payment_mode = $_POST['payment_mode'];
            $contact = $_POST['contact'];
            $stmt = $conn->prepare("INSERT INTO products (title, price, payment_mode, contact) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdss", $title, $price, $payment_mode, $contact);
            if ($stmt->execute()) {
                $product_id = $stmt->insert_id;
                if (!empty($_FILES['photos']['name'][0])) {
                    $total_files = count($_FILES['photos']['name']);
                    for ($i = 0; $i < $total_files; $i++) {
                        $file_name = $_FILES['photos']['name'][$i];
                        $file_tmp = $_FILES['photos']['tmp_name'][$i];
                        $blob_name = basename($file_name);
                        try {
                            $content = fopen($file_tmp, "r");
                            $blobClient->createBlockBlob($blobContainerName, $blob_name, $content);
                            $blob_url = "https://$blobAccountName.blob.core.windows.net/$blobContainerName/$blob_name";
                            $stmt = $conn->prepare("INSERT INTO product_photos (product_id, photo_url) VALUES (?, ?)");
                            $stmt->bind_param("is", $product_id, $blob_url);
                            $stmt->execute();
                        } catch (Exception $e) {
                            echo "Error uploading file: " . $e->getMessage();
                        }
                    }
                }
                echo "Product and photos added successfully.";
            } else {
                echo "Failed to add product.";
            }
        }
        ?>
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" required>
            <label for="price">Price</label>
            <input type="text" id="price" name="price" required>
            <label for="payment_mode">Payment Mode</label>
            <select id="payment_mode" name="payment_mode" required>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
                <option value="PayPal">PayPal</option>
            </select>
            <label for="contact">Contact</label>
            <input type="text" id="contact" name="contact" required>
            <label for="photos">Photos</label>
            <input type="file" id="photos" name="photos[]" multiple>
            <button type="submit">Submit</button>
        </form>
    </div>
</div>

<?php include('templates/footer.php'); ?>
