<?php



include("../../app/config/config.php");
include("../../app/config/conexion.php");

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');


require('../fpdf/fpdf.php');
$id = $_GET['id'];

// Verificar el estado del usuario
$stmt = $pdo->prepare("SELECT con.celular,us.nombre, us.ap_paterno, us.ap_materno, inf.tipo_cliente, inf.detalle_tipo_cliente, inf.fecha_registro, inf.monto, inf.tipo_pago, inf.num_recibo, inf.num_transferencia, cli.tipo_urbanizacion, inf.resumen_visita, inf.seguiente_paso, inf.lote,inf.manzano,inf.superficie, cli.nombres, cli.apellidos FROM tb_agendas ag INNER JOIN tb_usuarios us INNER JOIN tb_informe inf INNER JOIN tb_clientes cli INNER JOIN tb_contactos con WHERE (((((ag.id_agenda = $id AND ag.id_usuario_fk = us.id_usuario) AND ag.id_cliente_fk = cli.id_cliente ) AND us.id_usuario = $id_usuario)AND ag.id_cliente_fk = cli.id_cliente) AND ag.id_agenda=inf.id_agenda_fk) AND cli.id_contacto_fk=con.id_contacto");

$stmt->execute();

$datos = $stmt->fetch(PDO::FETCH_ASSOC);



class PDF extends FPDF
{

    public $nombreAsesor;


    function Header()
    {
        $this->AddLink();
        $this->Image('../../public/img/logo.png', 10, 5, 55, 0, 'PNG', 'www.google.com');
        $this->Cell(0, 15, '', 0, 1, 'C');
        $this->SetTextColor(5, 80, 156);
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 8, 'INFORME ASESOR COMERCIAL', 0, 1, 'C');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 5, 'Inmoviliaria Capricornio', 0, 1, 'C');
        $this->Ln(5);
    }
    function Footer()
    {
        $this->SetY(-25);
        $this->Image('../../public/img/ICONO-MARCA.png', 45, 152, 170, 0, 'PNG');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 5, "______________________________", 0, 1, 'C');
        $this->Cell(0, 5, $this->nombreAsesor, 0, 1, 'C');

        $this->SetFont('Arial', 'I', 9);
        $this->Cell(0, 10, utf8_decode('Página') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
}





$pdf = new PDF('P', 'mm', 'Letter'); //P=vertical L= Horizontal , mm=milimetros cm=centimetros in=pulgadas pt=punto , Legal-Letter 


$pdf->nombreAsesor = $datos['nombre'] . " " . $datos['ap_paterno'] . " " . $datos['ap_materno'];


$pdf->AddPage(); // RECIBE PARAMETROS (ORIENTACION, TAMAÑO DEL PAPEL) P=vertical L= Horizontal , Legal-Letter , 0 - 90 - 180



$pdf->AliasNbPages();
$pdf->SetTextColor(0, 102, 204);
$pdf->SetFillColor(200, 200, 200); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial', '', 12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
$pdf->Cell(0, 8, 'DATOS PERSONALES ASESOR DE VENTA', 0, 1, 'L', true); //
$pdf->Cell(0, 5, '', 0, 1, 'C');

$pdf->SetTextColor(5, 5, 123);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, "NOMBRES", 0, 0, "L");

$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, "APELLIDO PATERNO", 0, 0, "L");

$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, "APELLIDO MATERNO", 0, 1, "L");
// LLENAR DE LA BASE DE DATOS
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, $datos['nombre'], 0, 0, "L");

$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, $datos['ap_paterno'], 0, 0, "L");

$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, $datos['ap_materno'], 0, 1, "L");

// ************************** TITULO DE DETALLES DEL CLIENTE  *********************************
$pdf->SetTextColor(0, 102, 204);
$pdf->SetFillColor(200, 200, 200); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial', '', 12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
$pdf->Cell(3, 5, '', 0, 1, 'C');
$pdf->Cell(0, 8, 'DATOS DEL CLIENTE', 0, 1, 'L', true); //
$pdf->Cell(0, 5, '', 0, 1, 'C');


