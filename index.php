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
            <button onclick="mostrarSeccion('calculadora')">Calculadora de Tipo de ambio</button>
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
                    <div style="display: flex; justify-content: center; align-items: flex-end; gap: 0; margin-top: 60px;">
                        <img src="imagenes/fingo_mejorado.png"
                            alt="Logo FINGO"
                            style="height: 300px; width: auto; transform: rotate(-10deg); transform-origin: bottom right;">

                        <img src="imagenes/FINGO.png"
                            alt="Logo FINGO"
                            style="height: 300px; width: auto; transform: rotate(10deg); transform-origin: bottom left;">
                    </div>
                </div>

                <div style="text-align: center; margin-top: 20px;">
                    <svg width="500" height="150" viewBox="0 0 500 150">
                        <path id="curva" d="M 50 120 Q 250 20 450 120" fill="transparent" />
                        <text font-size="28" font-weight="bold" fill="#e600ffff">
                            <textPath href="#curva" startOffset="50%" text-anchor="middle">
                                Haz que cada colón cuente
                            </textPath>
                        </text>
                    </svg>
                    <br><br>
                    <p style="font-size: 3rem; font-weight: bold; color: #02029dff; margin: 10px 0;">
                        Cuida tus finanzas
                    </p>
                </div>
            </div>

            <!-- CALCULADORA DE TIPO DE CAMBIO -->
            <div id="calculadora" class="hidden">
                <h2 style="text-align:center;">Calculadora de Tipo de Cambio</h2>

                <div style="max-width: 500px; margin: 0 auto; padding: 20px; border: 1px solid #e45fc7ff; border-radius: 8px;">
                    <form id="form-cambio" style="margin-bottom: 20px;">
                        <div style="margin-bottom: 15px;">
                            <label for="monto" style="display: block; margin-bottom: 5px;">Monto:</label>
                            <input type="number" id="monto" name="monto" step="0.01" min="0" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                        </div>

                        <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                            <div style="flex: 1;">
                                <label for="moneda-origen" style="display: block; margin-bottom: 5px;">De:</label>
                                <select id="moneda-origen" name="moneda_origen" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                                    <option value="CRC">Colón Costarricense (CRC)</option>
                                    <option value="USD">Dólar Estadounidense (USD)</option>
                                    <option value="EUR">Euro (EUR)</option>
                                    <option value="GBP">Libra Esterlina (GBP)</option>
                                    <option value="MXN">Peso Mexicano (MXN)</option>
                                </select>
                            </div>

                            <div style="display: flex; align-items: center; padding-top: 22px;">
                                <button type="button" id="intercambiar" style="background: none; border: none; cursor: pointer; font-size: 20px;">⇄</button>
                            </div>

                            <div style="flex: 1;">
                                <label for="moneda-destino" style="display: block; margin-bottom: 5px;">A:</label>
                                <select id="moneda-destino" name="moneda_destino" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;" required>
                                    <option value="USD">Dólar Estadounidense (USD)</option>
                                    <option value="CRC">Colón Costarricense (CRC)</option>
                                    <option value="EUR">Euro (EUR)</option>
                                    <option value="GBP">Libra Esterlina (GBP)</option>
                                    <option value="MXN">Peso Mexicano (MXN)</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" style=" margin: 0 auto; width: 25%; padding: 10px; background-color: #fa0000ff; color: white; border: none; border-radius: 4px; cursor: pointer; font-family: Arial, sans-serif; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: background-color 0.3s;">
                            Calcular
                        </button>
                    </form>

                    <div id="resultado-cambio" style="display: none; padding: 15px; background-color: #fdfdfdff; border-radius: 4px; text-align: center;">
                        <h3 style="margin-top: 0;">Resultado:</h3>
                        <p id="resultado-texto" style="font-size: 18px; font-weight: bold;"></p>
                        <p id="tasa-cambio" style="font-size: 14px; color: #666;"></p>
                        <p id="ultima-actualizacion" style="font-size: 12px; color: #999;"></p>
                    </div>

                    <div id="error-cambio" style="display: none; padding: 15px; background-color: #f8d7da; color: #721c24; border-radius: 4px; text-align: center;"></div>
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
                        <div style="width: 160px;">
                            <form action="enviar_reporte.php" method="POST" style="margin: 0;">
                                <input type="hidden" name="mensaje" value="<?php echo htmlspecialchars("Saldo actual: ₡$saldo"); ?>">
                                <button type="submit" style="width: 100%; background-color: #007AFF; color: white; border: none; padding: 12px 0; font-size: 0.95em; font-weight: 500; border-radius: 6px; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.1); line-height: 1.2;">
                                    Enviar por correo
                                </button>
                            </form>
                        </div>

                        <div style="width: 160px;">
                            <button type="button" style="width: 100%; background-color: #25D366; color: white; border: none; padding: 12px 0; font-size: 0.95em; font-weight: 500; border-radius: 6px; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.1); line-height: 1.2;" onclick="window.open('https://wa.me/<?php echo $telefono; ?>?text=<?php echo $mensaje_wa; ?>','_blank')">
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

                    <p style="color:black; text-align:center; margin-top:10px;">
                        Saldo actual: ₡<?php echo $saldo; ?>
                    </p>

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

                        <div style="width: 160px;">
                            <form action="enviar_reporte.php" method="POST" style="margin: 0;">
                                <input type="hidden" name="mensaje" value="<?php echo htmlspecialchars("Saldo actual: ₡$saldo"); ?>">
                                <button type="submit" style="width: 100%; background-color: #007AFF; color: white; border: none; padding: 12px 0; font-size: 0.95em; font-weight: 500; border-radius: 6px; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.1); line-height: 1.2;">
                                    Enviar por correo
                                </button>
                            </form>
                        </div>

                        <div style="width: 160px;">
                            <button type="button" style="width: 100%; background-color: #25D366; color: white; border: none; padding: 12px 0; font-size: 0.95em; font-weight: 500; border-radius: 6px; cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.1); line-height: 1.2;" onclick="window.open('https://wa.me/<?php echo $telefono; ?>?text=<?php echo $mensaje_wa; ?>','_blank')">
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

            <script>
                // Función para mostrar una sección y ocultar las demás
                function mostrarSeccion(id) {
                    const secciones = ['login', 'registro', 'dashboard', 'calculadora', 'finanzas', 'reportes', 'usuario', 'notificaciones', 'config'];
                    secciones.forEach(sec => {
                        const el = document.getElementById(sec);
                        if (el) el.classList.add('hidden');
                    });
                    const mostrar = document.getElementById(id);
                    if (mostrar) mostrar.classList.remove('hidden');
                }

                // Configurar la calculadora
                document.addEventListener('DOMContentLoaded', function() {
                    const formCambio = document.getElementById('form-cambio');
                    if (formCambio) {
                        formCambio.addEventListener('submit', function(e) {
                            e.preventDefault();
                            convertirMoneda();
                        });

                        document.getElementById('intercambiar').addEventListener('click', function() {
                            const origen = document.getElementById('moneda-origen');
                            const destino = document.getElementById('moneda-destino');
                            const temp = origen.value;
                            origen.value = destino.value;
                            destino.value = temp;
                        });
                    }

                    // Mostrar sección inicial según estado de login
                    const userLoggedIn = document.body.getAttribute('data-loggedin');
                    if (!userLoggedIn) {
                        mostrarSeccion('login');
                    } else {
                        mostrarSeccion('dashboard');
                    }
                });

                // Función para convertir moneda usando API
                async function convertirMoneda() {
                    const monto = document.getElementById('monto').value;
                    const monedaOrigen = document.getElementById('moneda-origen').value;
                    const monedaDestino = document.getElementById('moneda-destino').value;

                    // Ocultar resultados anteriores
                    document.getElementById('resultado-cambio').style.display = 'none';
                    document.getElementById('error-cambio').style.display = 'none';

                    // Mostrar estado de carga
                    const boton = document.querySelector('#form-cambio button[type="submit"]');
                    const textoOriginal = boton.textContent;
                    boton.textContent = 'Calculando...';
                    boton.disabled = true;

                    try {
                        // Llamada a la API de tipo de cambio (reemplaza API_KEY con tu clave real)
                        const response = await fetch(`https://v6.exchangerate-api.com/v6/f834c5836910464dfad9f714/latest/${monedaOrigen}`);
                        const data = await response.json();

                        if (data.result === 'success' && data.conversion_rates[monedaDestino]) {
                            const tasa = data.conversion_rates[monedaDestino];
                            const resultado = (monto * tasa).toFixed(2);

                            // Mostrar resultados
                            document.getElementById('resultado-texto').textContent =
                                `${monto} ${monedaOrigen} = ${resultado} ${monedaDestino}`;
                            document.getElementById('tasa-cambio').textContent =
                                `1 ${monedaOrigen} = ${tasa.toFixed(6)} ${monedaDestino}`;
                            document.getElementById('ultima-actualizacion').textContent =
                                `Tasas actualizadas: ${new Date(data.time_last_update_utc).toLocaleDateString()}`;

                            document.getElementById('resultado-cambio').style.display = 'block';
                        } else {
                            throw new Error(data['error-type'] || 'No se pudo obtener la tasa de cambio');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        document.getElementById('error-cambio').textContent =
                            'Error al conectar con el servicio de tasas de cambio. Intente nuevamente más tarde.';
                        document.getElementById('error-cambio').style.display = 'block';
                    } finally {
                        boton.textContent = textoOriginal;
                        boton.disabled = false;
                    }
                }
            </script>

        <?php endif; ?>

    </main>

    <footer>
        GRUPO 6 &reg; DERECHOS RESERVADOS 2025
    </footer>
</body>

</html>