<?php
$titulo_pagina = 'Cambiar contraseña';
require_once('incluye/cargar.php');
pagina_requiere_nivel(3);
$usuario = usuario_actual();
if(isset($_POST['update'])) {
    $campos_requeridos = array('new-password','old-password','id');
    validar_campos($campos_requeridos);
    if(empty($errores)) {
        if(sha1($_POST['old-password']) !== usuario_actual()['contrasena'] ){
            $sesion->mensaje('d', "Tu antigua contraseña no coincide");
            redirigir('cambiar_contrasena.php',false);
        }
        $id = (int)$_POST['id'];
        $new = remover_basura($db->escape(sha1($_POST['new-password'])));
        $sql = "UPDATE usuario SET contrasena ='{$new}' WHERE id='{$db->escape($id)}'";
        $resultado = $db->query($sql);
        if($resultado && $db->affected_rows() === 1):
          $sesion->cerrarSesion();
          $sesion->mensaje('s',"Inicia sesión con tu nueva contraseña.");
          redirigir('index.php', false);
        else:
          $sesion->mensaje('d',' Lo siento, actualización falló.');
          redirigir('cambiar_contrasena.php', false);
        endif;
    } else {
        $sesion->mensaje("d", $errores);
        redirigir('cambiar_contrasena.php',false);
    }
}
include_once('disenos/cabecera.php'); 
?>
<div class="login-page">
    <div class="text-center">
        <h3>Cambiar contraseña</h3>
    </div>
    <?php echo mostrar_mensaje($mensaje); ?>
    <form method="post" action="cambiar_contrasena.php" class="clearfix">
        <div class="form-group">
            <label for="newPassword" class="control-label">Nueva contraseña</label>
            <input autofocus="" type="password" class="form-control" name="new-password" placeholder="Nueva contraseña" required="">
        </div>
        <div class="form-group">
            <label for="oldPassword" class="control-label">Antigua contraseña</label>
            <input type="password" class="form-control" name="old-password" placeholder="Antigua contraseña" required="">
        </div>
        <div class="form-group clearfix">
            <input type="hidden" name="id" value="<?php echo (int)$usuario['id'];?>">
            <button type="submit" name="update" class="btn btn-info">Cambiar</button>
        </div>
  </form>
</div>
<?php include_once('disenos/pie.php'); 
