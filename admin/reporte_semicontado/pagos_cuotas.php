<?php
require_once('../phpqrcode/qrlib.php'); // Asegúrate de tener el archivo qrlib.php en tu proyecto


include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');


require ('../fpdf/fpdf.php');


$id=$_GET['id'];
$id_cuota=$_GET['id_cuota'];


$sql=$pdo->prepare("SELECT * FROM tb_cuotas cu
INNER JOIN tb_semicontado semi
INNER JOIN tb_comprador com
WHERE ((cu.id_semicontado_fk=semi.id_semicontado) AND semi.id_comprador_fk=com.id_comprador) AND id_cuota=$id_cuota ");

$sql->execute();
$datos=$sql->fetch(PDO::FETCH_ASSOC);




class PDF extends FPDF{

    public $urbanizacion;
    
   
    function Header()
    {
        if ($this->PageNo() == 1) {

            $this->Image('../../public/img/HEADER-SEMICONTADO.png',0,0,216,70,'PNG');
            $this->Cell(0,5,'',0,1,'C');
            $this->SetTextColor(255, 255, 255);



            $this->SetFont('Arial','B', 18);
            $this->SetTextColor(255, 215, 0);
            $this->Cell(3,8,"",0,0);
            $this->Cell(58,8,utf8_decode("URBANIZACIÓN"),0,0,"C");

            $this->SetTextColor(255, 255, 255);

            $this->SetFont('Arial','B', 20);
            $this->Cell(0,8, utf8_decode('INMOBILIARIA Y CONSTRUCCIÓN'),0,1,'R');

            $this->SetFont('Arial','B', 14);
            $this->Cell(3,8,"",0,0);
            $this->Cell(58,8,$this->urbanizacion,0,0,"C");



            $this->SetFont('Arial','B', 16);
            $this->Cell(0,8,'CAPRICORNIO S.R.L.',0,1,'R');
            $this->SetTextColor(0, 0, 0);
            $this->SetFont('Arial','', 12);
            $this->Ln(2);
            $this->SetTextColor(255, 255, 255);
            $this->Cell(0,5,'PLAN DE PAGOS GENERAL',0,1,'R');
        }
    
    }
    function Footer()
    {
        $this->SetY(-25);
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','', 9);

        $this->Cell(89,5, "______________________________",0,0,'C');
        $this->Cell(89,5, "______________________________",0,1,'C');

        $this->Cell(89,5,"RECIBI CONFORME",0,0,'C');       
        $this->Cell(89,5,"ENTREGUE CONFORME",0,1,'C');

        $this->SetFont('Arial','I', 9);
        $this->Cell(0,10,utf8_decode('Página').$this->PageNo().' de {nb}',0,0,'C');
    }
}



$interlineado=4.5;

// *****************************************************************************************************************************************
// Datos para el código QR
// Datos a incluir en el QR

$number = $id_cuota;
$key = 'mi_clave_secreta'; // Debe ser una clave segura y secreta
$iv = random_bytes(16); // Vector de inicialización para mayor seguridad

// Encriptar el número
$encrypted_number = openssl_encrypt($number, 'AES-256-CBC', $key, 0, $iv);
$url = "$URL/verificar/?idcu=" . urlencode(base64_encode($encrypted_number . '::' . base64_encode($iv)));



// Ruta del archivo temporal para el código QR
// Generar QR
$qrFile = 'qr.png';
QRcode::png($url, $qrFile);

// *****************************************************************************************************************************************



$pdf = new PDF('P','mm','Letter'); //P=vertical L= Horizontal , mm=milimetros cm=centimetros in=pulgadas pt=punto , Legal-Letter 

$pdf->urbanizacion=$datos['urbanizacion'];


$pdf->SetMargins(20, 10, 15);
$pdf->AddPage(); // RECIBE PARAMETROS (ORIENTACION, TAMAÑO DEL PAPEL) P=vertical L= Horizontal , Legal-Letter , 0 - 90 - 180
$pdf->AliasNbPages();

// *****************************************************************************************************************************************
// Añadir el código QR al PDF
$pdf->Image($qrFile, 170, 210, 30, 30, 'PNG'); // Ajusta la posición y el tamaño según sea necesario
// Limpiar el archivo temporal
// unlink($qrFile);
// *****************************************************************************************************************************************

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
$pdf->Cell(91,8,' DETALLES URBANIZACION' ,0,0,'L',true); //
$pdf->Cell(1,8,'' ,0,0,'L'); //
$pdf->Cell(90,8,' DETALLES PAGO' ,0,1,'L',true); //
$pdf->SetTextColor(0,0,0);


$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(25,$interlineado,utf8_decode("DIRECCIÓN:"),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(65,$interlineado,"URBANIZACION ".$datos['urbanizacion'],0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(28,$interlineado,utf8_decode("FECHA PAGO: "),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$datos['fecha_registro_pago'],0,1,'L');
$pdf->SetFont('Arial','B',10);


$pdf->Ln(1);


$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(25,$interlineado,utf8_decode("MANZANO:"),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(65,$interlineado,$datos['manzano'],0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(28,$interlineado,utf8_decode("MONTO PAGO: "),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$datos['monto']. utf8_decode(" Dólares"),0,1,'L');
$pdf->SetFont('Arial','B',10);


$pdf->Ln(1);


$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(25,$interlineado,utf8_decode("LOTE:"),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(65,$interlineado,$datos['lote'],0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(28,$interlineado,utf8_decode("TIPO PAGO: "),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$datos['tipo_pago'],0,1,'L');
$pdf->SetFont('Arial','B',10);

$pdf->Ln(1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(25,$interlineado,utf8_decode("SUPERFICIE:"),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(65,$interlineado,$datos['superficie'],0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(28,$interlineado,utf8_decode("NRO. RECIBO: "),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,$datos['numero_recibo'],0,1,'L');
$pdf->SetFont('Arial','B',10);

$pdf->Ln(1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(5,$interlineado,"",0,0,'L');
$pdf->Cell(25,$interlineado,utf8_decode(""),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(65,$interlineado,"",0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(28,$interlineado,utf8_decode("NRO. CUOTA: "),0,0,'L');
$pdf->SetFont('Arial','',10);
$pdf->Cell(0,$interlineado,utf8_decode($datos['nombre_cuota']),0,1,'L');
$pdf->SetFont('Arial','B',10);





$pdf->Output('', 'reserva.pdf');


?>