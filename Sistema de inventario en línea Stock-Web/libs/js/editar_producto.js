/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function redimension() {
    var $ancho = $(window).width();

    if($ancho < 991) {
        $(".venta-decimal").css("margin-left","15px");
        $(".venta-compra").css("margin-left","15px");
        $(".venta-decimal").css("margin-top","0px");
        $(".venta-compra").css("margin-top","0px");
        $(".clase").css("margin-top","0px");
    } else {
        $(".venta-decimal").css("margin-left","0");
        $(".venta-compra").css("margin-left","0");
        $(".venta-decimal").css("margin-top","25px");
        $(".venta-compra").css("margin-top","25px");
        $(".clase").css("margin-top","25px");
    }

    $(window).resize(function cambioRedimension() {
        //aqui el codigo que se ejecutara cuando se redimencione la ventana
        var $ancho = $(window).width();
        if($ancho < 991) {
            $(".venta-decimal").css("margin-left","15px");
            $(".venta-compra").css("margin-left","15px");
            $(".venta-decimal").css("margin-top","0px");
            $(".venta-compra").css("margin-top","0px");
            $(".clase").css("margin-top","0px");
        } else {
            $(".venta-decimal").css("margin-left","0");
            $(".venta-compra").css("margin-left","0");
            $(".venta-decimal").css("margin-top","25px");
            $(".venta-compra").css("margin-top","25px");
            $(".clase").css("margin-top","25px");
        }
    });
});
