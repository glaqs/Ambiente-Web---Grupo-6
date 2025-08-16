<?php
session_start();
include "config.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM finanzas WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
}

header("Location: index.php"); // Volvemos al index después de limpiar
exit;
