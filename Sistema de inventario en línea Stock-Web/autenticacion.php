<?php
include_once('incluye/cargar.php');
$campos_requeridos = array('usuario','password' );
validar_campos($campos_requeridos);
$nombre_usuario = remover_basura($_POST['usuario']);
$contrasena = remover_basura($_POST['password']);

if(empty($errores)) {
    $id_usuario = autenticar($nombre_usuario, $contrasena);
    if($id_usuario > -1) {
        $sesion->login($id_usuario);
        actualizarUltimoLogin($id_usuario);
        $sesion->mensaje("s", "Bienvenido al inventario.");
    } elseif($id_usuario == -1) {
        $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>Usuario incorrecto.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    } elseif($id_usuario == -2) {
        $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>Contraseña incorrecta.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    } elseif($id_usuario == -3) {
        $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>Te encuentras cesado.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    } elseif($id_usuario == -4) {
        $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>Tu grupo se encuentra cesado.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    }
} else {
    $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>$errores.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
}

$requisito = "<input type='hidden' id='requisito' value='$id_usuario' />";

echo $mensaje;
echo $requisito;
