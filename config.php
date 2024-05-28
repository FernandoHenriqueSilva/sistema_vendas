<?php
$servername = "azuredbvendasfernando.mysql.database.azure.com";
$username = "fernando";
$password = "Rasengan1*";
$dbname = "sistema_vendas";

// Crie a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname, 3306);

// Verifique a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Azure Blob Storage configuration
$blobAccountName = "storagevendasfernando";
$blobContainerName = "blobvendas"; // Adicione esta linha para definir a variável
$blobSasToken = "sp=racwdl&st=2024-05-28T01:29:17Z&se=2024-05-31T09:29:17Z&spr=https&sv=2022-11-02&sr=c&sig=qNyZbN1aebYr83Wpqbbwxuno1ViwJ0z14dRZvMRgHJk%3D";

// Formar a string de conexão do blob
$blobConnectionString = "BlobEndpoint=https://$blobAccountName.blob.core.windows.net/;SharedAccessSignature=$blobSasToken";

// Azure Blob Storage client
require 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;

$blobClient = BlobRestProxy::createBlobService($blobConnectionString);
?>
