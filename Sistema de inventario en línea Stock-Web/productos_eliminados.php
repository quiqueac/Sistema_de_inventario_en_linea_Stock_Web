<?php
$titulo_pagina = 'Lista de productos';
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$productos = unir_tabla_productos();
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-12">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Productos eliminados</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;vertical-align:middle;">#</th>
                            <th class="text-center" style="vertical-align:middle;">Imagen</th>
                            <th class="text-center" style="vertical-align:middle;">Descripción</th>
                            <th class="text-center" style="width: 10%;vertical-align:middle;"> Categoría </th>
                            <th class="text-center" style="width: 10%;vertical-align:middle;"> Cantidad </th>
                            <th class="text-center" style="width: 10%;vertical-align:middle;"> Precio de compra </th>
                            <th class="text-center" style="width: 10%;vertical-align:middle;"> Precio de venta </th>
                            <th class="text-center" style="width: 10%;vertical-align:middle;"> Fecha actualizado </th>
                            <th class="text-center" style="width: 100px;vertical-align:middle;"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto):?>
                        <tr>
                            <td class="text-center" style="vertical-align:middle;"><?php echo contar_id();?></td>
                            <td>
                                <?php if($producto['id_media'] === NULL): ?>
                                <img class="img-avatar img-circle" src="cargas/productos/no_image.jpg" alt="">
                                <?php else: ?>
                                <img class="img-avatar img-circle" src="cargas/productos/<?php echo $producto['imagen']; ?>" alt="">
                                <?php endif; ?>
                            </td>
                            <td class="text-center" style="vertical-align:middle;"> <?php echo remover_basura($producto['nombre']); ?></td>
                            <td class="text-center" style="vertical-align:middle;"> <?php echo remover_basura($producto['categorie']); ?></td>
                            <td class="text-center" style="vertical-align:middle;"> <?php echo remover_basura($producto['cantidad']); ?></td>
                            <td class="text-center" style="vertical-align:middle;"> <?php echo remover_basura($producto['precio_compra']); ?></td>
                            <td class="text-center" style="vertical-align:middle;"> <?php echo remover_basura($producto['precio_venta']); ?></td>
                            <td class="text-center" style="vertical-align:middle;"> <?php echo leer_fecha($producto['fecha_actualizacion']); ?></td>
                            <td class="text-center" style="vertical-align:middle;">
                                <div class="btn-group">
                                    <a href="restaurar_producto.php?id=<?php echo (int)$producto['id'];?>" class="btn btn-info btn-xs"  title="Restaurar" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-repeat"></span>
                                    </a>
                                    <a href="eliminar_producto_definitivamente.php?id=<?php echo (int)$producto['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php');
