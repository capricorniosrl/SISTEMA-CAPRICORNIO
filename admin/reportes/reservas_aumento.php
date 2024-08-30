<?php
include("../../app/config/config.php");
include("../../app/config/conexion.php");
include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
require('../fpdf/fpdf.php');

$id = $_GET['id'];

$sql = $pdo->prepare("SELECT * FROM tb_informe info 
    INNER JOIN tb_agendas ag 
    INNER JOIN tb_usuarios us 
    INNER JOIN tb_clientes cli 
    WHERE (((info.id_agenda_fk=ag.id_agenda) 
    AND ag.id_usuario_fk=us.id_usuario) 
    AND ag.id_cliente_fk=cli.id_cliente) 
    AND info.id_informe=:id");
$sql->bindParam(':id', $id, PDO::PARAM_INT);
$sql->execute();

$dato = $sql->fetch(PDO::FETCH_ASSOC);


// consulta para el reporte de las reservas
$id_aumento = $_GET['id_aumento'];
$sql_reserva = $pdo->prepare("SELECT * FROM tb_aumento_reserva WHERE id_informe_fk='$id' AND id_aumento_reserva='$id_aumento'");
$sql_reserva->execute();

$datos_reserva = $sql_reserva->fetch(PDO::FETCH_ASSOC);





$dato_reserva = $sql_reserva->fetch(PDO::FETCH_ASSOC);

class PDF extends FPDF
{
    public $anio;
    public $mes;
    public $dia;
    public $num_recibo;


    function Header()
    {
        $this->Image('../../public/img/fondo.png', 0, 0, 216, 297, 'PNG'); // Ajusta las dimensiones de acuerdo a tu PDF

        $this->Image('../../public/img/logo.png', 25, 8, 57, 15, 'PNG');
        $this->Cell(141, 6, '', 0, 0, 'C');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 6, 'RECIBO', 0, 1, 'C');

        $this->Cell(57, 6, '', 0, 0, 'C');
        $this->Cell(84, 6, '', 0, 0, 'C');
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(11.63, 6, utf8_decode('DÍA'), 1, 0, 'C');
        $this->Cell(11.63, 6, utf8_decode('MES'), 1, 0, 'C');
        $this->Cell(11.63, 6, utf8_decode('AÑO'), 1, 1, 'C');

        $this->SetFont('Arial', '', 8);
        $this->Cell(57, 7, utf8_decode('Av. Mario Mercado Nro. 1805 - Llojeta'), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(84, 7, '', 0, 0, 'C');
        $this->SetFillColor(221, 221, 221);

        $this->SetFillColor(233, 212, 108);
        $this->Cell(11.63, 7, $this->dia, 1, 0, 'C', true);
        $this->Cell(11.63, 7, $this->mes, 1, 0, 'C', true);
        $this->Cell(11.63, 7, $this->anio, 1, 1, 'C', true);
        $this->SetFillColor(255, 255, 255);

        $this->SetFont('Arial', '', 8);
        $this->Cell(57, 4, utf8_decode('Calle Murillo frente al Teleférico Morado N° 1258'), 0, 0, 'C');
        $this->Cell(0, 4, '', 0, 1, 'C');

        $this->SetFont('Arial', '', 8);
        $this->Cell(57, 4, utf8_decode('La Paz - Bolivia'), 0, 0, 'C');
        $this->Cell(84, 4, '', 0, 0, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 4, utf8_decode('N° ' . $this->num_recibo), 0, 1, 'C');

        $this->Ln(4);
    }

    function Footer()
    {
        // Configura la imagen de fondo
        $this->SetY(-18);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 4, utf8_decode('Pago valido únicamente para planes al contado, semi contado, crédito, reservas - No aplica reembolsos'), 0, 0, 'C');

        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    function SetDash($black = false, $white = false)
    {
        if ($black && $white) {
            $s = sprintf('[%.3F %.3F] 0 d', $black * $this->k, $white * $this->k);
        } else {
            $s = '[] 0 d';
        }
        $this->_out($s);
    }
}

$espacio = 1.8;


$pdf = new PDF('P', 'mm', 'Letter'); //P=vertical L= Horizontal , mm=milimetros cm=centimetros in=pulgadas pt=punto , Legal-Letter 
// Asignar valores de fecha antes de agregar la página
$fecha = $datos_reserva['fecha_registro_aumento'];
$partes = explode('-', $fecha);

$pdf->anio = $partes[0]; // Año
$pdf->mes = $partes[1];  // Mes
$pdf->dia = $partes[2];  // Día

if ($dato['num_recibo']) {
    $pdf->num_recibo = $dato['num_recibo'];
} else {
    $pdf->num_recibo = $dato['num_transferencia'];
}



$pdf->SetMargins(25, 10, 15);

$pdf->AddPage(); // RECIBE PARAMETROS (ORIENTACION, TAMAÑO DEL PAPEL) P=vertical L= Horizontal , Legal-Letter , 0 - 90 - 180
$pdf->AliasNbPages();


$pdf->SetTextColor(0, 0, 0); //color de la letra


$pdf->SetLineWidth(0.7);
$pdf->Line(20, 258, 205, 258);

$pdf->Line(20, 258, 20, 7);

$pdf->Line(20, 7, 205, 7);

$pdf->Line(205, 7, 205, 258);


$pdf->SetLineWidth(0);



// $pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(233, 212, 108);
$pdf->SetFont('helvetica', 'B', 12.5);


$pdf->Cell(40, 7, 'Recibi del Sr./Sra.', 0, 0, 'R');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 7, utf8_decode($dato['nombres'] . " " . $dato['apellidos']), 1, 1, 'C', true);
$pdf->SetFont('helvetica', 'B', 10);

