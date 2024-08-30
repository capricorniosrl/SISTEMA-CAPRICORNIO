<?php
require_once('../fpdf/fpdf.php'); // Asegúrate de tener el archivo fpdf.php en tu proyecto
require_once('qrlib.php'); // Asegúrate de tener el archivo qrlib.php en tu proyecto


// Datos para el código QR
$data = "hola mundo";

// Ruta del archivo temporal para el código QR
$qrFile = 'temp_qr.png';

// Generar el código QR
QRcode::png($data, $qrFile, 'L', 4, 2);

// Crear una instancia de FPDF
$pdf = new FPDF('P', 'mm', 'A4'); // Tamaño carta (A4) en mm
$pdf->AddPage();

// Configuración del título
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Título del Documento'), 0, 1, 'C');

// Espacio entre el título y el código QR
$pdf->Ln(20);

// Añadir el código QR al PDF
$pdf->Image($qrFile, 70, 50, 70, 70, 'PNG'); // Ajusta la posición y el tamaño según sea necesario

// Espacio para el pie de página
$pdf->Ln(100);

// Configuración del pie de página
$pdf->SetY(-15);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Pie de Página - Ejemplo de PDF', 0, 0, 'C');

// Guardar el PDF
$pdf->Output('', 'document_with_qr_code.pdf');

// Limpiar el archivo temporal
unlink($qrFile);

echo "PDF generado con éxito.";
?>