<?php
session_start();
include "config.php"; // Conexion a B.D.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (!empty($email) && !empty($password)) {
        // Preparar consulta segura
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();

            // Verificar contraseña
            if (password_verify($password, $usuario['clave'])) {
                // Login correcto
                $_SESSION['user_id'] = $usuario['id']; // Guardar id del usuario en sesión
                $_SESSION['nombre'] = $usuario['nombre'];

                echo "<script>
                    alert('✅ Bienvenido {$usuario['nombre']}');
                    window.location.href = 'dashboard.php';
                </script>";
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
                window.location.href = 'login.php';
            </script>";
            exit();
        }
    } else {
        echo "<script>
            alert('⚠️ Debes llenar todos los campos');
            window.location.href = 'login.php';
        </script>";
        exit();
    }
}
?>

