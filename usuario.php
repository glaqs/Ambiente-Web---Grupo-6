<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) die("No autorizado");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    if ($password) {
        $sql = "UPDATE usuarios SET nombre=?, email=?, password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $email, $password, $_SESSION['user_id']);
    } else {
        $sql = "UPDATE usuarios SET nombre=?, email=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $nombre, $email, $_SESSION['user_id']);
    }
    $stmt->execute();
    $_SESSION['nombre'] = $nombre;
    header("Location: index.php");
}
