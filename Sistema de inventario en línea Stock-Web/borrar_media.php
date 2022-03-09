<?php
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$find_media = encontrar_por_id('media',(int)$_GET['id']);
$photo = new Media();
if($photo->destruir_media($find_media['id'],$find_media['nombre_archivo'])) {
    $sesion->mensaje("s","Se ha eliminado la foto.");
    redirigir('media.php');
} else {
    $sesion->mensaje("d","Se ha producido un error en la eliminación de fotografías.");
    redirigir('media.php');
}

