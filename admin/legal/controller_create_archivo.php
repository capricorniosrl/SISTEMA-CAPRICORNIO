<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileSize = $_FILES['file']['size'];
        $fileType = $_FILES['file']['type'];
        $idComprador = $_POST['id_comprador'];

        // Crear un nombre único para el archivo
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $uniqueFileName = uniqid() .$fileName. '.' . $fileExtension;

        // Definir el directorio de subida y la ruta completa del archivo
        $uploadDir = 'DOCUMENTOS/';
        $uploadFile = $uploadDir . $uniqueFileName;

        // Mover el archivo al directorio de destino
        if (move_uploaded_file($fileTmpPath, $uploadFile)) {
            try {
                
                $matricula = $_POST['matricula'];

                $sql = "INSERT INTO tb_archivo (ruta_archivo, matricula, id_comprador_fk) VALUES (:ruta_archivo, :matricula, :id_comprador_fk)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':ruta_archivo', $uploadFile);
                $stmt->bindParam(':matricula', $matricula);
                $stmt->bindParam(':id_comprador_fk', $idComprador);

                if ($stmt->execute()) {
                    // Respuesta JSON
                    $response = [
                        'fileName' => $uniqueFileName,
                        'fileSize' => $fileSize,
                        'fileType' => $fileType,
                        'idComprador' => $idComprador,
                        'message' => 'Archivo subido y registrado correctamente.'
                    ];
                    echo json_encode($response);
                    $estado_doc=1;
                    $sql_update = $pdo->prepare("UPDATE tb_comprador SET estado_doc_priv=:estado_doc_priv WHERE id_comprador=:id_comprador");

                    $sql_update->bindParam(':estado_doc_priv',$estado_doc);
                    $sql_update->bindParam(':id_comprador',$idComprador);

                    $sql_update->execute();


                    header('location:'.$URL.'/admin/legal/index.php');
                } else {
                    echo json_encode(['error' => 'Error al guardar la información en la base de datos.']);
                }
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['error' => 'No se pudo mover el archivo al directorio de destino.']);
        }
    } else {
        echo json_encode(['error' => 'Error en la carga del archivo.']);
    }
} else {
    echo json_encode(['error' => 'Método de solicitud no permitido.']);
}
?>
