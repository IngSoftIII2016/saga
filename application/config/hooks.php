<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'] = array(
    'class'    => 'Gestion_sesion', // clase que controla la sesion
    'function' => 'index', // metodo encargado de todo, dentro de la clase
    'filename' => 'Gestion_sesion.php', // archivo a cargar
    'filepath' => 'hooks' // carpeta donde se encuentra la clase
);