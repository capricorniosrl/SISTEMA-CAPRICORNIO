<?php



include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');


require ('../fpdf/fpdf.php');
$id = $_GET['id'];

$id_user = $_GET['usuario'];

// Verificar el estado del usuario


$sql=$pdo->prepare("SELECT us.nombre, us.ap_paterno, us.ap_materno, info.id_informe, con.num_recibo, com.nombre_1, com.ap_paterno_1, com.ap_materno_1, com.ci_1, com.exp_1, com.nombre_2, com.ap_paterno_2, com.ap_materno_2, com.ci_2, com.exp_2, con.literal, con.monto_bolivianos, con.concepto, us.nombre, us.ap_paterno, us.ap_materno, con.monto_dolar, con.fecha_registro, con.superficie, con.lote, con.manzano, con.urbanizacion
FROM tb_contado con
INNER JOIN tb_comprador com
INNER JOIN tb_usuarios us
INNER JOIN tb_agendas ag
INNER JOIN tb_clientes cli
INNER JOIN tb_contactos cont
INNER JOIN tb_informe info
WHERE ((((((con.id_comprador_fk=com.id_comprador AND com.id_usuario_fk=us.id_usuario) AND us.id_usuario=ag.id_usuario_fk) AND info.id_agenda_fk=ag.id_agenda) AND us.id_usuario='$id_user') AND info.id_informe='$id') AND ag.id_cliente_fk=cli.id_cliente) AND (us.id_usuario=cont.id_usuario_fk AND cli.id_contacto_fk=cont.id_contacto) AND (com.celular_1=cont.celular)");

$sql->execute();
$datos=$sql->fetch(PDO::FETCH_ASSOC);



class PDF extends FPDF{

    public $recibi;
    public $entregado;
    
   
    function Header()
    {
        $this->Image('../../public/img/logo.png',20,5,65,25,'PNG');
        $this->Cell(0,15,'',0,1,'C');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial','B', 18);
        $this->Cell(0,8,utf8_decode('INMOBILIARIA Y CONSTRUCCIÓN CAPRICORNIO S.R.L.'),0,1,'C');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial','', 12);
        $this->Cell(0,5,'Avenida Mario Mercado Nro. 1805 Zona Llojeta ---- NIT 491835023',0,1,'C');
        $this->Ln(4);
    }
    function Footer()
    {
        $this->SetY(-25);
        $this->Image('../../public/img/ICONO-MARCA.png', 45, 152, 170, 0, 'PNG');
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','', 9);

        $this->Cell(89,5, "______________________________",0,0,'C');
        $this->Cell(89,5, "______________________________",0,1,'C');

        $this->Cell(89,5, $this->entregado,0,0,'C');       
        $this->Cell(89,5, $this->recibi,0,1,'C');

        $this->SetFont('Arial','I', 9);
        $this->Cell(0,10,utf8_decode('Página').$this->PageNo().' de {nb}',0,0,'C');
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





$pdf = new PDF('P','mm','Letter'); //P=vertical L= Horizontal , mm=milimetros cm=centimetros in=pulgadas pt=punto , Legal-Letter 


$pdf->recibi = "RECIBI CONFORME";
$pdf->entregado = "ENTREGADO CONFORME";

$pdf->SetMargins(25, 10, 15);

$pdf->AddPage(); // RECIBE PARAMETROS (ORIENTACION, TAMAÑO DEL PAPEL) P=vertical L= Horizontal , Legal-Letter , 0 - 90 - 180



$pdf->AliasNbPages();
$pdf->Line(25,50,200,50);



$pdf->SetFont('Arial','B',16); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
$pdf->Cell(100,8,'RECIBO' ,0,0,'R');


$pdf->SetTextColor(255,0,0);
$pdf->SetFont('helvetica','',12);
$pdf->Cell(0,8,'Nro. '.$datos['num_recibo'] ,0,1,'R');


$pdf->SetTextColor(0,0,0);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'RECIBI DEL Sr./Sra.' ,0,1,'L');
$pdf->SetFont('helvetica','',12);



$pdf->Cell(0,6,$datos['nombre_1']." ".$datos['ap_paterno_1']." ".$datos['ap_materno_1'].' con C.I.: '.$datos['ci_1']." ". $datos['exp_1'],0,1,'C');
$pdf->Cell(0,1,'................................................................................................................................................' ,0,1,'C');
$pdf->Ln(3);
if ($datos['nombre_2']) {
    $pdf->Cell(0,6,$datos['nombre_2']." ".$datos['ap_paterno_2']." ".$datos['ap_materno_2'].' con C.I.: '.$datos['ci_2']." ". $datos['exp_2'],0,1,'C');
}
else {
    $pdf->Cell(0,6,'------------------------------------------' ,0,1,'C');
}


$pdf->Cell(0,1,'................................................................................................................................................' ,0,1,'C');




$pdf->SetLineWidth(2);
$pdf->Line(26,79,200,79);
$pdf->SetLineWidth(0);
$pdf->Line(25,81,201,81);


$pdf->Ln(7);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'LA SUMA DE:' ,0,1,'L');
$pdf->SetFont('helvetica','',12);
$pdf->MultiCell(0,6,$datos['literal'],'B',"C");

$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,8,'BOLIVIANOS' ,0,0,'L');
$pdf->SetFont('helvetica','',12);

