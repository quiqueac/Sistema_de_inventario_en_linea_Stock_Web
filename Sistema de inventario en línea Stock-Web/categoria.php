<?php
$titulo_pagina = 'Lista de categorías';
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$todas_categorias = encontrar_todos('categoria');
if(isset($_POST['agregar_categoria'])) {
    $campo_requerido = array('nombre-categoria');
    validar_campos($campo_requerido);
    $nombre_categoria = remover_basura($db->escape($_POST['nombre-categoria']));
    if(empty($errores)) {
        $comprobar = encontrar_nombre_categoria($nombre_categoria);
        $variable = null;
        foreach($comprobar as $buscar_categoria) {
            $variable = $buscar_categoria['nombre'];
        }
        if($variable == null) {
            $sql  = "INSERT INTO categoria (nombre)";
            $sql .= " VALUES ('{$nombre_categoria}')";
            if($db->query($sql)){
                $sesion->mensaje("s", "Categoría agregada exitosamente.");
                redirigir('categoria.php',false);
            }
        } else {
            $sesion->mensaje("d", "Lo siento, ya hay una categoría con ese nombre.");
            redirigir('categoria.php',false);
        }
    } else {
        $sesion->mensaje("d", $errores);
        redirigir('categoria.php',false);
    }
}
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-12">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Agregar categoría</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="categoria.php">
                    <div class="form-group">
                        <input autofocus="" type="text" class="form-control" name="nombre-categoria" placeholder="Nombre de la categoría" required>
                    </div>
                    <button type="submit" name="agregar_categoria" class="btn btn-primary">Agregar categoría</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Lista de categorías</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Categorías</th>
                            <th class="text-center" style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todas_categorias as $categoria): ?>
                        <?php if($categoria['nombre'] != "No hay"): ?>
                        <tr>
                            <td class="text-center"><?php echo contar_id();?></td>
                            <td><?php echo remover_basura(ucfirst($categoria['nombre'])); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="editar_categoria.php?id=<?php echo (int)$categoria['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <a href="borrar_categoria.php?id=<?php echo (int)$categoria['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
           </div>
        </div>
    </div>
</div>
</div>
<?php include_once('disenos/pie.php'); 
