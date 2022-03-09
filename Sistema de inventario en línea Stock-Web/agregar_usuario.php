<?php
$titulo_pagina = 'Agregar usuarios';
require_once('incluye/cargar.php');
pagina_requiere_nivel(1);
$grupos = encontrar_todos('grupo');
include_once('disenos/cabecera.php');
echo mostrar_mensaje($mensaje); 
?>
<div class="">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Agregar usuario</span>
           </strong>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
                <div id="resultado"></div>
                <div id="valor"></div>
                <form method="POST" id="formulario">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" autofocus="" type="text" class="form-control" name="nombre" placeholder="Nombre completo" required>
                    </div>
                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input id="usuario" required="" type="text" class="form-control" name="usuario" placeholder="Nombre de usuario">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input id="password" required="" type="password" class="form-control" name="password"  placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <label for="rol">Rol de usuario</label>
                        <select id="rol" class="form-control" name="rol" required="">
                            <?php foreach ($grupos as $grupo ):?>
                            <option value="<?php echo $grupo['nivel'];?>"><?php echo ucwords($grupo['nombre']);?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group clearfix">
                        <button type="submit" name="agregar_usuario" class="btn btn-primary">Guardar</button>
                    </div>
              </form>
            </div>
        </div>
    </div>
</div>
<script src="libs/js/agregar_usuario.js"></script>
<?php include_once('disenos/pie.php'); 
