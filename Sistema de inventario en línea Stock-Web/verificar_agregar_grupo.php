<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('incluye/cargar.php');

$campos_requeridos = array('nombre_grupo','nivel_grupo');
validar_campos($campos_requeridos);

if(isset($_POST['nombre_grupo']) && isset($_POST['nivel_grupo']) && isset($_POST['estado'])) {
    if(encontrar_por_nombre_grupo($_POST['nombre_grupo']) === false ) {
        $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>El nombre de grupo ya existe.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        $verificacion = -1;
    } elseif(encontrar_por_nivel_grupo($_POST['nivel_grupo']) === false) {
        $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>Este nivel de grupo ya existe.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        $verificacion = -2;
    }
    elseif(empty($errores)) {
        $nombre = remover_basura($db->escape($_POST['nombre_grupo']));
        $nivel = remover_basura($db->escape($_POST['nivel_grupo']));
        $estado = remover_basura($db->escape($_POST['estado']));

        $query  = "INSERT INTO grupo (";
        $query .="nombre,nivel,estado_actual";
        $query .=") VALUES (";
        $query .=" '{$nombre}', '{$nivel}','{$estado}'";
        $query .=")";

        if($db->query($query)) {
            $sesion->mensaje('s',"El grupo ha sido creado.");
            $verificacion = 0;
        } else {
            $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>Lamentablemente no se pudo crear el grupo.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    } else {
        $sesion->mensaje("d", $errores);
    }
}

$requisito = "<input type='hidden' id='requisito' value='$verificacion' />";

echo $mensaje;
echo $requisito;
