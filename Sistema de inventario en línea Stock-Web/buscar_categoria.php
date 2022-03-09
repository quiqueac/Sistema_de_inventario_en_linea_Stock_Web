<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once('incluye/cargar.php');

$categorias = $_REQUEST['categorias'];
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$numero = sizeof($categorias);
$mensaje = "";
$categorias_error = "";
$indicador = FALSE;
$indicadores = TRUE;
$resultado = array($numero);
$datos_categorias = "";
$categorias_recientes;
$numero_recientes = -1;

if(isset($_POST['categorias_recientes'])) {
    $categorias_recientes = $_POST['categorias_recientes'];
}

if(isset($_POST['contador_tabla_recientes'])) {
    $numero_recientes = $_POST['contador_tabla_recientes'];
}

if(isset($categorias)) {
    for($contador = 0; $contador < $numero; $contador++) {
        $categoria_filtrada = $categorias[$contador];
        $categoria_filtrada = str_replace($caracteres_malos, $caracteres_buenos, $categoria_filtrada);
        $categoria_filtrada = trim($categoria_filtrada);
        $consulta_categoria = encontrar_nombre_categoria($categoria_filtrada);
        foreach ($consulta_categoria as $nombre) {
            $resultado[$contador] = $nombre['nombre'];
            if(isset($resultado[$contador])) {
                $categorias_error = $categorias_error . $resultado[$contador] . ", ";
                $indicador = TRUE;
            }
        }
    }
    if($indicador && $numero == 1) {
        $contar_id = $_POST['contador'];
        $categorias_error = substr($categorias_error, 0, -2);
        $mensaje = "<div class='alert alert-warning'><span style='padding-right:5px'>La siguiente categoría ya está utilizada:" . " " . $categorias_error . ".</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        if($numero_recientes != -1) {
            $datos_categorias = "<h3 style='padding:10px' class='bg-primary text-center pad-basic no-btm'>Categorías recien agregadas</h3><div class='panel panel-default'><table id='tabla_categorias_recientes' class='table table-bordered table-striped table-hover'><thead><tr><th class='text-center' style='width: 50px;'>#</th><th>Categorías</th></tr></thead><tbody>";
            for($j = 0; $j < $numero_recientes; $j++) {
                $c = $j + $contar_id;
                $datos_categorias .= "<tr><td class='text-center'>$c</td><td>$categorias_recientes[$j]</td></tr>";
            }
            $datos_categorias .= "</tbody></table></div>";
        }
    } else if($indicador && $numero != 1) {
        $contar_id = $_POST['contador'];
        $categorias_error = substr($categorias_error, 0, -2);
        $mensaje = "<div class='alert alert-warning'><span style='padding-right:5px'>Las siguientes categorías ya están utilizadas:" . " " . $categorias_error . ".</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        if($numero_recientes != -1) {
            $datos_categorias = "<h3 style='padding:10px' class='bg-primary text-center pad-basic no-btm'>Categorías recien agregadas</h3><div class='panel panel-default'><table id='tabla_categorias_recientes' class='table table-bordered table-striped table-hover'><thead><tr><th class='text-center' style='width: 50px;'>#</th><th>Categorías</th></tr></thead><tbody>";
            for($j = 0; $j < $numero_recientes; $j++) {
                $c = $j + $contar_id;
                $datos_categorias .= "<tr><td class='text-center'>$c</td><td>$categorias_recientes[$j]</td></tr>";
            }
            $datos_categorias .= "</tbody></table></div>";
        }
    } else if(!$indicador) {
        $nombre_categoria = array($numero);
        for($contador = 0; $contador < $numero; $contador++) {
            $nombre_categoria[$contador] = remover_basura($db->escape($categorias[$contador]));
            $sql  = "INSERT INTO categoria (nombre)";
            $sql .= " VALUES ('{$nombre_categoria[$contador]}')";
            if($db->query($sql)){
                $indicadores = FALSE;
            } else {
                $indicadores = TRUE;
            }
        }
        if(!$indicadores) {
            $mensaje = "<div class='alert alert-success'><span style='padding-right:5px'>Los registros fueron agregados exitosamente.</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $contar_id = $_POST['contador'];
            $datos_categorias = "<h3 style='padding:10px' class='bg-primary text-center pad-basic no-btm'>Categorías recien agregadas</h3><div class='panel panel-default'><table id='tabla_categorias_recientes' class='table table-bordered table-striped table-hover'><thead><tr><th class='text-center' style='width: 50px;'>#</th><th>Categorías</th></tr></thead><tbody>";
            if($numero_recientes != -1) {
                for($j = 0; $j < $numero_recientes; $j++) {
                    $c = $j + $contar_id;
                    $datos_categorias .= "<tr><td class='text-center'>$c</td><td>$categorias_recientes[$j]</td></tr>";
                }
                $numero += $numero_recientes;
                for($counter = $numero_recientes; $counter < $numero; $counter++) {
                    $total = $counter + $contar_id;
                    $indice = $counter - $numero_recientes;
                    $datos_categorias .= "<tr><td class='text-center'>$total</td><td>$nombre_categoria[$indice]</td></tr>";
                }
            } else  {
                for($counter = 0; $counter < $numero; $counter++) {
                    $total = $counter + $contar_id;
                    $datos_categorias .= "<tr><td class='text-center'>$total</td><td>$nombre_categoria[$counter]</td></tr>";
                }
            }
            $datos_categorias .= "</tbody></table></div>";
        } else {
            $mensaje = "<div class='alert alert-danger'><span style='padding-right:5px'>La inserción de registros falló.:" . " " . $categorias_error . "</span><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }
}

echo $mensaje;
echo $datos_categorias;
