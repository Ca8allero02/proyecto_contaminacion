<?php
session_start();

if (!isset($_SESSION['nombre_empresa'])) {
    header("Location: login.html");
    exit();
}

require 'conn.php';
$id_empresa = $_SESSION['id_empresa'];

$sql_empresa = "SELECT fecha, nivel_contaminacion FROM mediciones WHERE id_empresa = ?";
$stmt = $mysqli->prepare($sql_empresa);
$stmt->bind_param("i", $id_empresa);
$stmt->execute();
$result = $stmt->get_result();

$sql_global = "SELECT AVG(nivel_contaminacion) AS contaminacion_global FROM mediciones";
$result_global = $mysqli->query($sql_global);
$contaminacion_global = $result_global->fetch_assoc()['contaminacion_global'];

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Contaminación</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="dashboard">
    <div class="dashboard-header">
        <h2>Dashboard de Contaminación</h2>
        <form action="generar_pdf.php" method="POST">
            <button type="submit" class="btn-download">Descargar PDF</button>
        </form>
    </div>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Nivel Empresa</th>
            <th>Promedio Global</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['fecha']; ?></td>
            <td><?php echo $row['nivel_contaminacion']; ?></td>
            <td><?php echo $contaminacion_global; ?></td>
        </tr>
        <?php } ?>
        </table>
    <a href="contaminacion.php">Registrar Nueva Contaminación</a>
    <a href="logout.php">Cerrar Sesión</a>
</div>
</body>
</html>

