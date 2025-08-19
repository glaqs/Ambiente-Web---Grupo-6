<?php
session_start();
include "config.php"; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, nombre, password, telefono FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verificar contraseña
        if (password_verify($password, $row['password'])) {
            // Guardar datos en sesión
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['telefono'] = $row['telefono'];
            $_SESSION['email'] = $email; // ← Guardamos el email 

            // Redirigir al dashboard
            header("Location: index.php?seccion=dashboard");
            exit;
        }
    }

    // Si falla el login
    header("Location: index.php?error=1");
    exit;
}
