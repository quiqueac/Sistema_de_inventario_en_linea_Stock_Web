<?php
session_start();

class Session {

    public $mensaje;
    private $user_is_logged_in = false;

    function __construct() {
        $this->mensaje_flash();
        $this->configuracionDeLoginUsuario();
    }

    public function estaLogeado() {
        return $this->user_is_logged_in;
    }
    
    public function login($id_usuario) {
        $_SESSION['user_id'] = $id_usuario;
    }
    
    private function configuracionDeLoginUsuario() {
        if(isset($_SESSION['user_id'])) {
            $this->user_is_logged_in = true;
        } else {
            $this->user_is_logged_in = false;
        }
    }
    
    public function cerrarSesion() {
        unset($_SESSION['user_id']);
    }

    public function mensaje($type ='', $mensaje ='') {
      if(!empty($mensaje)) {
        if(strlen(trim($type)) == 1){
            $type = str_replace( array('d', 'i', 'w','s'), array('danger', 'info', 'warning','success'), $type );
        }
        $_SESSION['mensaje'][$type] = $mensaje;
        } else {
            return $this->mensaje;
        }
    }

    private function mensaje_flash() {
        if(isset($_SESSION['mensaje'])) {
            $this->mensaje = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
        } else {
            $this->mensaje;
        }
    }
}

$sesion = new Session();
$mensaje = $sesion->mensaje();
