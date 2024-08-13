<?php



include ("../../app/config/config.php");
include ("../../app/config/conexion.php");

include ('../../layout/admin/session.php');
include ('../../layout/admin/datos_session_user.php');


require ('../fpdf/fpdf.php');

$id = $_GET['id'];

// Verificar el estado del usuario


$stmt = $pdo->prepare("SELECT * FROM tb_clientes_importacion WHERE id_cliente_imp='$id'");
$stmt->execute();
$datos = $stmt->fetch(PDO::FETCH_ASSOC);



class PDF extends FPDF{

    public $nombreAsesor;
    public $totalPages;
    
   
    function Header()
    {
        if ($this->PageNo() == 1) {
            $this->Image('img/IMPORTAR.png',25,20,40,0,'PNG');
            $this->SetTextColor(5, 80, 156);
            $this->SetFont('Arial','B', 25);
            $this->Cell(0,10,'FORMULARIO',0,1,'R');
            $this->Cell(0,10,'DE CLIENTE',0,1,'R');
            $this->Cell(0,12,'',0,1,'');        
            $this->Ln(5);
        }
    }
    function Footer()
    {
        $this->SetY(-25);
        $this->Image('img/IMPORTAR_MARCA.png', 40, 100, 135, 0, 'PNG');
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','', 9);
        $this->SetFont('Arial','I', 9);
        $this->Cell(0,10,utf8_decode('Página').$this->PageNo().' de {nb}',0,0,'R');
        // Añadir firma en la última página
        if($this->PageNo() == $this->totalPages) {
            $this->SetY(-50); // Ajusta la posición vertical según sea necesario
            $this->SetFont('Arial','B', 12);
            $this->Cell(0,10,'FIRMA',0,0,'C');
        }
    }
    
    function SetTotalPages($totalPages) {
        $this->totalPages = $totalPages;
    }
}






$pdf = new PDF('P','mm','Letter'); //P=vertical L= Horizontal , mm=milimetros cm=centimetros in=pulgadas pt=punto , Legal-Letter 


// $pdf->nombreAsesor = $datos['nombre']." ".$datos['ap_paterno']." ".$datos['ap_materno'];

$pdf->SetMargins(25, 20, 20); // Establece los márgenes izquierdo, superior y derecho
$pdf->AddPage(); // RECIBE PARAMETROS (ORIENTACION, TAMAÑO DEL PAPEL) P=vertical L= Horizontal , Legal-Letter , 0 - 90 - 180


$pdf->AliasNbPages();
$pdf->SetTotalPages($pdf->AliasNbPages());


// Dibujar una línea azul
$pdf->SetDrawColor(189, 21, 29); // Establecer el color de dibujo a azul (RGB)
$pdf->SetLineWidth(1);
$pdf->Line(25, 53, 195, 53); // Dibujar una línea desde el punto (10, 50) al punto (200, 50)




$pdf->SetDrawColor(0, 0, 0); // Establecer el color de dibujo a azul (RGB)
$pdf->SetLineWidth(0);
$pdf->SetTextColor(0,102,204);
$pdf->SetFillColor(233, 233, 233); // Establecer color de fondo (RGB)
$pdf->SetFont('Arial','',10); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
$pdf->Cell(0,7,'INFORMACION CLIENTE' ,0,1,'L',true); //
$pdf->Cell(0,3,'',0,1,'C');



$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'Importador: ' ,0,0,'L');



$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5, utf8_decode($datos['nombre_completo']) ,0,1,'C');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);




$pdf->Cell(25,-1.5,'' ,0,0,'L');
$pdf->Cell(0,-1.5,'...................................................................................................................................................................' ,0,1,'L');

$pdf->Cell(0,3,'',0,1,'L');

$pdf->Cell(25,6,'Telefono: ' ,0,0,'L'); 

$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(60,6,utf8_decode($datos['celular']),0,0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);


$pdf->Cell(15,5,'Gmail: ' ,0,0,'L');



$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,utf8_decode($datos['email']),0,1,'C');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);


