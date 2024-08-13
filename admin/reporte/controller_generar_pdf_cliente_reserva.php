<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');
require('../fpdf/fpdf.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $cliente_id = $_POST['cliente_id'];
    $fecha_inicio = $_POST['clienteInicio'];
    $fecha_fin= $_POST['clienteFin'];
    

    // Verificar que las fechas se están recibiendo correctamente
    // if ($fecha_inicio) {
    //     echo json_encode(['error' => $cliente_id." ".$fecha_inicio." ".$fecha_fin]);
    //     exit();
    // }

 

    try {
        // Buscar los clientes en la base de datos


        $sql_buscar = $pdo->prepare("SELECT us.nombre, us.ap_paterno, us.ap_materno,info.estado_reporte,UPPER(info.lote) AS lote,UPPER(info.manzano) AS manzano,info.id_informe,con.celular,cli.tipo_urbanizacion,cli.nombres,cli.apellidos,info.monto,info.fecha_registro,info.fecha_cierre,UPPER(info.tipo_pago) as tipo_pago,DATEDIFF(info.fecha_cierre,info.fecha_registro) as dias FROM tb_clientes cli INNER JOIN tb_agendas ag INNER JOIN tb_informe info INNER JOIN tb_usuarios us INNER JOIN tb_contactos con WHERE (info.monto>0 AND ((ag.id_agenda = info.id_agenda_fk) AND ag.id_cliente_fk = cli.id_cliente) AND (cli.id_contacto_fk=con.id_contacto AND con.id_usuario_fk = us.id_usuario) AND ag.id_usuario_fk = '$cliente_id') AND ag.fecha_visita BETWEEN '$fecha_inicio' AND '$fecha_fin' ORDER BY ag.fecha_visita ASC");



        $sql_buscar->execute();
        
        $clientes = $sql_buscar->fetchAll(PDO::FETCH_ASSOC);

        $sql_buscar->execute();
        $datos = $sql_buscar->fetch(PDO::FETCH_ASSOC);


        if (!$clientes) {
            echo json_encode(['error' => 'El Asesor no tiene Clientes Agendados']);
            exit;
        }   
             
        class PDF extends FPDF{

            public $nombreAsesor;
            
        
            function Header()
            {
                $this->AddLink();
                $this->Image('../../public/img/logo.png',10,5,55,0,'PNG','www.google.com');
                $this->Cell(0,15,'',0,1,'C');
                $this->SetTextColor(5, 80, 156);
                $this->SetFont('Arial','B', 18);
                $this->Cell(0,8,'LISTA DE CLIENTES CON RESERVA',0,1,'C');
                $this->SetTextColor(0, 0, 0);
                $this->SetFont('Arial','', 12);
                $this->Cell(0,5,'Inmoviliaria Capricornio',0,1,'C');
                $this->Ln(5);
            }
            function Footer()
            {
                $this->SetY(-25);
                $this->Image('../../public/img/ICONO-MARCA.png', 110, 88, 170, 0, 'PNG');
                $this->SetTextColor(0,0,0);
                $this->SetFont('Arial','', 9);
                // $this->Cell(0,5, "______________________________",0,1,'C');
                // $this->Cell(0,5, $this->nombreAsesor,0,1,'C');

                $this->SetFont('Arial','I', 9);
                $this->Cell(0,10,utf8_decode('Página').$this->PageNo().' de {nb}',0,0,'C');
            }
        }

        $pdf = new PDF('L','mm','Letter'); //P=vertical L= Horizontal , mm=milimetros cm=centimetros in=pulgadas pt=punto , Legal-Letter 



        $pdf->nombreAsesor = $datos['nombre']." ".$datos['ap_paterno']." ".$datos['ap_materno'];

        $pdf->AddPage(); // RECIBE PARAMETROS (ORIENTACION, TAMAÑO DEL PAPEL) P=vertical L= Horizontal , Legal-Letter , 0 - 90 - 180

        $pdf->AliasNbPages();
        $pdf->SetTextColor(0,102,204);
        $pdf->SetFillColor(233, 233, 233); // Establecer color de fondo (RGB)
        $pdf->SetFont('Arial','',12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
        $pdf->Cell(80,8,'LISTA DE CLIENTES DEL ASESOR(a): ',0,0,'L',true);




        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', 'B', 9);


        $pdf->Cell(100,8,$datos['nombre']." ".$datos['ap_paterno']." ".$datos['ap_materno'] ,0,0,'L',true); 


        $pdf->Cell(30,8,'FECHA:',0,0,'R',true);

        if ($fecha_inicio == $fecha_fin) {
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(0,8,date('d-m-Y', strtotime($fecha_fin)),0,1,'R',true);
        } else {
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(0,8,date('d-m-Y', strtotime($fecha_inicio)). "  al  " .date('d-m-Y', strtotime($fecha_fin)),0,1,'R',true);
        }
        



        $pdf->Cell(0,5,'',0,1,'C');


        // Configuración de la tabla
      
        $pdf->SetFillColor(133, 146, 158);
        $pdf->SetTextColor(255,255,255);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(10, 10, 'ID', 1,0,'C',true);

        $pdf->SetFont('Arial', 'B',8);


        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Cell(55, 10, 'NOMBRES DEL CLIENTE', 1,0,'C',true);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 10, 'CELULAR', 1,0,'C',true);
        $pdf->Cell(35, 10, 'URBANIZACION', 1,0,'C',true);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(20, 10, 'MONTO', 1,0,'C',true);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(30, 10, 'TIPO DE PAGO', 1,0,'C',true);
        $pdf->Cell(40, 10, 'FECHA DEPOSITO', 1,0,'C',true);
        $pdf->Cell(0, 10, 'FECHA FIN', 1,0,'C',true);
        $pdf->Ln();

        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', '', 8);
        $contador=0;
        foreach ($clientes as $cliente) {
            $contador++;
            
            $pdf->Cell(10, 8, $contador,1,0,'C');
            $pdf->Cell(55, 8, $cliente['nombres']." ".$cliente['apellidos'],1,0);
            $pdf->Cell(20, 8, $cliente['celular'],1,0);
            $pdf->Cell(35, 8, $cliente['tipo_urbanizacion'],1,0);
            $pdf->Cell(20, 8, $cliente['monto']." Bs",1,0,'R');
            // $pdf->Cell(20, 8, date('d-m-Y', strtotime($cliente['nombre'])), 'T',0,'C');
            $pdf->Cell(30, 8, $cliente['tipo_pago'],1,0,'C');

            $pdf->Cell(40, 8, date('d-m-Y', strtotime($cliente['fecha_registro'])),1,0,'C');
            $pdf->Cell(0, 8, date('d-m-Y', strtotime($cliente['fecha_cierre'])),1,0,'C');
   

            
            $pdf->Cell(0, 8,"", 'B',1,1);
            // $pdf->Ln();
        }


        
        // Guardar el PDF en una variable
        $pdf_content = $pdf->Output('S','lista'); // 'S' para devolver como string

        // Codificar el contenido en base64 para el uso en un iframe
        $pdf_base64 = base64_encode($pdf_content);

        // Generar la URL de descarga
        $pdf_data_url = 'data:application/pdf;base64,' . $pdf_base64;

        // $cliente_id = $datos['nom_user']."_".$datos['ap_paterno']."_".$datos['ap_materno'];
        $cliente_id = "General_reservas";
        echo json_encode([
          
            'id_cliente' => $cliente_id,
            'pdf_url' => $pdf_data_url
        ]);

        
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
