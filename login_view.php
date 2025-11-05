<?php
session_start();
$error_email = $error_password = $error_negocio = "";

if (isset($_GET['error'])) {
  switch ($_GET['error']) {
    case 'user':
      $error_email = "El usuario no existe.";
      break;
    case 'pass':
      $error_password = "La contraseña es incorrecta.";
      break;
    case 'negocio':
      $error_negocio = "Debes seleccionar un negocio.";
      break;
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Inicio de Sesión - ASAPP</title>
  <link rel="stylesheet" href="css/styles_register.css">


  <script>
    // Muestra/oculta el selector de negocio según el tipo de usuario
    async function verificarRol() {
      const email = document.getElementById("email").value.trim();
      const selectNegocio = document.getElementById("selectNegocio");
      const labelNegocio = document.getElementById("labelNegocio");

      if (email.length === 0) return;

      const formData = new FormData();
      formData.append("email", email);

      const res = await fetch("verificar_rol.php", {
        method: "POST",
        body: formData
      });
      const rol = await res.text();

      if (rol === "admin") {
        selectNegocio.style.display = "none";
        labelNegocio.style.display = "none";
        selectNegocio.removeAttribute("required");
      } else if (rol === "cliente") {
        selectNegocio.style.display = "block";
        labelNegocio.style.display = "block";
        selectNegocio.setAttribute("required", "true");
      } else {
        selectNegocio.style.display = "none";
        labelNegocio.style.display = "none";
      }
    }
  </script>
</head>

<body>
  <h2 style="text-align:center;">Iniciar Sesión</h2>
  <form action="login.php" method="POST">
    <label for="email">Correo electrónico:</label>
    <input type="email" id="email" name="email" placeholder="Ej: usuario@asapp.com" required onblur="verificarRol()">
    <?php if (!empty($error_email)) echo "<span class='error-text'>$error_email</span>"; ?><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" placeholder="********" required>
    <?php if (!empty($error_password)) echo "<span class='error-text'>$error_password</span>"; ?><br>

    <label id="labelNegocio">Selecciona el negocio:</label>
    <select id="selectNegocio" name="id_negocio" required>
      <option value="">-- Selecciona un negocio --</option>
      <?php
      include 'conexion.php';
      $resNegocios = $conn->query("SELECT id_negocio, nombre FROM negocios ORDER BY nombre ASC");
      while ($row = $resNegocios->fetch_assoc()) {
        echo "<option value='{$row['id_negocio']}'>{$row['nombre']}</option>";
      }
      ?>
    </select>
    <?php if (!empty($error_negocio)) echo "<span class='error-text'>$error_negocio</span>"; ?><br>

    <button type="submit">Ingresar</button>
  </form>

  <p style="text-align:center;">¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
</body>

</html>