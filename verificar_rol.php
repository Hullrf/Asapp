<?php
include 'conexion.php';

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    $sql = "SELECT rol FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo $user['rol']; // admin o cliente
    } else {
        echo 'none';
    }
}
?>
