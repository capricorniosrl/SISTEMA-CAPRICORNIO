<?php
include ('../../app/config/config.php');
include ('../../app/config/conexion.php');

if (isset($_POST['usuario_id'])) {
    $usuario_id = $_POST['usuario_id'];

    $query=$pdo->prepare("SELECT * FROM tb_usuarios WHERE id_usuario='$usuario_id'");
    
    $query->execute();

    $usuarios=$query->fetchAll(PDO::FETCH_ASSOC);

    $contador = 0;
    
    foreach ($usuarios as $usuario) {
                                
        $contador++;
    ?>
            <tr>
                <td><?php echo $contador;?></td>
                <td><?php echo $usuario['nombre']." ".$usuario['ap_paterno']." ".$usuario['ap_materno'];?></td>
                <td><?php echo $usuario['celular'] ?></td>
                <td>Su contraseña se restaurará con su número de carnet <h3><span class="badge badge-secondary"> <?php echo $usuario['ci'];?></span></h3></td>
                
                <td>
                    <a href="controller_restablecer.php?id=<?php echo$usuario['id_usuario']?>" type="button" class="btn btn-outline-primary"> <i class="fas fa-sync-alt"></i> RESTABLECER</a>
                </td>
                
            </tr>

    <?php
        
      
    }
}
?>
