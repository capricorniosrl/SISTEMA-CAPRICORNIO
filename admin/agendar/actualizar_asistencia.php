<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

header('Content-Type: application/json');

$id = $_POST['id'];
$asistio = $_POST['asistio'];

try {
    $query = "UPDATE tb_agendas SET asistio = :asistio WHERE id_agenda = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':asistio', $asistio, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $e->getMessage()]);
}
?>
