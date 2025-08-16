<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $telefono = $_POST['telefono'];

    $sql = "INSERT INTO usuarios (nombre, email, password, telefono) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $password, $telefono);

    if ($stmt->execute()) {
        header("Location: index.php?registro=ok");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h2>Registrar Usuario</h2>
    <form action="registro.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre completo" required><br>
        <input type="email" name="email" placeholder="Correo electrónico" required><br>
        <input type="password" name="password" placeholder="Contraseña" required><br>
        <input type="text" name="telefono" placeholder="Número de teléfono (con código país, ej. +506...)" required><br>
        <button type="submit">Registrarse</button>
    </form>
    <a href="index.php">Volver</a>
</body>
</html>
