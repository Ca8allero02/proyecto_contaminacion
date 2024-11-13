<?php
require 'conn.php';
session_start();

if (!isset($_SESSION['nombre_empresa'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_empresa = $_SESSION['id_empresa'];
    $fecha = $_POST['fecha'];
    $nivel_contaminacion = $_POST['nivel_contaminacion'];

    $sql = "INSERT INTO mediciones (id_empresa, fecha, nivel_contaminacion) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("isi", $id_empresa, $fecha, $nivel_contaminacion);

    if ($stmt->execute()) {
        echo "Datos registrados exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
<a href="contaminacion.php">Volver</a><br>
<a href="logout.php">Cerrar Sesión</a>
