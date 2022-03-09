<?php
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$categoria = encontrar_por_id('categoria',(int)$_GET['id']);
if(!$categoria) {
    $sesion->mensaje("d","Falta id de categoría.");
    redirigir('categoria.php');
}
$borrar_id = borrar_por_id('categoria',(int)$categoria['id']);
if($borrar_id) {
    $sesion->mensaje("s","Categoría eliminada.");
    redirigir('categoria.php');
} else {
    $sesion->mensaje("d","La eliminación falló.");
    redirigir('categoria.php');
}
