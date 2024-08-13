<?php
    include ('../../app/config/config.php');
    include ('../../app/config/conexion.php');

    include ('../../layout/admin/session.php');
    include ('../../layout/admin/datos_session_user.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        
 
        
        // Prepara la declaración SQL para eliminar la función
        $stmt = $pdo->prepare('DELETE FROM tb_funciones WHERE id_funciones = :id_funciones');
        $stmt->bindParam(':id_funciones', $id);
        
        // Ejecuta la declaración
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
