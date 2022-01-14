<?php
//error_reporting(0);
//validamos datos del servidor


$id = $_GET['id'];

$user = "root";
$pass = "";
$host = "localhost";


//conectamos al base datos



require('C:\xampp\htdocs\CASnCS_Modular\fpdf\fpdf.php');
$mysqli = new mysqli("localhost", "root", "", "c&cs");
$conexion = mysqli_connect("localhost", "root", "", "c&cs");
$sql = "SELECT * FROM orden_servicio WHERE id_sg=$id;";
$resultado = mysqli_query($conexion, $sql);



//conectamos al base datos





class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('C:\xampp\htdocs\CASnCS_Modular\img\logos\img.09.png',20,13,33);
    // Arial bold 15
    $this->SetFont('Arial','B',20);
    // Movernos a la derecha
    $this->Cell(65);
    // Título
    $this->Cell(60,10,'ORDEN DE SERVICIO',0,0,'C');
    // Salto de línea
    $this->Ln(20);
    $this->Cell(190,0,date('d/m/Y'),0,0,'R'); 

    
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetTextColor(0,0,0);
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
}
}



$pdf = new PDF();
$pdf -> AliasNbPages(); 
$pdf->AddPage();
$pdf->SetFont('Arial','',18);

$pdf->SetLineWidth(0.2);
$pdf->SetFillColor(155, 155, 155);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetDrawColor(255, 255, 255);
$pdf->Ln(10);

while($row = $resultado->fetch_assoc()){
    $pdf->Cell(50,10,utf8_decode('ID'),1,0,'C',1);
    $pdf->Cell(140,10,utf8_decode($row['id_sg']),1,1,'C',1);
    $pdf->Cell(50,10,utf8_decode('ID CLIENTE'),1,0,'C',1);
    $pdf->Cell(140,10,utf8_decode($row['client_hasorden']),1,1,'C',1);
/*     $pdf->Cell(50,10,utf8_decode('NOMBRE CLIENTE'),1,0,'C',0);
    $pdf->Cell(140,10,utf8_decode($row['nombre_cliente']),1,1,'C',0); */
    $pdf->Cell(50,10,utf8_decode('MODELO'),1,0,'C',1);
    $pdf->Cell(140,10,utf8_decode($row['modelo_coche']),1,1,'C',1);
    $pdf->Cell(50,10,utf8_decode('PLACAS'),1,0,'C',1);
    $pdf->Cell(140,10,($row['placas_coche']),1,1,'C',1);

    
}
$pdf->Output('', 'Orden.pdf');
?>
