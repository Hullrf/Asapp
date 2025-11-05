<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <title>Registro - ASAPP</title>
    <link rel="stylesheet" href="css/styles_register.css" />

    <script>
      function toggleNegocio() {
        const rol = document.getElementById("rol").value;
        const fields = document.getElementById("negocioFields");
        const inputs = fields.querySelectorAll("input");
        if (rol === "admin") {
          fields.style.display = "block";
          inputs.forEach((input) => input.setAttribute("required", true));
        } else {
          fields.style.display = "none";
          inputs.forEach((input) => input.removeAttribute("required"));
        }
      }

      // Mostrar mensajes de error dinámicamente
      window.onload = function () {
        const params = new URLSearchParams(window.location.search);
        const error = params.get("error");
        const success = params.get("success");

        if (error) {
          const field = document.getElementById("error-" + error);
          if (field) field.style.display = "block";
        }

        if (success) {
          document.getElementById("success-msg").style.display = "block";
        }
      };
    </script>
  </head>
  <body>
    <h2 style="text-align: center">Crear Cuenta</h2>

    <form action="register.php" method="POST">
      <div id="success-msg" class="success" style="display: none">
        ✅ Registro exitoso. Ahora puedes
        <a href="login_view.php">iniciar sesión</a>.z
      </div>

      <label for="rol">Registrarse como:</label>
      <select name="rol" id="rol" onchange="toggleNegocio()" required>
        <option value="cliente">Cliente</option>
        <option value="admin">Administrador de negocio</option></select
      ><br /><br />

      <label>Nombre de usuario:</label>
      <input type="text" name="nombre" required />
      <span id="error-nombre" class="error-text" style="display: none"
        >El nombre es obligatorio.</span
      >

      <label>Email:</label>
      <input type="email" name="email" required />
      <span id="error-email" class="error-text" style="display: none"
        >Correo no válido o ya registrado.</span
      >

      <label>Contraseña:</label>
      <input type="password" name="password" required />
      <span id="error-password" class="error-text" style="display: none"
        >Contraseña inválida o no coincide.</span
      >

      <div id="negocioFields" style="display: none">
        <h4>Datos del Negocio</h4>
        <label>Nombre del negocio:</label>
        <input type="text" name="nombre_negocio" />
        <label>Dirección:</label>
        <input type="text" name="direccion" />
        <label>Teléfono:</label>
        <input type="text" name="telefono" />
        <label>Email del negocio:</label>
        <input type="email" name="email_negocio" />
        <span id="error-negocio" class="error-text" style="display: none"
          >Completa los datos del negocio.</span
        >
      </div>

      <button type="submit">Registrar</button>
    </form>

    <p style="text-align: center">
      ¿Ya tienes cuenta? <a href="login_view.php">Inicia sesión</a>
    </p>
  </body>
</html>
