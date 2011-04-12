<?php

session_start();

//incluimos funciones,configuración e idioma
include('../funciones.php');
require('../config.php');
require('../idioma/'.$idioma.'');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo 'SIESTTA 2.0: '.$nombre_centro.' '.$id_admin_sist.''; ?></title>
<link href="../index.css" rel="stylesheet" type="text/css" />
<script src="../js/prototype.js" type="text/javascript"></script>
<script src="../js/effects.js" type="text/javascript"></script>
<script src="../js/scriptaculous.js" type="text/javascript"></script>
<script src="../js/funciones.js" type="text/javascript"></script>
<script src="../js/litbox.js" type="text/javascript"></script>
<script src="../js/litboxflash.js" type="text/javascript"></script>
</head>
<body>
<?php
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']) && $_SESSION['rol_sesion'] == 'admin')
{
$nombre=$_SESSION['nombre_sesion'];
$apellidos=$_SESSION['apellidos_sesion'];
echo '<div id="contenedor">';
echo '<div id="header">';
echo '<span class="blanco"><img src="../imgs/usuario.png" /><a href="'.$web.'" target="_blank">'.$nombre.' '.$apellidos.'</a></span>';
echo '<span id="cargando" /><img src="../imgs/cargando.gif" title="'.$id_cargando.'" /></span>';
echo '</div>';
echo '<div id="left">';
//cargamos menú lateral
require('menu.php');
echo '</div>';
//presentamos el divisor principal donde aparecerá el contenido de la opción seleccionada
echo '<div id="center">';
echo '</div>';
////////////////////////////////////////////////////////////////////////
////////mantener esta nota//////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
echo '<div id="footer">';
echo '<br/>';
echo '<a id="web" href="http://siestta.org" target="_blank">SIESTTA 2.0</a> es software libre bajo licencia <a id="gnu" href="http://www.gnu.org/copyleft/gpl.html" target="_blank">GNU General Public License</a>';
echo '<br />';
echo '<a id="autorweb" href="http://ramoncastro.es" target="_blank">Ram&oacute;n Castro P&eacute;rez</a> 2007';
echo '</div>';
echo '</div>';
////////////////////////////////////////////////////////////////////////
//////////fin nota a mantener//////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
}//fin de if sesión
?>
</body>
</html>
