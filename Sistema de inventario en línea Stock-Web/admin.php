<?php
$titulo_pagina = 'Admin página de inicio';
require_once('incluye/cargar.php');
pagina_requiere_nivel(3);
$contar_categoria = contar_por_id('categoria');
$contar_producto = contar_por_id('producto');
$contar_venta = contar_por_id('venta');
$contar_usuario = contar_por_id('usuario');
$productos_vendidos = encontrar_productos_altamente_vendidos('10');
$productos_recientes = encontrar_productos_recientemente_anadidos('5');
$ventas_recientes = encontrar_todas_ventas_agregadas_recientemente('5');
$productos_bajo = encontrar_productos_bajo_stock('10');
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-12">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left bg-green">
                <i class="glyphicon glyphicon-user" style="font-size:20px;margin-left:-5px"></i>
            </div>
            <div class="panel-value pull-right">
                <h2 class="margin-top"><?php  echo $contar_usuario['total']; ?></h2>
                <p class="text-muted">Usuarios</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left bg-red">
                <i class="glyphicon glyphicon-list" style="font-size:20px;margin-left:-5px"></i>
            </div>
            <div class="panel-value pull-right">
                <h2 class="margin-top"> <?php  echo $contar_categoria['total']; ?> </h2>
                <p class="text-muted">Categorías</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left bg-blue">
                <i class="glyphicon glyphicon-shopping-cart" style="font-size:20px;margin-left:-5px"></i>
            </div>
            <div class="panel-value pull-right">
                <h2 class="margin-top"> <?php echo $contar_producto['total']; ?> </h2>
                <p class="text-muted">Productos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left bg-yellow">
                <i class="glyphicon glyphicon-usd" style="font-size:20px;margin-left:-5px"></i>
            </div>
            <div class="panel-value pull-right">
                <h2 class="margin-top"> <?php  echo $contar_venta['total']; ?></h2>
                <p class="text-muted">Ventas</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Productos más vendidos</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th style="vertical-align:middle">Título</th>
                            <th style="vertical-align:middle">Cantidad total</th>
                        <tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos_vendidos as $producto_vendido): ?>
                        <tr>
                            <?php if($usuario['nivel'] == 1 || $usuario['nivel'] == 2): ?>
                            <td><a href="editar_producto.php?id=<?php echo (int)$producto_vendido['id']; ?>"><?php echo remover_basura(primer_caracter($producto_vendido['nombre'])); ?></a></td>
                            <?php else: ?>
                            <td><?php echo remover_basura(primer_caracter($producto_vendido['nombre'])); ?></td>
                            <?php endif; ?>
                            <td><?php echo (int)$producto_vendido['totalQty']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>ÚLTIMAS VENTAS</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:50px;vertical-align:middle;">#</th>
                            <th style="vertical-align:middle;">Producto</th>
                            <th style="vertical-align:middle;width:30%;">Fecha</th>
                            <th style="vertical-align:middle;width:30%;">Venta total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas_recientes as $venta_reciente): ?>
                        <tr>
                            <td class="text-center"><?php echo contar_id();?></td>
                            <td>
                                <?php if($usuario['nivel'] == 1): ?>
                                <a href="editar_venta.php?id=<?php echo (int)$venta_reciente['id']; ?>">
                                    <?php echo remover_basura(primer_caracter($venta_reciente['nombre'])); ?>
                                </a>
                                <?php else: ?>
                                    <?php echo remover_basura(primer_caracter($venta_reciente['nombre'])); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo remover_basura(ucfirst($venta_reciente['fecha'])); ?></td>
                            <td>$<?php echo remover_basura(primer_caracter($venta_reciente['precio'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Productos recientemente añadidos</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <?php foreach ($productos_recientes as $producto_reciente): ?>
                    <a class="list-group-item clearfix" href="editar_producto.php?id=<?php echo (int)$producto_reciente['id'];?>">
                        <h4 class="list-group-item-heading">
                            <?php if($producto_reciente['id_media'] === '0'): ?>
                            <img class="img-avatar img-circle" src="cargas/productos/no_image.jpg" alt="">
                            <?php else: ?>
                            <img class="img-avatar img-circle" src="cargas/productos/<?php echo $producto_reciente['image'];?>" alt="" />
                            <?php endif;?>
                            <?php echo remover_basura(primer_caracter($producto_reciente['nombre']));?>
                            <span class="label label-warning pull-right">
                            $<?php echo (int)$producto_reciente['precio_venta']; ?>
                            </span>
                        </h4>
                        <span class="list-group-item-text pull-right">
                            <?php echo "<span style='margin-right:10px'>".remover_basura(primer_caracter($producto_reciente['categorie']))."</span>"; ?>
                        </span>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php if($contar_producto['total'] > 0): ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Productos con bajo stock</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th style="vertical-align:middle;">Título</th>
                            <th style="vertical-align:middle;">Cantidad</th>
                        <tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos_bajo as $producto): ?>
                        <tr>
                            <?php if($usuario['nivel'] == 1 || $usuario['nivel'] == 2): ?>
                            <td><a href="editar_producto.php?id=<?php echo (int)$producto['id']; ?>"><?php echo remover_basura(primer_caracter($producto['nombre'])); ?></a></td>
                            <?php else: ?>
                            <td><?php echo remover_basura(primer_caracter($producto['nombre'])); ?></td>
                            <?php endif; ?>
                            <td><?php echo (int)$producto['cantidad']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php 
    $reportes = encontrar_tipos_reporte_por_usuario($usuario['id']);
    ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Reportes automáticos</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th style="vertical-align:middle;">Tipo</th>
                            <th style="vertical-align:middle;">Reporte</th>
                        <tr>
                    </thead>
                    <tbody>
                        <?php 
                        function _data_last_month_day() { 
                            $month = date('m');
                            $year = date('Y');
                            $day = date("d", mktime(0,0,0, $month+1, 0, $year));

                            return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
                        }
                        function _data_first_month_day() {
                            $month = date('m');
                            $year = date('Y');
                            return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
                        }
                        ?>
                        <?php foreach ($reportes as $reporte): ?>
                        <tr>
                            <?php 
                            if($reporte['id_reporte'] == 1) {
                                echo "<td> Diario </td>";
                                $fecha_inicio = date('Y-m-d');
                                echo "<td><a href='http://ac13100034.000webhostapp.com/reporte_ventas_proceso.php?fecha-inicio=$fecha_inicio&tipo=1'>Ver</a></td>";
                            } elseif($reporte['id_reporte'] == 2) {
                                echo "<td> Mensual </td>";
                                $fecha_inicio = _data_first_month_day();
                                $fecha_fin = _data_last_month_day();
                                echo "<td><a href='http://ac13100034.000webhostapp.com/reporte_ventas_proceso.php?fecha-inicio=$fecha_inicio&fecha-fin=$fecha_fin&tipo=2'>Ver</a></td>";
                            } else {
                                echo "<td> Por fechas </td>";
                                $resultados = buscarTipoReportes($usuario['id'], 3);
                                foreach($resultados as $resultado):
                                    $id_tipos_reporte = $resultado['id'];
                                endforeach;
                                $rangos = buscarRangoFechas($id_tipos_reporte);
                                foreach($rangos as $rango):
                                    $fecha_inicio = $rango['fecha_inicio'];
                                    $fecha_inicio = substr($fecha_inicio, 0, -9);
                                    $fecha_fin = $rango['fecha_fin'];
                                    $fecha_fin = substr($fecha_fin, 0, -9);
                                endforeach;
                                echo "<td><a href='http://ac13100034.000webhostapp.com/reporte_ventas_proceso.php?fecha-inicio=$fecha_inicio&fecha-fin=$fecha_fin&tipo=2'>Ver</a></td>";
                            }
                            ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php'); 
