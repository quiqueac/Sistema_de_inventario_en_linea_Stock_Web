<?php
$titulo_pagina = 'Editar venta';
require_once('incluye/cargar.php');
pagina_requiere_nivel(3);
$venta = encontrar_por_id('venta',(int)$_GET['id']);
if(!$venta) {
    $sesion->mensaje("d","Id de producto no encontrada.");
    redirigir('ventas.php');
}
$producto = encontrar_por_id('producto_respaldo',$venta['id_producto']);
if(isset($_POST['actualizar_venta'])) {
    $campos_requeridos = array('titulo','cantidad','precio','totales', 'fecha');
    validar_campos($campos_requeridos);
    if(empty($errores)) {
        $id_producto = $db->escape((int)$producto['id']);
        $cantidad_venta = $db->escape((int)$_POST['cantidad']);
        $total_venta = $db->escape($_POST['totales']);
        $fecha = $db->escape($_POST['fecha']);
        $venta_fecha = date("Y-m-d", strtotime($fecha));
        $sql  = "UPDATE venta SET";
        $sql .= " id_producto= '{$id_producto}',cantidad={$cantidad_venta},precio='{$total_venta}',fecha='{$venta_fecha}'";
        $sql .= " WHERE id ='{$venta['id']}'";
        $resultado = $db->query($sql);
        if($resultado && $db->affected_rows() === 1) {
            //actualizar_cantidad_producto($cantidad_venta,$id_producto);
            $sesion->mensaje('s',"Venta actualizada.");
            redirigir('ventas.php', false);
        } else {
            redirigir('ventas.php', false);
        }
    } else {
        $sesion->mensaje("d", $errores);
        redirigir('editar_venta.php?id='.(int)$venta['id'],false);
    }
}
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-6">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong style="vertical-align:middle">
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Editar venta</span>
                </strong>
                <div class="pull-right">
                    <a href="ventas.php" class="btn btn-primary btn-xs">Mostrar todas las ventas</a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <th> Título </th>
                        <th> Cantidad </th>
                        <th> Precio </th>
                        <th> Total </th>
                        <th> Fecha </th>
                        <th> Acción </th>
                    </thead>
                    <tbody  id="product_info">
                        <tr>
                            <form method="POST" action="editar_venta.php?id=<?php echo (int)$venta['id']; ?>">
                                <td id="s_name">
                                    <input type="hidden" name="titulo" value="<?php echo remover_basura($producto['nombre']); ?>" />
                                    <input type="text" disabled="" class="form-control" id="sug_input" name="titulo" value="<?php echo remover_basura($producto['nombre']); ?>">
                                    <div id="result" class="list-group"></div>
                                </td>
                                <td id="s_qty">
                                    <input type="hidden" name="cantidad" value="<?php echo (int)$venta['cantidad']; ?>" />
                                    <input type="number" disabled="" class="form-control" name="cantidad" value="<?php echo (int)$venta['cantidad']; ?>" min="1" max="<?php echo (int)$producto['cantidad']; ?>">
                                </td>
                                <td id="s_price">
                                    <input type="hidden" name="precio" value="<?php echo remover_basura($producto['precio_venta']); ?>" />
                                    <input disabled="" type="text" class="form-control" name="precio" value="<?php echo remover_basura($producto['precio_venta']); ?>" >
                                </td>
                                <td>
                                    <input type="hidden" name="totales" value="<?php echo remover_basura($venta['precio']); ?>" />
                                    <input disabled type="text" class="form-control" name="totales" value="<?php echo remover_basura($venta['precio']); ?>">
                                </td>
                                <td id="s_date">
                                    <input type="text" required="" class="form-control datepicker" name="fecha" data-date-format="" value="<?php echo remover_basura($venta['fecha']); ?>">
                                </td>
                                <td>
                                    <button type="submit" name="actualizar_venta" class="btn btn-primary">Actualizar venta</button>
                                </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php'); 
