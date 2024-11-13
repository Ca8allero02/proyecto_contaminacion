<?php
require 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $sector = $_POST['sector'];
    $contrasena = $_POST['contrasena'];
    $contrasena_hashed = password_hash($contrasena, PASSWORD_DEFAULT);
    $fecha_registro = date('Y-m-d');

    // Verificar si la empresa ya existe
    $sql_check = "SELECT id_empresa FROM Empresa WHERE nombre = ?";
    $stmt_check = $mysqli->prepare($sql_check);
    $stmt_check->bind_param("s", $nombre);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "Error: La empresa ya está registrada.";
    } else {
        $sql = "INSERT INTO Empresa (nombre, direccion, sector, contrasena, fecha_registro) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssss", $nombre, $direccion, $sector, $contrasena_hashed, $fecha_registro);

        if ($stmt->execute()) {
            echo "¡Registro exitoso!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $stmt_check->close();
    $mysqli->close();
}
?>