$pdf->SetTextColor(5, 5, 123);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, "NOMBRES", 0, 0, "L");

$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, "APELLIDOS", 0, 0, "L");

$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, "CELULAR", 0, 1, "L");
// LLENAR DE LA BASE DE DATOS
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, strtoupper($datos['nombres']), 0, 0, "L");

$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, strtoupper($datos['apellidos']), 0, 0, "L");

$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(61.88, 5, $datos['celular'], 0, 1, "L");

// ************************** TITULO DE DETALLES DEL INFORME  *********************************
$pdf->SetTextColor(0, 102, 204);
$pdf->SetFillColor(200, 200, 200); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial', '', 12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
$pdf->Cell(3, 5, '', 0, 1, 'C');
$pdf->Cell(0, 8, 'DETALLES DEL INFORME', 0, 1, 'L', true); //
$pdf->Cell(0, 5, '', 0, 1, 'C');


$pdf->SetTextColor(5, 5, 123);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(3, 5, '', 0, 0, 'C');

$pdf->Cell(50, 5, "1. TIPO DE CLIENTE:", 0, 0, "L");

$pdf->Cell(20, 5, "Oficina:", 0, 0, "L");
$pdf->Cell(3, 5, '', 0, 0, 'C');

if ($datos['tipo_cliente'] == "OFICINA") {

    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 11);
    // fin de la fuente negro

    $pdf->Cell(5, 5, 'X', 1, 0, 'C');

    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo


    $pdf->Cell(3, 5, '', 0, 0, 'C');
    $pdf->Cell(2, 5, ':', 0, 0, 'C');
    $pdf->Cell(3, 5, '', 0, 0, 'C');

    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 9);
    // fin de la fuente negro

    $pdf->Cell(110, 5, $datos['detalle_tipo_cliente'], 0, 1, "L");
    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo
} else {
    $pdf->Cell(5, 5, '', 1, 0, 'C');
    $pdf->Cell(3, 5, '', 0, 0, 'C');
    $pdf->Cell(2, 5, ':', 0, 0, 'C');
    $pdf->Cell(3, 5, '', 0, 0, 'C');
    $pdf->Cell(110, 5, "", 0, 1, "L");
}




$pdf->Cell(87, 1, "", 0, 0, "L");
$pdf->Cell(110, 1, ".......................................................................................................................", 0, 1, "L");

$pdf->Cell(0, 1.5, '', 0, 1, 'C'); //SE PARADOR

$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(50, 5, "", 0, 0, "L");
$pdf->Cell(20, 5, "Propio:", 0, 0, "L");
$pdf->Cell(3, 5, '', 0, 0, 'C');



if ($datos['tipo_cliente'] == "PROPIO") {

    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 11);
    // fin de la fuente negro


    $pdf->Cell(5, 5, 'X', 1, 0, 'C');

    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo


    $pdf->Cell(3, 5, '', 0, 0, 'C');
    $pdf->Cell(2, 5, ':', 0, 0, 'C');
    $pdf->Cell(3, 5, '', 0, 0, 'C');

    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 9);
    // fin de la fuente negro
    $pdf->Cell(110, 5, $datos['detalle_tipo_cliente'], 0, 1, "L");
    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo

} else {
    $pdf->Cell(5, 5, '', 1, 0, 'C');
    $pdf->Cell(3, 5, '', 0, 0, 'C');
    $pdf->Cell(2, 5, ':', 0, 0, 'C');
    $pdf->Cell(3, 5, '', 0, 0, 'C');
    $pdf->Cell(110, 5, "", 0, 1, "L");
}





$pdf->Cell(87, 1, "", 0, 0, "L");
$pdf->Cell(110, 1, ".......................................................................................................................", 0, 1, "L");

$pdf->Cell(0, 3, '', 0, 1, 'C'); //SE PARADOR
$pdf->Cell(3, 5, '', 0, 0, 'C');

$pdf->Cell(50, 5, "2. FECHA Y HORA:", 0, 0, "L");

