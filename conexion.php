<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "asapp_negocios";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset('utf8mb4');
} catch (Exception $e) {
    echo "Error de conexión a la base de datos: " . htmlspecialchars($e->getMessage());
    exit;
}
?>
