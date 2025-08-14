<div id="reportes">
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

<div id="usuario">
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
