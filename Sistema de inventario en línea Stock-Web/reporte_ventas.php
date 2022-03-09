<?php
$titulo_pagina = 'Reporte de ventas';
require_once('incluye/cargar.php');
pagina_requiere_nivel(3);
include_once('disenos/cabecera.php'); 
?>
<div class="row">
    <div class="col-md-12">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <form class="clearfix" method="post" action="reporte_ventas_proceso.php">
                    <div class="form-group">
                        <label class="form-label">Rango de fechas</label>
                        <div class="input-group">
                            <input type="text" class="datepicker form-control fecha-inicio" name="fecha-inicio" placeholder="De" autocomplete="off">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                            <input type="text" class="datepicker form-control fecha-fin" name="fecha-fin" placeholder="Hasta" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary">Generar reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="libs/js/moment.js"></script>
<script>
    $(document).ready(function() {
        $(".fecha-inicio").change(function dateInicio() {
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
        $(".fecha-fin").change(function dateFin() {
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
