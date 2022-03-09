<?php
$titulo_pagina = 'Agregar venta';
require_once('incluye/cargar.php');
pagina_requiere_nivel(3);
$usuario = usuario_actual();
if(isset($_POST['add_sale'])) {
    $campos_requeridos = array('s_id','quantity','price','total', 'date' );
    validar_campos($campos_requeridos);
    if(empty($errores)) {
        $p_id      = $db->escape((int)$_POST['s_id']);
        $s_qty     = $db->escape((int)$_POST['quantity']);
        $s_total   = $db->escape($_POST['total']);
        $date      = $db->escape($_POST['date']);
        $s_date    = crear_fecha();

        $sql  = "INSERT INTO venta (";
        $sql .= " id_usuario,id_producto,cantidad,precio,fecha";
        $sql .= ") VALUES (";
        $sql .= "{$usuario['id']},'{$p_id}','{$s_qty}','{$s_total}','{$date}'";
        $sql .= ")";

        if($db->query($sql)) {
            actualizar_cantidad_producto($s_qty,$p_id);
            $sesion->mensaje('s',"Venta agregada. ");
            redirigir('ventas.php', false);
        } else {
            $sesion->mensaje('d','Lo siento el registro falló.');
            redirigir('agregar_venta.php', false);
        }
    } else {
        $sesion->mensaje("d", $errores);
        redirigir('agregar_venta.php',false);
    }
}
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-6">
        <?php echo mostrar_mensaje($mensaje); ?>
        <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Búsqueda</button>
                    </span>
                    <input autofocus="" type="text" id="sug_input" class="form-control" name="title"  placeholder="Buscar por el nombre del producto">
                </div>
                <div id="result" class="list-group"></div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Agregar venta</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="agregar_venta.php">
                    <table class="table table-bordered">
                        <thead>
                            <th class="text-center"> Producto </th>
                            <th class="text-center"> Precio </th>
                            <th class="text-center"> Cantidad </th>
                            <th class="text-center"> Total </th>
                            <th class="text-center"> Agregado</th>
                            <th class="text-center"> Acciones</th>
                        </thead>
                        <tbody  id="product_info"> </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php'); 