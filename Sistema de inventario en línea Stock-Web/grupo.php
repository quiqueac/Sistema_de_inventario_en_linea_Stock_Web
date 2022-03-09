<?php
$titulo_pagina = 'Lista de grupos';
require_once('incluye/cargar.php');
pagina_requiere_nivel(1);
$todos_grupos = encontrar_todos('grupo');
include_once('disenos/cabecera.php');
?>
<div class="row">
    <div class="col-md-12">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong style="vertical-align:middle;">
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Grupos</span>
                </strong>
                <a href="agregar_grupo.php" class="btn btn-info pull-right btn-xs"> Agregar grupo</a>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;vertical-align:middle">#</th>
                            <th class="text-center" style="vertical-align:middle">Nombre del grupo</th>
                            <th class="text-center" style="width:20%;vertical-align:middle">Nivel del grupo</th>
                            <th class="text-center" style="width:15%;vertical-align:middle">Estado</th>
                            <th class="text-center" style="width:100px;vertical-align:middle">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($todos_grupos as $grupo): ?>
                        <tr>
                            <td class="text-center" style="vertical-align:middle"><?php echo contar_id();?></td>
                            <td><?php echo remover_basura(ucwords($grupo['nombre']))?></td>
                            <td class="text-center" style="vertical-align:middle">
                                <?php echo remover_basura(ucwords($grupo['nivel']))?>
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <?php if($grupo['estado_actual'] === '1'): ?>
                                <span class="label label-success"><?php echo "Activo"; ?></span>
                                <?php else: ?>
                                <span class="label label-danger"><?php echo "Inactivo"; ?></span>
                                <?php endif;?>
                            </td>
                            <td class="text-center" style="vertical-align:middle">
                                <div class="btn-group">
                                    <a href="editar_grupo.php?id=<?php echo (int)$grupo['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                    <?php if($grupo['nivel'] !== '1'): ?>
                                    <a href="borrar_grupo.php?id=<?php echo (int)$grupo['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
                                        <i class="glyphicon glyphicon-remove"></i>
                                    </a>
                                    <?php endif;?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach;?>
                   </tbody>
               </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php'); 
