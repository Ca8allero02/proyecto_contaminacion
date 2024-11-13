<?php
$mysqli = new mysqli('localhost', 'root', '', 'proyecto');
$mysqli->set_charset("utf8");

if ($mysqli->connect_error) {
    die('Error en la conexión: ' . $mysqli->connect_error);
}
?>