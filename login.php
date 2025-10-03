<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['id_negocio'] = $user['id_negocio'];

            if ($user['rol'] == "cliente") {
                header("Location: factura.php?id_pedido=1");
            } elseif ($user['rol'] == "admin") {
                header("Location: Panel_Control.php");
            }
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta');window.location='login_view.html';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado');window.location='login_view.html';</script>";
    }
}
include "login.html";
