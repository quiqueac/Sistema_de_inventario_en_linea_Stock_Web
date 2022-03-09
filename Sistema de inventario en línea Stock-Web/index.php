<?php
ob_start();
require_once('incluye/cargar.php');
if($sesion->estaLogeado(true)) { redirigir('casa.php', false);}
$usuario = usuario_actual();
$empresa = empresa();
$tema = tema();
?>
<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>
                <?php 
                if (!empty($titulo_pagina)) {
                    echo remover_basura($titulo_pagina);
                } elseif (!empty($usuario)) {
                    echo ucfirst($usuario['nombre']);
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
                    default:
                        break;
                }
            ?>
            <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
            <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
            <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
            <script src="libs/js/fecha.js"></script>
            <script>
                $(function date() {
                    $.datepicker.setDefaults($.datepicker.regional["es"]);
                });
            </script>
        </head>
        <body>
            <?php if ($sesion->estaLogeado(true)): ?>
            <header id="header">
                <div class="logo pull-left"> Sistema de inventario </div>
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
                                    <span><?php echo remover_basura(ucfirst($usuario['nombre'])); ?> <i class="caret"></i></span>
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
                <?php if($usuario['nivel_grupo'] === '1'): ?>
                <?php include_once('menu_administrador.php');?>
                <?php elseif($usuario['nivel_grupo'] === '2'): ?>
                <?php include_once('menu_especial.php');?>
                <?php elseif($usuario['nivel_grupo'] === '3'): ?>
                <?php include_once('menu_usuario.php');?>
                <?php endif;?>
           </div>
            <?php endif;?>
            <?php
            if($usuario['imagen_fondo'] != "") {
                echo "<img style='position: relative; height: 75em' src='cargas/fondos/$usuario[imagen_fondo]' width='100%' />";
            }
            ?>
            <link rel='stylesheet' href='libs/css/main.css' />
            <div style="padding-top:70px">
                <div class="login-page" id="inicio-sesion" style="padding-bottom:20px">
                    <div class="text-center">
                        <h1>Bienvenido</h1>
                        <p>Iniciar sesión </p>
                    </div>
                    <div id="resultado"></div>
                    <div id="valor"></div>
                    <?php echo mostrar_mensaje($mensaje); ?>
                    <form method="post" class="clearfix" id="formulario">
                        <div class="form-group">
                            <label for="usuario" class="control-label">Usuario</label>
                            <input id="usuario" autofocus="" type="name" class="form-control" name="usuario" placeholder="Usuario" required="">
                        </div>
                        <div class="form-group">
                            <label for="Password" class="control-label">Contraseña</label>
                            <input id="password" type="password" name= "password" class="form-control" placeholder="Contraseña" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info  pull-right">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
            <script src="libs/js/autenticacion.js"></script>
            <?php include_once('disenos/pie.php'); 
