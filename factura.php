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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Factura Pedido #<?php echo htmlspecialchars($pedido['id_pedido']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }

        .factura {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 1000px;
            margin: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 12px;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }

        .btn-crear {
            background: #007bff;
            color: #fff;
        }

        .btn-editar {
            background: #ffc107;
            color: #000;
        }

        .btn-eliminar {
            background: #dc3545;
            color: #fff;
        }

        .btn-pagar {
            background: #28a745;
            color: #fff;
            padding: 10px 16px;
            margin-left: 8px;
            border-radius: 6px;
        }

        .alert {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 12px;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .small-input {
            width: 70px;
        }

        .actions-forms {
            display: flex;
            gap: 6px;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="factura">
        <h2><?php echo htmlspecialchars($pedido['negocio']); ?></h2>
        <!-- INFORMACIÓN DEL NEGOCIO -->
        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($pedido['direccion']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($pedido['telefono']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($pedido['email']); ?></p>
        <hr>
        <p><strong>Pedido #:</strong> <?php echo htmlspecialchars($pedido['id_pedido']); ?></p>
        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($pedido['fecha']); ?></p>
        <p><strong>Código QR:</strong> <?php echo htmlspecialchars($pedido['codigo_qr']); ?></p>
        <p><strong>Estado:</strong> <?php echo htmlspecialchars($pedido['estado']); ?></p>


        <?php if ($pedido_pagado): ?>
            <div class="alert success">✅ Este pedido ya está pagado en su totalidad.</div>
        <?php endif; ?>

        <!-- Botón de pago (JS crea el formulario que envía a pasarela.php) -->
        <div style="text-align:right;">
            <span class="total">Total seleccionado: $<span id="total">0.00</span></span>
            <?php if (!$pedido_pagado): ?>
                <button id="btnPagar" class="btn btn-pagar" type="button">Pagar seleccionados</button>
            <?php endif; ?>
        </div>

        <!-- Tabla de items  -->
        <table>
            <thead>
                <tr>
                    <th>Seleccionar</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($items_array) === 0): ?>
                    <tr>
                        <td colspan="7">No hay ítems registrados en este pedido.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($items_array as $row): ?>
                        <tr>
                            <td>
                                <?php if ($row['estado'] === 'Pendiente'): ?>
                                    <input type="checkbox" class="pay-checkbox" value="<?php echo $row['id_item']; ?>" data-precio="<?php echo $row['subtotal']; ?>">
                                <?php elseif ($row['estado'] === 'pagado'): ?>
                                    <input type="checkbox" checked disabled>
                                <?php else: ?>
                                    <input type="checkbox" disabled>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                            <td>$<?php echo number_format($row['precio_unitario'], 2); ?></td>
                            <td>$<?php echo number_format($row['subtotal'], 2); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($row['estado'])); ?></td>
                            <td>
                                <div class="actions-forms">
                                    <!-- FORM editar (POST a esta misma página) -->
                                    <form method="POST" style="display:inline-block;">
                                        <input type="hidden" name="id_item" value="<?php echo $row['id_item']; ?>">
                                        <input class="small-input" type="number" name="nueva_cantidad" value="<?php echo $row['cantidad']; ?>" min="1" required>
                                        <button type="submit" name="editar_item" class="btn btn-editar">Editar</button>
                                    </form>

                                    <!-- FORM eliminar (POST a esta misma página) -->
                                    <form method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este ítem?');">
                                        <input type="hidden" name="id_item" value="<?php echo $row['id_item']; ?>">
                                        <button type="submit" name="eliminar_item" class="btn btn-eliminar">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- formulario crear nuevo item -->
        <h3>Agregar nuevo producto</h3>
        <form method="POST">
            <select name="id_producto" required>
                <option value="">-- Selecciona producto --</option>
                <?php
                $stmtProd = $conn->prepare("SELECT id_producto, nombre FROM productos WHERE id_negocio = (SELECT id_negocio FROM pedidos WHERE id_pedido = ?)");
                $stmtProd->bind_param("i", $id_pedido);
                $stmtProd->execute();
                $resProd = $stmtProd->get_result();
                while ($prod = $resProd->fetch_assoc()) {
                    echo "<option value=\"" . intval($prod['id_producto']) . "\">" . htmlspecialchars($prod['nombre']) . "</option>";
                }
                $stmtProd->close();
                ?>
            </select>
            <input type="number" name="cantidad" placeholder="Cantidad" min="1" required>
            <button type="submit" name="crear_item" class="btn btn-crear">Agregar</button>
        </form>
    </div>

    <script>
        // Calcular total dinámico y habilitar / deshabilitar botón
        function calcularTotalYEstadoBoton() {
            const checkboxes = Array.from(document.querySelectorAll('.pay-checkbox'));
            const totalSpan = document.getElementById('total');
            const btnPagar = document.getElementById('btnPagar');
            let total = 0;
            let anyChecked = false;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseFloat(cb.dataset.precio || 0);
                    anyChecked = true;
                }
            });
            totalSpan.textContent = total.toFixed(2);
            if (btnPagar) btnPagar.disabled = !anyChecked;
        }

        // Evento para los checkboxes
        document.addEventListener('DOMContentLoaded', () => {
            const checkboxes = Array.from(document.querySelectorAll('.pay-checkbox'));
            checkboxes.forEach(cb => cb.addEventListener('change', calcularTotalYEstadoBoton));
            calcularTotalYEstadoBoton(); // inicializar

            // Enviar seleccionados a pasarela.php creando un form dinámico
            const btnPagar = document.getElementById('btnPagar');
            if (btnPagar) {
                btnPagar.addEventListener('click', () => {
                    const selected = Array.from(document.querySelectorAll('.pay-checkbox:checked')).map(cb => cb.value);
                    if (selected.length === 0) {
                        alert('Selecciona al menos un ítem para pagar.');
                        return;
                    }

                    // Crear form dinámico
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'pasarela.php';

                    // id_pedido
                    const inputPedido = document.createElement('input');
                    inputPedido.type = 'hidden';
                    inputPedido.name = 'id_pedido';
                    inputPedido.value = '<?php echo $id_pedido; ?>';
                    form.appendChild(inputPedido);

                    // items[] (nombre igual a lo que espera pasarela.php)
                    selected.forEach(id_item => {
                        const inp = document.createElement('input');
                        inp.type = 'hidden';
                        inp.name = 'items[]'; 
                        inp.value = id_item;
                        form.appendChild(inp);
                    });

                    document.body.appendChild(form);
                    form.submit();
                });
            }
        });
    </script>
</body>

</html>
<?php $conn->close(); ?>