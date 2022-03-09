/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('#formulario').submit(function formularioUsuario(event) {
    var $nombre;
    var $usuario;
    var $password;
    var $rol;
    
    $nombre = $("#nombre").val();
    $usuario = $("#usuario").val();
    $password = $("#password").val();
    $rol = $("#rol").val();
    
    $.post("verificar_agregar_usuario.php", {nombre: $nombre, usuario: $usuario, password: $password, rol: $rol}, function(mensaje) {
        $("#resultado").html(mensaje);
        $("#valor").html(requisito);
    }).success(function() {
        if($("#valor #requisito").length) {
            var $variable;
            
            $variable = $("#requisito").val();
            
            if($variable > -1){
                location.href ="http://ac13100034.000webhostapp.com/usuarios.php";
            } else if($variable == -1) {
                $("#usuario").val('').focus();
            }
        }
    });
    event.preventDefault();
});
