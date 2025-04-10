<?php

require "conexion.php";
require "fpdf/fpdf.php";

function setText($pdf, $texto, $longitud, $x, $y) {
    $texto_utf8 = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8'); // Conversión adecuada
    $pdf->SetXY($x, $y);
    $pdf->Cell($longitud, 5, $texto_utf8, 0, 1, 'C');
}

// Verificar y obtener el parámetro `id`
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = mysqli_real_escape_string($conexion, $_GET['id']); // Sanitizar el valor de id
} else {
    die("Error: ID inválido o no proporcionado.");
}

// Consulta para obtener los datos del alumno
$sql = "SELECT sociales.nombre AS sociales, sociales.app AS appe, sociales.apm AS apme 
        FROM sociales 
        WHERE sociales.id = $id";

$resultado = mysqli_query($conexion, $sql);

// Verificar si la consulta tuvo éxito y se obtuvo un resultado
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $datos = $resultado->fetch_assoc();
} else {
    die("Error: No se encontraron datos para el ID proporcionado.");
}

// Concatenar correctamente el nombre completo con espacio
$nombreCompleto = $datos['sociales'] . ' ' . $datos['appe'] . ' ' . $datos['apme'];


// Crear el PDF
$pdf = new FPDF("l", "mm", "letter");
$pdf->AddPage();
$pdf->setFont("Arial", "B", 12);

// Insertar imagen de fondo
$pdf->Image('images/cer.jpg', 0, 0, 280, 206);

// Configuración de texto en el PDF
$pdf->setFont("Arial", "B", 22);

// Ajustar la posición y el tamaño para que el nombre completo se ajuste bien
setText($pdf, $nombreCompleto, 260, 8, 123); // Ajusta la longitud y las coordenadas según sea necesario

$pdf->setFont("Arial", "B", 16);
setText($pdf, "POR SER ALUMNO DE SOCIALES", 190, 47, 138);

$pdf->setFont("Arial", "B", 18);
setText($pdf, "Nombre del Rector", 70, 45, 175);
setText($pdf, "Nombre del Catedratico", 70, 174, 175);
setText($pdf, "Rector", 70, 45, 165);
setText($pdf, "Catedratico", 70, 174, 166);

// Agregar la fecha actual
$pdf->setFont("Arial", "", 12);
setText($pdf, date('d/m/Y'), 0, 250, 188);

// Generar y mostrar el PDF
$pdf->Output();

?>