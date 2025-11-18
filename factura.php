<?php
// Mostrar errores (solo en desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión
include 'conexion.php';

// Obtener id_pedido
$id_pedido = isset($_GET['id_pedido']) ? intval($_GET['id_pedido']) : 0;
if ($id_pedido <= 0) {
    die("⚠️ ID de pedido inválido. Usa ?id_pedido=1 en la URL.");
}

// Agregar item ===
if (isset($_POST['crear_item'])) {
    $id_producto = intval($_POST['id_producto']);
    $cantidad = intval($_POST['cantidad']);
    if ($cantidad > 0 && $id_producto > 0) {
        // obtener precio
        $stmt = $conn->prepare("SELECT precio FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows) {
            $prod = $res->fetch_assoc();
            $precio = floatval($prod['precio']);
            $subtotal = $precio * $cantidad;
            $estado = 'Pendiente';
            $stmtIns = $conn->prepare("INSERT INTO items_pedido (id_pedido, id_producto, cantidad, precio_unitario, subtotal, estado) VALUES (?, ?, ?, ?, ?, ?)");
            $stmtIns->bind_param("iiidds", $id_pedido, $id_producto, $cantidad, $precio, $subtotal, $estado);
            $stmtIns->execute();
            $stmtIns->close();
        }
        $stmt->close();
    }
    header("Location: factura.php?id_pedido=" . $id_pedido);
    exit;
}

// Editar cantidad del item
if (isset($_POST['editar_item'])) {
    $id_item = intval($_POST['id_item']);
    $nueva_cantidad = intval($_POST['nueva_cantidad']);
    if ($id_item > 0 && $nueva_cantidad > 0) {
        // obtener id_producto del item
        $stmt = $conn->prepare("SELECT id_producto FROM items_pedido WHERE id_item = ?");
        $stmt->bind_param("i", $id_item);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows) {
            $it = $res->fetch_assoc();
            $id_producto = intval($it['id_producto']);
            // obtener precio del producto
            $stmt2 = $conn->prepare("SELECT precio FROM productos WHERE id_producto = ?");
            $stmt2->bind_param("i", $id_producto);
            $stmt2->execute();
            $res2 = $stmt2->get_result();
            if ($res2 && $res2->num_rows) {
                $p = $res2->fetch_assoc();
                $precio = floatval($p['precio']);
                $subtotal = $precio * $nueva_cantidad;
                $stmtUpd = $conn->prepare("UPDATE items_pedido SET cantidad = ?, subtotal = ?, precio_unitario = ? WHERE id_item = ?");
                $stmtUpd->bind_param("iddi", $nueva_cantidad, $subtotal, $precio, $id_item);
                $stmtUpd->execute();
                $stmtUpd->close();
            }
            $stmt2->close();
        }
        $stmt->close();
    }
    header("Location: factura.php?id_pedido=" . $id_pedido);
    exit;
}

// Eliminar item
if (isset($_POST['eliminar_item'])) {
    $id_item = intval($_POST['id_item']);
    if ($id_item > 0) {
        $stmt = $conn->prepare("DELETE FROM items_pedido WHERE id_item = ?");
        $stmt->bind_param("i", $id_item);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: factura.php?id_pedido=" . $id_pedido);
    exit;
}

// Leer datos del pedido e items 
// datos del pedido + negocio
$stmt = $conn->prepare("SELECT p.id_pedido, p.fecha, p.codigo_qr, p.estado, 
                               n.nombre AS negocio, n.direccion, n.telefono, n.email
                        FROM pedidos p
                        INNER JOIN negocios n ON p.id_negocio = n.id_negocio
                        WHERE p.id_pedido = ?");
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$resPedido = $stmt->get_result();
if (!$resPedido || $resPedido->num_rows === 0) {
    die("⚠️ Pedido no encontrado.");
}
$pedido = $resPedido->fetch_assoc();
$stmt->close();

// items
$stmt = $conn->prepare("SELECT i.id_item, pr.nombre, i.cantidad, i.precio_unitario, i.subtotal, i.estado
                        FROM items_pedido i
                        INNER JOIN productos pr ON i.id_producto = pr.id_producto
                        WHERE i.id_pedido = ?");
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$resItems = $stmt->get_result();
$items_array = [];
while ($r = $resItems->fetch_assoc()) $items_array[] = $r;
$stmt->close();

// verificar si hay pendientes
$stmt = $conn->prepare("SELECT COUNT(*) as pendientes FROM items_pedido WHERE id_pedido = ? AND estado = 'Pendiente'");
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$pedido_pagado = ($row['pendientes'] == 0);
$stmt->close();

include 'factura_view.php';

?>

<?php $conn->close(); ?>