//fuente negro y ariela normal
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
// fin de la fuente negro

$pdf->Cell(20, 5, date('d-m-Y', strtotime($datos['fecha_registro'])), 0, 1, "L");

//Inicio de feunte titulo
$pdf->SetTextColor(5, 5, 123);
$pdf->SetFont('Arial', 'B', 9);
//Fin de feunte titulo


$pdf->Cell(0, 3, '', 0, 1, 'C'); //SE PARADOR
$pdf->Cell(3, 5, '', 0, 0, 'C');

$pdf->Cell(50, 5, "3. MONTO RESERVADO:", 0, 0, "L");

//fuente negro y ariela normal
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
// fin de la fuente negro
if ($datos['monto']) {
    $pdf->Cell(25, 5, $datos['monto'] . " Bs", 1, 0, "C");
} else {
    $pdf->Cell(25, 5, "---", 1, 0, "C");
}


//Inicio de feunte titulo
$pdf->SetTextColor(5, 5, 123);
$pdf->SetFont('Arial', 'B', 9);
//Fin de feunte titulo


$pdf->Cell(3, 5, "", 0, 0, "C");
$pdf->Cell(40, 5, "00/100 Bolivianos", 0, 1, "L");

$pdf->Cell(0, 3, '', 0, 1, 'C'); //SE PARADOR
$pdf->Cell(3, 5, '', 0, 0, 'C');

$pdf->Cell(50, 5, "4. TIPO DE PAGO:", 0, 0, "L");

$pdf->Cell(20, 5, "Efectivo:", 0, 0, "L");
$pdf->Cell(3, 5, '', 0, 0, 'C');

if ($datos['tipo_pago'] == "efectivo") {
    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 11);
    // fin de la fuente negro

    $pdf->Cell(5, 5, 'X', 1, 0, 'C');

    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo
} else {
    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 9);
    // fin de la fuente negro

    $pdf->Cell(5, 5, '', 1, 0, 'C');

    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo

}




$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(2, 5, ':', 0, 0, 'C');

if ($datos['num_recibo']) {
    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 11);
    // fin de la fuente negro
    $pdf->Cell(110, 5, $datos['num_recibo'], 0, 1, "L");
    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo
} else {
    $pdf->Cell(110, 5, "", 0, 1, "L");
}





$pdf->Cell(87, 1, "", 0, 0, "L");
$pdf->Cell(110, 1, ".......................................................................................................................", 0, 1, "L");

$pdf->Cell(0, 3, '', 0, 1, 'C'); //SE PARADOR

$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->Cell(50, 5, "", 0, 0, "L");
$pdf->Cell(20, 5, "QR:", 0, 0, "L");
$pdf->Cell(3, 5, '', 0, 0, 'C');


if ($datos['tipo_pago'] == "qr") {
    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 11);
    // fin de la fuente negro

    $pdf->Cell(5, 5, 'X', 1, 0, 'C');

    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo
} else {
    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 9);
    // fin de la fuente negro

    $pdf->Cell(5, 5, '', 1, 0, 'C');

    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo

}


$pdf->Cell(3, 5, '', 0, 0, 'C');

$pdf->Cell(25, 5, "Transferencia:", 0, 0, "L");
$pdf->Cell(3, 5, '', 0, 0, 'C');

if ($datos['tipo_pago'] == "transferencia") {
    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 11);
    // fin de la fuente negro

    $pdf->Cell(5, 5, 'X', 1, 0, 'C');

    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo
} else {
    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 9);
    // fin de la fuente negro

    $pdf->Cell(5, 5, '', 1, 0, 'C');

    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo

}



$pdf->Cell(1.5, 5, '', 0, 0, 'C');
$pdf->Cell(2, 5, ':', 0, 0, 'C');



$pdf->Cell(3, 5, '', 0, 0, 'C');

if ($datos['num_transferencia']) {
    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 11);
    // fin de la fuente negro
    $pdf->Cell(110, 5, $datos['num_transferencia'], 0, 1, "L");
    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo
} else {
    $pdf->Cell(110, 5, "", 0, 1, "L");
}





