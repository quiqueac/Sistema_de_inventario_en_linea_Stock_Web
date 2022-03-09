<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('incluye/cargar.php');

$titulo_productos = $_REQUEST['titulo_productos'];
$categoria_productos = $_REQUEST['categoria_productos'];
$imagen_productos = $_REQUEST['imagen_productos'];
$cantidad_productos = $_REQUEST['cantidad_productos'];
$compra_productos = $_REQUEST['compra_productos'];
$compra_decimal_productos = $_REQUEST['compra_decimal_productos'];
$precio_productos = $_REQUEST['precio_productos'];
$precio_decimal_productos = $_REQUEST['precio_decimal_productos'];
$numero = $_REQUEST['contador_producto'];
$contador_tabla = $_REQUEST['contador_tabla'];
$nombre_imagen_productos = $_REQUEST['nombre_imagen_productos'];
$nombre_categoria_productos = $_REQUEST['nombre_categoria_productos'];

if(isset($nombre_imagen_productos)) {
    for($i = 0; $i < $numero; $i++) {
        $nombre_imagen_productos[$i] = trim($nombre_imagen_productos[$i]);
    }
}

$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");

$mensaje = "";
$titulos_productos_error = "";
$indicador = FALSE;
$indicadores = TRUE;
$resultado = array($numero);
$datos_productos = "";
$numero_recientes = -1;
$arreglo_productos_agregados;

if(isset($_REQUEST['contador_tabla_productos_recientes'])) {
    $numero_recientes = $_REQUEST['contador_tabla_productos_recientes'];
    if(isset($_REQUEST['productos_agregados'])) {  
        $productos_agregados = $_REQUEST['productos_agregados'];
    }
}

