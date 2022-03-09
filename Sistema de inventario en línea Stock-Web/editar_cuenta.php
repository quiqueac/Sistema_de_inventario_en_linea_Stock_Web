<?php
$titulo_pagina = 'Editar cuenta';
require_once('incluye/cargar.php');
/*
$editar_usuario = encontrar_por_id('usuarios',(int)$_POST['user_id']);
$grupos  = encontrar_todos('grupo_usuario');
*/
pagina_requiere_nivel(3);
if(isset($_POST['submit'])) {
    $photo = new Media();
    $id_usuario = (int)$_POST['user_id'];
    $photo->subir($_FILES['usuario_upload']);
    if($photo->proceso_usuario($id_usuario)){
        $sesion->mensaje('s','La foto fue subida al servidor.');
        redirigir('editar_cuenta.php');
    } else{
        $sesion->mensaje('d',join($photo->errors));
        redirigir('editar_cuenta.php');
    }
}
if(isset($_POST['not'])) {
    $id_usuario = (int)$_POST['user_id'];
    $holas = new Media();
    $holas->borrar_imagen($id_usuario);
    $booleano = updateImagen($id_usuario);
    if($booleano){
        $sesion->mensaje('s','La foto por defecto fue colocada.');
        redirigir('editar_cuenta.php');
    } else{
        $sesion->mensaje('d',join($photo->errors));
        redirigir('editar_cuenta.php');
    }
}
if(isset($_POST['fondo'])) {
    $photo = new Media();
    $id_usuario = (int)$_POST['user_id'];
    $photo->subir($_FILES['fondo_upload']);
    if($photo->process_fondo($id_usuario)){
        $sesion->mensaje('s','La foto fue subida al servidor.');
        redirigir('editar_cuenta.php');
    } else{
        $sesion->mensaje('d',join($photo->errors));
        redirigir('editar_cuenta.php');
    }
}
if(isset($_POST['not_fondo'])) {
    $id_usuario = (int)$_POST['user_id'];
    $hola = new Media();
    $hola->borrar_fondo($id_usuario);
    $booleano = updateImagenFondo($id_usuario);
    if($booleano){
        $sesion->mensaje('s','La foto de fondo fue retirada.');
        redirigir('editar_cuenta.php');
    } else{
        $sesion->mensaje('d',join($photo->errors));
        redirigir('editar_cuenta.php');
    }
}
if(isset($_POST['update'])) {
    $campos_requeridos = array('name','username' );
    validar_campos($campos_requeridos);
    if(empty($errores)) {
        $id = (int)$_SESSION['user_id'];
        $nombre = remover_basura($db->escape($_POST['name']));
        $nombre_usuario = remover_basura($db->escape($_POST['username']));
        $sql = "UPDATE usuario SET nombre ='{$nombre}', username ='{$nombre_usuario}' WHERE id='{$id}'";
        $resultado = $db->query($sql);
        if($resultado && $db->affected_rows() === 1) {
            $sesion->mensaje('s',"Cuenta actualizada. ");
            redirigir('editar_cuenta.php', false);
        } else {
            #$sesion->mensaje('d',' Lo siento, la actualización no se efectuó.');
            redirigir('editar_cuenta.php', false);
        }
    } else {
        $sesion->mensaje("d", $errores);
        redirigir('editar_cuenta.php',false);
    }
}
if(isset($_POST['empresa'])) {
    $lema = $_POST['lema'];
    $comprobarLema = updateLema($lema);
    $photo = new Media();
    $photo->subir($_FILES['logo_upload']);
    $comprobarLogo = $photo->proceso_logo();
    if($comprobarLema && $comprobarLogo){
        $sesion->mensaje('s','El logo fue subido al servidor y el lema fue actualizado.');
        redirigir('editar_cuenta.php');
    } 
    if($comprobarLema && !$comprobarLogo) {
        $sesion->mensaje('s','El lema fue actualizado.');
        redirigir('editar_cuenta.php');
    }
    if(!$comprobarLema && $comprobarLogo) {
        $sesion->mensaje('s','El logo fue subido al servidor.');
        redirigir('editar_cuenta.php');
    }
    else {
        $sesion->mensaje('d',join($photo->errors));
        redirigir('editar_cuenta.php');
    }
}
if(isset($_POST['not_empresa'])) {
    $hola = new Media();
    $hola->borrar_logo();
    $booleano = updateLogo($id_usuario);
    if($booleano){
        $sesion->mensaje('s','El logo fue retirado.');
        redirigir('editar_cuenta.php');
    } else{
        $sesion->mensaje('d',join($photo->errors));
        redirigir('editar_cuenta.php');
    }
}
if(isset($_POST['tema'])) {
    $id_usuario = (int)$_POST['user_id'];
    $idTema = intval($_POST['tema-seleccion']);
    if($idTema > 0) {
        $comprobarTema = updateTema($id_usuario,$idTema);
        if($comprobarTema) {
            $sesion->mensaje('s','El tema fue actualizado.');
            redirigir('editar_cuenta.php');
        }
    }
}
if(isset($_POST['reporte'])) {
    $id_usuario = (int)$_POST['user_id'];
    if(isset($_POST['diario'])) {
        if(!buscarTipoReporte($id_usuario, 1)) {
            insertarTipoReporte($id_usuario, 1);
            $sesion->mensaje('s','Se realizaron cambios en reportes de ventas.');
        }
    } if(isset($_POST['mensual'])) {
        if(!buscarTipoReporte($id_usuario, 2)) {
            insertarTipoReporte($id_usuario, 2);
            $sesion->mensaje('s','Se realizaron cambios en reportes de ventas.');
        }
    } if(isset($_POST['fecha'])) {
        if(!buscarTipoReporte($id_usuario, 3)) {
            insertarTipoReporte($id_usuario, 3);
            $fecha_inicio = $_POST['fecha-inicio'];
            $fecha_fin = $_POST['fecha-fin'];
            $resultados = buscarTipoReportes($id_usuario, 3);
            foreach($resultados as $resultado):
                $id_tipos_reporte = $resultado['id'];
            endforeach;
            insertarRangoFecha($id_tipos_reporte, $fecha_inicio, $fecha_fin);
            $sesion->mensaje('s','Se realizaron cambios en reportes de ventas.');
        }
    } if(!isset($_POST['diario'])) {
        if(buscarTipoReporte($id_usuario, 1)) {
            borrarTipoReporte($id_usuario, 1);
            $sesion->mensaje('s','Se realizaron cambios en reportes de ventas.');
        }
    } if(!isset($_POST['mensual'])) {
        if(buscarTipoReporte($id_usuario, 2)) {
            borrarTipoReporte($id_usuario, 2);
            $sesion->mensaje('s','Se realizaron cambios en reportes de ventas.');
        }
    } if(!isset($_POST['fecha'])) {
        if(buscarTipoReporte($id_usuario, 3)) {
            $resultados = buscarTipoReportes($id_usuario, 3);
            foreach($resultados as $resultado):
                $id_tipos_reporte = $resultado['id'];
            endforeach;
            borrarRangoFecha($id_tipos_reporte);
            borrarTipoReporte($id_usuario, 3);
            $sesion->mensaje('s','Se realizaron cambios en reportes de ventas.');
        }
    }
    redirigir('editar_cuenta.php');
}
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-12">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <span class="glyphicon glyphicon-camera"></span>
                <span>Cambiar mi foto</span>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 panel-body">
                        <form class="form" action="editar_cuenta.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <input style="width:100.5%" type="file" name="usuario_upload" multiple="multiple" class="btn btn-default btn-file"/>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="<?php echo $usuario['id'];?>">
                                <button type="submit" name="submit" style="margin-bottom:10px" class="btn btn-warning col-xs-12 col-md-5">Cambiar</button>
                                <button type="submit" name="not" class="btn btn-warning pull-right col-xs-12 col-md-6">Quitar mi foto actual</button>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <span class="glyphicon glyphicon-edit"></span>
                <span>Editar mi cuenta</span>
            </div>
            <div class="panel-body">
                <form method="post" action="editar_cuenta.php?id=<?php echo (int)$usuario['id'];?>" class="clearfix">
                    <div class="form-group">
                        <label for="name" class="control-label">Nombre(s)</label>
                        <input type="name" class="form-control" required="" name="name" value="<?php echo remover_basura(ucwords($usuario['nombre_usuario'])); ?>">
                    </div>
                    <div class="form-group">
                        <label for="username" class="control-label">Usuario</label>
                        <input type="text" class="form-control" required="" name="username" value="<?php echo remover_basura(ucwords($usuario['username'])); ?>">
                    </div>
                    <div class="form-group clearfix">
                        <a href="cambiar_contrasena.php" title="change password" style="margin-bottom:10px" class="col-xs-12 col-md-6 btn btn-danger pull-right">Cambiar contraseña</a>
                        <button type="submit" name="update" class="btn btn-info col-xs-12 col-md-5">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <span class="glyphicon glyphicon-camera"></span>
                <span>Cambiar mi fondo</span>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 panel-body">
                        <form class="form" action="editar_cuenta.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <input style="width:100.5%" type="file" name="fondo_upload" multiple="multiple" class="btn btn-default btn-file"/>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="<?php echo $usuario['id'];?>">
                                <button type="submit" name="fondo" style="margin-bottom:10px" class="col-xs-12 col-md-4 btn btn-warning">Cambiar</button>
                                <button type="submit" name="not_fondo" class="col-xs-12 col-md-7 btn btn-warning pull-right">Quitar mi fondo actual</button>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($usuario['nivel'] === '1'): ?>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <span class="glyphicon glyphicon-edit"></span>
                <span>Cambiar logo y/o lema</span>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 panel-body">
                        <form class="form" action="editar_cuenta.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="lema" class="control-label">Lema de la empresa</label>
                                <input type="text" class="form-control" name="lema" value="<?php echo remover_basura($empresa['lema']); ?>">
                            </div>
                            <div class="form-group">
                                <input style="width:100.5%" type="file" name="logo_upload" multiple="multiple" class="btn btn-default btn-file"/>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="empresa" class="btn btn-warning">Cambiar</button>
                                <button type="submit" name="not_empresa" class="btn btn-warning pull-right">Quitar logo</button>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <span class="glyphicon glyphicon-edit"></span>
                <span>Cambiar tema</span>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 panel-body" >
                        <form class="form" action="" method="POST">
                            <div class="form-group">
                                <label for="tema" class="control-label">Tema</label>
                                <input type="hidden" name="user_id" value="<?php echo $usuario['id'];?>">
                                <select class="form-control" id="seleccion" name="tema-seleccion">
                                    <option value="0" selected="">Selecciona una opción</option>
                                    <option value="1">Por defecto</option>
                                    <option value="2">Pastel</option>
                                    <option value="3">Personalizado 1</option>
                                    <option value="4">Personalizado 2</option>
                                    <option value="5">Personalizado 3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="tema" id="tema" class="btn btn-warning">Cambiar tema</button>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <span class="glyphicon glyphicon-list-alt"></span>
                <span>Reportes de ventas automáticos</span>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 panel-body" >
                        <form class="form" action="" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="<?php echo $usuario['id'];?>">
                                <div class="col-md-4">
                                    <label for="diario" class="control-label">Diarias</label>
                                    <input style="transform:scale(1.1);" type="checkbox" name="diario" value="ON" />
                                </div>
                                <div class="col-md-4">
                                    <label for="mensual" class="control-label">Mensuales</label>
                                    <input style="transform:scale(1.1);" type="checkbox" name="mensual" value="ON" />
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha" class="control-label">Entre fechas</label>
                                    <input id="fecha" style="transform:scale(1.1);" type="checkbox" name="fecha" value="ON" />
                                </div>
                                <div>
                                    <label class="form-label">Rango de fechas</label>
                                    <div class="input-group">
                                        <input required="" disabled type="text" class="datepicker form-control fecha-inicio" name="fecha-inicio" id="fecha-inicio" placeholder="De" autocomplete="off">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                                        <input required="" disabled type="text" class="datepicker form-control fecha-fin" name="fecha-fin" id="fecha-fin" placeholder="Hasta" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="reporte" id="tema" class="btn btn-warning">Actualizar reportes automáticos</button>
                            </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="libs/js/moment.js"></script>
