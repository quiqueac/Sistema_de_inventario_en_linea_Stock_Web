<?php
require_once('incluye/cargar.php');
if (!$sesion->estaLogeado(true)) { redirigir('index.php', false);}
$html = '';
if(isset($_POST['product_name']) && strlen($_POST['product_name'])) {
    $products = encontrar_producto_por_titulo($_POST['product_name']);
    if($products) {
        foreach ($products as $producto):
            $html .= "<li class=\"list-group-item\">";
            $html .= $producto['nombre'];
            $html .= "</li>";
        endforeach;
    } else {
        $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $html .= 'No encontrado';
        $html .= "</li>";
    }
    echo json_encode($html);
}
if(isset($_POST['p_name']) && strlen($_POST['p_name'])) {
    $product_title = remover_basura($db->escape($_POST['p_name']));
    $results = encontrar_todos_producto_por_titulo($product_title);
    foreach ($results as $resultado) {
        $cantidad = $resultado['cantidad'];
    }
    if($results && $cantidad > 0) {
        foreach ($results as $resultado) {
            $html .= "<tr>";
            $html .= "<td id=\"s_name\">".$resultado['nombre']."</td>";
            $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$resultado['id']}\">";
            $html  .= "<td>";
            $html .= "<input type=\"hidden\" name=\"price\" value=\"{$resultado['precio_venta']}\">";
            $html  .= "<input type=\"number\" disabled min='1' class=\"form-control\" name=\"price\" value=\"{$resultado['precio_venta']}\">";
            $html  .= "</td>";
            $html .= "<td id=\"s_qty\">";
            $html .= "<input type=\"number\" min='1' max=\"{$resultado['cantidad']}\" class=\"form-control\" name=\"quantity\" value=\"1\" required>";
            $html  .= "</td>";
            $html  .= "<td>";
            $html .= "<input type=\"hidden\" name=\"total\" value=\"{$resultado['precio_venta']}\">";
            $html  .= "<input type=\"text\" disabled class=\"form-control\" name=\"total\" value=\"{$resultado['precio_venta']}\">";
            $html  .= "</td>";
            $html  .= "<td>";
            $html  .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\" required>";
            $html  .= "</td>";
            $html  .= "<td>";
            $html  .= "<button type=\"submit\" name=\"add_sale\" class=\"btn btn-primary\">Agregar</button>";
            $html  .= "</td>";
            $html  .= "</tr>";
        }
    } elseif($results && $cantidad == 0) {
        $html ='<tr><td>El producto no cuenta con suficiente inventario.</td></tr>';
    } else {
        $html ='<tr><td>El producto no se encuentra registrado en la base de datos.</td></tr>';
    }
echo json_encode($html);
}
