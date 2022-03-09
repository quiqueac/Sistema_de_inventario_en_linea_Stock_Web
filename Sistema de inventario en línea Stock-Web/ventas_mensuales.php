<?php
$titulo_pagina = 'Ventas mensuales';
require_once('incluye/cargar.php');
pagina_requiere_nivel(3);
$agno = date('Y');
$mes = date('m');
$ventas = ventasMensuales($agno,$mes);
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
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Ventas mensuales</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle" class="text-center">#</th>
                            <th style="vertical-align: middle" class="text-center"> Descripción </th>
                            <th style="vertical-align: middle" class="text-center"> Cantidad vendida</th>
                            <th style="vertical-align: middle" class="text-center"> Total </th>
                            <th style="vertical-align: middle" class="text-center"> Fecha </th>
                            <th style="vertical-align: middle" class="text-center"> Registró usuario </th>
                       </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventas as $venta):?>
                        <tr>
                            <td class="text-center"><?php echo contar_id();?></td>
                            <td><?php echo remover_basura($venta['nombre']); ?></td>
                            <td class="text-center"><?php echo (int)$venta['cantidad']; ?></td>
                            <td class="text-center"><?php echo remover_basura($venta['total_saleing_price']); ?></td>
                            <td class="text-center"><?php echo date("d/m/Y", strtotime ($venta['date'])); ?></td>
                            <td class="text-center"><?php echo $usuario['username'] ?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
               </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php');
