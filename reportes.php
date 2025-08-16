<?php
session_start();
include "config.php";

if (!isset($_SESSION['user_id'])) die("No autorizado");

$sql = "SELECT * FROM finanzas WHERE user_id=? ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<table border="1" style="width:100%; margin-top:20px;">
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
    <?php endwhile; ?>
</table>