<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login_view.html");
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
    $sql = "DELETE FROM productos WHERE id_producto=? AND id_negocio=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_producto, $id_negocio);
    $stmt->execute();
    header("Location: panel_control.php");
    exit;
}

// ====================
// LISTAR PRODUCTOS
// ====================
$sql = "SELECT * FROM productos WHERE id_negocio=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_negocio);
$stmt->execute();
$resProductos = $stmt->get_result();

// Renderizar vista
include 'panel_control_view.html';
$conn->close();
?>
