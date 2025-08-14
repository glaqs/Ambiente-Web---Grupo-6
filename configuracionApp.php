<?php
// Datos quemados de configuración
$config = [
    ["Opción" => "Nombre de Usuario", "Valor" => "Gael"],
    ["Opción" => "Correo Electrónico", "Valor" => "gaelgudel@gmail.com"],
    ["Opción" => "Moneda", "Valor" => "CRC"],
    ["Opción" => "Notificaciones", "Valor" => "Activadas"],
    ["Opción" => "Límite Diario", "Valor" => "₡100,000"]
];
?>

<div id="config" class="hidden">
    <h2>Configuración de Fingo</h2>
    <ul>
        <?php foreach ($config as $c): ?>
            <li><strong><?= $c['Opción']; ?>:</strong> <?= $c['Valor']; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