if(isset($titulo_productos)) {
    for($contador = 0; $contador < $numero; $contador++) {
        $titulo_producto_filtrado = $titulo_productos[$contador];
        $titulo_producto_filtrado = str_replace($caracteres_malos, $caracteres_buenos, $titulo_producto_filtrado);
        $titulo_producto_filtrado = trim($titulo_producto_filtrado);
        $consulta_titulo_producto = encontrar_nombre_producto($titulo_producto_filtrado);
        foreach ($consulta_titulo_producto as $nombre) {
            $resultado[$contador] = $nombre['nombre'];
            if(isset($resultado[$contador])) {
                $titulos_productos_error = $titulos_productos_error . $resultado[$contador] . ", ";
                $indicador = TRUE;
            }
        }
    }
    if($indicador && $numero == 1) {
        $contar_id = $contador_tabla;
        $titulos_productos_error = substr($titulos_productos_error, 0, -2);
        $mensaje = "<div class='alert alert-warning'><span style='padding-right:5px'>El siguiente nombre de producto ya existe:" . " " . $titulos_productos_error . ".</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        if($numero_recientes != -1) {
            $datos_productos = "<h3 style='padding:10px' class='bg-primary text-center pad-basic no-btm'>Productos recien agregados</h3><div class='panel panel-default'><table class='tabla-resultado-producto table table-bordered table-striped table-hover'><thead><tr><th class='text-center' style='width: 50px;vertical-align:middle;'>#</th><th class='text-center' style='vertical-align:middle;'>Imagen</th><th class='text-center' style='vertical-align:middle;'>Descripción</th><th class='text-center' style='width: 10%;vertical-align:middle;'> Categoría </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Cantidad </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Precio de compra </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Precio de venta </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Agregado </th></thead><tbody>";
            for($j = 0; $j < $numero_recientes; $j++) {
                $c = $j + $contar_id;
                $arreglo_productos_agregados = encontrar_productos($productos_agregados[$j]);
                $datos_productos .= "<tr><td class='text-center' style='vertical-align:middle;'>$c</td>";
                $datos_productos .= "<td><img class='img-avatar img-circle' src='cargas/productos/".$arreglo_productos_agregados['nombre_archivo']."' alt=''></td>";
                $datos_productos .= "<td class='text-center necesario' style='vertical-align:middle;'>".$arreglo_productos_agregados['nombre']."</td>";
                $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['categoria']."</td>";
                $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['cantidad']."</td>";
                $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['precio_compra']."</td>";
                $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['precio_venta']."</td>";
                $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['fecha_actualizacion']."</td></tr>";
            }
            $datos_productos .= "</tbody></table></div>";
        }
    } else if($indicador && $numero != 1) {
        $contar_id = $contador_tabla;
        $titulos_productos_error = substr($titulos_productos_error, 0, -2);
        $mensaje = "<div class='alert alert-warning'><span style='padding-right:5px'>Los siguentes productos ya están creados:" . " " . $titulos_productos_error . ".</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        if($numero_recientes != -1) {
            $datos_productos = "<h3 style='padding:10px' class='bg-primary text-center pad-basic no-btm'>Categorías recien agregadas</h3><div class='panel panel-default'><table class='tabla-resultado-producto table table-bordered table-striped table-hover'><thead><tr><th class='text-center' style='width: 50px;vertical-align:middle;'>#</th><th class='text-center' style='vertical-align:middle;'>Imagen</th><th class='text-center' style='vertical-align:middle;'>Descripción</th><th class='text-center' style='width: 10%;vertical-align:middle;'> Categoría </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Cantidad </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Precio de compra </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Precio de venta </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Agregado </th></thead><tbody>";
            for($j = 0; $j < $numero_recientes; $j++) {
                $c = $j + $contar_id;
                $arreglo_productos_agregados = encontrar_productos($productos_agregados[$j]);
                $datos_productos .= "<tr><td class='text-center' style='vertical-align:middle;'>$c</td>";
                $datos_productos .= "<td><img class='img-avatar img-circle' src='cargas/productos/".$arreglo_productos_agregados['nombre_archivo']."' alt=''></td>";
                $datos_productos .= "<td class='text-center necesario' style='vertical-align:middle;'>".$arreglo_productos_agregados['nombre']."</td>";
                $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['categoria']."</td>";
                $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['cantidad']."</td>";
                $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['precio_compra']."</td>";
                $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['precio_venta']."</td>";
                $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['fecha_actualizacion']."</td></tr>";
            }
            $datos_productos .= "</tbody></table></div>";
        }
    } else if(!$indicador) {
        $nombre_producto = array($numero);
        $cantidad_producto = array($numero);
        $categoria_producto = array($numero);
        $compra_producto = array($numero);
        $venta_producto = array($numero);
        $media_id = array($numero);
        $compra_decimal_producto = array($numero);
        $venta_decimal_producto = array($numero);
        for($contador = 0; $contador < $numero; $contador++) {
            $nombre_producto[$contador] = remover_basura($db->escape($titulo_productos[$contador]));
            $cantidad_producto[$contador] = remover_basura($db->escape($cantidad_productos[$contador]));
            $compra_producto[$contador] = remover_basura($db->escape($compra_productos[$contador]));
            $venta_producto[$contador] = remover_basura($db->escape($precio_productos[$contador]));
            $categoria_producto[$contador] = remover_basura($db->escape($categoria_productos[$contador]));
            $media_id[$contador] = remover_basura($db->escape($imagen_productos[$contador]));
            $compra_decimal_producto[$contador] = remover_basura($db->escape($compra_decimal_productos[$contador]));
            $compra_decimal_producto[$contador] += 0.00;
            $compra_decimal_producto[$contador] /= 100.00;
            $compra_producto[$contador] += $compra_decimal_producto[$contador];
            $compra_producto[$contador] += 0.00;
            $venta_decimal_producto[$contador] = remover_basura($db->escape($precio_decimal_productos[$contador]));
            $venta_decimal_producto[$contador] += 0.00;
            $venta_decimal_producto[$contador] /= 100.00;
            $venta_producto[$contador] += $venta_decimal_producto[$contador];
            $venta_producto[$contador] += 0.00;
            $date = crear_fecha();
            $sql = "INSERT INTO producto (";
            $sql .=" nombre,cantidad,precio_compra,precio_venta,id_categoria,id_media,fecha_actualizacion";
            $sql .=") VALUES (";
            $sql .=" '{$nombre_producto[$contador]}', '{$cantidad_producto[$contador]}', '{$compra_producto[$contador]}', '{$venta_producto[$contador]}', '{$categoria_producto[$contador]}', {$media_id[$contador]}, '{$date}'";
            $sql .=")";
            if($db->query($sql)) {
                $indicadores = FALSE;
            } else {
                $indicadores = TRUE;
            }
        }
        if(!$indicadores) {
            $mensaje = "<div class='alert alert-success'><span style='padding-right:5px'>Los registros fueron agregados exitosamente.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $contar_id = $contador_tabla;
            $datos_productos = "<h3 style='padding:10px' class='bg-primary text-center pad-basic no-btm'>Productos recien agregados</h3><div class='panel panel-default'><table class='tabla-resultado-producto table table-bordered table-striped table-hover'><thead><tr><th class='text-center' style='width: 50px;vertical-align:middle;'>#</th><th class='text-center' style='vertical-align:middle;'>Imagen</th><th class='text-center' style='vertical-align:middle;'>Descripción</th><th class='text-center' style='width: 10%;vertical-align:middle;'> Categoría </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Cantidad </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Precio de compra </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Precio de venta </th><th class='text-center' style='width: 10%;vertical-align:middle;'> Agregado </th></thead><tbody>";
            if($numero_recientes != -1) {
                for($j = 0; $j < $numero_recientes; $j++) {
                    $c = $j + $contar_id;
                    $arreglo_productos_agregados = encontrar_productos($productos_agregados[$j]);
                    $datos_productos .= "<tr><td class='text-center' style='vertical-align:middle;'>$c</td>";
                    $datos_productos .= "<td><img class='img-avatar img-circle' src='cargas/productos/".$arreglo_productos_agregados['nombre_archivo']."' alt=''></td>";
                    $datos_productos .= "<td class='text-center necesario' style='vertical-align:middle;'>".$arreglo_productos_agregados['nombre']."</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['categoria']."</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['cantidad']."</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['precio_compra']."</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['precio_venta']."</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>".$arreglo_productos_agregados['fecha_actualizacion']."</td></tr>";
                }
                for($counter = 0; $counter < $numero; $counter++) {
                    $total = $counter + $contar_id + $numero_recientes;
                    $mostrar_fecha = leer_fecha($date);
                    $datos_productos .= "<tr><td class='text-center' style='vertical-align:middle;'>$total</td>";
                    $datos_productos .= "<td><img class='img-avatar img-circle' src='cargas/productos/$nombre_imagen_productos[$counter]' alt=''></td>";
                    $datos_productos .= "<td class='text-center necesario' style='vertical-align:middle;'>$nombre_producto[$counter]</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>$nombre_categoria_productos[$counter]</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>$cantidad_producto[$counter]</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>$compra_producto[$counter]</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>$venta_producto[$counter]</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>$mostrar_fecha</td></tr>";
                }
            }
            else {
                for($counter = 0; $counter < $numero; $counter++) {
                    $total = $counter + $contar_id;
                    $mostrar_fecha = leer_fecha($date);
                    $datos_productos .= "<tr><td class='text-center' style='vertical-align:middle;'>$total</td>";
                    $datos_productos .= "<td><img class='img-avatar img-circle' src='cargas/productos/$nombre_imagen_productos[$counter]' alt=''></td>";
                    $datos_productos .= "<td class='text-center necesario' style='vertical-align:middle;'>$nombre_producto[$counter]</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>$nombre_categoria_productos[$counter]</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>$cantidad_producto[$counter]</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>$compra_producto[$counter]</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>$venta_producto[$counter]</td>";
                    $datos_productos .= "<td class='text-center' style='vertical-align:middle;'>$mostrar_fecha</td></tr>";
                }
            }
            $datos_productos .= "</tbody></table></div>";
        } else {
            $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>La inserción de registros falló.:" . " " . $titulos_productos_error . "</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }
}

echo $mensaje;
echo $datos_productos;

