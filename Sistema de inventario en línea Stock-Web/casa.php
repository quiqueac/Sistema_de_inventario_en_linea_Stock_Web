<?php
$titulo_pagina = 'Página principal';
require_once('incluye/cargar.php');
if (!$sesion->estaLogeado(true)) { redirigir('index.php', false);}
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-12">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
    <div class="col-md-12">
        <div class="panel">
            <div class="jumbotron text-center">
                <h1>Esta es su nueva página de inicio</h1>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php'); 
