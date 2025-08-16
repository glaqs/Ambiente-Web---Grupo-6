<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Debes iniciar sesión'); window.location.href='index.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = trim($_POST['tipo']); // 'ingreso' o 'gasto'
    $descripcion = trim($_POST['descripcion']);
    $monto = trim($_POST['monto']);
    $fecha = trim($_POST['fecha']);
    $user_id = $_SESSION['user_id'];

    // Validar campos
    if (empty($tipo) || empty($descripcion) || empty($monto) || empty($fecha)) {
        echo "<script>alert('Por favor complete todos los campos'); window.history.back();</script>";
        exit;
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO finanzas (user_id, tipo, descripcion, monto, fecha) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conn->error);
    }
    $stmt->bind_param("issds", $user_id, $tipo, $descripcion, $monto, $fecha);

    if ($stmt->execute()) {
        // Mensaje y redirige a la sección de finanzas
        echo "<script>
                alert('Datos ingresados correctamente');
                window.location.href='index.php';
                window.onload = function() { 
                    if (window.location.hash !== '#finanzas') {
                        window.location.hash = '#finanzas';
                    }
                };
              </script>";
    } else {
        echo "<script>alert('Error al guardar los datos'); window.history.back();</script>";
    }
}
