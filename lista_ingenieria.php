<?php 
include("conexion.php");
require('fpdf/fpdf.php');

// Obtener los datos del formulario
$catedratico_id = $_GET['catedratico']; 
$cuatrimestre_id = $_GET['cuatrimestre'];
$fecha = $_GET['fecha']; 

// Consultas para obtener el nombre del catedrático y cuatrimestre
$query_catedratico = "SELECT nombre, app, apm FROM catedraticos WHERE id = '$catedratico_id'";
$result_catedratico = mysqli_query($conexion, $query_catedratico);
$catedratico_row = mysqli_fetch_assoc($result_catedratico);
$catedratico_nombre = $catedratico_row['nombre'];
$catedratico_app = $catedratico_row['app'];
$catedratico_apm = $catedratico_row['apm'];

$query_cuatrimestre = "SELECT nombre FROM cuatrimestres WHERE id = '$cuatrimestre_id'";
$result_cuatrimestre = mysqli_query($conexion, $query_cuatrimestre);
$cuatrimestre_row = mysqli_fetch_assoc($result_cuatrimestre);
$cuatrimestre_nombre = $cuatrimestre_row['nombre'];

// Asignar los meses según el trimestre seleccionado
$meses = [];
switch ($fecha) {
    case '1':
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril'];
        break;
    case '2':
        $meses = ['Mayo', 'Junio', 'Julio', 'Agosto'];
        break;
    case '3':
        $meses = ['Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        break;
}

$query = "SELECT id, nombre, app, apm FROM ingenieria WHERE cuatrimestre = '$cuatrimestre_id' ORDER BY nombre ASC"; // Orden alfabético
$result = mysqli_query($conexion, $query);

// Crear instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Agregar logo
$logo = 'images/logo.jpg';
$pdf->Image($logo, 10, 5, 30, 25);

// Configuración del encabezado
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, "Lista de Asistencia", 0, 1, 'C');

$pdf->Ln(1);

$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, "CLAVE07PSU0063R", 0, 1, 'C');
$pdf->Ln(-4);
$pdf->Cell(0, 10, "D.G.P.07-0225", 0, 1, 'C');
$pdf->Ln(-4);
$pdf->Cell(0, 10, "REGIMEN PARTICULAR", 0, 1, 'C');
$pdf->Ln(-4);
$pdf->Cell(0, 10, "____________________________________________________________________________________", 0, 1, 'C');
$pdf->Ln(-8);
$pdf->Cell(0, 10, "_____________________________________________________________________________________________", 0, 1, 'C');
$pdf->Ln(-8);
$pdf->Cell(0, 10, "__________________________________________________________________________________________________", 0, 1, 'C');
$pdf->Cell(0, 10, "NOMBRE DEL CATEDRATICO: $catedratico_nombre $catedratico_app $catedratico_apm                                                                         MATUTINO ", 0, 1, 'L');
$pdf->Cell(0, 10, "LICENCIATURA: INGENIERIA", 0, 1, 'L');
$pdf->Cell(0, 10, "CUATRIMESTRE: $cuatrimestre_nombre", 0, 1, 'L');
$pdf->Ln(5);

// Títulos de las columnas (más estilizados)
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(82, 10, ' ', 1, 0, 'C', true);

// Agregar las columnas de los meses
foreach ($meses as $mes) {
    $pdf->Cell(25, 10, $mes, 1, 0, 'C', true);
}

$pdf->Ln();

// Títulos de las columnas (más estilizados)
$pdf->SetFont('Arial', 'B', 7);
$pdf->SetFillColor(200, 220, 255);
$pdf->Cell(7, 7, 'ID', 1, 0, 'C', true);
$pdf->Cell(25, 7, 'Nombre', 1, 0, 'C', true);
$pdf->Cell(25, 7, 'Apellido Paterno', 1, 0, 'C', true);
$pdf->Cell(25, 7, 'Apellido Materno', 1, 0, 'C', true);

// Aquí agregamos los días debajo de los meses
$pdf->SetFont('Arial', '', 9);
$pdf->SetFillColor(230, 230, 230); // Fondo gris claro
$days = [1, 2, 3, 4, 5]; // Los días para cada mes

foreach ($meses as $mes) {
    foreach ($days as $day) {
        $pdf->Cell(5, 7, $day, 1, 0, 'C', true); // Mostrar los días en las celdas
    }
}

$pdf->Ln();

// Reiniciar el ID para la lista
$id_counter = 1;

// Datos de los alumnos
$pdf->SetFont('Arial', '', 9);
$pdf->SetFillColor(255, 255, 255); // Fondo blanco para las filas de datos
while ($row = mysqli_fetch_assoc($result)) {
    // Reiniciar el ID aquí
    $pdf->Cell(7, 5, $id_counter++, 1, 0, 'C', true); // Incrementa el contador
    $pdf->Cell(25, 5, $row['nombre'], 1, 0, 'C', true);
    $pdf->Cell(25, 5, $row['app'], 1, 0, 'C', true);
    $pdf->Cell(25, 5, $row['apm'], 1, 0, 'C', true);
    
    // Ahora agregamos los campos vacíos debajo de los días (para marcar)
    foreach ($meses as $mes) {
        foreach ($days as $day) {
            $pdf->Cell(5, 5, '', 1, 0, 'C', true); // Casilla vacía para marcar
        }
    }
    
    $pdf->Ln();
}

// Pie de página
function Footer()
{
    $pdf->Cell(10,50, "__________________________________",0,0,"C");
    $pdf->Ln(4);
    $pdf->Cell(10,50, "FIRMA DEL DOCENTE",0,0,"C");
    $pdf->Ln(4);
    // Posición: a 1,5 cm del final
    $pdf->SetY(-15);
    // Arial italic 8
    $pdf->SetFont("Arial","I",8);
    // Número de página
    $pdf->Cell(0,10,"Pagina" .$this->PageNo()."/{nb}",0,0,"C");
    
    // Fecha
    $pdf->SetFont("Arial","",10);
    $pdf->Cell(20,5,"Fecha:". date("d/m/y"),0,0,"C");
}

// Salida del archivo PDF
$pdf->Output();
?>
