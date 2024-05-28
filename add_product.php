<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $payment_mode = $_POST['payment_mode'];
    $contact = $_POST['contact'];

    // Prepare statement to insert product
    $stmt = $conn->prepare("INSERT INTO products (title, price, payment_mode, contact) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $title, $price, $payment_mode, $contact);
    $stmt->execute();
    $product_id = $stmt->insert_id; // Get the ID of the inserted product
    $stmt->close();

    // Handle file upload
    if (!empty($_FILES['photos']['name'][0])) {
        $total_files = count($_FILES['photos']['name']);
        for ($i = 0; $i < $total_files; $i++) {
            $file_name = $_FILES['photos']['name'][$i];
            $file_tmp = $_FILES['photos']['tmp_name'][$i];
            $blob_name = basename($file_name);

            try {
                // Upload blob to Azure using SAS token
                $content = fopen($file_tmp, "r");
                $blobClient->createBlockBlob($blobContainerName, $blob_name, $content);

                // Get the URL of the uploaded blob
                $blob_url = "https://$blobAccountName.blob.core.windows.net/$blobContainerName/$blob_name";

                // Insert photo URL into database
                $stmt = $conn->prepare("INSERT INTO product_photos (product_id, photo_url) VALUES (?, ?)");
                $stmt->bind_param("is", $product_id, $blob_url);
                $stmt->execute();
                $stmt->close();
            } catch (Exception $e) {
                echo "Failed to upload to Azure Blob Storage: " . $e->getMessage();
            }
        }
    }

    echo "Product added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <h2>Add Product</h2>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required>

        <label for="payment_mode">Payment Mode:</label>
        <select id="payment_mode" name="payment_mode">
            <option value="Dinheiro">Dinheiro</option>
            <option value="Pix">Pix</option>
            <option value="Cartão">Cartão</option>
        </select>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" required>

        <label for="photos">Photos (max 5):</label>
        <input type="file" id="photos" name="photos[]" multiple accept="image/*" required>

        <button type="submit">Add Product</button>
    </form>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
