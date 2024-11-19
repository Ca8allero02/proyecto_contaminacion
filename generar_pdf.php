<?php
require 'conn.php';
require 'fpdf/fpdf.php';
session_start();

if (!isset($_SESSION['nombre_empresa'])) {
    header("Location: login.html");
    exit();
}

$id_empresa = $_SESSION['id_empresa'];
$nombre_empresa = $_SESSION['nombre_empresa'];

// Obtener datos de la empresa
$sql_empresa = "SELECT fecha, nivel_contaminacion FROM mediciones WHERE id_empresa = ?";
$stmt = $mysqli->prepare($sql_empresa);
$stmt->bind_param("i", $id_empresa);
$stmt->execute();
$result = $stmt->get_result();

// Calcular promedio global
$sql_global = "SELECT AVG(nivel_contaminacion) AS contaminacion_global FROM mediciones";
$result_global = $mysqli->query($sql_global);
$contaminacion_global = $result_global->fetch_assoc()['contaminacion_global'];

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Título
$pdf->Cell(0, 10, "Certificado de Seguimiento de Contaminacion", 0, 1, 'C');
$pdf->Ln(10);

// Información de la empresa
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Empresa: " . $nombre_empresa, 0, 1);
$pdf->Ln(10);

// Tabla de datos
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, "Fecha", 1);
$pdf->Cell(70, 10, "Nivel Empresa", 1);
$pdf->Cell(70, 10, "Promedio Global", 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(50, 10, $row['fecha'], 1);
    $pdf->Cell(70, 10, $row['nivel_contaminacion'], 1);
    $pdf->Cell(70, 10, number_format($contaminacion_global, 2), 1);
    $pdf->Ln();
}

// Pie de página
$pdf->Ln(10);
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, "Generado el " . date('d-m-Y'), 0, 1, 'C');

// Descargar el archivo
$pdf->Output('D', 'Certificado_Contaminacion.pdf');

// Cerrar conexión
$stmt->close();
$mysqli->close();
?>
