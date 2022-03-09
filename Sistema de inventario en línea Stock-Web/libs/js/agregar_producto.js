/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function ventanaLista() {
    var $ancho = $(window).width();

    if($ancho < 991) {
        $(".venta-decimal").css("margin-left","15px");
        $(".venta-compra").css("margin-left","15px");
    } else {
        $(".venta-decimal").css("margin-left","0");
        $(".venta-compra").css("margin-left","0");
    }

    $(window).resize(function ventanaCambio(){
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
});

$('#formulario').submit(function formularioProducto(event) {
    var $titulo;
    var $categoria;
    var $foto;
    var $cantidad;
    var $compra;
    var $compra_decimal;
    var $precio;
    var $precio_decimal;
    
    $titulo = $("#titulo").val();
    $categoria = $("#categoria").val();
    $foto = $("#foto").val();
    $cantidad = $("#cantidad").val();
    $compra = $("#compra").val();
    $compra_decimal = $("#compra_decimal").val();
    $precio = $("#precio").val();
    $precio_decimal = $("#precio_decimal").val();
    
    $.post("verificar_agregar_producto.php", {titulo: $titulo, categoria: $categoria, foto: $foto, cantidad: $cantidad, compra: $compra, compra_decimal: $compra_decimal, precio: $precio, precio_decimal: $precio_decimal}, function(mensaje) {
        $("#resultado").html(mensaje);
        $("#valor").html(requisito);
    }).success(function() {
        if($("#valor #requisito").length) {
            var $variable;
            
            $variable = $("#requisito").val();
            
            if($variable > -1){
                location.href ="http://ac13100034.000webhostapp.com/producto.php";
            } else if($variable == -1) {
                $("#titulo").val('').focus();
            }
        }
    });
    event.preventDefault();
});
