<?php
require_once('incluye/cargar.php');
pagina_requiere_nivel(1);
$borrar_id = borrar_por_id('usuario',(int)$_GET['id']);
if($borrar_id) {
    $sesion->mensaje("s","Usuario eliminado.");
    redirigir('usuarios.php');
} else {
    $sesion->mensaje("d","Se ha producido un error en la eliminación del usuario.");
    redirigir('usuarios.php');
}
