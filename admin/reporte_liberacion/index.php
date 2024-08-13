<?php



include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');


require ('../fpdf/fpdf.php');


$id = $_GET['id'];

// Verificar el estado del usuario
$stmt = $pdo->prepare("SELECT  info.fecha_registro, us.nombre, us.ap_paterno, us.ap_materno, cli.nombres, cli.apellidos, con.celular, cli.tipo_urbanizacion, info.monto, info.lote, UPPER(info.manzano) manzano, lib.resumen, lib.seguiente
FROM tb_agendas ag INNER JOIN tb_clientes cli INNER JOIN tb_contactos con INNER JOIN tb_informe info INNER JOIN tb_liberacion lib INNER JOIN tb_usuarios us
WHERE ((((ag.id_agenda=info.id_agenda_fk AND ag.id_cliente_fk = cli.id_cliente) AND (cli.id_contacto_fk = con.id_contacto and info.id_agenda_fk = ag.id_agenda)) AND lib.id_informe_fk = info.id_informe) AND info.id_informe = $id) AND us.id_usuario=$id_usuario");

$stmt->execute();

$datos = $stmt->fetch(PDO::FETCH_ASSOC);



class PDF extends FPDF{

    public $nombreAsesor;
    
   
    function Header()
    {
        $this->AddLink();
        $this->Image('../../public/img/logo.png',10,5,55,0,'PNG','www.google.com');
        $this->Cell(0,15,'',0,1,'C');
        $this->SetTextColor(5, 80, 156);
        $this->SetFont('Arial','B', 13);
        $this->Cell(0,8,'INFORME ASESOR COMERCIAL',0,1,'C');
        $this->SetFont('Arial','B', 16);
        $this->Cell(0,8,'RESERVAS LIBERADAS U OTROS EXTRAORDINARIOS',0,1,'C');
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial','', 12);
        $this->Cell(0,5,'Inmoviliaria Capricornio',0,1,'C');
        $this->Ln(5);
    }
    function Footer()
    {
        $this->SetY(-25);
        $this->Image('../../public/img/ICONO-MARCA.png', 45, 152, 170, 0, 'PNG');
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','', 9);
        $this->Cell(0,5, "______________________________",0,1,'C');
        $this->Cell(0,5, $this->nombreAsesor,0,1,'C');

        $this->SetFont('Arial','I', 9);
        $this->Cell(0,10,utf8_decode('Página').$this->PageNo().' de {nb}',0,0,'C');
    }
}





$pdf = new PDF('P','mm','Letter'); //P=vertical L= Horizontal , mm=milimetros cm=centimetros in=pulgadas pt=punto , Legal-Letter 


$pdf->nombreAsesor = $datos['nombre']." ".$datos['ap_paterno']." ".$datos['ap_materno'];


$pdf->AddPage(); // RECIBE PARAMETROS (ORIENTACION, TAMAÑO DEL PAPEL) P=vertical L= Horizontal , Legal-Letter , 0 - 90 - 180



$pdf->AliasNbPages();
$pdf->SetTextColor(0,102,204);
$pdf->SetFillColor(233, 233, 233); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial','',12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
$pdf->Cell(0,8,'DATOS PERSONALES ASESOR DE VENTA' ,0,1,'L',true); //
$pdf->Cell(0,5,'',0,1,'C');

    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(61.88,5,"NOMBRES",0,0,"L");

    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(61.88,5,"APELLIDO PATERNO",0,0,"L");

    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(61.88,5,"APELLIDO MATERNO",0,1,"L");
    // LLENAR DE LA BASE DE DATOS
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(61.88,5,$datos['nombre'],0,0,"L");

    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(61.88,5,$datos['ap_paterno'],0,0,"L");

    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(61.88,5,$datos['ap_materno'],0,1,"L");



    // ************************** TITULO DE DETALLES DEL INFORME  *********************************
    $pdf->SetTextColor(0,102,204);
    $pdf->SetFillColor(233, 233, 233); // Establecer color de fondo (RGB)
    $pdf->SetFont('Arial','',12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
    $pdf->Cell(3,5,'',0,1,'C');
    $pdf->Cell(0,8,'DETALLES DE LA LIBERACION' ,0,1,'L',true); //
    $pdf->Cell(0,5,'',0,1,'C');


    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',9);

    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(50,5,"NOMBRE DEL CLIENTE:",0,0,"L");

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(0,5,$datos['nombres']." ".$datos['apellidos'],0,1,"L");
    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',9);
    
    $pdf->Cell(0,2,"",0,1);

    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(50,5,"TEL/CEL DEL CLIENTE:",0,0,"L");
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(0,5,$datos['celular'],0,1,"L");
    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',9);

    $pdf->Cell(0,2,"",0,1);

    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(50,5,"URBANIZACION:",0,0,"L");
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(0,5,$datos['tipo_urbanizacion'],0,1,"L");
    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',9);

    $pdf->Cell(0,2,"",0,1);

    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(50,5,"LOTE:",0,0,"L");
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(40,5,$datos['lote'],0,0,"L");
    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',9);



    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(30,5,"MANZANO:",0,0,"L");
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(0,5,$datos['manzano'],0,1,"L");
    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',9);

    $pdf->Cell(0,2,"",0,1);

    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(50,5,"FECHA REGISTRO:",0,0,"L");
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(0,5,$datos['fecha_registro'],0,1,"L");
    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',9);


    $pdf->Cell(0,2,"",0,1);

    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->Cell(50,5,"MONTO DE LA RESERVA:",0,0,"L");
    $pdf->Cell(20,5,$datos['monto'],0,0,"C", true);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(0,5,"Bolivianos 00/100",0,1,"L");
    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',9);

     // ************************** TITULO RESUMEN DE LA VISITA  *********************************
     $pdf->SetTextColor(0,102,204);
     $pdf->SetFillColor(233, 233, 233); // Establecer color de fondo (RGB)
     $pdf->SetFont('Arial','',12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
     $pdf->Cell(3,5,'',0,1,'C');
     $pdf->Cell(0,8,'RESUMEN DE LA VISITA' ,0,1,'L',true); //
   

     
    $pdf->Cell(0,3,'',0,1,'C'); //SE PARADOR
    $pdf->Cell(3,5,'',0,0,'C');
    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(3,5,'',0,0,'C');


    //fuente negro y ariela normal
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',11);        
    // fin de la fuente negro
    $pdf->MultiCell(185,4.5,utf8_decode($datos['resumen']),0,"J");
    //Inicio de feunte titulo
    $pdf->SetTextColor(5,5,123);
    $pdf->SetFont('Arial','B',9);
    //Fin de feunte titulo


    // ************************** TITULO RESUMEN DE LA VISITA  *********************************
    $pdf->SetTextColor(0,102,204);
    $pdf->SetFillColor(233, 233, 233); // Establecer color de fondo (RGB)
    $pdf->SetFont('Arial','',12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
    $pdf->Cell(3,5,'',0,1,'C');

    
    $pdf->Cell(0,8,'SIGUIENTE PASO POR EL ASESOR COMERCIAL' ,0,1,'L',true); //
  

    
   $pdf->Cell(0,3,'',0,1,'C'); //SE PARADOR
   $pdf->Cell(3,5,'',0,0,'C');
   $pdf->SetTextColor(5,5,123);
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(3,5,'',0,0,'C');

    //fuente negro y ariela normal
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('Arial','',11);        
    // fin de la fuente negro
   $pdf->MultiCell(185,4.5,$datos['seguiente'],0,"J");
   //Inicio de feunte titulo
   $pdf->SetTextColor(5,5,123);
   $pdf->SetFont('Arial','B',9);
   //Fin de feunte titulo

$pdf->Output('', 'reserva.pdf');


?>