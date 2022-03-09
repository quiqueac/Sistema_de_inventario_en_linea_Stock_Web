<?php $usuario = usuario_actual(); ?>
<?php $empresa = empresa(); ?>
<?php $tema = tema(); ?>
<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>
                <?php 
                if (!empty($titulo_pagina)) {
                    echo remover_basura($titulo_pagina);
                } elseif (!empty($usuario)) {
                    echo ucfirst($usuario['nombre_usuario']);
                } else {
                    echo "Sistema de inventario";
                }
                ?>
            </title>
            <link rel="shortcut icon" type="image/x-icon" href="cargas/icono/stock.ico" />
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
            <?php 
                $numero = intval($tema['id_tema']);
                switch ($numero) {
                    case 1:
                        echo "<link rel='stylesheet' href='libs/css/main.css' />";
                        break;
                    case 2:
                        echo "<link rel='stylesheet' href='libs/css/pastel.css' />";
                        break;
                    case 3:
                        echo "<link rel='stylesheet' href='libs/css/personalizado1.css' />";
                        break;
                    case 4:
                        echo "<link rel='stylesheet' href='libs/css/personalizado2.css' />";
                        break;
                    case 5:
                        echo "<link rel='stylesheet' href='libs/css/personalizado3.css' />";
                        break;
                    default:
                        break;
                }
            ?>
            <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
            <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
            <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
            <script src="libs/js/fecha.js"></script>
            <script>
                $(function checarFecha() {
                    $.datepicker.setDefaults($.datepicker.regional["es"]);
                    var $ancho = $(window).width();
                    if($ancho < 890) {
                        $("div.header-date").css("display", "none");
                    } else {
                        $("div.header-date").css("display", "inline");
                    }
                    $(window).resize(function dimensionarChecarFecha(){
                        //aqui el codigo que se ejecutara cuando se redimencione la ventana
                        $ancho = $(window).width();
                        if($ancho < 890) {
                            $("div.header-date").css("display", "none");
                        } else {
                            $("div.header-date").css("display", "inline");
                        }
                    });
                });
            </script>
        </head>
        <body>
            <?php if ($sesion->estaLogeado(true)): ?>
            <header id="header">
                <div class="logo pull-left"> Stock-Web </div>
                <div class="header-content">
                    <div class="header-date pull-left">
                        <?php if($empresa['logo'] !== ''): ?>
                        <img src="cargas/logo/<?php echo $empresa['logo']; ?>" width="50" height="50" alt="logo"/>
                        <?php endif;?>
                        <?php if($empresa['lema'] !== ''): ?>
                        <strong><?php echo '"' . $empresa['lema'] . '"'; ?></strong>
                        <?php endif;?>
                        <strong><?php date_default_timezone_set('America/Monterrey'); echo date("d/m/Y  g:i a");?></strong>
                    </div>
                    <div class="pull-right clearfix">
                        <ul class="info-menu list-inline list-unstyled">
                            <li class="profile">
                                <a href="#" data-toggle="dropdown" class="toggle" aria-expanded="false">
                                    <img src="cargas/usuarios/<?php echo $usuario['imagen'];?>" alt="user-image" class="img-circle img-inline">
                                    <span><?php echo remover_basura(ucfirst($usuario['username'])); ?> <i class="caret"></i></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="perfil.php?id=<?php echo (int)$usuario['id'];?>">
                                            <i class="glyphicon glyphicon-user"></i>
                                            Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a href="editar_cuenta.php">
                                            <i class="glyphicon glyphicon-cog"></i>
                                            Configuración
                                        </a>
                                    </li>
                                    <li class="last">
                                        <a href="cerrar_sesion.php">
                                            <i class="glyphicon glyphicon-off"></i>
                                            Salir
                                        </a>
                                    </li>
                               </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            <div class="sidebar">
                <?php if($usuario['nivel'] === '1'): ?>
                <?php include_once('menu_administrador.php');?>
                <?php elseif($usuario['nivel'] === '2'): ?>
                <?php include_once('menu_especial.php');?>
                <?php elseif($usuario['nivel'] === '3'): ?>
                <?php include_once('menu_usuario.php');?>
                <?php endif;?>
           </div>
        <?php endif;?>
        <?php
        if($usuario['imagen_fondo'] != "") {
            echo "<img style='position: relative; height: 75em' src='cargas/fondos/$usuario[imagen_fondo]' width='100%' />";
        }
        ?>
        <div class="page" style="position:absolute;display:block;padding:45px 15px 20px 263px;">
        <div class="container-fluid">
