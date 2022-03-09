<?php
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$producto = encontrar_por_id('producto',(int)$_GET['id']);
if(!$producto) {
    $sesion->mensaje("d","Id de producto pérdida.");
    redirigir('producto.php');
}
$borrar_id = borrar_por_id('producto',(int)$producto['id']);
if($borrar_id){
    $sesion->mensaje("s","El producto fue eliminado.");
    redirigir('producto.php');
} else {
    $sesion->mensaje("d","La eliminación falló.");
    redirigir('producto.php');
}
