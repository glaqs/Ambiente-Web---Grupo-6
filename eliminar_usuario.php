<?php
session_start();
include "config.php"; // Conexión a la base de datos

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Confirmar si se envió la acción de eliminar
if (isset($_POST['eliminar'])) {
    $sql = "DELETE FROM usuarios WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Cerrar sesión después de eliminar cuenta
        session_destroy();
        echo "<script>alert('Usuario eliminado correctamente.'); window.location.href='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error al eliminar el usuario.'); window.history.back();</script>";
        exit();
    }
}
