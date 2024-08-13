<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');
require('../fpdf/fpdf.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $fecha_inicio = $_POST['clienteInicio'];
    $fecha_fin= $_POST['clienteFin'];
    

    // // Verificar que las fechas se están recibiendo correctamente
    // if ($fecha_inicio) {
    //     echo json_encode(['error' => $fecha_inicio." ".$fecha_fin]);
    //     exit();
    // }

 

    try {
        // Buscar los clientes en la base de datos

        $sql_usuario = $pdo->prepare("SELECT * FROM tb_usuarios");
        $sql_usuario->execute();
        
        $id_ususario_buscar = $sql_usuario->fetchAll(PDO::FETCH_ASSOC);



        $sql_buscar = $pdo->prepare("SELECT info.fecha_cierre, info.fecha_registro, info.monto, info.lote, info.manzano, con.celular, us.id_usuario, ag.detalle_agenda, ag.visitantes, UPPER(us.nombre) as nom_user, us.ap_paterno, us.ap_materno, UPPER(cli.nombres) as nombre_usuario, UPPER(cli.apellidos) as apellidos, cli.tipo_urbanizacion, ag.fecha_visita, UPPER(cli.detalle) as detalle, ag.asistio FROM tb_clientes cli INNER JOIN tb_agendas ag INNER JOIN tb_usuarios us INNER JOIN tb_informe info INNER JOIN tb_contactos con WHERE con.id_contacto = cli.id_contacto_fk AND ((((( ag.id_cliente_fk=cli.id_cliente) AND ag.id_usuario_fk = us.id_usuario) AND ag.estado=1) AND ag.fecha_visita BETWEEN '2024-04-01' AND '2024-08-22') AND ag.id_agenda = info.id_agenda_fk) AND info.monto>0 ORDER BY us.nombre, ag.fecha_visita");


        $sql_buscar->execute();
        
        $clientes = $sql_buscar->fetchAll(PDO::FETCH_ASSOC);




        // $sql_buscar->execute();
        // $datos = $sql_buscar->fetch(PDO::FETCH_ASSOC);


             
        class PDF extends FPDF{

            public $nombreAsesor;
            
        
            function Header()
            {

                if ($this->PageNo() == 1) {
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



        // $pdf->nombreAsesor = $datos['nom_user']." ".$datos['ap_paterno']." ".$datos['ap_materno'];

        $pdf->AddPage(); // RECIBE PARAMETROS (ORIENTACION, TAMAÑO DEL PAPEL) P=vertical L= Horizontal , Legal-Letter , 0 - 90 - 180

        $pdf->AliasNbPages();
        $pdf->SetTextColor(0,102,204);
        $pdf->SetFillColor(233, 233, 233); // Establecer color de fondo (RGB)
        $pdf->SetFont('Arial','',12); // FUENTE , B=NEGRILLA - I=ITALICA - U=UNDERLINE, RAMAÑO
        $pdf->Cell(180,8,'LISTA GENERAL DE CLIENTES CON RESERVA Y ASESORES:',0,0,'L',true);

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
        $pdf->Cell(10, 8, 'ID', 1,0,'C',true);

        $pdf->SetFont('Arial', 'B',8);


        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Cell(60, 8, 'NOMBRES Y APELLIDOS', 1,0,'C',true);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(25, 8, 'CELULAR', 1,0,'C',true);
        $pdf->Cell(40, 8, 'URBANIZACION', 1,0,'C',true);
        $pdf->Cell(30, 8, 'LOTE Y MANZ.', 1,0,'C',true);
        $pdf->Cell(20, 8, 'MONTO', 1,0,'C',true);

        $pdf->Cell(33, 8, 'FECHA DEPOSITO', 1,0,'C',true);   
        $pdf->Cell(0, 8, 'FECHA LIMITE', 1,0,'C',true);  


        $pdf->Ln();

        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial', '', 7);
        $contador=0;

        $sw=0;

        foreach ($id_ususario_buscar as $dato_id) {
            
            // $pdf->Cell(0, 5, $dato_id['id_usuario']." ".$dato_id['nombre']." ".$dato_id['ap_paterno']." ".$dato_id['ap_materno'],1,1,"L");
            
            foreach ($clientes as $cliente) {

                if ($cliente['id_usuario']==$dato_id['id_usuario']) {

                    if ($sw==0) {
                        $pdf->Cell(0,1," ",0,1);
                        $pdf->SetFillColor(195, 198, 201);
                        $pdf->SetTextColor(0,0,0);
                        $pdf->SetFont('Arial', 'B', 8);
                        $pdf->Cell(0, 5,"ASESOR DE VENTAS: ".$dato_id['nombre']." ".$dato_id['ap_paterno']." ".$dato_id['ap_materno'],'B',1,"L",true);
                        $pdf->SetTextColor(0,0,0);
                        $pdf->SetFont('Arial', '', 7);
                        $sw=1;
                    }
                   
                    $contador++;
                
                    $pdf->Cell(10, 6, $contador, 'T',0,'C');
                    $pdf->Cell(60, 6, $cliente['nombre_usuario']." ".$cliente['apellidos'], 'T',0);
                    $pdf->Cell(25, 6, $cliente['celular'], 'T',0);
                    $pdf->Cell(40, 6, $cliente['tipo_urbanizacion'], 'T',0);
                    $pdf->SetFont('Arial', 'B');
                    $pdf->Cell(9, 6, "LOTE: ", 'T',0);
                    $pdf->SetFont('Arial', '',7);
                    $pdf->Cell(6, 6, $cliente['lote'], 'T',0);
                    $pdf->SetFont('Arial', 'B');
                    $pdf->Cell(9, 6, "MANZ.: ", 'T',0);
                    $pdf->SetFont('Arial', '',7);
                    $pdf->Cell(6, 6,$cliente['manzano'],'T' ,0);
                    $pdf->Cell(20, 6, $cliente['monto']." Bs.", 'T',0,'C');
                    $pdf->Cell(33, 6, date('d-m-Y', strtotime($cliente['fecha_registro'])), 'T',0,'C');
                    $pdf->Cell(0, 6, date('d-m-Y', strtotime($cliente['fecha_cierre'])), 'T',1,'C');
                                        
                    // $pdf->Ln();
                }
                
            }
            $sw=0;
            $contador=0;
        }

        

        


        
        // Guardar el PDF en una variable
        $pdf_content = $pdf->Output('S','lista'); // 'S' para devolver como string

        // Codificar el contenido en base64 para el uso en un iframe
        $pdf_base64 = base64_encode($pdf_content);

        // Generar la URL de descarga
        $pdf_data_url = 'data:application/pdf;base64,' . $pdf_base64;

        // $cliente_id = "Genetal";
        echo json_encode([
            // 'id_cliente' => $cliente['id_cliente'],
            // 'nombres' => $cliente['nombres'],
            // 'apellidos' => $cliente['apellidos'],
            // 'tipo_urbanizacion' => $cliente['tipo_urbanizacion'],
            // 'fecha_registro' => $cliente['fecha_registro'],
            // 'detalle' => $cliente['detalle'],
            'id_cliente' => "Genetal",
            'pdf_url' => $pdf_data_url
        ]);

        
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error al procesar la solicitud: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
}
