/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('#formulario').submit(function formularioAutenticacion(event) {
    var $usuario;
    var $password;
    
    $usuario = $("#usuario").val();
    $password = $("#password").val();
    
    $.post("autenticacion.php", {usuario: $usuario, password: $password}, function(mensaje) {
        $("#resultado").html(mensaje);
        $("#valor").html(requisito);
    }).success(function() {
        if($("#valor #requisito").length) {
            var $variable;
            
            $variable = $("#requisito").val();
            
            if($variable > -1){
                location.href ="http://ac13100034.000webhostapp.com/casa.php";
            } else if($variable == -1) {
                $("#usuario").val('').focus();
            } else if($variable == -2) {
                $("#password").val('').focus();
            }
        }
    });
    event.preventDefault();
});
