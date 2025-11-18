<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login_view.php");
    exit();
}

$id_negocio = $_SESSION['id_negocio'] ?? null;

if (!$id_negocio) {
    die("⚠️ No se encontró el negocio asociado a este usuario.");
}

// ====================
// OPERACIONES CRUD
// ====================

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    $sql = "INSERT INTO productos (id_negocio, nombre, descripcion, precio, disponible)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issdi", $id_negocio, $nombre, $descripcion, $precio, $disponible);
    $stmt->execute();
    header("Location: panel_control.php");
    exit;
}

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    $sql = "UPDATE productos 
            SET nombre=?, descripcion=?, precio=?, disponible=? 
            WHERE id_producto=? AND id_negocio=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdiii", $nombre, $descripcion, $precio, $disponible, $id_producto, $id_negocio);
    $stmt->execute();
    header("Location: panel_control.php");
    exit;
}



// DELETE
if (isset($_GET['delete'])) {
    $id_producto = intval($_GET['delete']);

    // Verificar si el producto está referenciado en items_pedido
    $checkStmt = $conn->prepare("SELECT COUNT(*) AS total FROM items_pedido WHERE id_producto = ?");
    $checkStmt->bind_param("i", $id_producto);
    $checkStmt->execute();
    $totalResult = $checkStmt->get_result()->fetch_assoc()['total'];

    if ($totalResult > 0) {
        echo "<script>
                alert('❌ No se puede eliminar este producto porque está incluido en una o más facturas.');
                window.location.href = 'panel_control.php';
              </script>";
        exit();
    }

    // Si no está referenciado, eliminar normalmente
    $stmt = $conn->prepare("DELETE FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();

    header("Location: panel_control.php");
    exit();
}
// ====================
// LISTAR PRODUCTOS
// ====================
$sql = "SELECT * FROM productos WHERE id_negocio=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_negocio);
$stmt->execute();
$resProductos = $stmt->get_result();



// Crear Pedido
if (isset($_POST['crear_pedido'])) {
    $id_negocio = $_SESSION['id_negocio'];
    $productos = $_POST['productos'] ?? [];
    $cantidades = $_POST['cantidades'] ?? [];

    if (empty($productos)) {
        echo "<p style='color:red;'>⚠️ No se seleccionó ningún producto.</p>";
    } else {
        // Generar código QR único
        $codigo_qr = 'QR' . strtoupper(substr(md5(uniqid()), 0, 6));

        // Crear el pedido principal
        $sqlPedido = "INSERT INTO pedidos (id_negocio, codigo_qr, estado) VALUES (?, ?, 'Pendiente')";
        $stmt = $conn->prepare($sqlPedido);
        $stmt->bind_param("is", $id_negocio, $codigo_qr);
        $stmt->execute();
        $id_pedido = $stmt->insert_id;

        // Insertar productos seleccionados
        foreach ($productos as $id_producto) {
            $cantidad = intval($cantidades[$id_producto]) ?: 1;

            $result = $conn->query("SELECT precio FROM productos WHERE id_producto = $id_producto");
            if ($row = $result->fetch_assoc()) {
                $precio_unitario = $row['precio'];
                $subtotal = $precio_unitario * $cantidad;

                $sqlItem = "INSERT INTO items_pedido (id_pedido, id_producto, cantidad, precio_unitario, subtotal, estado)
                            VALUES (?, ?, ?, ?, ?, 'Pendiente')";
                $stmtItem = $conn->prepare($sqlItem);
                $stmtItem->bind_param("iiidd", $id_pedido, $id_producto, $cantidad, $precio_unitario, $subtotal);
                $stmtItem->execute();
            }
        }

        echo "<p style='color:green;'>✅ Pedido creado correctamente con código QR: $codigo_qr</p>";
    }
}
// Renderizar vista
include 'panel_control_view.php';
$conn->close();
?>