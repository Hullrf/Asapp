<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rol = $_POST['rol'];
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $nombre_negocio = trim($_POST['nombre_negocio'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email_negocio = trim($_POST['email_negocio'] ?? '');

    // Validaciones básicas
    if (empty($nombre)) {
        header("Location: register.html?error=nombre");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: register.html?error=email");
        exit();
    }

    if (strlen($password) < 6) {
        header("Location: register.html?error=password");
        exit();
    }

    // Validaciones de negocio para admin
    if ($rol === 'admin' && (empty($nombre_negocio) || empty($direccion) || empty($telefono))) {
        header("Location: register.html?error=negocio");
        exit();
    }

    // Verificar correo existente
    $check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        header("Location: register.html?error=email");
        exit();
    }

    // Crear registros
    $hash = password_hash($password, PASSWORD_DEFAULT);

    if ($rol === 'admin') {
        $stmtNeg = $conn->prepare("INSERT INTO negocios (nombre, direccion, telefono, email) VALUES (?, ?, ?, ?)");
        $stmtNeg->bind_param("ssss", $nombre_negocio, $direccion, $telefono, $email_negocio);
        $stmtNeg->execute();
        $id_negocio = $stmtNeg->insert_id;

        $stmtUser = $conn->prepare("INSERT INTO usuarios (rol, nombre, email, password, id_negocio) VALUES (?, ?, ?, ?, ?)");
        $stmtUser->bind_param("ssssi", $rol, $nombre, $email, $hash, $id_negocio);
        $stmtUser->execute();
    } else {
        $stmtUser = $conn->prepare("INSERT INTO usuarios (rol, nombre, email, password) VALUES (?, ?, ?, ?)");
        $stmtUser->bind_param("ssss", $rol, $nombre, $email, $hash);
        $stmtUser->execute();
    }

    header("Location: register.html?success=1");
    exit();
}
include "register.html";
?>
