<?php
session_start();
include 'conexion.php';

// Verificamos que el usuario esté logueado
if (!isset($_SESSION['id_negocio'])) {
    die("No autorizado");
}

$id_negocio = $_SESSION['id_negocio'];

// Datos enviados desde el formulario
$productos = $_POST['productos']; // array con id_producto
$cantidades = $_POST['cantidades']; // array con cantidad

// Generar un código QR único
$codigo_qr = 'QR' . strtoupper(substr(md5(uniqid()), 0, 6));

// Insertar el pedido principal
$sqlPedido = "INSERT INTO pedidos (id_negocio, codigo_qr, estado) VALUES (?, ?, 'Pendiente')";
$stmt = $conn->prepare($sqlPedido);
$stmt->bind_param("is", $id_negocio, $codigo_qr);
$stmt->execute();
$id_pedido = $stmt->insert_id;

// Insertar los items
for ($i = 0; $i < count($productos); $i++) {
    $id_producto = $productos[$i];
    $cantidad = $cantidades[$i];

    // Obtener precio del producto
    $result = $conn->query("SELECT precio FROM productos WHERE id_producto = $id_producto");
    $row = $result->fetch_assoc();
    $precio_unitario = $row['precio'];
    $subtotal = $precio_unitario * $cantidad;

    // Insertar item
    $sqlItem = "INSERT INTO items_pedido (id_pedido, id_producto, cantidad, precio_unitario, subtotal, estado)
                VALUES (?, ?, ?, ?, ?, 'Pendiente')";
    $stmtItem = $conn->prepare($sqlItem);
    $stmtItem->bind_param("iiidd", $id_pedido, $id_producto, $cantidad, $precio_unitario, $subtotal);
    $stmtItem->execute();
}

echo "✅ Pedido creado correctamente con código QR: " . $codigo_qr;
?>
