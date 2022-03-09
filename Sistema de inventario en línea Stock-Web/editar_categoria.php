<?php
$titulo_pagina = 'Editar categoría';
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$categoria = encontrar_por_id('categoria',(int)$_GET['id']);
if(!$categoria) {
  $sesion->mensaje("d","Id de categoría perdido.");
  redirigir('categoria.php');
}
if(isset($_POST['editar_categoria'])) {
    $req_field = array('nombre-categoria');
    validar_campos($req_field);
    $cat_name = remover_basura($db->escape($_POST['nombre-categoria']));
    $categorias = encontrar_nombre_categoria($cat_name);
    foreach($categorias as $categoria):
        $nombreCategoria = $categoria['nombre'];
    endforeach;
    $categoriaActual = encontrar_por_id("categoria", $_GET['id']);
    /*
    foreach($categoriaActual as $cat):
        $a = $cat['nombre'];
    endforeach;
    */
    if(empty($errores)) {
        if($cat_name == $nombreCategoria && $cat_name != $categoriaActual['nombre']) {
            $sesion->mensaje("d", "Lo siento, ya hay una categoría con ese nombre.");
            redirigir("editar_categoria.php?id=$_GET[id]",false);
        } else {
            $sql = "UPDATE categoria SET nombre='{$cat_name}'";
            $sql .= " WHERE id='{$categoria['id']}'";
            $resultado = $db->query($sql);
            if($resultado && $db->affected_rows() === 1) {
                $sesion->mensaje("s", "Categoría actualizada.");
                redirigir('categoria.php',false);
            } else {
                $sesion->mensaje("d", "Lo siento, no se pudo actualizar.");
                redirigir("editar_categoria.php?id=$_GET[id]",false);
            }
        }
    } else {
        $sesion->mensaje("d", $errores);
        redirigir("editar_categoria.php?id=$_GET[id]",false);
    }
}
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-12">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Editando <?php echo remover_basura(ucfirst($categoria['nombre']));?></span>
               </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="editar_categoria.php?id=<?php echo (int)$categoria['id'];?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="nombre-categoria" value="<?php echo remover_basura(ucfirst($categoria['nombre']));?>" required="">
                    </div>
                    <button type="submit" name="editar_categoria" class="btn btn-primary">Actualizar categoría</button>
              </form>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php'); 
