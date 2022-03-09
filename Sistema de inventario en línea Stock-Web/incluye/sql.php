<?php
require_once('incluye/cargar.php');

function encontrar_todos($table) {
    global $db;
    if(tablaExiste($table)) {
        return encontrar_por_sql("SELECT * FROM ".$db->escape($table));
    }
}

function encontrar_por_sql($sql) {
    global $db;
    $resultado = $db->query($sql);
    $result_set = $db->while_loop($resultado);
    return $result_set;
}

function encontrar_por_id($table,$id) {
    global $db;
    $id = (int)$id;
    if(tablaExiste($table)) {
        $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
        if ($resultado = $db->fetch_assoc($sql)) {
            return $resultado;
        } else {
            return null;
        }
    }
}

function encontrar_id_grupo_usuario($nivel_grupo) {
    global $db;
    $sql = $db->query("SELECT * FROM grupo where nivel = $nivel_grupo");
    if ($resultado = $db->fetch_assoc($sql)) {
        return $resultado['id'];
    } else {
        return null;
    }
}

function encontrar_nombre_usuarios($usuario) {
    global $db;
    $sql = $db->query("SELECT * FROM usuario where username = '$usuario'");
    if ($resultado = $db->fetch_assoc($sql)) {
        return $resultado['username'];
    } else {
        return null;
    }
}

function encontrar_productos($nombre) {
    global $db;
    $sql = $db->query("SELECT nombre_archivo, producto.nombre, categoria.nombre as categoria, cantidad, precio_compra, precio_venta, fecha_actualizacion FROM producto RIGHT JOIN media on id_media = media.id RIGHT JOIN categoria on id_categoria = categoria.id where producto.nombre = '$nombre'");
    if ($resultado = $db->fetch_assoc($sql)) {
        return $resultado;
    } else {
        return null;
    }
}

function encontrar_por_id_usuario($id) {
    global $db;
    $id = (int)$id;
    $sql = $db->query("SELECT usuario.id, id_grupo_usuario, usuario.nombre as nombre_usuario, username, contrasena,imagen, imagen_fondo, estado, ultimo_login, grupo.nombre, nivel, estado_actual FROM usuario LEFT JOIN grupo ON id_grupo_usuario = grupo.id WHERE usuario.id='{$db->escape($id)}' LIMIT 1");
    if ($resultado = $db->fetch_assoc($sql)) {
        return $resultado;
    } else {
        return null;
    }
}

function encontrar_por_id_join($table,$tables,$id) {
    global $db;
    $id = (int)$id;
    if(tablaExiste($table)) {
        $sql = $db->query("SELECT * FROM {$db->escape($table)} RIGHT JOIN {$db->escape($tables)} ON tema.ID = tema_personal.ID WHERE ID_USUARIO='{$db->escape($id)}' LIMIT 1");
        if ($resultado = $db->fetch_assoc($sql)) {
            return $resultado;
        } else {
            return null;
        }
    }
}

function borrar_por_id($table,$id) {
    global $db;
    if(tablaExiste($table)) {
        $sql = "DELETE FROM ".$db->escape($table);
        $sql .= " WHERE id=". $db->escape($id);
        $sql .= " LIMIT 1";
        $db->query($sql);
        return ($db->affected_rows() === 1) ? true : false;
    }
}

