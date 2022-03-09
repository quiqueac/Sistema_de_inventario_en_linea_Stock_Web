<?php
$titulo_pagina = 'Agregar grupo';
require_once('incluye/cargar.php');
pagina_requiere_nivel(1);
include_once('disenos/cabecera.php');
?>
<div class="login-page" style='margin-top:-2px'>
    <div class="text-center">
        <h3>Agregar nuevo grupo de usuarios</h3>
    </div>
    <div id="resultado"></div>
    <div id="valor"></div>
    <form method="POST" class="clearfix" id="formulario">
        <div class="form-group">
            <label for="nombre_grupo" class="control-label">Nombre del grupo</label>
            <input id="nombre_grupo" autofocus="" type="name" class="form-control" name="nombre_grupo" required>
        </div>
        <div class="form-group">
            <label for="nivel_grupo" class="control-label">Nivel del grupo</label>
            <input id="nivel_grupo" type="number" min="1" max="3" class="form-control" name="nivel_grupo" required="">
        </div>
      <div class="form-group">
        <label for="estado">Estado</label>
        <select id="estado" class="form-control" name="estado">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>
      </div>
        <div class="form-group clearfix">
            <button type="submit" name="agregar" class="btn btn-info">Guardar</button>
        </div>
  </form>
</div>
<script src="libs/js/agregar_grupo.js"></script>
<?php include_once('disenos/pie.php'); 
