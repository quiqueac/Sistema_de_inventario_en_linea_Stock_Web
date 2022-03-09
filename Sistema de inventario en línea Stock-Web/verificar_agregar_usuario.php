<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('incluye/cargar.php');

$campos_requeridos = array('nombre','usuario','password','rol');
validar_campos($campos_requeridos);
if(empty($errores)){
    $nombre = remover_basura($db->escape($_POST['nombre']));
    $nombre_usuario = remover_basura($db->escape($_POST['usuario']));
    $contrasena = remover_basura($db->escape($_POST['password']));
    $rol = (int)$db->escape($_POST['rol']);
    $contrasena = sha1($contrasena);
    $usuarios = encontrar_nombre_usuario($nombre_usuario);
    foreach($usuarios as $usuario):
        $nombreUsuario = $usuario['usuario'];
    endforeach;
    $grupos = encontrar_nivel_grupo($rol);
    foreach($grupos as $grupo):
        $rol = $grupo['id'];
    endforeach;
    $comprobar = encontrar_nombre_usuarios($nombre_usuario);
    if($comprobar != null) {
        $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>Ya hay un nombre de usuario igual.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        $verificacion = -1;
    } else {
        $query = "INSERT INTO usuario (";
        $query .="id_grupo_usuario,nombre,username,contrasena,estado";
        $query .=") VALUES (";
        $query .="$rol, '{$nombre}', '{$nombre_usuario}', '{$contrasena}','1'";
        $query .=")";
        if($db->query($query)) {
            $valores = encontrar_usuario($nombre);
            foreach($valores as $valor):
                $idUsuario = $valor['id'];
            endforeach;
            $query = "INSERT INTO tema_personal (";
            $query .="id_usuario,id_tema";
            $query .=") VALUES (";
            $query .=" '{$idUsuario}' ,'1'";
            $query .=")";
            if($db->query($query)) {
                $sesion->mensaje('s'," La cuenta de usuario ha sido creada.");
                $verificacion = 0;
            }
        } else {
            if(isset($nombreUsuario)) {
                $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>Ya hay un nombre de usuario igual.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $verificacion = -1;
            } else {
                $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>No se pudo crear la cuenta.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $verificacion = -1;
            }
        }
    }
} else {
    $mensaje = $errores;
    $verificacion = -1;
}

$requisito = "<input type='hidden' id='requisito' value='$verificacion' />";

echo $mensaje;
echo $requisito;
