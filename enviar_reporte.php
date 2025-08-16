<?php
session_start();
include "config.php"; // Conexión a la base de datos

// Usar PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ajusta esta ruta según donde tengas PHPMailer en tu proyecto
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Verificar que el usuario esté logueado
if (!isset($_SESSION['user_id']) || empty($_SESSION['email'])) {
    die("Debes iniciar sesión para enviar reportes.");
}

// Datos del usuario
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['email'];
$user_nombre = $_SESSION['nombre'] ?? 'Usuario';

// Obtener reportes del usuario
$stmt = $conn->prepare("SELECT tipo, descripcion, monto, fecha FROM finanzas WHERE user_id=? ORDER BY fecha DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("No hay registros para enviar.");
}

// Construir mensaje HTML
$mensaje = "<h2>Reportes de Finanzas de $user_nombre</h2>";
$mensaje .= "<table border='1' cellpadding='5' cellspacing='0'>";
$mensaje .= "<tr><th>Tipo</th><th>Descripción</th><th>Monto</th><th>Fecha</th></tr>";
while ($row = $result->fetch_assoc()) {
    $mensaje .= "<tr>";
    $mensaje .= "<td>{$row['tipo']}</td>";
    $mensaje .= "<td>{$row['descripcion']}</td>";
    $mensaje .= "<td>{$row['monto']}</td>";
    $mensaje .= "<td>{$row['fecha']}</td>";
    $mensaje .= "</tr>";
}
$mensaje .= "</table>";

// Configuración de PHPMailer
$mail = new PHPMailer(true);

try {
    // Configuración SMTP Gmail
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'proyectov3web@gmail.com'; // Tu correo Gmail
    $mail->Password = 'mgakybwtvetjnjpi'; // Tu contraseña de aplicación sin espacios
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Remitente y destinatario
    $mail->setFrom('proyectov3web@gmail.com', 'FINGO®');
    $mail->addAddress($user_email, $user_nombre);

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Tus reportes de finanzas';
    $mail->Body = $mensaje;

    $mail->send();
    echo "<script>alert('Reporte enviado correctamente al correo $user_email'); window.location.href='index.php?seccion=reportes';</script>";
} catch (Exception $e) {
    echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
}
