<?php
$titulo_pagina = 'Lista de ventas';
require_once('incluye/cargar.php');
pagina_requiere_nivel(3);
$ventas = encontrar_todas_ventas();
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
                <strong style="vertical-align:middle">
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Todas la ventas</span>
                </strong>
                <div class="pull-right">
                    <a href="agregar_venta.php" class="btn btn-primary btn-xs">Agregar venta</a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="vertical-align:middle" class="text-center">#</th>
                            <th style="vertical-align:middle" class="text-center"> Nombre del producto </th>
                            <th style="vertical-align:middle" class="text-center"> Cantidad</th>
                            <th style="vertical-align:middle" class="text-center"> Total </th>
                            <th style="vertical-align:middle" class="text-center"> Fecha </th>
                            <?php if($usuario['nivel'] == 1): ?>
                            <th style="vertical-align:middle" class="text-center"> Acciones </th>
                            <?php endif; ?>
                            <th style="vertical-align:middle" class="text-center"> Registró usuario </th>
                       </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas as $venta):?>
                        <tr>
                            <td style="vertical-align:middle" class="text-center"><?php echo contar_id();?></td>
                            <td style="vertical-align:middle" class="text-center"><?php echo remover_basura($venta['nombre']); ?></td>
                            <td style="vertical-align:middle" class="text-center"><?php echo (int)$venta['cantidad']; ?></td>
                            <td style="vertical-align:middle" class="text-center"><?php echo remover_basura($venta['precio']); ?></td>
                            <td style="vertical-align:middle" class="text-center"><?php echo $venta['fecha']; ?></td>
                            <?php if($usuario['nivel'] == 1): ?>
                            <td style="vertical-align:middle" class="text-center">
                                <div class="btn-group">
                                    <a href="editar_venta.php?id=<?php echo (int)$venta['id'];?>" class="btn btn-warning btn-xs"  title="Editar" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <a href="borrar_venta.php?id=<?php echo (int)$venta['id'];?>" class="btn btn-danger btn-xs"  title="Borrar" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </div>
                            </td>
                            <?php endif; ?>
                            <?php $usuario_venta = encontrar_por_id("usuario", $venta['id_usuario']) ?>
                            <td style="vertical-align:middle" class="text-center"><?php echo $usuario_venta['username'] ?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php'); 
