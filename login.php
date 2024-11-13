<?php
require 'conn.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_empresa = $_POST['nombre_empresa'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT id_empresa, contrasena FROM Empresa WHERE nombre = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $nombre_empresa);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_empresa, $contrasena_hash);
        $stmt->fetch();

        if (password_verify($contrasena, $contrasena_hash)) {
            $_SESSION['nombre_empresa'] = $nombre_empresa;
            $_SESSION['id_empresa'] = $id_empresa;
            header("Location: contaminacion.php");
            exit();
        } else {
            echo "Error: Contraseña incorrecta.";
        }
    } else {
        echo "Error: Empresa no registrada.";
    }

    $stmt->close();
    $mysqli->close();
}
?>
