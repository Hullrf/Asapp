<?php
include 'conexion.php';

// Capturar id_pedido (POST preferente, fallback GET)
$id_pedido = isset($_POST['id_pedido']) ? intval($_POST['id_pedido']) : (isset($_GET['id_pedido']) ? intval($_GET['id_pedido']) : 0);

// Capturar items enviados (POST preferente, fallback GET)
$items = [];
if (isset($_POST['items']) && is_array($_POST['items'])) {
    $items = array_map('intval', $_POST['items']);
} elseif (isset($_GET['items']) && is_array($_GET['items'])) {
    $items = array_map('intval', $_GET['items']);
}

if ($id_pedido <= 0) {
    die("⚠️ Pedido inválido. No se recibió id_pedido.");
}

// Si el usuario confirmó el pago (botón en la pasarela)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_pago'])) {
    $items_confirmados = isset($_POST['items_confirmados']) ? array_map('intval', (array)$_POST['items_confirmados']) : [];

    // Actualizar solo ítems válidos (que pertenezcan al pedido)
    $stmtCheck = $conn->prepare("SELECT id_pedido FROM items_pedido WHERE id_item = ? LIMIT 1");
    $stmtUpdate = $conn->prepare("UPDATE items_pedido SET estado = 'pagado' WHERE id_item = ?");
    foreach ($items_confirmados as $id_item) {
        // validar pertenencia
        $stmtCheck->bind_param('i', $id_item);
        $stmtCheck->execute();
        $res = $stmtCheck->get_result();
        $row = $res->fetch_assoc();
        if (!$row) continue;
        if (intval($row['id_pedido']) !== $id_pedido) continue; // no pertenece → ignorar

        // actualizar
        $stmtUpdate->bind_param('i', $id_item);
        $stmtUpdate->execute();
    }
    $stmtCheck->close();
    $stmtUpdate->close();

    // Si ya no hay pendientes, actualizar pedidos
    $stmtPend = $conn->prepare("SELECT COUNT(*) AS pendientes FROM items_pedido WHERE id_pedido = ? AND estado = 'pendiente'");
    $stmtPend->bind_param('i', $id_pedido);
    $stmtPend->execute();
    $resPend = $stmtPend->get_result()->fetch_assoc();
    $stmtPend->close();

    if (intval($resPend['pendientes']) === 0) {
        $stmtUpdPedido = $conn->prepare("UPDATE pedidos SET estado = 'pagado' WHERE id_pedido = ?");
        $stmtUpdPedido->bind_param('i', $id_pedido);
        $stmtUpdPedido->execute();
        $stmtUpdPedido->close();
    }

    header("Location: factura.php?id_pedido=" . $id_pedido);
    exit;
}

// Mostrar la pasarela (vista) — usa $items (los enviados) para mostrar resumen
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pasarela de Pago</title>
  <link rel="stylesheet" href="css/styles_pasarela.css">
</head>

<body>
<div class="pasarela">
    <h2>Simulación de Pasarela</h2>

    <?php if (empty($items)): ?>
        <p>No se recibieron ítems para pagar. <a href="factura.php?id_pedido=<?php echo $id_pedido; ?>">Volver a factura</a></p>
        <?php exit; ?>
    <?php endif; ?>

    <div>
        <p>Pedido #: <?php echo htmlspecialchars($id_pedido); ?></p>
        <ul>
            <?php
            // mostrar detalles básicos (nombre & subtotal) consultando la BD
            $stmtIt = $conn->prepare("SELECT id_item, i.id_producto, pr.nombre, i.subtotal FROM items_pedido i JOIN productos pr ON i.id_producto = pr.id_producto WHERE id_item = ?");
            foreach ($items as $id_item) {
                $stmtIt->bind_param('i', $id_item);
                $stmtIt->execute();
                $resIt = $stmtIt->get_result();
                if ($rowIt = $resIt->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($rowIt['nombre']) . " — $" . number_format($rowIt['subtotal'], 2) . "</li>";
                }
            }
            $stmtIt->close();
            ?>
        </ul>
    </div>

    <form method="post">
        <!-- reenviamos id_pedido y los items_confirmados[] para que confirmar_pago procese -->
        <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($id_pedido); ?>">
        <?php foreach ($items as $it): ?>
            <input type="hidden" name="items_confirmados[]" value="<?php echo intval($it); ?>">
        <?php endforeach; ?>

        <button type="submit" name="confirmar_pago">Confirmar Pago</button>
    </form>

    <p><a href="factura.php?id_pedido=<?php echo $id_pedido; ?>">Cancelar y volver</a></p>
</div>
</body>
</html>
<?php $conn->close(); ?>