<script>
    $(document).ready(function fecha() {
        $('#fecha').on('change', function() {
            if ($(this).is(':checked')) {
                $("#fecha-inicio").prop("disabled", false);
                $("#fecha-fin").prop("disabled", false);
            } else {
                $("#fecha-inicio").prop("disabled", true);
                $("#fecha-fin").prop("disabled", true);
            }
        });
        $(".fecha-inicio").change(function fechaVar() {
            var valor = $(".fecha-fin").val();
            if(valor === '') {
                var fecha1;
                var fecha2;
                var fecha;
                var diferencia;
                
                fecha = $(".fecha-inicio").val();
                fecha1 = moment(fecha);
                fecha2 = moment(new Date());       
                diferencia = fecha1.diff(fecha2,'days');
                
                if(diferencia > 0) {
                    $(".fecha-fin").datepicker('option', 'minDate', diferencia + 1);
                } else {
                    $(".fecha-fin").datepicker('option', 'minDate', diferencia);
                }
            }
        });
        $(".fecha-fin").change(function fechaObj() {
            var valor = $(".fecha-inicio").val();
            if(valor === '') {
                var fecha1;
                var fecha2;
                var fecha;
                var diferencia;
                
                fecha = $(".fecha-fin").val();
                fecha1 = moment(fecha);
                fecha2 = moment(new Date());       
                diferencia = fecha1.diff(fecha2,'days');
                alert(diferencia);
                
                if(diferencia > 0) {
                    $(".fecha-inicio").datepicker('option', 'maxDate', diferencia + 1);
                } else {
                    $(".fecha-inicio").datepicker('option', 'maxDate', diferencia);
                }
                
            }
        });
    });
</script>
<?php include_once('disenos/pie.php'); 
