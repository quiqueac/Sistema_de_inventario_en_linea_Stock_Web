/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function documentoProductos() { 
    var $contador_producto = 1;
    var $ancho = $(window).width();
    var $indice;
    var $indices;
    var $titulo_productos;
    var $categoria_productos;
    var $imagen_productos;
    var $cantidad_productos;
    var $compra_productos;
    var $compra_decimal_productos;
    var $precio_productos;
    var $precio_decimal_productos;
    var $nombre_imagen_productos;
    var $nombre_categoria_productos;
    var $contador_tabla_productos_recientes;
    var $productos_agregados;
    
    if($ancho < 991) {
        $(".venta-decimal").css("margin-left","15px");
        $(".venta-compra").css("margin-left","15px");
    } else {
        $(".venta-decimal").css("margin-left","0");
        $(".venta-compra").css("margin-left","0");
    }
    
    $(window).resize(function redimensionProductos(){
        //aqui el codigo que se ejecutara cuando se redimencione la ventana
        var $ancho = $(window).width();
        if($ancho < 991) {
            $(".venta-decimal").css("margin-left","15px");
            $(".venta-compra").css("margin-left","15px");
        } else {
            $(".venta-decimal").css("margin-left","0");
            $(".venta-compra").css("margin-left","0");
        }
    });
    
    // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
    $("#adicional-producto").on('click', function agregarProducto() {
        $indice = $("#formulario-producto .form-producto");
        $("#formulario-producto .form-producto:eq(0)").clone().appendTo("#contenedor-producto").attr("id","contenedor-producto-" + $contador_producto);
        $("#formulario-producto input.titulo:eq(" + $contador_producto + ")").attr("name","titulo-producto-" + $contador_producto);
        $("#formulario-producto select.categoria:eq(" + $contador_producto + ")").attr("name","categoria-" + $contador_producto);
        $("#formulario-producto select.foto:eq(" + $contador_producto + ")").attr("name","product-photo-" + $contador_producto);
        $("#formulario-producto input.cantidad:eq(" + $contador_producto + ")").attr("name","cantidad-" + $contador_producto);
        $("#formulario-producto input.compra:eq(" + $contador_producto + ")").attr("name","compra-" + $contador_producto);
        $("#formulario-producto input.compra_decimal:eq(" + $contador_producto + ")").attr("name","compra_decimal-" + $contador_producto);
        $("#formulario-producto input.precio:eq(" + $contador_producto + ")").attr("name","precio-" + $contador_producto);
        $("#formulario-producto input.precio_decimal:eq(" + $contador_producto + ")").attr("name","precio_decimal-" + $contador_producto);
        $("#formulario-producto .boton-menos-producto:eq(" + $contador_producto + ")").attr("id","" + $contador_producto);
        $('.boton-menos-producto').attr("disabled", false);
        $("#formulario-producto input.titulo:eq(" + $contador_producto + ")").val('').focus();
        $("#formulario-producto select.categoria:eq(" + $contador_producto + ")").val('');
        $("#formulario-producto select.foto:eq(" + $contador_producto + ")").val('');
        $("#formulario-producto input.cantidad:eq(" + $contador_producto + ")").val('');
        $("#formulario-producto input.compra:eq(" + $contador_producto + ")").val('');
        $("#formulario-producto input.compra_decimal:eq(" + $contador_producto + ")").val('0');
        $("#formulario-producto input.precio:eq(" + $contador_producto + ")").val('');
        $("#formulario-producto input.precio_decimal:eq(" + $contador_producto + ")").val('0');
        $contador_producto++;
    });
    
    // Evento que selecciona la fila y la elimina
    $(document).on("click",".boton-menos-producto",function eliminarProducto() {
        $indices = $(this).attr("id");
        if($contador_producto === 2) {
            $("#contenedor-producto-" + $indices).remove();
            $contador_producto--;
            $('.boton-menos-producto').attr("disabled", true);
        } else {
            $("#contenedor-producto-" + $indices).remove();
            $contador_producto--;
        }
        for(var $i = 0; $i <= $contador_producto; $i++) {
            $("#formulario-producto div div.form-producto:eq(" + $i + ")").attr("id","contenedor-producto-" + $i);
            $("#formulario-producto input.titulo:eq(" + $i + ")").attr("name","titulo-producto-" + $i);
            $("#formulario-producto select.categoria:eq(" + $i + ")").attr("name","categoria-" + $i);
            $("#formulario-producto select.foto:eq(" + $i + ")").attr("name","product-photo-" + $i);
            $("#formulario-producto input.cantidad:eq(" + $i + ")").attr("name","cantidad-" + $i);
            $("#formulario-producto input.compra:eq(" + $i + ")").attr("name","compra-" + $i);
            $("#formulario-producto input.compra_decimal:eq(" + $i + ")").attr("name","compra_decimal-" + $i);
            $("#formulario-producto input.precio:eq(" + $i + ")").attr("name","precio-" + $i);
            $("#formulario-producto input.precio_decimal:eq(" + $i + ")").attr("name","precio_decimal-" + $i);
            $("#formulario-producto .boton-menos-producto:eq(" + $i + ")").attr("id","" + $i);
        }
    });
    
    $("#agregarProducto").click(function adicionarProducto() {
        $titulo_productos = new Array($contador_producto);
        var $indicador = false;
        for(var $i = 0; $i < $contador_producto; $i++) {
            $titulo_productos[$i] = $("#formulario-producto input.titulo:eq(" + $i + ")").val();
        }
        for(var $i = 0; $i < $contador_producto; $i++) {
            for(var $j = 1; $j < $contador_producto; $j++) {
                if($titulo_productos[$i] === $titulo_productos[$j] && $i !== $j) {
                    if(!$("#formulario-producto div.clase-titulo:eq(" + $j + ")").hasClass('has-error')) {
                        $("#formulario-producto input.titulo:eq(" + $j + ")").val('').focus();
                        $("#formulario-producto div.titulo-es:eq(" + $j + ")").append("<span class='span-" + $j + "'>Procura no ingresar iguales.</span>");
                        $("#formulario-producto div.clase-titulo:eq(" + $j + ")").addClass('has-error');
                        $indicador = true;
                        break;
                    } else {
                        $("#formulario-producto input.titulo:eq(" + $j + ")").val('').focus();
                        $indicador = true;
                        break;
                    }
                } else {
                    if($("#formulario-producto div.clase-titulo:eq(" + $j + ")").hasClass('has-error')) {
                        $("#formulario-producto div.clase-titulo:eq(" + $j + ")").removeClass('has-error');
                        $("span").remove(".span-" + $j);
                    }
                }
            }
            if($indicador) {
                break;
            }
        }
    });
    
    $('#formulario-producto').submit(function enviarProductos(event) {
        var $contador_tabla = $(".origen tr").length;
        $categoria_productos = new Array($contador_producto);
        $imagen_productos = new Array($contador_producto);
        $cantidad_productos = new Array($contador_producto);
        $compra_productos = new Array($contador_producto);
        $compra_decimal_productos = new Array($contador_producto);
        $precio_productos = new Array($contador_producto);
        $precio_decimal_productos = new Array($contador_producto);
        $nombre_imagen_productos = new Array($contador_producto);
        $nombre_categoria_productos = new Array($contador_producto);
        
        for(var $i = 0; $i < $contador_producto; $i++) {
            $categoria_productos[$i] = $("#formulario-producto select.categoria:eq(" + $i + ")").val();
            $imagen_productos[$i] = $("#formulario-producto select.foto:eq(" + $i + ")").val();
            $cantidad_productos[$i] = $("#formulario-producto input.cantidad:eq(" + $i + ")").val();
            $compra_productos[$i] = $("#formulario-producto input.compra:eq(" + $i + ")").val();
            $compra_decimal_productos[$i] = $("#formulario-producto input.compra_decimal:eq(" + $i + ")").val();
            $precio_productos[$i] = $("#formulario-producto input.precio:eq(" + $i + ")").val();
            $precio_decimal_productos[$i] = $("#formulario-producto input.precio_decimal:eq(" + $i + ")").val();
            $nombre_imagen_productos[$i] = $("#formulario-producto select.foto:eq(" + $i + ") option:selected").text();
            $nombre_categoria_productos[$i] = $("#formulario-producto select.categoria:eq(" + $i + ") option:selected").text();
        }
        
        if($(".tabla-resultado-producto tbody tr").length) {
            $contador_tabla_productos_recientes = $(".tabla-resultado-producto tbody tr").length;
            $productos_agregados = new Array($contador_tabla_productos_recientes);
            for(var $i = 0; $i < $contador_tabla_productos_recientes; $i++) {
                $productos_agregados[$i] = $(".tabla-resultado-producto tbody tr td.necesario")[$i].innerHTML;
            }
        }
        
        $.post("buscar_producto.php", {productos_agregados: $productos_agregados, contador_tabla_productos_recientes: $contador_tabla_productos_recientes, nombre_categoria_productos: $nombre_categoria_productos, nombre_imagen_productos: $nombre_imagen_productos, titulo_productos: $titulo_productos, categoria_productos: $categoria_productos, imagen_productos: $imagen_productos, cantidad_productos: $cantidad_productos, compra_productos: $compra_productos, compra_decimal_productos: $compra_decimal_productos, precio_productos: $precio_productos, precio_decimal_productos: $precio_decimal_productos, contador_producto: $contador_producto, contador_tabla: $contador_tabla}, function(mensaje) {
            $("#resultadoBusqueda-productos").html(mensaje);
            $("#resultados-productos").html(datos_productos);
        });
        event.preventDefault();
    });
});
