<?php
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$borrar_id = borrar_por_id('producto_eliminado',(int)$_GET['id']);
if($borrar_id){
    $sesion->mensaje("s","El producto fue eliminado definitivamente.");
    redirigir('productos_eliminados.php');
} else {
    $sesion->mensaje("d","La eliminación falló.");
    redirigir('productos_eliminados.php');
}
