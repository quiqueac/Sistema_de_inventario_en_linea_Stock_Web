<?php
$titulo_pagina = 'Lista de usuarios';
require_once('incluye/cargar.php');
pagina_requiere_nivel(1);
$todos_usuarios = encontrar_todos_usuarios();
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
                    <span>Usuarios</span>
                </strong>
                <a href="agregar_usuario.php" class="btn btn-info pull-right btn-xs">Agregar usuario</a>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;vertical-align:middle">#</th>
                            <th class="text-center" style="vertical-align:middle">Nombre </th>
                            <th class="text-center" style="vertical-align:middle">Usuario</th>
                            <th style="vertical-align:middle;" class="text-center" style="width: 15%;">Rol de usuario</th>
                            <th style="vertical-align:middle;" class="text-center" style="width: 10%;">Estado</th>
                            <th class="text-center" style="vertical-align:middle;" style="width: 20%;">Último acceso</th>
                            <th style="vertical-align:middle;" class="text-center" style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($todos_usuarios as $agregar_usuario): ?>
                        <tr>
                            <td class="text-center" style="vertical-align:middle"><?php echo contar_id();?></td>
                            <td class="text-center" style="vertical-align:middle"><?php echo remover_basura(ucwords($agregar_usuario['nombre']))?></td>
                            <td class="text-center" style="vertical-align:middle"><?php echo remover_basura(ucwords($agregar_usuario['username']))?></td>
                            <td class="text-center" style="vertical-align:middle"><?php echo remover_basura(ucwords($agregar_usuario['nombre_grupo']))?></td>
                            <td class="text-center" style="vertical-align:middle">
                                <?php if($agregar_usuario['estado'] === '1'): ?>
                                <span class="label label-success"><?php echo "Activo"; ?></span>
                                <?php else: ?>
                                <span class="label label-danger"><?php echo "Inactivo"; ?></span>
                                <?php endif;?>
                            </td>
                            <td class="text-center" style="vertical-align:middle"><?php echo leer_fecha($agregar_usuario['ultimo_login'])?></td>
                            <td class="text-center" style="vertical-align:middle">
                                <div class="btn-group">
                                    <a href="editar_usuario.php?id=<?php echo (int)$agregar_usuario['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Editar">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                    <?php if($agregar_usuario['id'] !== '1' && $usuario['id'] != $agregar_usuario['id']): ?>
                                    <a href="borrar_usuario.php?id=<?php echo (int)$agregar_usuario['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Eliminar">
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