$pdf->Ln($espacio);
$pdf->Cell(40, 7, '', 0, 0, 'R');
$pdf->Cell(0, 7, '', 1, 1, 'C', true);
$pdf->Ln($espacio);
$pdf->SetFont('helvetica', 'B', 12.5);
$pdf->Cell(40, 7, 'La Suma de:', 0, 0, 'R');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 7, $datos_reserva['monto_aumento'] . " Bolivianos", 1, 1, 'C', true);
$pdf->SetFont('helvetica', 'B', 10);

$pdf->Ln($espacio);
$pdf->Cell(40, 7, '', 0, 0, 'R');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 7, $datos_reserva['literal_aumento'], 1, 1, 'C', true);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln($espacio);
$pdf->SetFont('helvetica', 'B', 12.5);
$pdf->Cell(40, 7, 'Por concepto de:', 0, 0, 'R');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 7, utf8_decode(strtoupper($datos_reserva['concepto'])), 1, 1, 'C', true);
$pdf->SetFont('helvetica', 'B', 10);

$pdf->Ln($espacio);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 7, utf8_decode("URBANIZACIÓN: " . $dato['tipo_urbanizacion'] . "      LOTE:" . $dato['lote'] . "      MANZANO:" . $dato['manzano']), 1, 1, 'C', true);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Ln($espacio);

$pdf->Cell(12, 7, 'Total:', 0, 0, 'L');
$pdf->Cell(40, 7, $dato['monto'] . " Bs", 1, 0, 'C', true);
$pdf->Cell(22, 7, 'A cuenta:', 0, 0, 'R');
$pdf->Cell(40, 7, ' -----------------------', 1, 0, 'C', true);
$pdf->Cell(22, 7, 'Saldo:', 0, 0, 'R');
$pdf->Cell(40, 7, ' -----------------------', 1, 1, 'C', true);



$pdf->Ln(22);
$pdf->Cell(88, 1, '............................................', 0, 0, 'C');
$pdf->Cell(88, 1, '............................................', 0, 1, 'C');
$pdf->Cell(88, 7, 'Entregue conforme', 0, 0, 'C');
$pdf->Cell(88, 7, 'Recibi conforme', 0, 1, 'C');

$pdf->Cell(28, 4, 'C.I.:', 0, 0, 'R');
$pdf->Cell(36, 4, "", 0, 0, 'C');
$pdf->Cell(24, 4, '', 0, 0, 'C');
$pdf->Cell(28, 4, 'C.I.:', 0, 0, 'R');
$pdf->Cell(36, 4, '', 0, 0, 'C');
$pdf->Cell(24, 4, '', 0, 1, 'C');

