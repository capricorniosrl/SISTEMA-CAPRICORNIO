<?php

include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');


require ('../fpdf/fpdf.php');


$id=$_GET['id'];

$sql=$pdo->prepare("SELECT * FROM tb_credito cre
INNER JOIN tb_comprador comp
INNER JOIN tb_usuarios us
INNER JOIN tb_agendas ag
INNER JOIN tb_clientes cli
INNER JOIN tb_contactos con
INNER JOIN tb_informe info
WHERE (((((((cre.id_comprador_fk=comp.id_comprador) AND comp.id_usuario_fk=us.id_usuario) AND ag.id_usuario_fk=us.id_usuario) AND info.id_agenda_fk=ag.id_agenda) AND ag.id_cliente_fk=cli.id_cliente) AND cli.id_contacto_fk=con.id_contacto) AND cli.id_usuario_fk=us.id_usuario)
AND (comp.id_comprador='$id' AND con.celular=comp.celular_1 )");

$sql->execute();
$datos=$sql->fetch(PDO::FETCH_ASSOC);




$id_credito=$datos['id_credito'];

$sql2=$pdo->prepare("SELECT  COUNT(*) as cuotas FROM tb_credito cre INNER JOIN tb_comprador comp INNER JOIN tb_cuotas_credito cu WHERE ((cre.id_comprador_fk=comp.id_comprador) AND comp.id_comprador='$id') AND cu.id_credito_fk='$id_credito'");

$sql2->execute();
$dato2=$sql2->fetch(PDO::FETCH_ASSOC);


class PDF extends FPDF
{
    public $urbanizacion;
    public $total_pages;
    
    // Override de método Header
    function Header()
    {
        if ($this->PageNo() == 1) {
            $this->Image('../../public/img/HEADER-SEMICONTADO.png', 0, 0, 216, 70, 'PNG');
            $this->Cell(0, 5, '', 0, 1, 'C');
            $this->SetTextColor(255, 255, 255);

            $this->SetFont('Arial', 'B', 18);
            $this->SetTextColor(255, 215, 0);
            $this->Cell(3, 8, "", 0, 0);
            $this->Cell(58, 8, utf8_decode("URBANIZACIÓN"), 0, 0, "C");

            $this->SetTextColor(255, 255, 255);

            $this->SetFont('Arial', 'B', 20);
            $this->Cell(0, 8, utf8_decode('INMOBILIARIA Y CONSTRUCCIÓN'), 0, 1, 'R');

            $this->SetFont('Arial', 'B', 14);
            $this->Cell(3, 8, "", 0, 0);
            $this->Cell(58, 8, $this->urbanizacion, 0, 0, "C");

            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 8, 'CAPRICORNIO S.R.L.', 0, 1, 'R');
            $this->SetTextColor(0, 0, 0);
            $this->SetFont('Arial', '', 12);
            $this->Ln(2);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(0, 5, 'PLAN DE PAGOS GENERAL', 0, 1, 'R');
        }
    }

    function Footer()
    {
        // Mostrar el footer solo en la última página
        if ($this->PageNo() == $this->total_pages) {
            $this->SetY(-25);
            $this->SetTextColor(0, 0, 0);
            $this->SetFont('Arial', '', 9);
    
            $this->Cell(89, 5, "______________________________", 0, 0, 'C');
            $this->Cell(89, 5, "______________________________", 0, 1, 'C');
    
            $this->Cell(89, 5, "ENTREGUE CONFORME", 0, 0, 'C');
            $this->Cell(89, 5, "RECIBI CONFORME", 0, 1, 'C');
    
            $this->SetFont('Arial', 'I', 9);
            $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
        }
    }

    // Añadir método para actualizar el total de páginas
    function AddPage($orientation = '', $size = '', $rotation = 0)
    {
        parent::AddPage($orientation, $size, $rotation);
        $this->total_pages = $this->PageNo(); // Actualizar el total de páginas
    }
}



$interlineado=4;

$pdf = new PDF('P', 'mm', 'Letter'); // Crear objeto PDF
$pdf->urbanizacion = $datos['urbanizacion']; // Asignar valor a urbanizacion
$pdf->SetMargins(20, 10, 15);
$pdf->SetAutoPageBreak(TRUE, 35); // Establecer el margen inferior en 3 cm (30 mm)
$pdf->AliasNbPages(); // Alias para total de páginas
$pdf->AddPage(); // Añadir primera página




$pdf->SetDrawColor(255, 255, 255);
$pdf->SetLineWidth(1);
$pdf->Line(142,31,200,31);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0);



$pdf->SetTextColor(0,102,204);
$pdf->SetFillColor(233, 233, 233); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial','B',12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
$pdf->Ln(16);
$pdf->Cell(120,8,' DATOS DEL CLIENTE',0,1,'L',true); //




