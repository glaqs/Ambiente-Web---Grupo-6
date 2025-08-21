<?php
session_start();
include "config.php"; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y limpiar datos de entrada
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    
    // Verificar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        echo "<script>
            alert('⚠️ Debes completar todos los campos');
            window.location.href = 'index.php';
        </script>";
        exit();
    }
    
    // Validar formato de email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
            alert('⚠️ Formato de email inválido');
            window.location.href = 'index.php';
        </script>";
        exit();
    }
    
    // Preparar consulta segura
    $stmt = $conn->prepare("SELECT id, nombre, password, telefono FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        
        // Verificar contraseña
        if (password_verify($password, $usuario['password'])) {
            // Login correcto - Guardar datos en sesión
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['telefono'] = $usuario['telefono'];
            $_SESSION['email'] = $email;
            
            // Redirigir al dashboard
            header("Location: index.php?seccion=dashboard");
            exit();
        } else {
            // Contraseña incorrecta
            echo "<script>
                alert('❌ Contraseña inválida');
                window.location.href = 'index.php';
            </script>";
            exit();
        }
    } else {
        // Usuario no encontrado
        echo "<script>
            alert('⚠️ Usuario no encontrado');
            window.location.href = 'index.php';
        </script>";
        exit();
    }
}
?>