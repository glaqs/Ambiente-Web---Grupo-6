<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: panel.php");
    exit();
}

$notificaciones = [
    "Has recibido ₡25,000 de Carlos Alvarado - 2025-08-10",
    "Pago de ₡7,500 en Supermercado Palí - 2025-08-12",
    "Recibiste un reembolso de ₡3,200 - 2025-08-13",
    "Nuevo inicio de sesión desde un dispositivo - 2025-08-14",
    "Meta de ahorro 'Vacaciones Guanacaste' alcanzó el 75% - 2025-08-14",
    "Recibiste tu salario de ₡750,000 - 2025-08-15"
];

$config = [
    ["Opción" => "Nombre de Usuario", "Valor" => "Gael"],
    ["Opción" => "Correo Electrónico", "Valor" => "gaelgudel@gmail.com"],
    ["Opción" => "Moneda", "Valor" => "CRC"],
    ["Opción" => "Notificaciones", "Valor" => "Activadas"],
    ["Opción" => "Límite Diario", "Valor" => "₡100,000"]
];
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
        <!-- Login -->
        <div id="login">
            <h2>Iniciar Sesión</h2>
            <form id="formLogin" method="POST">
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <button type="submit">Entrar</button>
            </form>
        </div>

        <!-- Registro -->
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

        <!-- Dashboard -->
        <div id="dashboard" class="hidden">
            <div class="dashboard-info">
                <h2>Panel de Usuario</h2>
                <p>Bienvenido/a a tu panel. Desde aquí puedes acceder a todas las funciones de <strong>FINGO®</strong>.</p>
                <p>En este panel encontrarás:</p>
                <ul>
                    <p>Finanzas: Registra y consulta tus ingresos y gastos.</p>
                    <p>Reportes: Visualiza reportes gráficos de tus finanzas.</p>
                    <p>Usuario: Administra tu perfil y preferencias.</p>
                    <p>Notificaciones: Recibe alertas importantes.</p>
                    <p>Configuración: Personaliza la aplicación a tu gusto.</p>
                    <br><br>
                </ul>
                <p><em>Consejo:</em> Explora cada módulo para aprovechar todas nuestras funcionalidades.</p>
            </div>
        </div>

        <!-- Finanzas -->
        <div id="finanzas" class="hidden">
            <h2>Finanzas</h2>
            <div class="tabla-finanzas">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Concepto</th>
                            <th>Monto (₡)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="ingreso">
                            <td>01/08/2025</td>
                            <td>Ingreso</td>
                            <td>Proyecto freelance</td>
                            <td>500,000</td>
                        </tr>
                        <tr class="gasto">
                            <td>02/08/2025</td>
                            <td>Gasto</td>
                            <td>Supermercado</td>
                            <td>120,000</td>
                        </tr>
                        <tr class="gasto">
                            <td>03/08/2025</td>
                            <td>Gasto</td>
                            <td>Transporte</td>
                            <td>75,000</td>
                        </tr>
                        <tr class="ingreso">
                            <td>04/08/2025</td>
                            <td>Ingreso</td>
                            <td>Venta de productos</td>
                            <td>300,000</td>
                        </tr>
                        <tr class="gasto">
                            <td>05/08/2025</td>
                            <td>Gasto</td>
                            <td>Suscripción mensual</td>
                            <td>50,000</td>
                        </tr>
                        <tr class="gasto">
                            <td>06/08/2025</td>
                            <td>Gasto</td>
                            <td>Restaurante</td>
                            <td>80,000</td>
                        </tr>
                        <tr class="ingreso">
                            <td>07/08/2025</td>
                            <td>Ingreso</td>
                            <td>Reembolso cliente</td>
                            <td>250,000</td>
                        </tr>
                        <tr class="gasto">
                            <td>08/08/2025</td>
                            <td>Gasto</td>
                            <td>Servicios básicos</td>
                            <td>90,000</td>
                        </tr>
                        <tr class="ingreso">
                            <td>09/08/2025</td>
                            <td>Ingreso</td>
                            <td>Inversión devuelta</td>
                            <td>400,000</td>
                        </tr>
                        <tr class="gasto">
                            <td>10/08/2025</td>
                            <td>Gasto</td>
                            <td>Transporte adicional</td>
                            <td>60,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="reportes" class="hidden">
            <h2>Reportes Financieros</h2>
            <?php
            $reportes = [
                ["Fecha" => "2025-01-15", "Tipo" => "Ingreso", "Monto" => 1500, "Descripción" => "Pago de cliente"],
                ["Fecha" => "2025-01-20", "Tipo" => "Gasto", "Monto" => 450, "Descripción" => "Compra de insumos"],
                ["Fecha" => "2025-02-01", "Tipo" => "Ingreso", "Monto" => 2000, "Descripción" => "Venta de producto"]
            ];
            echo "<table border='1' cellpadding='5'><tr><th>Fecha</th><th>Tipo</th><th>Monto</th><th>Descripción</th></tr>";
            foreach ($reportes as $r) {
                echo "<tr>
                        <td>{$r['Fecha']}</td>
                        <td>{$r['Tipo']}</td>
                        <td>₡" . number_format($r['Monto'], 2) . "</td>
                        <td>{$r['Descripción']}</td>
                      </tr>";
            }
            echo "</table>";
            ?>
        </div>

        <div id="usuario" class="hidden">
            <h2>Perfil de Usuario</h2>
            <?php
            $usuario = [
                "Nombre" => "Juan",
                "Correo" => "juan@aaa.com",
            ];
            echo "<ul>";
            foreach ($usuario as $campo => $valor) {
                echo "<li><strong>$campo:</strong> $valor</li>";
            }
            echo "</ul>";
            ?>
 </div>
        <!-- Notificaciones -->
        <div id="notificaciones" class="hidden">
            <h2>Notificaciones</h2>
            <ul>
                <?php foreach ($notificaciones as $notif): ?>
                    <p><?php echo $notif; ?></p>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Configuración -->
        <div id="config" class="hidden">
            <h2>Configuración</h2>
            <ul>
                <?php foreach ($config as $c): ?>
                    <p><strong><?php echo $c['Opción']; ?>:</strong> <?php echo $c['Valor']; ?></p>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>

    <footer>GRUPO 6 &reg; DERECHOS RESERVADOS 2025</footer>

    <script src="script.js"></script>
</body>

</html>
