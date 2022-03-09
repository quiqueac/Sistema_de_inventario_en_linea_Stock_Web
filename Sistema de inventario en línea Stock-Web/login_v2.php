<?php
ob_start();
require_once('inclye/cargar.php');
if($sesion->estaLogeado(true)) { redirigir('casa.php', false);}
?>
<div class="login-page">
    <div class="text-center">
        <h1>Bienvenido</h1>
        <p>Sesión iniciada</p>
    </div>
    <?php echo mostrar_mensaje($mensaje); ?>
    <form method="post" action="auth_v2.php" class="clearfix">
        <div class="form-group">
            <label for="username" class="control-label">Usuario</label>
            <input type="name" class="form-control" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="Password" class="control-label">Contraseña</label>
            <input type="password" name= "password" class="form-control" placeholder="password">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info pull-right">Login</button>
        </div>
    </form>
</div>
<?php include_once('disenos/cabecera.php'); 
