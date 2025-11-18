<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $id_negocio = isset($_POST['id_negocio']) ? intval($_POST['id_negocio']) : null;

    // Buscar usuario
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si existe el usuario
    if ($result->num_rows === 0) {
        header("Location: login_view.php?error=user");
        exit();
    }

    $user = $result->fetch_assoc();

    // Verificar contraseña
    if (!password_verify($password, $user['password'])) {
        header("Location: login_view.php?error=pass");
        exit();
    }

    // Si pasa las validaciones, guardar datos de sesión
    $_SESSION['id_usuario'] = $user['id_usuario'];
    $_SESSION['rol'] = $user['rol'];
    $_SESSION['nombre'] = $user['nombre'];

    // Caso 1: Administrador
    if ($user['rol'] === 'admin') {
        $_SESSION['id_negocio'] = $user['id_negocio'];
        header("Location: Panel_Control.php");
        exit();
    }

    // Caso 2: Cliente
if ($user['rol'] === 'cliente') {
    // Si no selecciona negocio
    if (!$id_negocio) {
        header("Location: login_view.php?error=negocio");
        exit();
    }

    $_SESSION['id_negocio'] = $id_negocio;

    // Verificar si ya existe un pedido pendiente
    $sqlPedido = "SELECT id_pedido FROM pedidos WHERE id_negocio = ? AND (estado = 'Pendiente' OR estado = 'pendiente') LIMIT 1";
    $stmtP = $conn->prepare($sqlPedido);
    $stmtP->bind_param("i", $id_negocio);
    $stmtP->execute();
    $resP = $stmtP->get_result();

    if ($resP->num_rows > 0) {
        // Ya existe un pedido pendiente
        $pedido = $resP->fetch_assoc();
        $_SESSION['id_pedido'] = $pedido['id_pedido'];
    } else {
        // Crear nuevo pedido
        $codigo_qr = 'QR' . strtoupper(substr(md5(uniqid()), 0, 6));
        $estado = 'Pendiente';
        $stmtN = $conn->prepare("INSERT INTO pedidos (id_negocio, codigo_qr, estado) VALUES (?, ?, ?)");
        $stmtN->bind_param("iss", $id_negocio, $codigo_qr, $estado);
        if ($stmtN->execute()) {
            $_SESSION['id_pedido'] = $stmtN->insert_id;
        } else {
            header("Location: login_view.php?error=pedido");
            exit();
        }
    }

    // Verificación final antes de redirigir
    if (!isset($_SESSION['id_pedido'])) {
        header("Location: login_view.php?error=pedido");
        exit();
    }

    // Redirigir a factura
    header("Location: factura.php?id_pedido=" . $_SESSION['id_pedido']);

    exit();
}
}
?>
