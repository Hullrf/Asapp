<?php
// Database connection settings (use your actual host, user and password)
$server = "localhost";
$username = "root";
$password = "";
$dbname = "asapp_negocios";
$port = 3306;

// Enable mysqli exceptions for easier error handling
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Verificar conexión
try {
    $conn = new mysqli($server, $username, $password, $dbname, $port);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    echo "Error de conexión a la base de datos: " . htmlspecialchars($e->getMessage(), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    exit;
}
?>
