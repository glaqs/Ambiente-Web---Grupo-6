<?php
session_start();
include "config.php"; // Conexión DB
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>FINGO® - Gestión Financiera</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body <?php echo isset($_SESSION['user_id']) ? 'data-loggedin="true"' : ''; ?>>

    <header>
        <img src="fingo_mejorada.png" alt="Logo FINGO">
        <h1>FINGO®</h1>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="logout-btn">Cerrar sesión</a>
        <?php endif; ?>
    </header>

    <nav>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <button onclick="mostrarSeccion('login')">Inicio/Login</button>
            <button onclick="mostrarSeccion('registro')">Registro</button>
        <?php else: ?>
            <button onclick="mostrarSeccion('dashboard')">Dashboard</button>
            <button onclick="mostrarSeccion('finanzas')">Finanzas</button>
            <button onclick="mostrarSeccion('reportes')">Reportes</button>
            <button onclick="mostrarSeccion('usuario')">Usuario</button>
            <button onclick="mostrarSeccion('notificaciones')">Notificaciones</button>
            <button onclick="mostrarSeccion('config')">Configuración</button>
        <?php endif; ?>
    </nav>

    <main>

        <!-- LOGIN -->
        <div id="login" class="<?php echo isset($_SESSION['user_id']) ? 'hidden' : ''; ?>">
            <h2>Iniciar Sesión</h2>
            <form action="login.php" method="POST">
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Entrar</button>
            </form>
        </div>

        <!-- REGISTRO -->
        <div id="registro" class="hidden">
            <h2>Registro de Usuario</h2>
            <form action="registro.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="password" name="confirmar_password" placeholder="Confirmar contraseña" required>
                <button type="submit">Crear cuenta</button>
            </form>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>

            <!-- DASHBOARD -->
            <div id="dashboard" class="hidden">
                <h2>Panel de Usuario</h2>
                <p>Bienvenido/a, <?php echo $_SESSION['nombre']; ?>!</p>
            </div>

            <!-- FINANZAS -->
            <div id="finanzas" class="hidden">
                <section>
                    <h2>Registrar Ingreso</h2>
                    <form action="finanzas.php" method="POST">
                        <input type="hidden" name="tipo" value="ingreso">
                        <input type="text" name="descripcion" placeholder="Fuente de ingreso">
                        <input type="number" name="monto" placeholder="Monto">
                        <input type="date" name="fecha">
                        <button type="submit">Guardar ingreso</button>
                    </form>
                </section>

                <section>
                    <h2>Registrar Gasto</h2>
                    <form action="finanzas.php" method="POST">
                        <input type="hidden" name="tipo" value="gasto">
                        <input type="text" name="descripcion" placeholder="Categoría">
                        <input type="number" name="monto" placeholder="Monto">
                        <input type="date" name="fecha">
                        <button type="submit">Guardar gasto</button>
                    </form>
                </section>
            </div>

            <!-- REPORTES -->
            <div id="reportes" class="hidden">
                <h2>Lista de Reportes</h2>
                <?php
                $sql = "SELECT * FROM finanzas WHERE user_id=? ORDER BY fecha DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0):
                ?>
                    <table border="1" style="width:100%; margin-top:20px;">
                        <tr>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                        </tr>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['tipo']; ?></td>
                                <td><?php echo $row['descripcion']; ?></td>
                                <td><?php echo $row['monto']; ?></td>
                                <td><?php echo $row['fecha']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else: ?>
                    <p>No hay registros aún.</p>
                <?php endif; ?>
            </div>

            <!-- USUARIO -->
            <div id="usuario" class="hidden">
                <h2>Editar Usuario</h2>
                <form action="usuario.php" method="POST">
                    <input type="text" name="nombre" placeholder="Nombre completo" value="<?php echo $_SESSION['nombre']; ?>">
                    <input type="email" name="email" placeholder="Correo electrónico">
                    <input type="password" name="password" placeholder="Nueva contraseña">
                    <button type="submit">Actualizar datos</button>
                </form>
            </div>

            <!-- NOTIFICACIONES -->
            <div id="notificaciones" class="hidden">
                <h2>Notificaciones</h2>
                <p>Aquí se mostrarán alertas importantes sobre tus finanzas.</p>
            </div>

            <!-- CONFIGURACIÓN -->
            <div id="config" class="hidden">
                <h2>Configuración</h2>
                <form action="configuracion.php" method="POST">
                    <label for="CambioNoti">Notificaciones:</label>
                    <select id="CambioNoti" name="notificaciones">
                        <option value="on">Activadas</option>
                        <option value="off">Desactivadas</option>
                    </select>
                    <button type="submit">Guardar Configuración</button>
                </form>
            </div>

        <?php endif; ?>

    </main>

    <footer>
        GRUPO 6 &reg; DERECHOS RESERVADOS 2025
    </footer>

    <script src="script.js"></script>
</body>

</html>