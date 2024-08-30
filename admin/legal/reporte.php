<?php
include("../../app/config/config.php");
include("../../app/config/conexion.php");

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');

require('../fpdf/fpdf.php');

// Crear una clase extendiendo FPDF
class PDF extends FPDF
{
    // Definir el encabezado
    function Header()
    {
        // No hacer nada en el encabezado para este ejemplo
    }

    // Definir el pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Función para aplicar negrita
    function SetBold($text)
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode($text), 0, 1);
        $this->SetFont('Arial', '', 12);
    }

    // Función para aplicar cursiva
    function SetItalic($text)
    {
        $this->SetFont('Arial', 'I', 12);
        $this->Cell(0, 10, utf8_decode($text), 0, 1);
        $this->SetFont('Arial', '', 12);
    }

    // Función para aplicar subrayado
    function SetUnderline($text)
    {
        $this->SetFont('Arial', 'U', 12);
        $this->Cell(0, 10, utf8_decode($text), 0, 1);
        $this->SetFont('Arial', '', 12);
    }

    // Función para convertir HTML a texto simple con formato
    function WriteHTML($html)
    {
        // Reemplazar las etiquetas HTML básicas por texto
        $html = str_replace(array('<br>', '<br/>', '<br />'), "\n", $html);
        $html = preg_replace('/<\/p>/', "\n", $html);
        $html = preg_replace('/<p[^>]*>/', "", $html);
        $html = strip_tags($html, '<b><i><u><p>'); // Solo mantener etiquetas básicas

        // Reemplazar etiquetas HTML por marcas de formato
        $html = preg_replace('/<b>(.*?)<\/b>/', '***$1***', $html); // Bold
        $html = preg_replace('/<i>(.*?)<\/i>/', '*$1*', $html); // Italic
        $html = preg_replace('/<u>(.*?)<\/u>/', '_$1_', $html); // Underline

        // Separar el texto por formato
        $parts = preg_split('/(\*\*\*.*?\*\*\*|\*.*?\*|_.*?_)/s', $html, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($parts as $part) {
            if (preg_match('/^\*\*\*(.*?)\*\*\*$/s', $part, $matches)) {
                $this->SetBold($matches[1]);
            } elseif (preg_match('/^\*(.*?)\*$/s', $part, $matches)) {
                $this->SetItalic($matches[1]);
            } elseif (preg_match('/^_(.*?)_$/s', $part, $matches)) {
                $this->SetUnderline($matches[1]);
            } else {
                $this->MultiCell(0, 10, utf8_decode($part), 0, 'J'); // Justificar el texto
            }
        }
    }
}

// Crear una instancia de la clase PDF con tamaño de página 'Oficio'
$pdf = new PDF('P', 'mm', array(216, 279)); // Dimensiones para tamaño oficio en mm

// Configurar márgenes
$pdf->SetMargins(15, 15, 15);

// Agregar una página
$pdf->AddPage();

// Establecer la fuente
$pdf->SetFont('Arial', '', 12);

// Obtener datos de la base de datos
$sql = $pdo->prepare("SELECT * FROM tb_documento WHERE id_informe_fk=115");
$sql->execute();
$datos = $sql->fetch(PDO::FETCH_ASSOC);

// Convertir HTML a texto y agregar al PDF
$pdf->WriteHTML($datos['texto']);

// Alias para el número total de páginas
$pdf->AliasNbPages();

// Salida del PDF al navegador
$pdf->Output('I', 'ejemplo.pdf');