$pdf->Cell(121, 1, "", 0, 0, "L");
$pdf->Cell(72, 1, ".................................................................................", 0, 1, "L");


$pdf->Cell(0, 3, '', 0, 1, 'C'); //SE PARADOR
$pdf->Cell(3, 5, '', 0, 0, 'C');

$pdf->Cell(50, 5, "5. NOMBRE DE LA URBANIZACION:", 0, 0, "L");

$pdf->Cell(3, 5, '', 0, 0, 'C');



if ($datos['tipo_urbanizacion']) {
    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 11);
    // fin de la fuente negro
    $pdf->Cell(137, 5, $datos['tipo_urbanizacion'], 0, 1, "C");
    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo
} else {
    $pdf->Cell(137, 5, "", 0, 1, "C");
}

$pdf->Cell(55, 1, "", 0, 0, "L");
$pdf->Cell(138, 1, "...........................................................................................................................................................", 0, 1, "L");



if ($datos['lote']) {

    $pdf->Cell(0, 3, '', 0, 1, 'C'); //SE PARADOR
    $pdf->Cell(3, 5, '', 0, 0, 'C');

    $pdf->Cell(30, 5, "6. DETALLES:", 0, 0, "L");

    $pdf->Cell(3, 5, '', 0, 0, 'C');
    //fuente negro y ariela normal
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 11);
    // fin de la fuente negro
    $pdf->Cell(0, 5, "LOTE:  " . $datos['lote'] . "        MANZANO:  " . $datos['manzano'] . "        SUPERFICIE:  " . $datos['superficie'] . " Mts2", 0, 1, "C");
    //Inicio de feunte titulo
    $pdf->SetTextColor(5, 5, 123);
    $pdf->SetFont('Arial', 'B', 9);
    //Fin de feunte titulo
} else {
    $pdf->Cell(137, 5, "", 0, 1, "C");
}

$pdf->Cell(30, 1, "", 0, 0, "L");
$pdf->Cell(138, 1, ".......................................................................................................................................................................................", 0, 1, "L");





// ************************** TITULO RESUMEN DE LA VISITA  *********************************
$pdf->SetTextColor(0, 102, 204);
$pdf->SetFillColor(200, 200, 200); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial', '', 12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
$pdf->Cell(3, 5, '', 0, 1, 'C');
$pdf->Cell(0, 8, 'RESUMEN DE LA VISITA', 0, 1, 'L', true); //



$pdf->Cell(0, 3, '', 0, 1, 'C'); //SE PARADOR
$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->SetTextColor(5, 5, 123);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(3, 5, '', 0, 0, 'C');


//fuente negro y ariela normal
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
// fin de la fuente negro
$pdf->MultiCell(185, 4.5, utf8_decode($datos['resumen_visita']), 0, "J");
//Inicio de feunte titulo
$pdf->SetTextColor(5, 5, 123);
$pdf->SetFont('Arial', 'B', 9);
//Fin de feunte titulo


// ************************** TITULO RESUMEN DE LA VISITA  *********************************
$pdf->SetTextColor(0, 102, 204);
$pdf->SetFillColor(200, 200, 200); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial', '', 12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
$pdf->Cell(3, 5, '', 0, 1, 'C');


$pdf->Cell(0, 8, 'SIGUIENTE PASO', 0, 1, 'L', true); //



$pdf->Cell(0, 3, '', 0, 1, 'C'); //SE PARADOR
$pdf->Cell(3, 5, '', 0, 0, 'C');
$pdf->SetTextColor(5, 5, 123);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(3, 5, '', 0, 0, 'C');

//fuente negro y ariela normal
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 10);
// fin de la fuente negro
$pdf->MultiCell(185, 4.5, utf8_decode($datos['seguiente_paso']), 0, "J");
//Inicio de feunte titulo
$pdf->SetTextColor(5, 5, 123);
$pdf->SetFont('Arial', 'B', 9);
//Fin de feunte titulo

$pdf->Output('I', 'reserva.pdf');
