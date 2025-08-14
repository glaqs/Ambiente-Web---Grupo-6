<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: panel.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FINGO® - Gestión Financiera</title>
    <link rel="stylesheet" href="estilos.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <header>
        <img src="imagenes/fingo mejorado.png" alt="Logo FINGO">
        <h1>FINGO®</h1>
    </header>

    <nav>
        <a href="#" id="navLogin" onclick="mostrarSeccion('login'); return false;">Inicio/Login</a>
        <a href="#" id="navRegistro" onclick="mostrarSeccion('registro'); return false;">Registro</a>

        <!-- Menú solo visible si está logueado -->
        <a href="#" class="nav-logged hidden" onclick="mostrarSeccion('dashboard'); return false;">Dashboard</a>
        <a href="#" class="nav-logged hidden" onclick="mostrarSeccion('finanzas'); return false;">Finanzas</a>
        <a href="#" class="nav-logged hidden" onclick="mostrarSeccion('reportes'); return false;">Reportes</a>
        <a href="#" class="nav-logged hidden" onclick="mostrarSeccion('usuario'); return false;">Usuario</a>
        <a href="#" class="nav-logged hidden" onclick="mostrarSeccion('notificaciones'); return false;">Notificaciones</a>
        <a href="#" class="nav-logged hidden" onclick="mostrarSeccion('config'); return false;">Configuración</a>
        <a href="#" id="logoutBtn" class="nav-logged hidden" onclick="logout(); return false;">Cerrar sesión</a>
    </nav>

    <main>
        <div id="login">
            <h2>Iniciar Sesión</h2>
            <form id="formLogin" method="POST">
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Entrar</button>
            </form>
        </div>

        <div id="registro" class="hidden">
            <h2>Registro de Usuario</h2>
            <form id="formRegistro" method="POST">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="password" name="password_confirm" placeholder="Confirmar contraseña" required>
                <button type="submit">Crear cuenta</button>
            </form>
        </div>

        <div id="dashboard" class="hidden">
            <h2>Panel de Usuario</h2>
            <p>Bienvenido/a a tu panel. Desde aquí puedes acceder a todas las funciones de FINGO®.</p>
        </div>
        <div id="finanzas" class="hidden"></div>
        <div id="reportes" class="hidden"></div>
        <div id="usuario" class="hidden"></div>
        <div id="notificaciones" class="hidden"></div>
        <div id="config" class="hidden"></div>
    </main>

    <footer>GRUPO 6 &reg; DERECHOS RESERVADOS 2025</footer>

   <script src="script.js"></script>
</body>

</html>