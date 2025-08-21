<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];
    $telefono = trim($_POST['telefono']);

    // Validar que las contraseñas coincidan
    if ($password !== $confirmar_password) {
        die("Las contraseñas no coinciden.");
    }

    // Hashear la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta
    $sql = "INSERT INTO usuarios (nombre, email, password, telefono) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación: " . $conn->error);
    }
    $stmt->bind_param("ssss", $nombre, $email, $password_hash, $telefono);

    // Ejecutar y redirigir si es exitoso

    if ($stmt->execute()) {
        header("Location: index.php?registro=ok");
        exit;
    } else {
        echo "Error al registrar usuario: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
