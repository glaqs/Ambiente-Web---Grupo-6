<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario - FINGO®</title>
</head>

<body>
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h1>
    <a href="#" onclick="logout(); return false;">Cerrar sesión</a>

    <script>
        function logout() {
            fetch('logout.php', {
                    method: 'POST'
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'index.html';
                    } else {
                        alert('Error al cerrar sesión');
                    }
                });
        }
    </script>
</body>
</html>