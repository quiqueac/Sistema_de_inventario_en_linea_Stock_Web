<?php
$titulo_pagina = 'Reporte de ventas';
$resultados = '';
require_once('incluye/cargar.php');
pagina_requiere_nivel(3);
$usuario = usuario_actual();
if(isset($_POST['submit'])){
    $fechas_requeridas = array('fecha-inicio','fecha-fin');
    validar_campos($fechas_requeridas);
    if(empty($errores)):
        $fecha_inicio = remover_basura($db->escape($_POST['fecha-inicio']));
        $fecha_fin = remover_basura($db->escape($_POST['fecha-fin']));
        $resultados = encontrar_ventas_por_fechas($fecha_inicio,$fecha_fin);
    else:
        $sesion->mensaje("d", $errores);
        redirigir('reporte_ventas.php', false);
    endif;
} elseif(isset($_GET['fecha-inicio'])) {
    $tipo = $_GET['tipo'];
    if(intval($tipo) == 1) {
        $fecha_inicio = $_GET['fecha-inicio'];
        $fecha_fin = $fecha_inicio;
        $resultados = encontrar_ventas_por_fechas($fecha_inicio,$fecha_fin);
    } elseif(intval($tipo) == 2) {
        $fecha_inicio = $_GET['fecha-inicio'];
        $fecha_fin = $_GET['fecha-fin'];
        $resultados = encontrar_ventas_por_fechas($fecha_inicio,$fecha_fin);
    } else {
        $fecha_inicio = $_GET['fecha-inicio'];
        $fecha_fin = $_GET['fecha-fin'];
        $fecha_inicio = remover_basura($fecha_inicio);
        $fecha_fin = remover_basura($fecha_fin);
        $resultados = encontrar_ventas_por_fechas($fecha_inicio,$fecha_fin);
    }
} else {
    $sesion->mensaje("d", "Selecciona fechas.");
    redirigir('reporte_ventas.php', false);
}
?>
<!doctype html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Reporte de ventas</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
        <style>
            @media print {
                html,body {
                    font-size: 9.5pt;
                    margin: 0;
                    padding: 0;
                }.page-break {
                    page-break-before:always;
                    width: auto;
                    margin: auto;
                }
            }
            .page-break {
                width: 980px;
                margin: 0 auto;
            }
            .sale-head {
                margin: 40px 0;
                text-align: center;
            }.sale-head h1,.sale-head strong {
                padding: 10px 20px;
                display: block;
            }.sale-head h1 {
                margin: 0;
                border-bottom: 1px solid #212121;
            }.table>thead:first-child>tr:first-child>th {
                border-top: 1px solid #000;
            }
            table thead tr th {
                text-align: center;
                border: 1px solid #ededed;
            }table tbody tr td {
                vertical-align: middle;
            }.sale-head,table.table thead tr th,table tbody tr td,table tfoot tr td {
                border: 1px solid #212121;
                white-space: nowrap;
            }.sale-head h1,table thead tr th,table tfoot tr td {
                background-color: #f8f8f8;
            }tfoot {
                color:#000;
                text-transform: uppercase;
                font-weight: 500;
            }
        </style>
   </head>
    <body>
        <?php if($resultados): ?>
        <div class="page-break">
            <div class="sale-head pull-right">
                <h1>Reporte de ventas</h1>
                <strong><?php if(isset($fecha_inicio)){ echo $fecha_inicio;}?> a <?php if(isset($fecha_fin)){echo $fecha_fin;}?> </strong>
            </div>
            <table class="table table-border">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Precio de compra</th>
                        <th>Precio de venta</th>
                        <th>Cantidad total</th>
                        <th>TOTAL</th>
                        <th>Registró usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($resultados as $resultado): ?>
                    <tr>
                        <td class=""><?php echo remover_basura($resultado['fecha']);?></td>
                        <td class="desc">
                            <h6><?php echo remover_basura(ucfirst($resultado['nombre']));?></h6>
                        </td>
                        <td class="text-right"><?php echo remover_basura($resultado['precio_compra']);?></td>
                        <td class="text-right"><?php echo remover_basura($resultado['precio_venta']);?></td>
                        <td class="text-right"><?php echo remover_basura($resultado['total_sales']);?></td>
                        <td class="text-right"><?php echo remover_basura($resultado['total_saleing_price']);?></td>
                        <?php $usuario_venta = encontrar_por_id("usuario", $resultado['id_usuario']) ?>
                        <td class="text-center"><?php echo $usuario_venta['username'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="text-right">
                        <td colspan="4"></td>
                        <td colspan="1"> Total </td>
                        <td> $
                            <?php echo number_format(@precio_total($resultados)[0], 2);?>
                        </td>
                    </tr>
                    <tr class="text-right">
                        <td colspan="4"></td>
                        <td colspan="1">Utilidad</td>
                        <td> $<?php echo number_format(@precio_total($resultados)[1], 2);?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php
        /*
        else:
            $sesion->mensaje("d", "No se encontraron ventas. ");
            redirigir('reporte_ventas.php', false); 
        */
        endif;
        ?>
    </body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } 
