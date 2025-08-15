<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) die("No autorizado");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo']; // ingreso o gasto
    $monto = $_POST['monto'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];

    // Insertar en finanzas automáticamente
    $sql = "INSERT INTO finanzas (user_id,tipo,monto,descripcion,fecha) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiss", $_SESSION['user_id'], $tipo, $monto, $descripcion, $fecha);
    $stmt->execute();

    header("Location: index.php");
}
