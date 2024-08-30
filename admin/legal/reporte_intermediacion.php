<?php
include("../../app/config/config.php");
include("../../app/config/conexion.php");

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

// Incluir TCPDF
require_once('tcpdfmain/tcpdf.php');

// Crear una clase extendida de TCPDF para personalizar el pie de página
class MYPDF extends TCPDF
{
    // Página de pie de página
    public function Footer()
    {
        // Posicionar el pie de página en la parte inferior de la página
        $this->SetY(-15);

        // Establecer la fuente para el pie de página
        $this->SetFont('helvetica', 'I', 8);

        // Obtener el número de página actual y el total de páginas
        $pageNumber = $this->getAliasNumPage();
        $totalPages = $this->getAliasNbPages();

        // Mostrar el texto en el centro del pie de página
        $this->Cell(0, 10, "Página $pageNumber de $totalPages", 0, 0, 'C');
    }
}

// Crear una nueva instancia de la clase extendida
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(216, 330), true, 'UTF-8', false);

// Configurar información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Nombre');
$pdf->SetTitle('Documento Legal');
$pdf->SetSubject('Uso de HTML en TCPDF');
$pdf->SetKeywords('TCPDF, HTML, PDF, ejemplo');

// Configurar márgenes
$pdf->SetMargins(30, 20, 20); // Margen izquierdo, superior y derecho
$pdf->SetHeaderMargin(10);    // Margen del encabezado
$pdf->SetFooterMargin(10);    // Margen del pie de página

// Desactivar impresión del encabezado (si no se usa)
$pdf->setPrintHeader(false);

// Agregar una página
$pdf->AddPage();

// Establecer fuente
$pdf->SetFont('helvetica', '', 12);

// Consulta y obtención de datos
$id_comprador = $_GET['id'];
$sql = $pdo->prepare("SELECT * FROM tb_documento WHERE id_comprador_fk='$id_comprador'");
$sql->execute();
$datos = $sql->fetch(PDO::FETCH_ASSOC);

// Definir el contenido HTML
$html = $datos['texto'];


// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->Ln(30);

// Texto a centrar
$line1 = 'LILIAN LORENA MACHICADO BUSTILLOS';
$line2 = 'C.I. 4894713 L.P';
$line3 = 'AGENTE INMOBILIARIO';
$line4 = 'REPRESENTANTE LEGAL';
$pdf->SetFont('helvetica', '', 11);
// Imprimir texto centrado
$pdf->Cell(0, 2, $line1, 0, 1, 'C');
$pdf->Cell(0, 2, $line2, 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 11);
$pdf->Cell(0, 2, $line3, 0, 1, 'C');
$pdf->Cell(0, 2, $line4, 0, 1, 'C');
$pdf->SetFont('helvetica', '', 11);

$pdf->Ln(30);
$sql_comprador = $pdo->prepare("SELECT * FROM tb_comprador WHERE id_comprador='$id_comprador'");
$sql_comprador->execute();
$datos_comprador = $sql_comprador->fetch(PDO::FETCH_ASSOC);

// Texto a centrar
$line1 = $datos_comprador['nombre_1'] . " " . $datos_comprador['ap_paterno_1'] . " " . $datos_comprador['ap_materno_1'];
$line2 = "C.I. " . $datos_comprador['ci_1'] . " " . $datos_comprador['exp_1'];
$line3 = 'COMPRADOR(a)';

// Imprimir texto centrado
$pdf->Cell(0, 2, $line1, 0, 1, 'C');
$pdf->Cell(0, 2, $line2, 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 11);
$pdf->Cell(0, 2, $line3, 0, 1, 'C');
$pdf->SetFont('helvetica', '', 11);

if ($datos_comprador['nombre_2']) {

    $pdf->Ln(30);
    $line1 = $datos_comprador['nombre_2'] . " " . $datos_comprador['ap_paterno_2'] . " " . $datos_comprador['ap_materno_2'];
    $line2 = "C.I. " . $datos_comprador['ci_2'] . " " . $datos_comprador['exp_2'];
    $line3 = 'COMPRADOR(a)';


    $pdf->Cell(0, 2, $line1, 0, 1, 'C');
    $pdf->Cell(0, 2, $line2, 0, 1, 'C');
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell(0, 2, $line3, 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 11);
}

// Cerrar y enviar el documento PDF al navegador
$pdf->Output('reporte_html.pdf', 'I');
