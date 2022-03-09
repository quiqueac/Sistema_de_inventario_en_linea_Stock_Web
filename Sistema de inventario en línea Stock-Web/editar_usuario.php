<?php
$titulo_pagina = 'Editar usuario';
require_once('incluye/cargar.php');
pagina_requiere_nivel(1);
$editar_usuario = encontrar_por_id_usuario((int)$_GET['id']);
$grupos  = encontrar_todos('grupo');
if(!$editar_usuario) {
    $sesion->mensaje("d","Id de usuario no encontrado.");
    redirigir('usuarios.php');
}
if(isset($_POST['actualizar'])) {
    $campos_requeridos = array('nombre','usuario','nivel');
    validar_campos($campos_requeridos);
    if(empty($errores)){
        $id = (int)$editar_usuario['id'];
        $nombre = remover_basura($db->escape($_POST['nombre']));
        $nombre_usuario = remover_basura($db->escape($_POST['usuario']));
        $nivel = (int)$db->escape($_POST['nivel']);
        $estado = remover_basura($db->escape($_POST['estado']));
        $niveles_grupos = encontrar_id_grupo_usuario($nivel);
        $comprobar = encontrar_nombre_usuarios($nombre_usuario);
        $usuarioActual = encontrar_por_id("usuario", $_GET['id']);
        if($comprobar != $usuarioActual['username'] && $comprobar != null) {
            $sesion->mensaje('d',"Ya hay un nombre de usuario igual. ");
            redirigir('editar_usuario.php?id='.(int)$editar_usuario['id'], false);
        }
        $sql = "UPDATE usuario SET nombre = '{$nombre}', username = '{$nombre_usuario}', id_grupo_usuario = {$niveles_grupos}, estado = {$estado} WHERE id = {$db->escape($id)}";
        $resultado = $db->query($sql);
        if($resultado && $db->affected_rows() === 1) {
            $sesion->mensaje('s',"Cuenta actualizada. ");
            redirigir('usuarios.php?id='.(int)$editar_usuario['id'], false);
        } else {
            redirigir('usuarios.php', false);
        }
    } else {
        $sesion->mensaje("d", $errores);
        redirigir('editar_usuario.php?id='.(int)$editar_usuario['id'],false);
    }
}
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-12"> <?php echo mostrar_mensaje($mensaje); ?> </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    Actualiza cuenta <?php echo remover_basura(ucwords($editar_usuario['nombre'])); ?>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="editar_usuario.php?id=<?php echo (int)$editar_usuario['id'];?>" class="clearfix">
                    <div class="form-group">
                        <label for="nombre" class="control-label">Nombre(s)</label>
                        <input type="name" required="" class="form-control" name="nombre" value="<?php echo remover_basura(ucwords($editar_usuario['nombre_usuario'])); ?>">
                    </div>
                    <div class="form-group">
                        <label for="usuario" class="control-label">Usuario</label>
                        <?php if($editar_usuario['id'] !== '1' && $editar_usuario['id'] != $usuario['id']): ?>
                        <input type="text" required="" class="form-control" name="usuario" value="<?php echo remover_basura(ucwords($editar_usuario['username'])); ?>">
                        <?php else: ?>
                        <input type="text" required="" disabled class="form-control" name="usuario" value="<?php echo remover_basura(ucwords($editar_usuario['username'])); ?>">
                        <input type="hidden" name="usuario" value="<?php echo remover_basura(ucwords($editar_usuario['username'])); ?>" />
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="nivel">Rol de usuario</label>
                        <?php if($editar_usuario['id'] !== '1' && $editar_usuario['id'] != $usuario['id']): ?>
                        <select class="form-control" name="nivel" required="">
                          <?php foreach($grupos as $grupo ):?>
                            <option 
                            <?php if ($grupo['nivel'] === $editar_usuario['nivel']) {
                                echo 'selected="selected"';
                            }
                            ?> value="<?php echo $grupo['nivel'];?>"><?php echo ucwords($grupo['nombre']);?></option>
                            <?php endforeach;?>
                        </select>
                        <?php else: ?>
                        <?php foreach ($grupos as $grupo):?>
                        <?php if ($grupo['nivel'] === $editar_usuario['nivel']) :?>
                        <input type="hidden" name="nivel" value="<?php echo $grupo['nivel']; ?>" />
                        <?php endif;?>
                        <?php endforeach;?>
                        <select class="form-control" name="nivel" disabled required="">
                          <?php foreach ($grupos as $grupo):?>
                            <option 
                            <?php if ($grupo['nivel'] === $editar_usuario['nivel']) {
                                echo 'selected="selected"';
                            }
                            ?> value="<?php echo $grupo['nivel'];?>"><?php echo ucwords($grupo['nombre']);?></option>
                            <?php endforeach;?>
                        </select>
                        <?php endif;?>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <?php if($editar_usuario['id'] !== '1' && $editar_usuario['id'] != $usuario['id']): ?>
                        <select class="form-control" name="estado" required="">
                            <option <?php if ($editar_usuario['estado'] === '1') {
                                echo 'selected="selected"';
                            }
                            ?>value="1">Activo</option>
                            <option <?php if ($editar_usuario['estado'] === '0') {
                                echo 'selected="selected"';
                            }
                            ?> value="0">Inactivo</option>
                        </select>
                        <?php else: ?>
                        <?php foreach ($grupos as $grupo):?>
                        <?php if ($grupo['nivel'] === $editar_usuario['nivel']) :?>
                        <input type="hidden" name="estado" value="<?php echo $editar_usuario['estado']; ?>" />
                        <?php endif;?>
                        <?php endforeach;?>
                        <select class="form-control" name="estado" disabled="" required="">
                            <option <?php if ($editar_usuario['estado'] === '1') {
                                echo 'selected="selected"';
                            }
                            ?>value="1">Activo</option>
                            <option <?php if ($editar_usuario['estado'] === '0') {
                                echo 'selected="selected"';
                            }
                            ?> value="0">Inactivo</option>
                        </select>
                        <?php endif;?>
                    </div>
                    <div class="form-group clearfix">
                        <button type="submit" name="actualizar" class="btn btn-info">Actualizar</button>
                    </div>
              </form>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php'); 
