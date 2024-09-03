 <?php
 include('../../app/config/config.php');
 include('../../app/config/conexion.php');
 /*$data = isset($_POST['data']);

 echo print_r($data);*/
 /*if(isset($_POST["data"])) {
    echo "ingresa datos";
    $data = json_decode($_POST['data'],true);
    echo $data;
    $sw = $data['sw'];
    $celular = $data['celular'];


    if($sw==0){
        $detalle = $data['detalle'];
         $sql = $pdo->prepare('UPDATE tb_contactos
         SET celular = :celular,
         detalle =:detalle,
         updated_at = :updated_at
         WHERE(celular = :celular)');
        $sql->bindParam(':celular', $celular);
        $sql->bindParam(':detalle', $detalle);
        $sql->bindParam(':updated_at',$fechayhora);
        $sql->execute();
        $datos = $sql->fetchAll();
        $nroTotal = is_array($datos) ? count($datos) : 0;
        if ($nroTotal > 0) {
        return "success";
        }else{
        return $error;
        }
         }else{
            $sql = $pdo->prepare('UPDATE tb_contactos
                          SET celular = :celular,
                          updated_at = :updated_at
                          WHERE(celular = :celular)');
                   $sql->bindParam(':celular', $celular);
                   $sql->bindParam(':updated_at',$fechayhora);
               $sql->execute();
         }

         $response = [
            'status' => 'success',
            'message' => 'Datos actualizados correctamente'
        ];
        echo json_encode($response);

 }else {
    // Si no se recibe 'data', puedes enviar una respuesta de error
    $response = [
        'status' => 'error',
        'message' => 'No se recibieron datos'
    ];
    echo json_encode($response);
}*/
//$celular = $_POST['celular'];
//$id_usuario = $_POST['id_usuario'];


$json = file_get_contents('php://input');

// Decodifica el JSON a un array asociativo de PHP
$data = json_decode($json, true);

// Verifica si json_decode() falló
if (json_last_error() !== JSON_ERROR_NONE) {
    // Maneja el error
    $response = [
        'status' => 'error',
        'message' => 'Error al decodificar JSON: ' . json_last_error_msg()
    ];
    echo json_encode($response);
    exit;
}

$celular = $data['celular'];
 
 








 ?>
 