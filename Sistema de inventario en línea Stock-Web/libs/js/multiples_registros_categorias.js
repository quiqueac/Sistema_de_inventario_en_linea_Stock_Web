/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function documentoCategorias() { 
    var $contador = 1;
    var $categorias;
    var $contador_tabla = 0;
    
    // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
    $("#adicional").on('click', function clickCategoria() {
        $("#tabla tbody tr:eq(0)").clone().removeClass('fila-fija').appendTo("#tabla");
        $("#tabla tbody tr:eq(" + $contador + ") input").removeAttr("name");
        $("#tabla tbody tr:eq(" + $contador + ") input").attr("name","nombre-categoria-" + $contador);
        $('.boton-menos').attr("disabled", false);
        $('#nombre-categoria').val('').focus();
        $contador++;
    });
    
    // Evento que selecciona la fila y la elimina 
    $(document).on("click",".eliminar",function eliminarCategoria() {
        if($contador === 2) {
            var parent = $(this).parents().get(0);
            $(parent).remove();
            $contador--;
            $('.boton-menos').attr("disabled", true);
        } else {
            var parent = $(this).parents().get(0);
            $(parent).remove();
            $contador--;
        }
        for (var $i = 0; $i <= $contador; $i++) {
            $("#tabla tbody tr:eq(" + $i + ") input").removeAttr("name");
            $("#tabla tbody tr:eq(" + $i + ") input").attr("name","nombre-categoria-" + $i);
        }
    });
    
    $("#agregarCategoria").click(function agregarCategoria() {
        $categorias = new Array($contador);
        var $indicador = false;
        for(var $i = 0; $i < $contador; $i++) {
            $categorias[$i] = $("#tabla tbody tr:eq(" + $i + ") input").val();
        }
        for(var $i = 0; $i < $contador; $i++) {
            for(var $j = 1; $j < $contador; $j++) {
                if($categorias[$i] === $categorias[$j] && $i !== $j) {
                    if(!$("#tabla tbody tr:eq(" + $j + ")").hasClass('has-error')) {
                        $("#tabla tbody tr:eq(" + $j + ") input").val('').focus();
                        $("#tabla tbody tr:eq(" + $j + ") td:eq(" + 0 + ")").append("<span class='" + $j + "'>Procura no ingresar iguales.</span>");
                        $("#tabla tbody tr:eq(" + $j + ")").addClass('has-error');
                        $indicador = true;
                        break;
                    } else {
                        $("#tabla tbody tr:eq(" + $j + ") input").val('').focus();
                        $indicador = true;
                        break;
                    }
                } else {
                    if($("#tabla tbody tr:eq(" + $j + ")").hasClass('has-error')) {
                        $("#tabla tbody tr:eq(" + $j + ")").removeClass('has-error');
                        $("span").remove("." + $j);
                    }
                }
            }
            if($indicador) {
                break;
            }
        }
    });
    
    $('#formulario').submit(function enviarCategoria(event) {
        $contador_tabla = $("#tabla_categorias tr").length;
        if($("#tabla_categorias_recientes tr").length) {
            var $contador_tabla_recientes = 0;
            $contador_tabla_recientes = $("#tabla_categorias_recientes tr").length;
            $contador_tabla_recientes--;
            var $categorias_agregadas = new Array($contador_tabla_recientes);
            for(var $i = 0; $i < $contador_tabla_recientes; $i++) {
                $categorias_agregadas[$i] = $("#tabla_categorias_recientes tbody tr:eq(" + $i + ") td")[1].innerHTML;
            }
        }
        $.post("buscar_categoria.php", {categorias: $categorias, contador: $contador_tabla, categorias_recientes: $categorias_agregadas, contador_tabla_recientes: $contador_tabla_recientes}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
            $("#resultados").html(datos_categorias);
        });
        event.preventDefault();
    });
});
