<?php
$errores = array();

function real_escape($str){
    global $con;
    $escape = mysqli_real_escape_string($con,$str);
    return $escape;
}

function remover_basura($str) {
    $str = nl2br($str);
    $str = htmlspecialchars(strip_tags($str, ENT_QUOTES));
    return $str;
}

function primer_caracter($str) {
    $val = str_replace('-'," ",$str);
    $val = ucfirst($val);
    return $val;
}

function validar_campos($var) {
    global $errores;
    foreach ($var as $field) {
        $val = remover_basura($_POST[$field]);
        if(isset($val) && $val=='') {
            $errores = $field .". No puede estar en blanco.";
            return $errores;
        }
    }
}

function mostrar_mensaje($mensaje =''){
    $output = array();
    if(!empty($mensaje)) {
        foreach ($mensaje as $key => $value) {
            $output  = "<div class=\"alert alert-{$key}\">";
            $output .= "<a href=\"#\" class=\"close\" data-dismiss=\"alert\">&times;</a>";
            $output .= remover_basura(primer_caracter($value));
            $output .= "</div>";
        }
        return $output;
    } else {
        return "";
    }
}

function redirigir($url, $permanent = false) {
    if (headers_sent() === false) {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }  
    exit();
}

function precio_total($totals) {
    $sum = 0;
    $sub = 0;
    foreach($totals as $total ){
        $sum += $total['total_saleing_price'];
        $sub += $total['total_buying_price'];
        $profit = $sum - $sub;
    }
    return array($sum,$profit);
}

function leer_fecha($str) {
    if ($str) {
        return date('d/m/Y g:i:s a', strtotime($str));
    } else {
        return null;
    }
}

function crear_fecha() {
    date_default_timezone_set('America/Monterrey');
    return strftime("%Y-%m-%d %H:%M:%S", time());
}

function contar_id() {
    static $count = 1;
    return $count++;
}

function contar_ids() {
    static $count = 1;
    return $count++;
}

function randString($length = 5) {
    $str='';
    $cha = "0123456789abcdefghijklmnopqrstuvwxyz";

    for ($x = 0; $x < $length; $x++) {
        $str .= $cha[mt_rand(0, strlen($cha))];
    }
    return $str;
}