$pdf->Cell(58,8,$datos['monto_bolivianos']." Bs." ,"B",0,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,8,'DOLARES' ,0,0,'L');
$pdf->SetFont('helvetica','',12);

$pdf->Cell(58,8,'---------------------' ,"B",1,'C');



$pdf->SetLineWidth(2);
$pdf->Line(26,115,200,115);
$pdf->SetLineWidth(0);
$pdf->Line(25,117,201,117);

$pdf->Ln(14);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,8,'POR CONCEPTO DE:' ,0,1,'L');
$pdf->SetFont('helvetica','',12);


$pdf->MultiCell(0,6,$datos['concepto'],"B","C");


$pdf->SetLineWidth(2);
$pdf->Line(26,145,200,145);
$pdf->SetLineWidth(0);
$pdf->Line(25,147,201,147);



$pdf->Ln(18);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(55,7,'ASESOR:' ,0,0,'L');
$pdf->SetFont('helvetica','',12);

$pdf->Cell(0,7,$datos['nombre']." ".$datos['ap_paterno']." ".$datos['ap_materno'] ,0,1,'L');



$pdf->SetFillColor(224, 224, 224); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial','B',12);
$pdf->Cell(55,7,'PRECIO ACORDARO:' ,0,0,'L',true);
$pdf->SetFont('helvetica','',12);

$pdf->Cell(0,7,$datos['monto_dolar'].' DOLARES' ,0,1,'L',true);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(55,7,'PLAN:' ,0,0,'L');
$pdf->SetFont('helvetica','',12);

$pdf->Cell(0,7,'CONTADO' ,0,1,'L');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(55,7,'FECHA DE PAGO:' ,0,0,'L',true);
$pdf->SetFont('helvetica','',12);

$pdf->Cell(0,7,date('d-m-Y', strtotime($datos['fecha_registro'])) ,0,1,'L',true);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,7,'SUPERFICIE:' ,0,0,'L');
$pdf->SetFont('helvetica','',12);

$pdf->Cell(35,7,$datos['superficie'].' Mts2' ,0,0,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(23,7,'LOTE:' ,0,0,'R');
$pdf->SetFont('helvetica','',12);

$pdf->Cell(29,7,$datos['lote'] ,0,0,'C');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(28,7,'MANZANO:' ,0,0,'R');
$pdf->SetFont('helvetica','',12);

$pdf->Cell(30,7,$datos['manzano'] ,0,1,'C');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(55,7,utf8_decode('URBANIZACIÓN:'),0,0,'L',true);
$pdf->SetFont('helvetica','',12);

$pdf->Cell(0,7,$datos['urbanizacion'] ,0,1,'L',true);


$pdf->SetLineWidth(2);
$pdf->Line(26,195,200,195);
$pdf->SetLineWidth(0);
$pdf->Line(25,197,201,197);






$pdf->Output('I', 'reserva.pdf');



?>