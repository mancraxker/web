<?php

require "conexion.php";
require "fpdf/fpdf.php";

// Función para establecer el texto en el PDF
function setText($pdf, $texto, $longitud, $x, $y) {
    $texto_utf8 = mb_convert_encoding($texto, 'ISO-8859-1', 'UTF-8'); // Conversión adecuada
    $pdf->SetXY($x, $y);
    $pdf->Cell($longitud, 5, $texto_utf8, 0, 1, 'C');
}

// Verifica si el cuatrimestre está presente en la URL
$cuatrimestre = isset($_GET['cuatrimestre']) ? $_GET['cuatrimestre'] : '';

// Si el cuatrimestre está vacío, se obtienen todos los alumnos
if (empty($cuatrimestre)) {
    // Consulta para obtener todos los alumnos sin filtro de cuatrimestre
    $sql = "SELECT sociales.id, sociales.nombre AS sociales, sociales.app AS appe, sociales.apm AS apme 
            FROM sociales";
} else {
    // Si hay un cuatrimestre, se filtra por cuatrimestre
    $sql = "SELECT sociales.id, sociales.nombre AS sociales, sociales.app AS appe, sociales.apm AS apme 
            FROM sociales WHERE sociales.cuatrimestre = '$cuatrimestre'";
}

$resultado = mysqli_query($conexion, $sql);

// Verificar si la consulta tuvo éxito y se obtuvo resultados
if ($resultado && mysqli_num_rows($resultado) > 0) {
    // Crear el PDF para todos los alumnos
    $pdf = new FPDF("l", "mm", "letter");

    while ($fila = mysqli_fetch_assoc($resultado)) {
        // Concatenar correctamente el nombre completo con espacio
        $nombreCompleto = $fila['sociales'] . ' ' . $fila['appe'] . ' ' . $fila['apme'];
		
		// Crear una nueva página por alumno
        $pdf->AddPage();
        $pdf->setFont("Arial", "B", 12);

        // Insertar imagen de fondo
        $pdf->Image('images/cer.jpg', 0, 0, 280, 206);

        // Configuración de texto en el PDF
        $pdf->setFont("Arial", "B", 22);
		
        // Configuración de texto en el PDF
        $pdf->setFont("Arial", "B", 22);
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
    }

    // Mostrar el PDF en pantalla
    $pdf->Output(); // Esto abrirá el PDF en el navegador en lugar de guardarlo

} else {
    echo "<script language='JavaScript'>
                alert('No se encotrararon alumnos en el cuatrimestre seleccionado');
                location.assign('cer_sol.php');
              </script>";
}

mysqli_close($conexion);
?>
