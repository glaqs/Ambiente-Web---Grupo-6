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
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
        exit;
    }

    // Verificar si el email ya existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Este email ya está registrado.'); window.history.back();</script>";
        $check->close();
        exit;
    }
    $check->close();

    // Hashear la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar la consulta de inserción
    $sql = "INSERT INTO usuarios (nombre, email, password, telefono) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<script>alert('Error en la preparación de la consulta.'); window.history.back();</script>";
        exit;
    }
    $stmt->bind_param("ssss", $nombre, $email, $password_hash, $telefono);

    // Ejecutar y redirigir si es exitoso
    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso'); window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error al registrar usuario: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
