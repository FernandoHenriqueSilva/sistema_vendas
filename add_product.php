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
                die("Error uploading file: " . $e->getMessage());
            }
        }
    }

    echo "Product and photos added successfully.";
}
?>

<?php include('templates/header.php'); ?>

<h2>Add New Product</h2>
<form method="post" enctype="multipart/form-data">
    <label for="title">Title:</label>
    <input type="text" id="title" name="title" required>

    <label for="price">Price:</label>
    <input type="text" id="price" name="price" required>

    <label for="payment_mode">Payment Mode:</label>
    <select id="payment_mode" name="payment_mode" required>
        <option value="cash">Cash</option>
        <option value="credit">Credit</option>
        <option value="debit">Debit</option>
    </select>

    <label for="contact">Contact:</label>
    <input type="text" id="contact" name="contact" required>

    <label for="photos">Photos:</label>
    <input type="file" id="photos" name="photos[]" multiple>

    <button type="submit">Add Product</button>
</form>

<?php include('templates/footer.php'); ?>

<?php
require 'config.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                    $message = "Error uploading file: " . $e->getMessage();
                }
            }
        }
        $message = "Product and photos added successfully.";
    } else {
        $message = "Failed

