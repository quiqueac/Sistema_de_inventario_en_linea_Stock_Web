<?php
$titulo_pagina = 'Mi perfil';
require_once('incluye/cargar.php');
pagina_requiere_nivel(3);
$id_usuario = (int)$_GET['id'];
if(empty($id_usuario)):
    redirigir('casa.php',false);
else:
    $user_p = encontrar_por_id('usuario',$id_usuario);
endif;
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel profile">
            <div class="jumbotron text-center bg-red">
                <img class="img-circle img-size-2" src="cargas/usuarios/<?php echo $user_p['imagen'];?>" alt="">
                <h3><?php echo primer_caracter($user_p['nombre']); ?></h3>
            </div>
            <?php if( $user_p['id'] === $usuario['id']):?>
            <ul class="nav nav-pills nav-stacked">
                <li><a href="editar_cuenta.php"> <i class="glyphicon glyphicon-edit"></i> Editar perfil</a></li>
            </ul>
        <?php endif;?>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php'); 
