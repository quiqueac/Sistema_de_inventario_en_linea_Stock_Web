<?php
define("URL_SEPARATOR", '/');
define("DS", DIRECTORY_SEPARATOR);

// -----------------------------------------------------------------------
// DEFINE ROOT PATHS
// -----------------------------------------------------------------------
defined('SITE_ROOT')? null: define('SITE_ROOT', realpath(dirname(__FILE__)));
define("LIB_PATH_INC", SITE_ROOT.DS);

require_once(LIB_PATH_INC.'config.php');
require_once(LIB_PATH_INC.'funciones.php');
require_once(LIB_PATH_INC.'sesion.php');
require_once(LIB_PATH_INC.'subir.php');
require_once(LIB_PATH_INC.'baseDatos.php');
require_once(LIB_PATH_INC.'sql.php');
