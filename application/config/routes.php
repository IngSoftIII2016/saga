<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/

/*la variable $route es una arreglo donde se almacenan como clave
 * la ruta que recibimos y como valor la ruta donde queremos
 * que redireccione esa ruta, por ejemplo cuando recibimos
 * localhost/saga/api/clases/1 se redirecciona a
 * localhost/saga/api/ClaseEndpoint/clases/$1
 * lo que permite enviar url desde angualar de una forma
 * mas entendible y cumpliendo con JSON API
 * y redirigirla a nuesto controladores
 */

$route['api/clases/(:num)'] = 'api/ClaseEndpoint/clases/$1';
$route['api/clases'] = 'api/ClaseEndpoint/clases/';

$route['api/eventos/(:num)'] = 'api/EventoEndpoint/eventos/$1';
$route['api/eventos'] = 'api/EventoEndpoint/eventos';

$route['api/usuarios/(:num)'] = 'api/UsuarioEndpoint/usuarios/$1';
$route['api/usuarios'] = 'api/UsuarioEndpoint/usuarios';

$route['api/horarios/(:num)'] = 'api/HorarioEndpoint/horarios/$1';
$route['api/horarios'] = 'api/UsuarioEndpoint/horarios';

$route['api/asignaturas/(:num)'] = 'api/AsignaturaEndpoint/asignaturas/$1';
$route['api/asignaturas'] = 'api/AsignaturaEndpoint/asignaturas';

$route['api/aulas/(:num)'] = 'api/AulaEndpoint/aulas/$1';
$route['api/aulas'] = 'api/AulaEndpoint/aulas';

$route['api/carreras/(:num)'] = 'api/CarreraEndpoint/carreras/$1';
$route['api/carreras'] = 'api/CarreraEndpoint/carreras';

$route['api/comisiones/(:num)'] = 'api/ComisionEndpoint/comisiones/$1';
$route['api/comisiones'] = 'api/ComisionEndpoint/comisiones';

$route['api/docentes/(:num)'] = 'api/DocenteEndpoint/docentes/$1';
$route['api/docentes'] = 'api/DocenteEndpoint/docentes';

$route['api/edificios/(:num)'] = 'api/EdificioEndpoint/edificios/$1';
$route['api/edificios'] = 'api/EdificioEndpoint/edificios';

$route['api/grupos/(:num)'] = 'api/GrupoEndpoint/grupos/$1';
$route['api/grupos'] = 'api/GrupoEndpoint/grupos';

$route['api/localidades/(:num)'] = 'api/LocalidadEndpoint/localidades/$1';
$route['api/localidades'] = 'api/LocalidadEndpoint/localidades';

$route['api/preriodos/(:num)'] = 'api/PreriodoEndpoint/preriodos/$1';
$route['api/preriodos'] = 'api/PreriodoEndpoint/preriodos';

$route['api/recursos/(:num)'] = 'api/RecursoEndpoint/recursos/$1';
$route['api/recursos'] = 'api/RecursoEndpoint/recursos';

$route['api/sedes/(:num)'] = 'api/SedeEndpoint/sedes/$1';
$route['api/sedes'] = 'api/SedeEndpoint/sedes';

$route['api/tiporecurso/(:num)'] = 'api/TiporecursoEndpoint/tiporecurso/$1';
$route['api/tiporecurso'] = 'api/TiporecursoEndpoint/tiporecurso';



$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
