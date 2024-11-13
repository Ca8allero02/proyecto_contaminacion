<?php
session_start();

if (!isset($_SESSION['nombre_empresa'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de Datos de Contaminación</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Ingreso de Datos de Contaminación</h2>
    <form action="procesar.php" method="post">
        <h6>Nombre de la Empresa: </h6>
        <input type="text" name="nombre_empresa" value="<?php echo htmlspecialchars($_SESSION['nombre_empresa']); ?>" readonly><br><br>
        
        <h6>Ingrese Fecha Actual: </h6>
        <input type="date" name="fecha" required><br><br>
        
        <h6>Ingrese Cantidad de Contaminación (toneladas): </h6>
        <input type="number" name="nivel_contaminacion" required><br><br>
        
        <input type="submit" value="Registrar Contaminación">
    </form>
    <a href="dashboard.php">Ver Dashboard</a><br>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>