$pdf->Cell(28, 1, '', 0, 0, 'C');
$pdf->Cell(36, 1, '......................................', 0, 0, 'C');
$pdf->Cell(24, 1, '', 0, 0, 'C');
$pdf->Cell(28, 1, '', 0, 0, 'C');
$pdf->Cell(36, 1, '......................................', 0, 0, 'C');
$pdf->Cell(24, 1, '', 0, 'C');

$pdf->Ln(15);


$pdf->Cell(20, 5, 'ASESOR: ', 0, 0, 'L');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 3, $dato['nombre'] . " " . $dato['ap_paterno'] . " " . $dato['ap_materno'], 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 10);

$pdf->Cell(20, 1, '', 0, 0, 'L');
$pdf->Cell(0, 1, '............................................................................................................................................................', 0, 1, 'L');

$pdf->Ln(4);

$pdf->Cell(0, 3, '', 0, 1, 'C');
$pdf->Cell(0, 1, '................................................................................................................................................................................', 0, 1, 'L');

$pdf->Ln(4);

$pdf->Cell(40, 5, 'PRECIO ACORDADO: ', 0, 0, 'L');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 3, $dato['precio_acordado'] . " Dolares", 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 10);

$pdf->Cell(40, 1, '', 0, 0, 'L');
$pdf->Cell(0, 1, '.......................................................................................................................................', 0, 1, 'L');

$pdf->Ln(4);

$pdf->Cell(20, 5, 'PLAN: ', 0, 0, 'L');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 3, $dato['plan'], 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 10);

$pdf->Cell(20, 1, '', 0, 0, 'L');
$pdf->Cell(0, 1, '...........................................................................................................................................................', 0, 1, 'L');

$pdf->Ln(4);

$pdf->Cell(48, 5, 'FECHA LIMITE DE PAGO: ', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 3, $dato['fecha_limite_pago'] . " Meses", 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(48, 1, '', 0, 0, 'L');
$pdf->Cell(0, 1, '..............................................................................................................................', 0, 1, 'L');


$pdf->Ln(4);

$pdf->Cell(30, 5, 'SUPERFICIE: ', 0, 0, 'L');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(36, 3, $dato['superficie'] . " Mts2", 0, 0, 'C');
$pdf->SetFont('helvetica', 'B', 10);

$pdf->Cell(18, 5, 'LOTE: ', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(30, 3, $dato['lote'], 0, 0, 'C');
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(25, 5, 'MANZANO: ', 0, 0, 'L');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(30, 3, $dato['manzano'], 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 10);

$pdf->Cell(27, 1, '', 0, 0, 'L');
$pdf->Cell(36, 1, '........................................', 0, 0, 'C');
$pdf->Cell(18, 1, '', 0, 0, 'L');
$pdf->Cell(30, 1, '................................', 0, 0, 'C');
$pdf->Cell(25, 1, '', 0, 0, 'L');
$pdf->Cell(30, 1, '.................................', 0, 1, 'C');

$pdf->Ln(4);

$pdf->Cell(55, 5, utf8_decode('TIPO DE CAMBIO DÓLARES: '), 0, 0, 'L');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 3, $dato['tipo_cambio'] . " Bolivianos", 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 10);

$pdf->Cell(48, 1, '', 0, 0, 'L');
$pdf->Cell(0, 1, '..............................................................................................................................', 0, 1, 'L');

$pdf->Ln(4);

$pdf->Cell(35, 5, utf8_decode('URBANIZACIÓN: '), 0, 0, 'L');

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 3, $dato['tipo_urbanizacion'], 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 10);

$pdf->Cell(35, 1, '', 0, 0, 'L');
$pdf->Cell(0, 1, '...........................................................................................................................................', 0, 1, 'L');

$pdf->Ln(4);

$pdf->Cell(35, 6, utf8_decode('OBSERVACIONES: '), 0, 1, 'L');
$pdf->SetFillColor(255, 255, 255);

$pdf->SetFont('helvetica', '', 10);
$pdf->MultiCell(0, 5, $dato['observacion'], 0, 1);




$pdf->Output('I', 'reserva.pdf');