$pdf->SetFillColor(0, 0, 0);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(48,$interlineado,"NOMBRE DEL CLIENTE:",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$datos['nombre_1']." ".$datos['ap_paterno_1']." ".$datos['ap_materno_1'] ,0,1,'L');
$pdf->SetFont('Arial','B',10);

$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(48,$interlineado,"CEDULA DE IDENTIDAD:",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$datos['ci_1']." ".$datos['exp_1'] ,0,1,'L');
$pdf->SetFont('Arial','B',10);

$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(48,$interlineado,"CELULAR:",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$datos['celular_1'],0,1,'L');
$pdf->SetFont('Arial','B',10);


if ($datos['nombre_2']) {
    $pdf->Ln(3);
    $pdf->Cell(5,$interlineado,"",0,0,'L');
    $pdf->Cell(48,$interlineado,"NOMBRE DEL CLIENTE:",0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,$interlineado,$datos['nombre_2']." ".$datos['ap_paterno_2']." ".$datos['ap_materno_2'] ,0,1,'L');
    $pdf->SetFont('Arial','B',10);

    $pdf->Cell(5,$interlineado,"",0,0,'L');
    $pdf->Cell(48,$interlineado,"CEDULA DE IDENTIDAD:",0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,$interlineado,$datos['ci_2']." ".$datos['exp_2'] ,0,1,'L');
    $pdf->SetFont('Arial','B',10);

    $pdf->Cell(5,$interlineado,"",0,0,'L');
    $pdf->Cell(48,$interlineado,"CELULAR:",0,0,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(0,$interlineado,$datos['celular_2'],0,1,'L');
    $pdf->SetFont('Arial','B',10);
}



$pdf->Ln(5);
$pdf->SetTextColor(0,102,204);
$pdf->SetFillColor(233, 233, 233); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial','B',12); 
$pdf->Cell(120,8,' DETALLES URBANIZACION' ,0,1,'L',true); //
$pdf->SetTextColor(0,0,0);


$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(25,$interlineado,utf8_decode("DIRECCIÓN:"),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,"URBANIZACION ".$datos['urbanizacion'],0,1,'L');
$pdf->SetFont('Arial','B',10);

$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(25,$interlineado,"MANZANO:",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(10,$interlineado, strtoupper($datos['manzano']),0,0,'L');
$pdf->SetFont('Arial','B',10);

$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(15,$interlineado,"LOTE:",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(10,$interlineado,strtoupper($datos['lote']),0,0,'L');
$pdf->SetFont('Arial','B',10);

$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(26,$interlineado,"SUPERFICIE:",0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$datos['superficie']." M2",0,1,'L');
$pdf->SetFont('Arial','B',10);

$pdf->Ln(5);
$pdf->SetTextColor(0,102,204);
$pdf->SetFillColor(233, 233, 233); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial','B',12); 
$pdf->Cell(120,8,' DETALLES - CREDITO' ,0,1,'L',true); //
$pdf->SetTextColor(0,0,0);


$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(38,$interlineado,utf8_decode("PRECIO DE VENTA:"),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,strtoupper($datos['monto_dolar']). utf8_decode(" Dólares"),0,1,'L');
$pdf->SetFont('Arial','B',10);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(38,$interlineado,utf8_decode("CUOTA INICIAL:"),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$datos['cuota_inicial']. utf8_decode(" Dólares"),0,1,'L');
$pdf->SetFont('Arial','B',10);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(38,$interlineado,utf8_decode("CUOTA INTERES:"),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,strtoupper($datos['cuota_interes']). utf8_decode(" Dólares"),0,1,'L');
$pdf->SetFont('Arial','B',10);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(70,$interlineado,utf8_decode("NUMERO DE CUOTAS A CANCELAR:"),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$dato2['cuotas']." Cuotas",0,1,'L');
$pdf->SetFont('Arial','B',10);


$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(38,$interlineado,utf8_decode("FECHA:"),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$datos['fecha_registro'] ,0,1,'L');
$pdf->SetFont('Arial','B',10);

$pdf->Ln(5);



$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(5, 67, 160); 
$pdf->Cell(22,7,utf8_decode("CUOTAS"),0,0,'C',true);$pdf->Cell(1,7,utf8_decode(""),0,0,'C');
$pdf->Cell(40,7,utf8_decode("FECHA"),0,0,'C',true);$pdf->Cell(1,7,utf8_decode(""),0,0,'C');
$pdf->Cell(42,7,utf8_decode("CUOTA INICIAL"),0,0,'C',true);$pdf->Cell(1,7,utf8_decode(""),0,0,'C');
$pdf->Cell(0,7,utf8_decode("SALDO A CANCELAR"),0,1,'C',true);

$pdf->Ln(1.5);

$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0);


$monto_cancelar=($datos['monto_dolar']-$datos['cuota_inicial'])-round($datos['monto']/$datos['tipo_cambio'],2);
$pdf->SetFillColor(255, 255, 255); 
$pdf->Cell(22,7,utf8_decode("INICIAL"),"B",0,'C',true);$pdf->Cell(1,7,utf8_decode(""),"B",0,'C');
$pdf->Cell(40,7,utf8_decode(date("d - m - Y", strtotime($datos['fecha_registro']))),"B",0,'L',true);$pdf->Cell(1,7,utf8_decode(""),"B",0,'C');
$pdf->Cell(42,7,utf8_decode($datos['cuota_inicial'].' Dólares'),"B",0,'R',true);$pdf->Cell(1,7,utf8_decode(""),"B",0,'C');
$pdf->Cell(0,7,utf8_decode($monto_cancelar." Dólares"),"B",0,'R',true);$pdf->Cell(1,7,utf8_decode(""),"B",1,'C');
$pdf->Ln(1);



$reserva=round($datos['monto']/$datos['tipo_cambio'],2);

// Preparar y ejecutar la consulta
$sql3 = $pdo->prepare("SELECT cu.numero_recibo, cu.fecha_registro_pago, cu.id_cuota, cu.nombre_cuota, cu.monto FROM tb_credito cre INNER JOIN tb_comprador comp INNER JOIN tb_cuotas_CREDITO cu WHERE ((cre.id_comprador_fk=comp.id_comprador) AND comp.id_comprador='$id') AND cu.id_credito_fk='$id_credito'");
$sql3->execute();
$contador = 0;
$dato3 = $sql3->fetchAll(PDO::FETCH_ASSOC);

// Crear un objeto DateTime para manejar la fecha
$fechaInicial = new DateTime($datos['fecha_registro']);

// Crear un array con los nombres de los meses en español
$meses = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio',
    7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
];

$suma_cuotas=0;


$sw=0;
foreach ($dato3 as $valor) {
    $contador++;

    $suma_cuotas=$suma_cuotas+$valor['monto'];
    
    // Sumar un mes para la próxima iteración
    $fechaInicial->modify('+1 month');
    
    // Obtener el mes y el año de la fecha actual
    $mes = $fechaInicial->format('n'); // 'n' da el número del mes sin ceros iniciales
    $anio = $fechaInicial->format('Y');
    
    // Obtener el nombre del mes usando el array
    $nombreMes = $meses[$mes];
    
    // Formatear la fecha en el formato deseado
    $fechaFormateada = $nombreMes . ' - ' . $anio;


    if ($sw==1) {
        $pdf->SetFillColor(255, 255, 255); 
        $sw=0;
    }
    else {
        $pdf->SetFillColor(235, 235, 235);
        $sw=1;
    }


    
    $pdf->Cell(22,7,utf8_decode($valor['nombre_cuota']),"B",0,'C',true);$pdf->Cell(1,7,utf8_decode(""),"B",0,'C');
    $pdf->Cell(40,7,utf8_decode($fechaFormateada),"B",0,'K',true);$pdf->Cell(1,7,utf8_decode(""),"B",0,'C');

    if ($valor['monto']){
        $pdf->Cell(42,7,utf8_decode($valor['monto']." Dólares"),"B",0,'R',true);$pdf->Cell(1,7,utf8_decode(""),"B",0,'C');
    }
    else {
        $pdf->Cell(42,7,utf8_decode("SIN CANCELAR"),"B",0,'R',true);$pdf->Cell(1,7,utf8_decode(""),"B",0,'C');
    }
    

   if ($valor['monto'] ) {
        if (($monto_cancelar-$suma_cuotas)<1) {
            $pdf->Cell(0,7,utf8_decode("SALDO A CANCELAR"),"B",1,'C',true);
        }
        else {
            $pdf->Cell(0,7,$monto_cancelar-$suma_cuotas.utf8_decode(" Dólares"),"B",1,'R',true);
        }
        
    }
    else {
        $pdf->Cell(0,7,$monto_cancelar-$suma_cuotas.utf8_decode(" Dólares"),"B",1,'R',true);
    }

    
    
    $pdf->Ln(1);
    
}
$pdf->Ln(3);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(63,7,utf8_decode("TOTAL"),"B",0,'C',true);$pdf->Cell(1,7,utf8_decode(""),"B",0,'C');
$pdf->Cell(42,7,round($suma_cuotas+$datos['cuota_inicial']+$reserva,0).utf8_decode(" Dólares"),"B",0,'C',true);


$pdf->Output('', 'reserva.pdf');


?>