$pdf->Cell(25,-1.5,'' ,0,0,'L');
$pdf->Cell(0,-1.5,'.................................................................                  ................................................................................' ,0,1,'L');

$pdf->Cell(0,3,'',0,1,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,utf8_decode('Dirección: ') ,0,0,'L');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,5,utf8_decode($datos['direccion']),0,1,'L');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);
$pdf->Cell(25,-1.5,'' ,0,0,'L');
$pdf->Cell(0,-1.5,'...................................................................................................................................................................' ,0,1,'L');
$pdf->Cell(0,4,'',0,1,'L');
$pdf->SetFont('Arial','',10); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
$pdf->Cell(0,7,'DETALLES' ,0,1,'L',true); //
$pdf->Cell(0,3,'',0,1,'C');


$pdf->SetFont('Arial','B',9);



$pdf->Cell(0,6,utf8_decode('1. ¿TIENE EXPERIENCIA PREVIA EN IMPORTACIONES DE PRODUCTOS? ') ,0,1,'L');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_1']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);


$pdf->Cell(0,6,utf8_decode('2. ¿CUÁL ES EL TIPO DE PRODUCTO QUE DESEA A IMPORTAR?') ,0,1,'L');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_2']),'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);


$pdf->Cell(0,6,utf8_decode('3. ¿CUÁNTO ES EL MONTO QUE USTED ESTIMA IMPORTAR? (MENSUAL-ANUAL) ') ,0,1,'L');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_3']." ".$datos['pregunta_3_1']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);



$pdf->Cell(0,6,utf8_decode('4. ¿CUÁNDO PIENSA REALIZAR SU IMPORTACIÓN?') ,0,1,'L');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_4']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);



$pdf->Cell(0,6,utf8_decode('5. ¿QUÉ MERCADO LE INTERESA?') ,0,1,'L');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_5']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);



$pdf->MultiCell(0,6,utf8_decode('6. ¿IDENTIFICO LOS REQUISITOS LEGALES Y REGULACIONES ADUANERAS PARA IMPORTAR ESE PRODUCTO?') ,0,'J');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_6']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);



$pdf->Cell(0,6,utf8_decode('7. ¿CUÁNTO VOLUMEN DE MERCADERÍA TIENE PLANIFICADO IMPORTAR? (Contenedor) (Carga Suelta)') ,0,1,'L');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_7']." ".$datos['pregunta_7_1']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);





$pdf->Cell(0,6,utf8_decode('8. ¿QUÉ OBJETIVO COMERCIAL BUSCA ALCANZAR CON ESTA IMPORTACIÓN?') ,0,1,'L');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_8']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);



$pdf->Cell(0,6,utf8_decode('9. ¿TIENE UN PRESUPUESTO ESTIMADO PARA LA IMPORTACIÓN Y LOGÍSTICA DE LOS PRODUCTOS?') ,0,1,'L');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_9']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);



$pdf->MultiCell(0,6,utf8_decode('10. ¿HA CONSIDERADO ASPECTOS COMO PLAZOS DE ENTREGA, COSTOS DE TRANSPORTE Y POSIBLES ARANCELES AL IMPORTAR?') ,0,'J');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_10']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);



$pdf->MultiCell(0,6,utf8_decode('11. ¿CUENTA CON UN PROVEEDOR CONFIABLE EN EL EXTRANJERO PARA LA IMPORTACIÓN DE PRODUCTOS?') ,0,'J');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_11']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);



$pdf->MultiCell(0,6,utf8_decode('12. ¿QUÉ ASPECTOS BUSCAS EN CAPRICORNIO SRL. ASESOR DE COMERCIO INTERNACIONAL PARA APOYARTE EN ESTE PROCESO DE IMPORTACIÓN?') ,0,'J');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_12']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);



$pdf->Cell(0,6,utf8_decode('13. OBSERVACIONES') ,0,1,'L');
$pdf->Cell(5,6,utf8_decode('') ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(0,4,utf8_decode($datos['pregunta_13']) ,'','J');
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(0,102,204);







$pdf->Output('I', 'reserva.pdf');


?>