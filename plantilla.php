<?php
require "fpdf/fpdf.php";

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image("images/logo.jpg",10,5,40,25);
    // Arial bold 15
    $this->SetFont("Arial","B",10);
    // Título
    $this->Cell(25);
    $this->Cell(190,30, "CLAVE07PSU0063R",0,0,"C");
    $this->Ln(4);
    $this->Cell(240,31, "D.G.P.07-0225",0,0,"C");
    $this->Ln(4);
    $this->Cell(240,32, "REGIMEN PARTICULAR",0,0,"C");
    $this->Ln(4);
    $this->Cell(0,32, "__________________________________________________________________________________________________________________",0,0,"C");
    $this->Ln(4);
	$this->Cell(0,32, "___________________________________________________________________________________________________________________",0,0,"C");
    $this->Ln(4);
	$this->Cell(0,32, "_____________________________________________________________________________________________________________________",0,0,"C");
    $this->Ln(4);
    $this->Cell(150,32, "LISTA DE ASISTENCIA: PERIODO ESCOLAR SEPTIEMBRE-DICIEMBRE 2024",0,0,"C");
    $this->Ln(4);
    $this->Cell(229,30, "NOMBRE DEL CATEFRATICO:____________________________________________________________________________________",0,0,"C");
    $this->Ln(4);
    $this->Cell(229,30, "CORREO:________________________________________________ TEL:_____________________________________________",0,0,"C");
    $this->Ln(4);
    $this->Cell(229,30, "LICENCIATURA:_________________________________________ CUATRIMESTRE:___________________________________",0,0,"C");
    $this->Ln(4);
    $this->Cell(229,30, "AIGNATURA:_______________________________________________ HORARIO:______________________________________",0,0,"C");
    $this->Ln(4);
    $this->Cell(40,30, "MATUTINO",0,0,"C");
    // Fecha
   /* $this->SetFont("Arial","",10);
    $this->Cell(20,5,"Fecha:". date("d/m/y"),0,0,"C");*/

    // Salto de línea
    $this->Ln(50);
}

// Pie de página
function Footer()
{
    $this->Cell(230,50, "__________________________________",0,0,"C");
    $this->Ln(4);
    $this->Cell(230,50, "FIRMA DEL DOCENTE",0,0,"C");
    $this->Ln(4);
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont("Arial","I",8);
    // Número de página
    $this->Cell(0,10,"Pagina" .$this->PageNo()."/{nb}",0,0,"C");
}
}
?>