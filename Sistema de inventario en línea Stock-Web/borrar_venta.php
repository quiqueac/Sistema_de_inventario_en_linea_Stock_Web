<?php
require_once('incluye/cargar.php');
pagina_requiere_nivel(3);
$borrar_venta = encontrar_por_id('venta',(int)$_GET['id']);
if(!$borrar_venta) {
    $sesion->mensaje("d","ID vacío.");
    redirigir('ventas.php');
}
$borrar_id = borrar_por_id('venta',(int)$borrar_venta['id']);
if($borrar_id) {
    $sesion->mensaje("s","Venta eliminada.");
    redirigir('ventas.php');
} else {
    $sesion->mensaje("d","La eliminación falló.");
    redirigir('ventas.php');
}
