<?php include_once('incluye/cargar.php'); ?>
<?php
$req_fields = array('usuario','contrasena' );
validar_campos($req_fields);
$username = remover_basura($_POST['usuario']);
$password = remover_basura($_POST['contrasena']);

if(empty($errors)) {

    $user = autenticar_v2($username, $password);

    if($user):
        $session->login($user['id']);
        actualizarUltimoLogin($user['id']);
        if($user['nivel_usuario'] === '1'):
          $session->mensaje("s", "Hola ".$user['usuario'].", Bienvenido al inventario.");
          redirigir('admin.php',false);
        elseif ($user['nivel_usuario'] === '2'):
           $session->mensaje("s", "Hola ".$user['usuario'].", Bienvenido al inventario.");
          redirigir('special.php',false);
        else:
           $session->mensaje("s", "Hola ".$user['usuario'].", Bienvenido al inventario.");
          redirigir('casa.php',false);
        endif;
        else:
          $session->mensaje("d", "Usuario/contraseña incorrectos.");
          redirigir('index.php',false);
        endif;
} else {
    $session->mensaje("d", $errors);
    redirigir('login_v2.php',false);
}
