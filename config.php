<?php
$servername = getenv('DB_SERVER');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = "sistema_vendas";

// Crie a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Verifique a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Azure Blob Storage configuration
$blobAccountName = "storagevendasfernando";
$blobContainerName = "blobvendas";
$blobSasToken = getenv('BLOB_TOKEN');

// Formar a string de conexão do blob
$blobConnectionString = "BlobEndpoint=https://$blobAccountName.blob.core.windows.net/;SharedAccessSignature=$blobSasToken";

// Azure Blob Storage client
require 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;

$blobClient = BlobRestProxy::createBlobService($blobConnectionString);
?>
