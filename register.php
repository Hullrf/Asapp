<?php
include 'conexion.php';

// Capturar datos del formulario
$nombre = $_POST['nombre']; 
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$rol = $_POST['rol'];

// Si es admin, capturar datos del negocio
if ($rol === 'admin') {
    $nombre_negocio = $_POST['nombre_negocio'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email_negocio = $_POST['email_negocio'];

    // Insertar en negocios
    $sqlNegocio = "INSERT INTO negocios (nombre, direccion, telefono, email, fecha_registro) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sqlNegocio);
    $stmt->bind_param("ssss", $nombre_negocio, $direccion, $telefono, $email_negocio);
    $stmt->execute();

    $id_negocio = $stmt->insert_id;
    $stmt->close();
} else {
    $id_negocio = NULL; // cliente no tiene negocio
}

// Insertar en usuarios
$sqlUser = "INSERT INTO usuarios (nombre, email, password, rol, id_negocio) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sqlUser);
$stmt->bind_param("ssssi", $nombre, $email, $password, $rol, $id_negocio);
$stmt->execute();

$stmt->close();
$conn->close();

// Redirigir al login
header("Location: login.html");
exit();

include "register.html"
?>
