<?php
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$producto = encontrar_por_id('producto_eliminado',(int)$_GET['id']);
if(!$producto) {
    $sesion->mensaje("d","Id de producto pérdida.");
    redirigir('productos_eliminados.php');
} else {
    $categoria = $producto['id_categoria'];
    if($categoria == NULL) {
        $categoria = 10;
    }
    $media = $producto['id_media'];
    if($media == NULL) {
        $media = 16;
    }
    $restore_id = restaurar_por_id((int)$producto['id'], $categoria, $media);
    switch ($restore_id) {
        case 0:
            $sesion->mensaje("d","La eliminación falló.");
            redirigir('productos_eliminados.php');
            break;
        case 1:
            $sesion->mensaje("s","El producto fue restaurado.");
            redirigir('producto.php');
            break;
        case 2:
            $sesion->mensaje("d","La eliminación falló.");
            redirigir('productos_eliminados.php');
        case 3:
            $sesion->mensaje("d","Ya hay un producto no eliminado con ese nombre.");
            redirigir('productos_eliminados.php');
            break;
        default:
            break;
    }
}
