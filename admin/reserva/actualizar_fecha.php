<?php
include ('../../app/config/config.php');
include ('../../app/config/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_informe = $_POST['id_informe'];
    $fecha_fin = $_POST['fecha_fin'];

    // Validar y limpiar datos si es necesario
    $id_informe = filter_var($id_informe, FILTER_SANITIZE_NUMBER_INT);
    $fecha_fin = filter_var($fecha_fin, FILTER_SANITIZE_STRING);

    try {
        $sql = "UPDATE tb_informe SET fecha_cierre = :fecha_cierre WHERE id_informe = :id_informe";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fecha_cierre', $fecha_fin);
        $stmt->bindParam(':id_informe', $id_informe);
        $stmt->execute();


        // Obtener los días restantes después de la actualización
        $sql = "SELECT DATEDIFF(fecha_cierre, fecha_registro) AS dias_restantes FROM tb_informe WHERE id_informe = :id_informe";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_informe', $id_informe);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $dias_restantes = $result['dias_restantes'];

        // echo "Fecha actualizada correctamente.";
        echo json_encode(['message' => 'Fecha actualizada correctamente.', 'dias_restantes' => $dias_restantes]);

    } catch (PDOException $e) {
        echo "Error al actualizar la fecha: " . $e->getMessage();
    }
} else {
    echo "Método no permitido.";
}
?>
