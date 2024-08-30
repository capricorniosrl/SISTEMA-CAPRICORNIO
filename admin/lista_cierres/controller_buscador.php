<?php
include('../../app/config/config.php');
include('../../app/config/conexion.php');

include('../../layout/admin/session.php');
include('../../layout/admin/datos_session_user.php');
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");
?>
<?php  
//include ('../../layout/admin/parte1.php'); 

$id_comprado=$_GET['variable'];
$sql=$pdo->prepare("SELECT 
  com.id_comprador,
  CASE
    WHEN semi.id_semicontado IS NOT NULL THEN 'semicontado' 
    WHEN cre.id_credito IS NOT NULL THEN 'credito'
    WHEN cont.id_ccontado IS NOT NULL THEN 'contado'
    ELSE 'No encontrado'
  END AS tabla
FROM tb_comprador com
LEFT JOIN tb_semicontado semi ON semi.id_comprador_fk = com.id_comprador
LEFT JOIN tb_credito cre ON cre.id_comprador_fk = com.id_comprador
LEFT JOIN tb_contado cont ON cont.id_comprador_fk = com.id_comprador
WHERE com.id_comprador = :id_comprado
LIMIT 1;");
$sql->bindParam(':id_comprado', $id_comprado);
$sql->execute();

$resultados = $sql->fetchAll(PDO::FETCH_ASSOC);
foreach ($resultados as $datos) {
if($datos['tabla']=="contado"){
$carnet=$_GET['carnet'];
$consulta=$pdo->prepare("SELECT info.lote,info.manzano, info.superficie, info.id_informe, us.id_usuario, com.*, con.* 
    FROM tb_contado con 
    INNER JOIN tb_comprador com 
    INNER JOIN tb_usuarios us 
    INNER JOIN tb_agendas ag 
    INNER JOIN tb_clientes cli 
    INNER JOIN tb_contactos cont 
    INNER JOIN tb_informe info 
    WHERE ((((con.id_comprador_fk=com.id_comprador 
    AND com.ci_1=:carnet AND com.id_usuario_fk=us.id_usuario) 
    AND us.id_usuario=ag.id_usuario_fk) 
    AND info.id_agenda_fk=ag.id_agenda) 
    AND ag.id_cliente_fk=cli.id_cliente) 
    AND (us.id_usuario=cont.id_usuario_fk 
    AND cli.id_contacto_fk=cont.id_contacto) 
    AND (com.celular_1=cont.celular);
");
$consulta->bindParam(':carnet', $carnet);
$consulta->execute();
$resultados_obtenidos = $consulta->fetchAll(PDO::FETCH_ASSOC);
foreach ($resultados_obtenidos as $datos_ulti) {
    if(isset($datos_ulti['id_informe']) && isset($datos_ulti['id_usuario'])){
        $id_informe=$datos_ulti['id_informe'];
        $id_usuario= $datos_ulti['id_usuario'];
        //href="../reporte_cierre/legal.php?id=<?php echo $usuario['id_informe'];&usuario=<?php echo $usuario['id_usuario']; "
        function js_redirect($id_informe,$id_usuario)
{
    echo "<script>window.location.href= '../reporte_cierre/legal.php?id=" . urlencode($id_informe) . "&usuario=" . urlencode($id_usuario) . "';</script>";
   
}

js_redirect($id_informe,$id_usuario); 
    }
}



//http://localhost/capricornio/admin/reporte_cierre/legal.php?id=88&usuario=1

/*function js_redirect($id_comprado)
{
    echo "<script>window.location.href='$url';</script>";
    exit();
}

js_redirect("contado.php");   */
                                    }
else if($datos['tabla']=="semicontado"){

//http://localhost/capricornio/admin/semi-contado/cliente_semicontado.php?variable=71

function js_redirect($id_comprado)
{
    //echo "<script>window.location.href='$url';</script>";
    echo "<script>window.location.href = '../semi-contado/cliente_semicontado.php?variable=' + '$id_comprado'</script>";
    exit();
}
                                        
js_redirect($id_comprado);   

                                    }
else if($datos['tabla']=="credito"){

//http://localhost/capricornio/admin/credito/cliente_credito.php?variable=74

function js_redirect($id_comprado)
{
    echo "<script>window.location.href = '../credito/cliente_credito.php?variable=' + '$id_comprado'</script>";
    exit();
}
                                        
js_redirect($id_comprado);   

                                    }
                                }



/*if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id_comprador = $row['id_comprador'];
        
        $sql_check = "SELECT 
                CASE
                    WHEN c.id_ccontado IS NOT NULL THEN 'tb_contado'
                    WHEN cr.id_credito IS NOT NULL THEN 'tb_credito'
                    WHEN s.id_semicontado IS NOT NULL THEN 'tb_semicontado'
                    ELSE 'No encontrado'
                END AS tabla,
                COALESCE(c.id_ccontado, cr.id_credito, s.id_semicontado) AS id,
                COALESCE(c.id_comprador_fk, cr.id_comprador_fk, s.id_comprador_fk) AS id_comprador
            FROM tb_contado c
            LEFT JOIN tb_credito cr ON c.id_comprador_fk = cr.id_comprador_fk
            LEFT JOIN tb_semicontado s ON c.id_comprador_fk = s.id_comprador_fk
            WHERE c.id_comprador_fk = ? 
               OR cr.id_comprador_fk = ?
               OR s.id_comprador_fk = ?
            LIMIT 1";
        
        $stmt = $conn->prepare($sql_check);
        $stmt->bind_param("iii", $id_comprador, $id_comprador, $id_comprador);
        $stmt->execute();
        $result_check = $stmt->get_result();
        
        if ($result_check->num_rows > 0) {
            $row_check = $result_check->fetch_assoc();
            echo "El id_comprador " . $row_check['id_comprador'] . " se encuentra en la tabla " . $row_check['tabla'] . ".\n";
        } else {
            echo "El id_comprador " . $id_comprador . " no se encuentra en ninguna de las tablas.\n";
        }
        
        $stmt->close();
    }
} else {
    echo "No hay registros en la tabla tb_comprador.";
}*/


?>