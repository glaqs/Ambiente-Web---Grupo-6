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
                
                <br>
                <p style="font-size: 1.5rem; font-weight: bold; text-align: center;">
                    Bienvenido/a, <?php echo $_SESSION['nombre'] ?? 'Usuario'; ?>!
                </p>

                <div style="position: relative; width: 100%; text-align: center; margin-top: 50px;">
                    <!-- Texto arqueado -->
                    <svg width="100%" height="150" viewBox="0 0 1000 150" style="position: absolute; top: 0; left: 0;">
                        <defs>
                            <path id="arco" d="M 50,120 Q 500,-30 950,120" />
                        </defs>
                        <text fill="#d10a0aff" font-size="28" font-weight="bold">
                            <textPath href="#arco" text-anchor="middle" startOffset="50%">
                                FINGO®: Finanzas Inteligentes de Gestión Organizada
                            </textPath>
                        </text>
                    </svg>
                    <br><br><br><br>
                    <!-- Imágenes del logo -->
                    <div style="display: flex; justify-content: center; align-items: center; gap: 35px; margin-top: 60px;">
                        <img src="imagenes/fingo_mejorado.png" alt="Logo FINGO" style="height: 300px; width: auto;">
                        <img src="imagenes/FINGO.png" alt="Logo FINGO" style="height: 300px; width: auto;">
                    </div>
                </div>


                <!-- Contenedor de eslóganes -->
                <div style="text-align: center; margin-top: 20px;">
                    <p style="font-size: 1.8rem; font-weight: bold; color: #c025d1ff; margin: 10px 0;">
                        Haz que cada colón cuente
                    </p>
                    <p style="font-size: 1.5rem; font-weight: bold; color: #02029dff; margin: 10px 0;">
                        Cuida tus finanzas
                    </p>
                </div>

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

                    <div style="display: flex; justify-content: center; gap: 12px; margin-top: 20px; align-items: center;">
                        <!-- Botón de correo -->
                        <div style="width: 160px;">
                            <form action="enviar_reporte.php" method="POST" style="margin: 0;">
                                <input type="hidden" name="mensaje" value="<?php echo htmlspecialchars("Saldo actual: ₡$saldo"); ?>">
                                <button type="submit" style="
                width: 100%;
                background-color: #007AFF;
                color: white;
                border: none;
                padding: 12px 0;
                font-size: 0.95em;
                font-weight: 500;
                border-radius: 6px;
                cursor: pointer;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                line-height: 1.2;
            ">
                                    Enviar por correo
                                </button>
                            </form>
                        </div>

                        <!-- Botón WhatsApp -->
                        <div style="width: 160px;">
                            <button type="button" style="
            width: 100%;
            background-color: #25D366;
            color: white;
            border: none;
            padding: 12px 0;
            font-size: 0.95em;
            font-weight: 500;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            line-height: 1.2;
        " onclick="window.open('https://wa.me/<?php echo $telefono; ?>?text=<?php echo $mensaje_wa; ?>','_blank')">
                                Enviar por WhatsApp
                            </button>
                        </div>
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

                    <!-- Notificación normal -->
                    <p style="color:black; text-align:center; margin-top:10px;">
                        Saldo actual: ₡<?php echo $saldo; ?>
                    </p>

                    <!-- Notificación de alerta -->
                    <?php if ($saldo <= $umbral_alerta): ?>
                        <p style="color:red; font-weight:bold; text-align:center; margin-top:10px;">
                            ¡ALERTA! Tu saldo (₡<?php echo $saldo; ?>) es igual o menor al 10% de tus ingresos totales (₡<?php echo $total_ingresos; ?>)
                        </p>
                    <?php endif; ?>

                    <br>
                    <h1 style="text-align: center; ">"CUIDA TUS GASTOS"</h1>

                    <?php
                    $mensaje_alerta_web = "Hola {$_SESSION['nombre']}, este es un recordatorio de tus finanzas. Saldo actual: ₡$saldo.";
                    $mensaje_alerta_normal_wa = urlencode("Hola {$_SESSION['nombre']}, este es un recordatorio de tus finanzas. Saldo actual: ₡$saldo.");
                    $mensaje_alerta_wa = urlencode("¡Alerta FINGO®! Tu saldo actual es ₡$saldo, que es igual o menor al 10% de tus ingresos totales.");
                    $mensaje_wa = ($saldo <= $umbral_alerta) ? $mensaje_alerta_wa : $mensaje_alerta_normal_wa;
                    ?>

                    <div style="display: flex; justify-content: center; gap: 12px; margin-top: 20px; align-items: center;">
                        
                    <!-- Botón de correo -->
                        <div style="width: 160px;">
                            <form action="enviar_reporte.php" method="POST" style="margin: 0;">
                                <input type="hidden" name="mensaje" value="<?php echo htmlspecialchars("Saldo actual: ₡$saldo"); ?>">
                                <button type="submit" style="
                        width: 100%;
                        background-color: #007AFF;
                        color: white;
                        border: none;
                        padding: 12px 0;
                        font-size: 0.95em;
                        font-weight: 500;
                        border-radius: 6px;
                        cursor: pointer;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                        line-height: 1.2;
                    ">
                                    Enviar por correo
                                </button>
                            </form>
                        </div>

                        <!-- Botón WhatsApp -->
                        <div style="width: 160px;">
                            <button type="button" style="
                    width: 100%;
                    background-color: #25D366;
                    color: white;
                    border: none;
                    padding: 12px 0;
                    font-size: 0.95em;
                    font-weight: 500;
                    border-radius: 6px;
                    cursor: pointer;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
                    line-height: 1.2;
                " onclick="window.open('https://wa.me/<?php echo $telefono; ?>?text=<?php echo $mensaje_wa; ?>','_blank')">
                                Enviar por WhatsApp
                            </button>
                        </div>
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