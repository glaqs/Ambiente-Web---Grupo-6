<?php
session_start();
include "config.php"; // Conexión a la base de datos

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$nombre   = $_POST['nombre'] ?? '';
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$telefono = $_POST['telefono'] ?? '';

// Validación básica
if (empty($nombre) || empty($email) || empty($telefono)) {
    echo "<script>alert('Por favor complete todos los campos.'); window.history.back();</script>";
    exit();
}

// Actualizar contraseña solo si se ingresó
if (!empty($password)) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET nombre=?, email=?, password=?, telefono=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nombre, $email, $password_hash, $telefono, $user_id);
} else {
    $sql = "UPDATE usuarios SET nombre=?, email=?, telefono=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $email, $telefono, $user_id);
}

// Ejecutar actualización
if ($stmt->execute()) {
    // Actualizar sesión 
    $_SESSION['nombre']   = $nombre;
    $_SESSION['email']    = $email;
    $_SESSION['telefono'] = $telefono;

    echo "<script>alert('Datos actualizados correctamente'); window.location.href='index.php';</script>";
} else {
    echo "<script>alert('Error al actualizar los datos.'); window.history.back();</script>";
}
