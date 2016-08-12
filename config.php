<?

ini_set("session.cookie_lifetime","7200");
ini_set("session.gc_maxlifetime","7200"); 

session_start();

error_reporting(E_ALL | E_STRICT);

$dirname = dirname(__FILE__);

define('SEPARATOR', '/');

define('ROOT', $dirname);

define('URL', 'http://' . $_SERVER['SERVER_NAME']);

define('APP_ROOT',  $dirname . SEPARATOR);

define('APP', APP_ROOT);



$pathRoot = str_replace("\\", "/", $dirname);

$pathRoot = str_replace($_SERVER['DOCUMENT_ROOT'], "", $pathRoot);

define('URL_APP', URL . SEPARATOR . $pathRoot);



define("CSS", URL_APP . "css" . SEPARATOR);

define("JSMENU", URL_APP . "SpryAssets" . SEPARATOR);

define("JS", URL_APP . "js" . SEPARATOR);

define("IMAGES", URL_APP . "images" . SEPARATOR);



define("URL_CLIENTE", URL_APP . "cliente" . SEPARATOR);

define("URL_COMERCIAL", URL_APP . "comercial" . SEPARATOR);

define("URL_COSTOS", URL_APP . "costos" . SEPARATOR);

define("URL_COTIZACION", URL_APP . "cotizacion" . SEPARATOR);

define("URL_HITOS", URL_APP . "hitos" . SEPARATOR);

define("URL_INGRESO_MERCANCIA", URL_APP . "ingreso_mercancia" . SEPARATOR);

define("URL_SALIDA_MERCANCIA", URL_APP . "salida_mercancia" . SEPARATOR);

define("URL_FACTURAS", URL_APP . "facturas" . SEPARATOR);

define("URL_INVENTARIO", URL_APP . "inventario" . SEPARATOR);

define("URL_PROVEEDOR", URL_APP . "proveedor" . SEPARATOR);

define("URL_PROYECTO_INGRESOS", URL_APP . "proyecto_ingresos" . SEPARATOR);

define("URL_PROYECTOS", URL_APP . "proyectos" . SEPARATOR);

define("URL_REPORTES", URL_APP . "reportes" . SEPARATOR);

define("URL_SOLICITUD_DESPACHO", URL_APP . "solicitud_despacho" . SEPARATOR);

define("URL_TAREAS", URL_APP . "tareas" . SEPARATOR);

define("URL_USUARIOS", URL_APP . "usuarios" . SEPARATOR);

define("URL_PERFILES", URL_APP . "perfiles" . SEPARATOR);

define("URL_VEHICULOS", URL_APP . "vehiculos" . SEPARATOR);

define("URL_TECNICOS", URL_APP . "tecnicos" . SEPARATOR);

define("URL_ASIGNACION", URL_APP . "asignacion" . SEPARATOR);

define("URL_ANTICIPOS", URL_APP . "anticipos" . SEPARATOR);

define("URL_BENEFICIARIO", URL_APP . "beneficiario" . SEPARATOR);

define("URL_PO", URL_APP . "po" . SEPARATOR);

define("URL_REINTEGROS", URL_APP . "reintegros" . SEPARATOR);

define("URL_REGIONAL", URL_APP . "regional" . SEPARATOR);

define("URL_REINTEGRO_ACPM", URL_APP . "reintegro_acpm" . SEPARATOR);

define("URL_PRECIOSACPM", URL_APP . "financiero" . SEPARATOR);

define("URL_DOCUMENTAL", URL_APP . "documental" . SEPARATOR);

define("URL_HITOS_UPLOAD", URL_APP . "hitos_upload" . SEPARATOR);




define("CLIENTE", "cliente" . SEPARATOR);

define("COMERCIAL", "comercial" . SEPARATOR);

define("COSTOS", "costos" . SEPARATOR);

define("COTIZACION", "cotizacion" . SEPARATOR);

define("HITOS", "hitos" . SEPARATOR);

define("INGRESO_MERCANCIA", "ingreso_mercancia" . SEPARATOR);

define("FACTURAS", "facturas" . SEPARATOR);

define("SALIDA_MERCANCIA", "salida_mercancia" . SEPARATOR);

define("INVENTARIO", "inventario" . SEPARATOR);

define("PROVEEDOR", "proveedor" . SEPARATOR);

define("PROYECTO_INGRESOS", "proyecto_ingresos" . SEPARATOR);

define("PROYECTOS", "proyectos" . SEPARATOR);

define("REPORTES", "reportes" . SEPARATOR);

define("SOLICITUD_DESPACHO", "solicitud_despacho" . SEPARATOR);

define("TAREAS", "tareas" . SEPARATOR);

define("USUARIOS", "usuarios" . SEPARATOR);

define("PERFILES", "perfiles" . SEPARATOR);

define("VEHICULOS", "vehiculos" . SEPARATOR);

define("TECNICOS", "tecnicos" . SEPARATOR);

define("ASIGNACION", "asignacion" . SEPARATOR);

define("ANTICIPO", "anticipo" . SEPARATOR);

define("LEGALIZACION", "legalizacion" . SEPARATOR);

define("BENEFICIARIO", "beneficiario" . SEPARATOR);

define("SITIOS", "sitios" . SEPARATOR);

define("PO", "po" . SEPARATOR);

define("INGRESOS", "ingresos" . SEPARATOR);

define("REINTEGROS", "reintegro" . SEPARATOR);

define("REGIONAL", "regional" . SEPARATOR);

define("REINTEGRO_ACPM", "reintegro_acpm" . SEPARATOR);

define("PRECIOSACPM", "preciosacpm" . SEPARATOR);

define("DOCUMENTAL", "documental" . SEPARATOR);

define("UPLOAD", "upload" . SEPARATOR);

define("ORDENSERVICIO", "ordenservicio" . SEPARATOR);

define("RESPONSABLES", "responsables" . SEPARATOR);

define("COORDINADORES", "coordinadores" . SEPARATOR);



date_default_timezone_set('America/Bogota');


require_once "conexion.php";

?>