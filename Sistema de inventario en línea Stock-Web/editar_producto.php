<?php
$titulo_pagina = 'Editar producto';
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$producto = encontrar_por_id('producto',(int)$_GET['id']);
$todas_categorias = encontrar_todos('categoria');
$todas_foto = encontrar_todos('media');
if(!$producto) {
    $sesion->mensaje("d","Id de producto pérdida.");
    redirigir('producto.php');
}
if(isset($_POST['producto'])) {
    $campos_requeridos = array('titulo_producto','categoria_producto','cantidad_producto','precio_compra', 'precio_venta' );
    validar_campos($campos_requeridos);
    if(empty($errores)) {
        $nombre_producto  = remover_basura($db->escape($_POST['titulo_producto']));
        $categoria_producto = (int)$_POST['categoria_producto'];
        $cantidad_producto = remover_basura($db->escape($_POST['cantidad_producto']));
        $compra_producto = remover_basura($db->escape($_POST['precio_compra']));
        $compra_decimal_producto = remover_basura($db->escape($_POST['compra_decimal']));
        $compra_decimal_producto += 0.00;
        $compra_decimal_producto /= 100.00;
        $compra_producto += $compra_decimal_producto;
        $venta_producto  = remover_basura($db->escape($_POST['precio_venta']));
        $venta_decimal_producto = remover_basura($db->escape($_POST['precio_decimal']));
        $venta_decimal_producto += 0.00;
        $venta_decimal_producto /= 100.00;
        $venta_producto += $venta_decimal_producto;
        $date   = crear_fecha();
        if (is_null($_POST['foto-producto']) || $_POST['foto-producto'] === "") {
            $media_id = "NULL";
        } else {
            $media_id = remover_basura($db->escape($_POST['foto-producto']));
        }
        $comprobar = encontrar_nombre_producto($nombre_producto);
        $variable = null;
        foreach ($comprobar as $buscar_producto) {
            $variable = $buscar_producto['nombre'];
        }
        $productoActual = encontrar_por_id("producto", $_GET['id']);
        if($variable != $productoActual['nombre'] && $variable != null) {
            $sesion->mensaje('d',"Ya hay un nombre de producto igual.");
            redirigir('editar_producto.php?id='.(int)$productoActual['id'], false);
        }
        $query   = "UPDATE producto SET";
        $query  .=" nombre ='{$nombre_producto}', cantidad ='{$cantidad_producto}',";
        $query  .=" precio_compra ='{$compra_producto}', precio_venta ='{$venta_producto}', id_categoria ='{$categoria_producto}',id_media={$media_id},fecha_actualizacion='{$date}'";
        $query  .=" WHERE id ='{$producto['id']}'";
        $resultado = $db->query($query);
        if($resultado && $db->affected_rows() === 1){
            $sesion->mensaje('s',"El producto ha sido actualizado. ");
            redirigir('producto.php', false);
        } else {
            if(isset($variable)) {
                redirigir('producto.php', false);
            } else {
                $sesion->mensaje('d','Ya hay un producto con ese nombre.');
                redirigir('editar_producto.php?id='.$producto['id'], false);
            }
        }
   } else {
        $sesion->mensaje("d", $errores);
        redirigir('editar_producto.php?id='.$producto['id'], false);
   }
}
include_once('disenos/cabecera.php');
?>
<div class="row">
    <div class="col-md-12">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
</div>
<div class="">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Editar producto</span>
        </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-12">
            <form method="POST" action="editar_producto.php?id=<?php echo (int)$producto['id'] ?>">
                <div class="form-group">
                    <label for="titulo_producto">Descripción</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-th-large"></i>
                        </span>
                        <input type="text" class="form-control" name="titulo_producto" value="<?php echo remover_basura($producto['nombre']);?>" required="">
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="categoria">Categoría</label>
                            <select class="form-control" name="categoria_producto" required="">
                                <option value="">Selecciona una categoría</option>
                                <?php foreach ($todas_categorias as $categoria): ?>
                                <?php if($categoria['nombre'] != "No hay"): ?>
                                <option value="<?php echo (int)$categoria['id']; ?>" <?php if($producto['id_categoria'] === $categoria['id']): echo "selected"; endif; ?> >
                                <?php echo remover_basura($categoria['nombre']); ?></option>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="imagen">Imágen</label>
                            <select class="form-control" name="foto-producto">
                                <option value=""> Selecciona una imágen </option>
                                <?php foreach ($todas_foto as $foto): ?>
                                <?php if($foto['nombre_archivo'] != "no_image.jpg"): ?>
                                <option value="<?php echo (int)$foto['id'];?>" <?php if($producto['id_media'] === $foto['id']): echo "selected"; endif; ?> >
                                <?php echo $foto['nombre_archivo'] ?></option>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="cantidad_producto">Cantidad</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>
                                </span>
                                <input type="number" min="0" class="form-control" name="cantidad_producto" value="<?php echo remover_basura($producto['cantidad']); ?>" required="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="precio">Precio de compra</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-usd"></i>
                                </span>
                                <?php 
                                $precio_compra = remover_basura($producto['precio_compra']);
                                $precio_compra_decimal = $precio_compra;
                                $precio_compra = intval($precio_compra);
                                $precio_compra_decimal -= $precio_compra;
                                $precio_compra_decimal *= 100;
                                $precio_compra_decimal = intval($precio_compra_decimal);
                                ?>
                                <input type="number" class="form-control" name="precio_compra" value="<?php echo $precio_compra;?>" required="">
                            </div>
                        </div>
                    </div>
                    <span style="padding-bottom:10px" class="venta-compra col-xs-12 form-group input-group-addon col-md-1">
                        <i>.</i>
                    </span>
                    <div class="form-group col-md-2 clase">
                        <input type="number" min="0" max="99" class="form-control" name="compra_decimal" placeholder="Decimales" required="" value="<?php echo $precio_compra_decimal;?>">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="venta">Precio de venta</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-usd"></i>
                                </span>
                                <?php 
                                $precio_venta = remover_basura($producto['precio_venta']);
                                $precio_venta_decimal = $precio_venta;
                                $precio_venta = intval($precio_venta);
                                $precio_venta_decimal -= $precio_venta;
                                $precio_venta_decimal *= 100;
                                $precio_venta_decimal = intval($precio_venta_decimal);
                                ?>
                                <input type="number" class="form-control" name="precio_venta" value="<?php echo $precio_venta;?>" required="">
                            </div>
                        </div>
                    </div>
                    <span style="padding-bottom:10px" class="venta-decimal form-group col-xs-12 input-group-addon col-md-1">
                        <i>.</i>
                    </span>
                    <div class="col-md-2 form-group clase">
                        <input type="number" min="0" max="99" class="form-control" name="precio_decimal" placeholder="Decimales" required="" value="<?php echo $precio_venta_decimal;?>">
                    </div>
                </div>
                <button type="submit" name="producto" class="btn btn-danger">Actualizar</button>
            </form>
        </div>
      </div>
    </div>
</div>
<script src="libs/js/editar_producto.js"></script>
<?php include_once('disenos/pie.php'); 
