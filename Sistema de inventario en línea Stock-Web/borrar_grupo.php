<?php
require_once('incluye/cargar.php');
pagina_requiere_nivel(1);
$borrar_id = borrar_por_id('grupo',(int)$_GET['id']);
if($borrar_id) {
    $sesion->mensaje("s","Grupo eliminado.");
    redirigir('grupo.php');
} else {
    $sesion->mensaje("d","La eliminación falló.");
    redirigir('grupo.php');
}
