<?php
$titulo_pagina = 'Editar grupo';
require_once('incluye/cargar.php');
pagina_requiere_nivel(1);
$editar_grupo = encontrar_por_id('grupo',(int)$_GET['id']);
if(isset($_POST['actualizar'])){
    $campos_requeridos = array('nombre-grupo','nivel-grupo');
    validar_campos($campos_requeridos);
    if(empty($errores)) {
        $nombre = remover_basura($db->escape($_POST['nombre-grupo']));
        $nivelIngresado = remover_basura($db->escape($_POST['nivel-grupo']));
        $estado = remover_basura($db->escape($_POST['estado']));
        $grupos = encontrar_nombre_grupo($nombre);
        foreach($grupos as $grupo):
            $nombreGrupo = $grupo['nombre'];
        endforeach;
        $niveles = encontrar_nivel_grupo($nivelIngresado);
        foreach($niveles as $nivel):
            $nivelGrupo = $nivel['nivel'];
        endforeach;
        $grupoActual = encontrar_por_id("grupo", $_GET['id']);
        $condicionA = false;
        $condicionB = false;
        if(isset($nombreGrupo)) {
            if($nombreGrupo != $grupoActual['nombre']) {
                $sesion->mensaje('d',' Ese nombre de grupo ya existe.  ');
                redirigir("editar_grupo.php?id=$_GET[id]", false);
            } else {
                $condicionA = true;
            }
        }
        if(isset($nivelGrupo)) {
            if($nivelGrupo != $grupoActual['nivel']) {
                $sesion->mensaje('d',' Ese nivel de grupo ya existe.  ');
                redirigir("editar_grupo.php?id=$_GET[id]", false);
            } else {
                $condicionB = true;
            }
        }
        $condicionC = false;
        if(isset($estado)) {
            if($estado == $grupoActual['estado_actual']) {
                $condicionC = true;
            }
        }
        $query  = "UPDATE grupo SET ";
        $query .= "nombre='{$nombre}',nivel=$nivelIngresado,estado_actual='{$estado}' ";
        $query .= "WHERE ID='{$db->escape($editar_grupo['id'])}'";
        $resultado = $db->query($query);
        if($resultado && $db->affected_rows() === 1 /*&& (!$condicionA || !$condicionB || !$condicionC)*/){
            $sesion->mensaje('s',"El grupo se ha actualizado.");
            redirigir('grupo.php?id='.(int)$editar_grupo['id'], false);
        } elseif(!$condicionA || !$condicionB) {
            $sesion->mensaje('d','Lamentablemente no se ha actualizado el grupo.');
            redirigir('editar_grupo.php?id='.(int)$editar_grupo['id'], false);
        } else {
            redirigir('grupo.php?id='.(int)$editar_grupo['id'], false);
        }
    } else {
        $sesion->mensaje("d", $errores);
        redirigir('editar_grupo.php?id='.(int)$editar_grupo['id'], false);
    }
}
include_once('disenos/cabecera.php'); 
?>
<div class="login-page" style='margin-top:-2px'>
    <div class="text-center">
        <h3>Editar grupo</h3>
    </div>
    <?php echo mostrar_mensaje($mensaje); ?>
    <form method="post" action="editar_grupo.php?id=<?php echo (int)$editar_grupo['id'];?>" class="clearfix">
        <div class="form-group">
            <label for="name" class="control-label">Nombre del grupo</label>
            <input type="name" class="form-control" name="nombre-grupo" required="" value="<?php echo remover_basura(ucwords($editar_grupo['nombre'])); ?>">
        </div>
        <div class="form-group">
            <label for="level" class="control-label">Nivel del grupo</label>
            <input type="hidden" name="nivel-grupo" value="<?php echo (int)$editar_grupo['nivel']; ?>" />
            <?php if($editar_grupo['nivel'] !== '1'): ?>
            <input type="number" min="1" max="3" required="" class="form-control" name="nivel-grupo" value="<?php echo (int)$editar_grupo['nivel']; ?>">
            <?php else: ?>
            <input type="number" disabled min="1" max="3" class="form-control" name="nivel-grupo" value="<?php echo (int)$editar_grupo['nivel']; ?>">
            <?php endif;?>
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="hidden" name="estado" value="<?php echo (int)$editar_grupo['estado_actual']; ?>" />
            <?php if($editar_grupo['estado_actual'] !== '1' || $editar_grupo['nivel'] !== '1'): ?>
            <select class="form-control" name="estado" required="">
            <?php else: ?>
            <select disabled class="form-control" name="estado">
            <?php endif;?>
                <option <?php if ($editar_grupo['estado_actual'] === '1') {
                    echo 'selected="selected"';
                }
                ?> value="1"> Activo </option>
                <option <?php if ($editar_grupo['estado_actual'] === '0') {
                    echo 'selected="selected"';
                }
                ?> value="0">Inactivo</option>
            </select>
        </div>
        <div class="form-group clearfix">
            <button type="submit" name="actualizar" class="btn btn-info">Actualizar</button>
        </div>
    </form>
</div>
<?php include_once('disenos/pie.php'); 
