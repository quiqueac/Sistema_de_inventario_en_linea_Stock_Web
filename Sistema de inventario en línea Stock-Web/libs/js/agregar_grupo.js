/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$('#formulario').submit(function miForm(event) {
    var $nombre_grupo;
    var $nivel_grupo;
    var $estado;
    
    $nombre_grupo = $("#nombre_grupo").val();
    $nivel_grupo = $("#nivel_grupo").val();
    $estado = $("#estado").val();
    
    $.post("verificar_agregar_grupo.php", {nombre_grupo: $nombre_grupo, nivel_grupo: $nivel_grupo, estado: $estado}, function(mensaje) {
        $("#resultado").html(mensaje);
        $("#valor").html(requisito);
    }).success(function() {
        if($("#valor #requisito").length) {
            var $variable;
            
            $variable = $("#requisito").val();
            
            if($variable > -1){
                location.href ="http://ac13100034.000webhostapp.com/grupo.php";
            } else if($variable == -1) {
                $("#nombre_grupo").val('').focus();
            } else if($variable == -2) {
                $("#nivel_grupo").val('').focus();
            }
        }
    });
    event.preventDefault();
});
