<?php
$notificaciones = [
    "Has recibido ₡25,000 de Carlos Alvarado - 2025-08-10",
    "Pago de ₡7,500 en Supermercado Palí - 2025-08-12",
    "Recibiste un reembolso de ₡3,200 - 2025-08-13",
    "Nuevo inicio de sesión desde un dispositivo - 2025-08-14",
    "Meta de ahorro 'Vacaciones Guanacaste' alcanzó el 75% - 2025-08-14",
    "Recibiste tu salario de ₡750,000 - 2025-08-15"
];
?>

<div id="notificaciones">
    <ul>
        <?php foreach($notificaciones as $mensaje): ?>
            <li><?php echo $mensaje; ?></li>
        <?php endforeach; ?>
    </ul>
</div>

