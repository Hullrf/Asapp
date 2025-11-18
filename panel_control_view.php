<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <title>Panel de Control</title>
  <link rel="stylesheet" href="css/styles_factura.css" />
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
  <h2>Panel de Control - Gestión de Productos</h2>

  <!-- Formulario Crear Producto -->
  <form action="panel_control.php" method="POST">
    <input type="hidden" name="crear" value="1" />
    <input type="text" name="nombre" placeholder="Nombre" required />
    <input
      type="text"
      name="descripcion"
      placeholder="Descripción"
      required />
    <input
      type="number"
      name="precio"
      placeholder="Precio"
      step="0.01"
      required />
    <label> <input type="checkbox" name="disponible" /> Disponible </label>
    <button type="submit">Agregar Producto</button>
  </form>

  <!-- Tabla Productos -->
  <table>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Descripción</th>
      <th>Precio</th>
      <th>Disponible</th>
      <th>Acciones</th>
    </tr>
    <?php while ($row = $resProductos->fetch_assoc()) { ?>
      <tr>
        <td><?= $row['id_producto'] ?></td>
        <td><?= htmlspecialchars($row['nombre']) ?></td>
        <td><?= htmlspecialchars($row['descripcion']) ?></td>
        <td>$<?= number_format($row['precio'], 2) ?></td>
        <td><?= $row['disponible'] ? 'Sí' : 'No' ?></td>
        <td>
          <!-- Botón Editar -->
          <form
            action="panel_control.php"
            method="POST"
            style="display: inline">
            <input type="hidden" name="editar" value="1" />
            <input
              type="hidden"
              name="id_producto"
              value="<?= $row['id_producto'] ?>" />
            <input
              type="text"
              name="nombre"
              value="<?= htmlspecialchars($row['nombre']) ?>"
              required />
            <input
              type="text"
              name="descripcion"
              value="<?= htmlspecialchars($row['descripcion']) ?>"
              required />
            <input
              type="number"
              name="precio"
              value="<?= $row['precio'] ?>"
              step="0.01"
              required />
            <label>
              <input type="checkbox" name="disponible"
                <?= $row['disponible'] ? 'checked' : '' ?>> Disponible
            </label>
            <button type="submit">Guardar</button>
          </form>

          <!-- Botón Eliminar -->
          <a
            href="panel_control.php?delete=<?= $row['id_producto'] ?>"
            onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
        </td>
      </tr>
    <?php } ?>
  </table>
  <hr />
  <h2>Crear Pedido</h2>
  <form action="panel_control.php" method="POST">
    <input type="hidden" name="crear_pedido" value="1" />

    <table>
      <tr>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
      </tr>
      <?php
      $resProductosPedido = $conn->query("SELECT * FROM productos WHERE
        id_negocio = {$_SESSION['id_negocio']}");
      while ($p =
        $resProductosPedido->fetch_assoc()
      ) { ?>
        <tr>
          <td>
            <label>
              <input
                type="checkbox"
                name="productos[]"
                value="<?= $p['id_producto'] ?>" />
              <?= htmlspecialchars($p['nombre']) ?>
            </label>
          </td>
          <td>$<?= number_format($p['precio'], 2) ?></td>
          <td>
            <input
              type="number"
              name="cantidades[<?= $p['id_producto'] ?>]"
              value="1"
              min="1" />
          </td>
        </tr>
      <?php } ?>
    </table>
    <button type="submit">Crear Pedido</button>
  </form>
</body>

</html>