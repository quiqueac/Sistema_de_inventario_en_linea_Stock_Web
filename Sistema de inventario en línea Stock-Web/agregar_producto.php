<?php
$titulo_pagina = 'Agregar producto';
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$todas_categorias = encontrar_todos('categoria');
$todas_fotos = encontrar_todos('media');
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
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Agregar producto</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div id="resultado"></div>
                    <div id="valor"></div>
                    <form method="POST" id="formulario" class="clearfix">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                </span>
                                <input id="titulo" autofocus="" type="text" class="form-control" name="titulo" placeholder="Descripción" required="">
                           </div>
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <select id="categoria" class="form-control" name="categoria" required="">
                                        <option value="">Selecciona una categoría</option>
                                        <?php foreach ($todas_categorias as $categoria): ?>
                                        <?php if($categoria['nombre'] != "No hay"): ?>
                                        <option value="<?php echo (int)$categoria['id'] ?>">
                                        <?php echo $categoria['nombre'] ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <select id="foto" class="form-control" name="foto" required="">
                                        <option value=""> Selecciona una imágen </option>
                                        <?php foreach ($todas_fotos as $foto): ?>
                                        <?php if($foto['nombre_archivo'] != "no_image.jpg"): ?>
                                        <option value="<?php echo (int)$foto['id'];?>" >
                                        <?php echo $foto['nombre_archivo'] ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="col-md-5 form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-shopping-cart"></i>
                                        </span>
                                        <input id="cantidad" type="number" min="1" class="form-control" name="cantidad" placeholder="Cantidad" required="">
                                   </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-usd"></i>
                                        </span>
                                        <input id="compra" type="number" min="1" class="form-control" name="compra" placeholder="Precio de compra" required="">
                                    </div>
                                </div>
                                <span style="padding-bottom:10px" class="venta-compra col-xs-12 form-group input-group-addon col-md-1">
                                    <i>.</i>
                                </span>
                                <div class="col-md-2 form-group">
                                    <input id="compra_decimal" type="number" min="0" max="99" class="form-control" name="compra_decimal" placeholder="Decimales" required="" value="0">
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                          <i class="glyphicon glyphicon-usd"></i>
                                        </span>
                                        <input id="precio" type="number" min="1" class="form-control" name="precio" placeholder="Precio de venta" required="">
                                    </div>
                                </div>
                                <span style="padding-bottom:10px" class="venta-decimal col-xs-12 form-group input-group-addon col-md-1">
                                    <i>.</i>
                                </span>
                                <div class="form-group col-md-2">
                                    <input id="precio_decimal" type="number" min="0" max="99" class="form-control" name="precio_decimal" placeholder="Decimales" required="" value="0">
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="agregar_producto" class="btn btn-danger">Agregar producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="libs/js/agregar_producto.js"></script>
<?php include_once('disenos/pie.php'); 
