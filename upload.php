<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $uploaded_files = $_FILES['photos'];
    $num_files = count($uploaded_files['name']);
    for ($i = 0; $i < $num_files; $i++) {
        if ($uploaded_files['error'][$i] == UPLOAD_ERR_OK) {
            $tmp_name = $uploaded_files['tmp_name'][$i];
            $name = basename($uploaded_files['name'][$i]);

            // Upload to Azure Blob Storage
            $content = fopen($tmp_name, "r");
            $options = new CreateBlockBlobOptions();
            $blob_name = $product_id . "_" . $name;
            $blobClient->createBlockBlob($blobContainerName, $blob_name, $content, $options);

            // Get the URL of the uploaded blob
            $blob_url = "
