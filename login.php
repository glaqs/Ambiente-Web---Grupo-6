<?php
session_start();
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['email'] = $row['email'];

            // Establecer mensaje de bienvenida temporal
            $_SESSION['mensaje'] = "Bienvenido/a, " . $row['nombre'] . "!";

            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = "Usuario o contraseña incorrectos";
            header("Location: index.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Usuario no existe";
        header("Location: index.php");
        exit;
    }
}
