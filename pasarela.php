<?php
include 'conexion.php';

// Capturar datos enviados desde factura.php
$id_pedido = isset($_POST['id_pedido']) ? intval($_POST['id_pedido']) : 0;
$items = isset($_POST['items']) ? $_POST['items'] : [];

if ($id_pedido <= 0) {
    die("⚠️ Pedido inválido.");
}

// Si confirma el pago
if (isset($_POST['confirmar_pago']) && !empty($_POST['items_confirmados'])) {
    $items_confirmados = $_POST['items_confirmados'];

    // Actualizar estado de los ítems
    $sqlUpdate = "UPDATE items_pedido SET estado = 'pagado' WHERE id_item = ?";
    $stmt = $conn->prepare($sqlUpdate);
    foreach ($items_confirmados as $id_item) {
        $stmt->bind_param('i', $id_item);
        $stmt->execute();
    }
    $stmt->close();

    // Revisar si todos los ítems quedaron pagados
    $sqlCheck = "SELECT COUNT(*) as pendientes FROM items_pedido WHERE id_pedido = ? AND estado = 'pendiente'";
    $stmt2 = $conn->prepare($sqlCheck);
    $stmt2->bind_param('i', $id_pedido);
    $stmt2->execute();
    $res = $stmt2->get_result();
    $row = $res->fetch_assoc();
    if ($row['pendientes'] == 0) {
        $conn->query("UPDATE pedidos SET estado = 'pagado' WHERE id_pedido = $id_pedido");
    }
    $stmt2->close();

    header("Location: factura.php?id_pedido=$id_pedido");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pasarela de Pago</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; text-align: center; padding: 50px; }
        .pasarela { background: #fff; padding: 40px; border-radius: 10px; width: 500px; margin: auto;
                    box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-bottom: 20px; }
        .fake-card { width: 100%; height: 180px; background: #ececec; border-radius: 10px; display: flex;
                     align-items: center; justify-content: center; font-size: 20px; color: #666; margin-bottom: 30px; }
        .btn-pago { display: inline-block; background: #28a745; color: white; padding: 12px 20px; border-radius: 5px;
                    text-decoration: none; font-weight: bold; border: none; cursor: pointer; }
        .btn-pago:hover { background: #218838; }
    </style>
</head>
<body>
<div class="pasarela">
    <h2>Simulación de Pasarela de Pago</h2>
    <div class="fake-card">💳 Aquí iría el formulario de tarjeta (simulado)</div>

    <form method="post">
        <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($id_pedido); ?>">
        <?php foreach ($items as $item): ?>
            <input type="hidden" name="items_confirmados[]" value="<?php echo htmlspecialchars($item); ?>">
        <?php endforeach; ?>
        <button type="submit" name="confirmar_pago" class="btn-pago">Confirmar Pago</button>
    </form>
</div>
</body>
</html>
<?php $conn->close(); ?>
