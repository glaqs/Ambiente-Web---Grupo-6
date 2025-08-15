<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirmar_password'];

    if ($password !== $confirm) {
        die("Las contraseñas no coinciden.");
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar en usuarios
    $sql = "INSERT INTO usuarios (nombre,email,password) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $hash);
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id; // obtener id del nuevo usuario

        // Crear configuración inicial automáticamente
        $sql_config = "INSERT INTO configuracion (user_id, notificaciones) VALUES (?, 'on')";
        $stmt_config = $conn->prepare($sql_config);
        $stmt_config->bind_param("i", $user_id);
        $stmt_config->execute();

        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
