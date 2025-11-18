<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Factura Pedido #<?php echo htmlspecialchars($pedido['id_pedido']); ?></title>
    <link rel="stylesheet" href="css/styles_factura.css">
</head>



<body>
    <div style="text-align:right;">
    <a href="logout.php" class="btn-logout" style="
        color: #fff;
        background-color: #d9534f;
        padding: 8px 12px;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
    ">Cerrar sesión</a>
    </div>

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
                                    <input type="checkbox" class="pay-checkbox" name="items[]" value="<?php echo $row['id_item']; ?>" data-precio="<?php echo $row['subtotal']; ?>">
                                <?php elseif ($row['estado'] === 'Pagado'): ?>
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
            // INYECTAR id_pedido al JS (esto lo procesa PHP cuando incluye la vista)
            window.ASAPP = window.ASAPP || {};
            window.ASAPP.id_pedido = <?php echo json_encode($id_pedido, JSON_NUMERIC_CHECK); ?>;
        </script>
    <script src="js/factura.js"></script>
</body>

</html>