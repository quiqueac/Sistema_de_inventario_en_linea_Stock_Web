<?php
$titulo_pagina = 'Múltiples registros';
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$categorias = encontrar_todos('categoria');
$productos = unir_tabla_producto();
$todas_categorias = $categorias;
$todas_fotos = encontrar_todos('media');
include_once('disenos/cabecera.php'); 
?>
<style>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
    background-color:#fbfbfb;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <span class="glyphicon glyphicon-equalizer"></span>
                <span>Agregar varias categorías</span>
            </div>
            <div class="panel-body" style="margin-top:-20px">
                <div>
                    <h3 style="padding:10px" class="bg-primary text-center pad-basic no-btm">Categorías</h3>
                    <div class="panel panel-default">
                        <table id='tabla_categorias' class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Categorías</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categorias as $categoria):?>
                                <tr>
                                    <td class="text-center"><?php echo contar_id();?></td>
                                    <td><?php echo remover_basura(ucfirst($categoria['nombre'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <form method="POST" id="formulario">
                        <div id="resultadoBusqueda"></div>
                        <div id="resultados"></div>
                        <h3 style="padding:10px" class="bg-primary text-center pad-basic no-btm">Agregar categorías</h3>
                        <table class="table bg-info" id="tabla">
                            <tr class="fila-fija form-group" id="fila">
                                <td><input required="" class="form-control" autofocus="" id="nombre-categoria" type="text" name="nombre_categoria-0" placeholder="Nombre de categoría"/></td>
                                <td class="eliminar"><button style="margin-top:4px" class="boton-menos btn-info" disabled="" type="button" >Menos -</button></td>
                            </tr>
                        </table>
                        <div class="btn-der">
                            <input type="submit" id="agregarCategoria" name="insertar" value="Insertar categoría(s)" class="btn btn-info"/>
                            <button id="adicional" name="adicional_producto" type="button" class="btn btn-warning"> Más + </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 panel-default panel">
            <div class="panel-heading clearfix" style="margin-left:-15px;margin-right:-15px">
                <span class="glyphicon glyphicon-equalizer"></span>
                <span>Agregar varios productos</span>
            </div>
            <div class="panel-body" style="margin-top:-20px;margin-left:-15px;margin-right:-15px">
                <div>
                    <h3 style="padding:10px" class="bg-primary text-center pad-basic no-btm">Productos</h3>
                    <div class="panel panel-default">
                        <table class="table table-bordered table-striped table-hover origen">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;vertical-align:middle;">#</th>
                                    <th class="text-center" style="vertical-align:middle;">Imagen</th>
                                    <th class="text-center" style="vertical-align:middle;">Descripción</th>
                                    <th class="text-center" style="width: 10%;vertical-align:middle;"> Categoría </th>
                                    <th class="text-center" style="width: 10%;vertical-align:middle;"> Cantidad </th>
                                    <th class="text-center" style="width: 10%;vertical-align:middle;"> Precio de compra </th>
                                    <th class="text-center" style="width: 10%;vertical-align:middle;"> Precio de venta </th>
                                    <th class="text-center" style="width: 10%;vertical-align:middle;"> Agregado </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $producto):?>
                                <tr>
                                    <td class="text-center" style="vertical-align:middle;"><?php echo contar_ids();?></td>
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
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <form method="POST" id="formulario-producto">
                        <div id="resultadoBusqueda-productos"></div>
                        <div id="resultados-productos"></div>
                        <h3 style="padding:10px" class="bg-primary text-center pad-basic no-btm">Agregar productos</h3>
                        <div id="contenedor-producto">
                            <div id="contenedor-producto-0" class="form-producto">
                                <div class="form-group titulo-es">
                                    <div class="input-group clase-titulo">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-th-large"></i>
                                        </span>
                                        <input autofocus="" type="text" class="form-control titulo" name="titulo-producto-0" placeholder="Descripción" required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <select class="form-control categoria" name="categoria-0" required="">
                                            <option value="">Selecciona una categoría</option>
                                            <?php  foreach ($todas_categorias as $categoria): ?>
                                            <?php if($categoria['nombre'] != "No hay"): ?>
                                            <option value="<?php echo (int)$categoria['id'] ?>">
                                            <?php echo $categoria['nombre'] ?></option>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <select class="form-control foto" name="product-photo-0" required="">
                                            <option value=""> Selecciona una imágen </option>
                                            <?php foreach ($todas_fotos as $photo): ?>
                                            <?php if($photo['nombre_archivo'] != "no_image.jpg"): ?>
                                            <option value="<?php echo (int)$photo['id'];?>" >
                                            <?php echo $photo['nombre_archivo'];?></option>
                                            <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-shopping-cart"></i>
                                            </span>
                                            <input type="number" min="1" class="form-control cantidad" name="cantidad-0" placeholder="Cantidad" required="">
                                       </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-usd"></i>
                                            </span>
                                            <input type="number" min="1" class="form-control compra" name="compra-0" placeholder="Precio de compra" required="">
                                        </div>
                                    </div>
                                    <span style="padding-bottom:10px;margin-bottom:15px" class="venta-compra col-xs-12 input-group-addon col-md-1">
                                        <i>.</i>
                                    </span>
                                    <div class="form-group col-md-2">
                                        <input type="number" min="0" max="99" class="form-control compra_decimal" name="compra_decimal-0" placeholder="Decimales" required="" value="0">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                              <i class="glyphicon glyphicon-usd"></i>
                                            </span>
                                            <input type="number" min="1" class="form-control precio" name="precio-0" placeholder="Precio de venta" required="">
                                        </div>
                                    </div>
                                    <span style="padding-bottom:10px;margin-bottom:15px" class="venta-decimal col-xs-12 form-group input-group-addon col-md-1">
                                        <i>.</i>
                                    </span>
                                    <div class="form-group col-md-2">
                                        <input type="number" min="0" max="99" class="form-control precio_decimal" name="precio_decimal-0" placeholder="Decimales" required="" value="0">
                                    </div>
                                    <div class="col-xs-2" style="padding-top:3px">
                                        <button class="boton-menos-producto btn-info" id="0" disabled="" type="button" >Menos -</button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div style="padding-top:10px" class="form-group btn-der">
                            <input type="submit" id="agregarProducto" name="insertar-producto" value="Insertar producto(s)" class="btn btn-info"/>
                            <button id="adicional-producto" name="adicional-producto" type="button" class="btn btn-warning"> Más + </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="libs/js/multiples_registros_categorias.js"></script>
    <script src="libs/js/multiples_registros_productos.js"></script>
    <?php include_once('disenos/pie.php');