function restaurar_por_id($id, $categoria, $media) {
    global $db;
    $sql = "SELECT * FROM producto_eliminado WHERE ID=$id";
    $resultado = $db->query($sql);
    if ($db->num_rows($resultado)) {
        $resultados = $resultado->fetch_array(MYSQLI_NUM);
        $sqls = "SELECT * FROM producto WHERE nombre='{$resultados[1]}'";
        $results = $db->query($sqls);
        if ($db->num_rows($results)) {
            return 3;
        }
        $sqlss = "DELETE FROM producto_eliminado WHERE id=$id";
        $db->query($sqlss);
        if($db->affected_rows() === 1) {
            $condicion = FALSE;
            $a5 = $resultados[5];
            if($a5 == NULL) {
                $condicion = TRUE;
            }
            $a6 = $resultados[6];
            if($a6 == NULL) {
                $condicion = TRUE;
            }
            if(!$condicion) {
                $sqlsss = "INSERT INTO producto (nombre,cantidad,precio_compra,precio_venta,id_categoria,id_media,fecha_actualizacion) VALUES ('$resultados[1]','$resultados[2]',$resultados[3],$resultados[4],$resultados[5],$resultados[6],'$resultados[7]')";
                $db->query($sqlsss);
                return ($db->affected_rows() === 1) ? 1 : 3;
            } else {
                $sqlsss = "INSERT INTO producto (nombre,cantidad,precio_compra,precio_venta,id_categoria,id_media,fecha_actualizacion) VALUES ('$resultados[1]','$resultados[2]',$resultados[3],$resultados[4],$categoria,$media,'$resultados[7]')";
                $db->query($sqlsss);
                return ($db->affected_rows() === 1) ? 1 : 3;
            }
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function contar_por_id($table) {
    global $db;
    if(tablaExiste($table)) {
        $sql = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
        $resultado = $db->query($sql);
        return($db->fetch_assoc($resultado));
    }
}

function tablaExiste($table) {
    global $db;
    $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
    if($table_exit) {
        if ($db->num_rows($table_exit) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

function autenticar($usuario='', $contrasena='') {
    global $db;
    $usuario = $db->escape($usuario);
    $contrasena = $db->escape($contrasena);
    $sql = sprintf("SELECT usuario.id,username,contrasena,nivel,estado,estado_actual FROM usuario INNER JOIN grupo ON id_grupo_usuario = grupo.id WHERE username = '$usuario'");
    $resultado = $db->query($sql);
    if($db->num_rows($resultado)) {
        $usuario = $db->fetch_assoc($resultado);
        $password_request = sha1($contrasena);
        if($password_request === $usuario['contrasena'] && $usuario['estado'] == 1 && $usuario['estado_actual'] == 1) {
            return $usuario['id'];
        } elseif($password_request !== $usuario['contrasena']) {
            return -2;
        } elseif($usuario['estado'] != 1) {
            return -3;
        } elseif($usuario['estado_actual'] != 1) {
            return -4;
        }
    }
    return -1;
}

function autenticar_v2($usuario='', $contrasena='') {
    global $db;
    $usuario = $db->escape($usuario);
    $contrasena = $db->escape($contrasena);
    $sql = sprintf("SELECT id,usuario,contrasena,nivel_usuario FROM usuarios WHERE usuario ='%s' LIMIT 1", $usuario);
    $resultado = $db->query($sql);
    if($db->num_rows($resultado)) {
        $usuario = $db->fetch_assoc($resultado);
        $password_request = sha1($contrasena);
        if($password_request === $usuario['contrasena']) {
            return $usuario;
        }
    }
    return false;
}

function usuario_actual() {
    static $usuario_actual;
    global $db;
    if(!$usuario_actual) {
        if(isset($_SESSION['user_id'])):
            $id_usuario = intval($_SESSION['user_id']);
            $usuario_actual = encontrar_por_id_usuario($id_usuario);
        endif;
    }
    return $usuario_actual;
}

function tema() {
    static $tema_actual;
    global $db;
    if(!$tema_actual) {
        if(isset($_SESSION['user_id'])):
            $id_usuario = intval($_SESSION['user_id']);
            $tema_actual = encontrar_por_id_join('tema','tema_personal',$id_usuario);
        endif;
    }
    return $tema_actual;
}

function empresa() {
    $empresas = encontrar_por_id('empresa', 1);
    return $empresas;
}

function updateLema($mensaje) {
    global $db;
    $sql = "UPDATE empresa SET lema='{$mensaje}' WHERE id ='1' LIMIT 1";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
}

function encontrar_todos_usuarios() {
    global $db;
    $results = array();
    $sql = "SELECT usuario.id,usuario.nombre,username,estado,ultimo_login,";
    $sql .="nivel,grupo.nombre as nombre_grupo ";
    $sql .="FROM usuario ";
    $sql .="LEFT JOIN grupo ";
    $sql .="ON grupo.id = id_grupo_usuario ORDER BY nombre ASC";
    $resultado = encontrar_por_sql($sql);
    return $resultado;
}

function encontrar_usuario($nombre) {
    global $db;
    $sql = "SELECT *";
    $sql .=" FROM usuario ";
    $sql .="WHERE nombre = '$nombre'";
    $resultado = encontrar_por_sql($sql);
    return $resultado;
}

function encontrar_nombre_usuario($nombre) {
    global $db;
    $sql = "SELECT *";
    $sql .=" FROM usuario ";
    $sql .="WHERE username = '$nombre'";
    $resultado = encontrar_por_sql($sql);
    return $resultado;
}

function encontrar_nombre_grupo($nombre) {
    global $db;
    $sql = "SELECT *";
    $sql .=" FROM grupo ";
    $sql .="WHERE nombre = '$nombre'";
    $resultado = encontrar_por_sql($sql);
    return $resultado;
}

function encontrar_nombre_categoria($nombre) {
    global $db;
    $sql = "SELECT *";
    $sql .=" FROM categoria ";
    $sql .="WHERE nombre = '$nombre'";
    $resultado = encontrar_por_sql($sql);
    return $resultado;
}

function encontrar_nombre_producto($nombre) {
    global $db;
    $sql = "SELECT *";
    $sql .=" FROM producto ";
    $sql .="WHERE nombre = '$nombre'";
    $resultado = encontrar_por_sql($sql);
    return $resultado;
}

function encontrar_nivel_grupo($nivel) {
    global $db;
    $sql = "SELECT *";
    $sql .=" FROM grupo ";
    $sql .="WHERE nivel = $nivel";
    $resultado = encontrar_por_sql($sql);
    return $resultado;
}

function actualizarUltimoLogin($id_usuario) {
    global $db;
    $date = crear_fecha();
    $sql = "UPDATE usuario SET ultimo_login='{$date}' WHERE id ='{$id_usuario}' LIMIT 1";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
}

function updateImagenFondo($id_usuario) {
    global $db;
    $sql = "UPDATE usuario SET imagen_fondo='' WHERE id ='{$id_usuario}' LIMIT 1";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
}

function updateLogo() {
    global $db;
    $sql = "UPDATE empresa SET logo='' WHERE id =1 LIMIT 1";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
}

function updateTema($idUsuario, $idTema) {
    global $db;
    $sql = "UPDATE tema_personal SET id_tema=$idTema WHERE id_usuario=$idUsuario LIMIT 1";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
}

function buscarTipoReporte($id_usuario, $id_reporte) {
    global $db;
    $sql = "SELECT * FROM reporte_usuario WHERE id_usuario = $id_usuario AND id_reporte = $id_reporte";
    $resultado = $db->query($sql);
    return($db->num_rows($resultado) === 1 ? true : false);
}

function buscarTipoReportes($id_usuario, $id_reporte) {
    $sql = "SELECT * FROM reporte_usuario WHERE id_usuario = $id_usuario AND id_reporte = $id_reporte";
    $resultado = encontrar_por_sql($sql);
    return $resultado;
}

function buscarRangoFechas ($id_tipos_reporte) {
    $sql = "SELECT * FROM rango_fecha WHERE id_tipos_reporte = $id_tipos_reporte";
    $resultado = encontrar_por_sql($sql);
    return $resultado;
}

function insertarRangoFecha($id_tipos_reporte, $fecha_inicio, $fecha_fin) {
    global $db;
    $sql = "INSERT INTO rango_fecha (id_tipos_reporte,fecha_inicio,fecha_fin) VALUES ($id_tipos_reporte, '$fecha_inicio', '$fecha_fin')";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
}

function insertarTipoReporte($id_usuario, $id_reporte) {
    global $db;
    $sql = "INSERT INTO reporte_usuario (id_usuario,id_reporte) VALUES ($id_usuario, $id_reporte)";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
}

function borrarTipoReporte($id_usuario, $id_reporte) {
    global $db;
    $sql = "DELETE FROM reporte_usuario WHERE id_usuario = $id_usuario AND id_reporte = $id_reporte";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
}

function borrarRangoFecha($id_tipos_reporte) {
    global $db;
    $sql = "DELETE FROM rango_fecha WHERE id_tipos_reporte = $id_tipos_reporte";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
}

function updateImagen($id_usuario) {
    global $db;
    $sql = "UPDATE usuario SET imagen='no_image.jpg' WHERE id ='{$id_usuario}' LIMIT 1";
    $resultado = $db->query($sql);
    return ($resultado && $db->affected_rows() === 1 ? true : false);
}

function encontrar_por_nombre_grupo($val) {
    global $db;
    $sql = "SELECT nombre FROM grupo WHERE nombre = '{$db->escape($val)}' LIMIT 1 ";
    $resultado = $db->query($sql);
    return($db->num_rows($resultado) === 0 ? true : false);
}

function encontrar_por_nivel_grupo($nivel) {
    global $db;
    $sql = "SELECT nivel FROM grupo WHERE nivel = '{$db->escape($nivel)}' LIMIT 1 ";
    $resultado = $db->query($sql);
    return($db->num_rows($resultado) === 0 ? true : false);
}

function pagina_requiere_nivel($nivel_requerido) {
    global $sesion;
    $usuario_actual = usuario_actual();
    $nivel_login = encontrar_por_nivel_grupo($usuario_actual['nivel']);
    if (!$sesion->estaLogeado(true)):
        $sesion->mensaje('d','Por favor iniciar sesión...');
        redirigir('index.php', false);
    elseif($nivel_login['estado_grupo'] === '0'):
        $sesion->mensaje('d','Este nivel de usuario esta inactivo!');
        redirigir('casa.php',false);
    elseif($usuario_actual['nivel'] <= (int)$nivel_requerido):
        return true;
    else:
        $sesion->mensaje("d", "¡Lo siento! no tienes permiso para ver la página.");
        redirigir('casa.php', false);
    endif;
}

function unir_tabla_producto() {
    global $db;
    $sql  =" SELECT p.id,p.nombre,p.cantidad,p.precio_compra,p.precio_venta,p.id_media,p.fecha_actualizacion,c.nombre";
    $sql  .=" AS categorie,m.nombre_archivo AS imagen";
    $sql  .=" FROM producto p";
    $sql  .=" LEFT JOIN categoria c ON c.id = p.id_categoria";
    $sql  .=" LEFT JOIN media m ON m.id = p.id_media";
    $sql  .=" ORDER BY p.id ASC";
    return encontrar_por_sql($sql);
}

function unir_tabla_productos() {
    global $db;
    $sql  =" SELECT p.id,p.nombre,p.cantidad,p.precio_compra,p.precio_venta,p.id_media,p.fecha_actualizacion,c.nombre";
    $sql  .=" AS categorie,m.nombre_archivo AS imagen";
    $sql  .=" FROM producto_eliminado p";
    $sql  .=" LEFT JOIN categoria c ON c.id = p.id_categoria";
    $sql  .=" LEFT JOIN media m ON m.id = p.id_media";
    $sql  .=" ORDER BY p.id ASC";
    return encontrar_por_sql($sql);
}

function encontrar_producto_por_titulo($product_name){
    global $db;
    $p_name = remover_basura($db->escape($product_name));
    $sql = "SELECT nombre FROM producto WHERE nombre like '%$p_name%' LIMIT 5";
    $resultado = encontrar_por_sql($sql);
    return $resultado;
}

function encontrar_todos_producto_por_titulo($title){
    global $db;
    $sql  = "SELECT * FROM producto ";
    $sql .= " WHERE nombre ='{$title}'";
    $sql .=" LIMIT 1";
    return encontrar_por_sql($sql);
}

function actualizar_cantidad_producto($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE producto SET cantidad=cantidad -'{$qty}' WHERE id = '{$id}'";
    $resultado = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);
}

function actualizar_id_categoria_producto($id){
    global $db;
    $id = (int)$id;
    $sql = "UPDATE producto_eliminado SET id_categoria = 10 WHERE id = '{$id}'";
    $resultado = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);
}

function actualizar_id_media_producto($id){
    global $db;
    $id = (int)$id;
    $sql = "UPDATE producto_eliminado SET id_media = 3 WHERE id = '{$id}'";
    $resultado = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);
}

function encontrar_productos_recientemente_anadidos($limite){
    global $db;
    $sql   = " SELECT p.id,p.nombre,p.precio_venta,p.id_media,c.nombre AS categorie,";
    $sql  .= "m.nombre_archivo AS image FROM producto p";
    $sql  .= " LEFT JOIN categoria c ON c.id = p.id_categoria";
    $sql  .= " LEFT JOIN media m ON m.id = p.id_media";
    $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limite);
    return encontrar_por_sql($sql);
}

function encontrar_productos_altamente_vendidos($limite){
    global $db;
    $sql  = "SELECT p.nombre, p.id, COUNT(s.id_producto) AS totalSold, SUM(s.cantidad) AS totalQty";
    $sql .= " FROM venta s";
    $sql .= " INNER JOIN producto p ON p.id = s.id_producto ";
    $sql .= " GROUP BY s.id_producto";
    $sql .= " ORDER BY SUM(s.cantidad) DESC LIMIT ".$db->escape((int)$limite);
    return $db->query($sql);
}

function encontrar_todas_ventas(){
    global $db;
    $sql  = "SELECT s.id,s.cantidad,s.precio,s.fecha,p.nombre,s.id_usuario";
    $sql .= " FROM venta s";
    $sql .= " LEFT JOIN producto_respaldo p ON s.id_producto = p.id";
    $sql .= " ORDER BY s.fecha DESC";
    return encontrar_por_sql($sql);
 }

function encontrar_todas_ventas_agregadas_recientemente($limite){
    global $db;
    $sql  = "SELECT s.id,s.cantidad,s.precio,s.fecha,p.nombre";
    $sql .= " FROM venta s";
    $sql .= " LEFT JOIN producto_respaldo p ON s.id_producto = p.id";
    $sql .= " ORDER BY s.fecha DESC LIMIT ".$db->escape((int)$limite);
    return encontrar_por_sql($sql);
}

function encontrar_tipos_reporte_por_usuario($id_usuario) {
    global $db;
    $sql  = "SELECT *";
    $sql .= " FROM reporte_usuario";
    $sql .= " WHERE id_usuario = ".$db->escape((int)$id_usuario);
    return encontrar_por_sql($sql);
}

function encontrar_productos_bajo_stock($limite) {
    global $db;
    $sql  = "SELECT nombre, cantidad, id";
    $sql .= " FROM producto";
    $sql .= " WHERE cantidad <= ".$db->escape((int)$limite);
    return encontrar_por_sql($sql);
}

function encontrar_ventas_por_fechas($start_date,$end_date){
    global $db;
    $start_date  = date("Y-m-d", strtotime($start_date));
    $end_date    = date("Y-m-d", strtotime($end_date));
    $sql  = "SELECT s.fecha, p.nombre,p.precio_venta,p.precio_compra,s.id_usuario,";
    $sql .= "COUNT(s.id_producto) AS total_records,";
    $sql .= "SUM(s.cantidad) AS total_sales,";
    $sql .= "SUM(p.precio_venta * s.cantidad) AS total_saleing_price,";
    $sql .= "SUM(p.precio_compra * s.cantidad) AS total_buying_price ";
    $sql .= "FROM venta s ";
    $sql .= "LEFT JOIN producto_respaldo p ON s.id_producto = p.id";
    $sql .= " WHERE s.fecha BETWEEN '{$start_date}' AND '{$end_date}'";
    $sql .= " GROUP BY DATE(s.fecha),p.nombre";
    $sql .= " ORDER BY DATE(s.fecha) DESC";
    return $db->query($sql);
}

function  ventasDiarias($year,$month,$day){
    global $db;
    $sql  = "SELECT s.cantidad,";
    $sql .= " DATE_FORMAT(s.fecha, '%Y-%m-%e') AS date,p.nombre,";
    $sql .= "SUM(p.precio_venta * s.cantidad) AS total_saleing_price";
    $sql .= " FROM venta s";
    $sql .= " LEFT JOIN producto_respaldo p ON s.id_producto = p.id";
    $sql .= " WHERE DATE_FORMAT(s.fecha, '%Y-%m-%e' ) = '{$year}-{$month}-{$day}'";
    $sql .= " GROUP BY DATE_FORMAT( s.fecha,  '%e' ),s.id_producto";
    return encontrar_por_sql($sql);
}

function  ventasMensuales($year,$month){
    global $db;
    $sql  = "SELECT s.cantidad,";
    $sql .= " DATE_FORMAT(s.fecha, '%Y-%m-%e') AS date,p.nombre,";
    $sql .= "SUM(p.precio_venta * s.cantidad) AS total_saleing_price";
    $sql .= " FROM venta s";
    $sql .= " LEFT JOIN producto_respaldo p ON s.id_producto = p.id";
    $sql .= " WHERE DATE_FORMAT(s.fecha, '%Y-%m' ) = '{$year}-{$month}'";
    $sql .= " GROUP BY DATE_FORMAT( s.fecha,  '%e' ),s.id_producto";
    return encontrar_por_sql($sql);
}
