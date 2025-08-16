<?php
session_start();
include "config.php";

if (isset($_SESSION['user_id'])) {
    $sql = "DELETE FROM finanzas WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['user_id']);
    if ($stmt->execute()) {
        echo "<script>alert('Todos los registros fueron eliminados'); window.location.href='index.php#reportes';</script>";
    } else {
        echo "<script>alert('Error al eliminar los registros'); window.location.href='index.php#reportes';</script>";
    }
} else {
    header("Location: index.php");
}
