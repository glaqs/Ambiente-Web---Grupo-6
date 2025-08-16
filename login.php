<?php
session_start();
include "config.php";

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

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['telefono'] = $row['telefono'];

            header("Location: index.php?seccion=dashboard");
            exit;
        }
    }

    header("Location: index.php?error=1");
    exit;
}
?>
