<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('incluye/cargar.php');

$campos_requeridos = array('titulo','categoria','cantidad','compra','precio');
validar_campos($campos_requeridos);
if(empty($errores)){
    $nombre_producto = remover_basura($db->escape($_POST['titulo']));
    $categoria_producto = remover_basura($db->escape($_POST['categoria']));
    $cantidad_producto = remover_basura($db->escape($_POST['cantidad']));
    $compra_producto = remover_basura($db->escape($_POST['compra']));
    $compra_decimal_producto = remover_basura($db->escape($_POST['compra_decimal']));
    $compra_decimal_producto += 0.00;
    $compra_decimal_producto /= 100.00;
    $compra_producto += $compra_decimal_producto;
    $vental_producto = remover_basura($db->escape($_POST['precio']));
    $venta_decimal_producto = remover_basura($db->escape($_POST['precio_decimal']));
    $venta_decimal_producto += 0.00;
    $venta_decimal_producto /= 100.00;
    $vental_producto += $venta_decimal_producto;
    $media_id = remover_basura($db->escape($_POST['foto']));
    $date   = crear_fecha();
    $comprobar = encontrar_nombre_producto($nombre_producto);
    $variable = null;
    foreach($comprobar as $buscar_producto) {
        $variable = $buscar_producto['nombre'];
    }
    if($variable != null) {
        $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>Ya hay un nombre de producto igual.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        $verificacion = -1;
    } else {
        $query  = "INSERT INTO producto (";
        $query .=" nombre,cantidad,precio_compra,precio_venta,id_categoria,id_media,fecha_actualizacion";
        $query .=") VALUES (";
        $query .=" '{$nombre_producto}', '{$cantidad_producto}', '{$compra_producto}', '{$vental_producto}', '{$categoria_producto}', {$media_id}, '{$date}'";
        $query .=")";
        if($db->query($query)){
            $sesion->mensaje('s',"El producto fue agregado exitosamente. ");
            $verificacion = 0;
        } else {
            $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>Ya hay un nombre de producto igual.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $verificacion = -1;
        } 
    }
} else {
    $mensaje = $errores;
    $verificacion = -1;
}
$requisito = "<input type='hidden' id='requisito' value='$verificacion' />";

echo $mensaje;
echo $requisito;
