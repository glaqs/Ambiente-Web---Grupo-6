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
        <img src="imagenes/fingo_mejorado.png" alt="Logo FINGO">
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
                <input type="text" name="telefono" placeholder="Número de teléfono" required>
                <button type="submit">Crear cuenta</button>
            </form>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>

            <!-- DASHBOARD -->
            <div id="dashboard">
                <h2>Panel de Usuario</h2>
                <p>Bienvenido/a, <?php echo $_SESSION['nombre'] ?? 'Usuario'; ?>!</p>
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
                <h2 style="text-align:center;">Lista de Reportes</h2>
                <?php
                $sql = "SELECT * FROM finanzas WHERE user_id=? ORDER BY fecha DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();
                $saldo = 0;
                ?>
                <?php if ($result->num_rows > 0): ?>
                    <div style="display:flex; justify-content:flex-end; margin-bottom:10px;">
                        <form action="limpiar_reportes.php" method="POST" onsubmit="return confirm('¿Seguro que deseas borrar todos tus registros?');">
                            <button type="submit" style="background-color:#d9534f; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer;">
                                Limpiar todos los datos
                            </button>
                        </form>
                    </div>

                    <div style="display:flex; justify-content:center;">
                        <table border="1" style="width:80%; text-align:center;">
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
                                <?php
                                if ($row['tipo'] == 'ingreso') $saldo += $row['monto'];
                                else $saldo -= $row['monto'];
                                ?>
                            <?php endwhile; ?>
                        </table>
                    </div>

                    <p style="text-align:center; margin-top:10px;"><strong>Saldo actual: <?php echo $saldo; ?> ₡</strong></p>

                    <?php
                    $mensaje_wa = urlencode("Hola, soy FINGO® y este mensaje es para recordarte tu disponible actual: ₡$saldo");
                    $telefono = $_SESSION['telefono'];
                    ?>

                    <div style="display:flex; justify-content:space-between; margin-top:15px; gap:10px;">
                        <form action="enviar_reporte.php" method="POST" style="flex:1;">
                            <input type="hidden" name="mensaje" value="<?php echo htmlspecialchars("Saldo actual: ₡$saldo"); ?>">
                            <button type="submit" style="width:100%; padding:10px; font-weight:bold; background-color:#41729F; color:white; border:none; border-radius:5px;">
                                Enviar reporte por correo
                            </button>
                        </form>

                        <a href="https://wa.me/<?php echo $telefono; ?>?text=<?php echo $mensaje_wa; ?>" target="_blank"
                            style="flex:1; display:flex; justify-content:center; align-items:center; padding:10px; font-weight:bold; background-color:#25d366; color:white; text-decoration:none; border-radius:5px;">
                            Enviar alerta por WhatsApp
                        </a>
                    </div>
                <?php else: ?>
                    <p style="text-align:center;">No hay registros aún.</p>
                <?php endif; ?>
            </div>

            <!-- USUARIO -->
            <div id="usuario" class="hidden">
                <h2>Editar Usuario</h2>
                <form action="usuario.php" method="POST">
                    <input type="text" name="nombre" placeholder="Nombre completo" value="<?php echo $_SESSION['nombre'] ?? ''; ?>">
                    <input type="email" name="email" placeholder="Correo electrónico" value="<?php echo $_SESSION['email'] ?? ''; ?>">
                    <input type="text" name="telefono" placeholder="Número de teléfono" value="<?php echo $_SESSION['telefono'] ?? ''; ?>">
                    <input type="password" name="password" placeholder="Nueva contraseña">
                    <button type="submit">Actualizar datos</button>
                </form>
            </div>

            <!-- NOTIFICACIONES -->
            <div id="notificaciones" class="hidden">
                <h2 style="text-align:center;">Notificaciones</h2>
                <?php
                $sql = "SELECT * FROM finanzas WHERE user_id=? ORDER BY fecha DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $_SESSION['user_id']);
                $stmt->execute();
                $result = $stmt->get_result();

                $saldo = 0;
                $total_ingresos = 0;
                $movimientos = [];

                while ($row = $result->fetch_assoc()) {
                    $movimientos[] = $row;
                    if ($row['tipo'] == 'ingreso') {
                        $saldo += $row['monto'];
                        $total_ingresos += $row['monto'];
                    } else {
                        $saldo -= $row['monto'];
                    }
                }

                $umbral_alerta = 0.1 * $total_ingresos;
                $telefono = $_SESSION['telefono'];
                ?>

                <?php if (!empty($movimientos)): ?>
                    <table border="1" style="width:80%; margin:0 auto; text-align:center;">
                        <tr>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                        </tr>
                        <?php foreach ($movimientos as $mov): ?>
                            <tr>
                                <td><?php echo $mov['tipo']; ?></td>
                                <td><?php echo $mov['descripcion']; ?></td>
                                <td><?php echo $mov['monto']; ?></td>
                                <td><?php echo $mov['fecha']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <?php if ($saldo <= $umbral_alerta): ?>
                        <p style="color:red; font-weight:bold; text-align:center; margin-top:10px;">
                            ¡ALERTA! Tu saldo ha bajado al 10% de tus ingresos totales. Saldo actual: ₡<?php echo $saldo; ?>
                        </p>
                    <?php endif; ?>

                    <?php
                    $mensaje_alerta_web = "Hola {$_SESSION['nombre']}, este es un recordatorio de tus finanzas. Saldo actual: ₡$saldo.";
                    $mensaje_alerta_wa = "¡Alerta FINGO®! Tu saldo actual es ₡$saldo. Tu disponibilidad ha alcanzado el 10% de tus ingresos.";
                    $mensaje_wa = urlencode($mensaje_alerta_wa);
                    ?>

                    <div style="display:flex; justify-content:space-between; margin-top:15px; gap:10px;">
                        <form action="enviar_reporte.php" method="POST" style="flex:1;">
                            <input type="hidden" name="mensaje" value="<?php echo htmlspecialchars($mensaje_alerta_web); ?>">
                            <button type="submit" style="width:100%; padding:10px; font-weight:bold; background-color:#41729F; color:white; border:none; border-radius:5px;">
                                Enviar reporte por correo
                            </button>
                        </form>

                        <a href="https://wa.me/<?php echo $telefono; ?>?text=<?php echo $mensaje_wa; ?>" target="_blank"
                            style="flex:1; display:flex; justify-content:center; align-items:center; padding:10px; font-weight:bold; background-color:#25d366; color:white; text-decoration:none; border-radius:5px;">
                            Enviar alerta por WhatsApp
                        </a>
                    </div>
                <?php else: ?>
                    <p style="text-align:center;">No hay movimientos registrados aún.</p>
                <?php endif; ?>
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