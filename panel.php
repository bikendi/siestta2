<?php

session_start();

//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');

//conectamos con MySQL
conecta();

//comprobamos usuario y clave
if (isset($_POST['txt_login']) && isset($_POST['pwd_clave']))
	{
	$usuario = $_POST['txt_login'];
	$clave = $_POST['pwd_clave'];
	$clave_crip = crypt($clave,'siestta');
	$sel_usuario = mysql_query("select * from docentes where docente = '$usuario' and clave = '$clave_crip'");
	 
	 if(mysql_num_rows($sel_usuario) > 0)
	 	{
	 	$reg_usuario = mysql_fetch_array($sel_usuario);
	 	$nombre = $reg_usuario['nombre'];
	 	$apellidos = $reg_usuario['apellidos'];
	 	$especialidad = $reg_usuario['especialidad'];
	 	$web = $reg_usuario['web'];
	 	$email = $reg_usuario['email'];
		$rol = $reg_usuario['rol'];
			if($rol == '0') $perfil = 'doc';
			if($rol == '1') $perfil = 'admin';
	 		 	
	 	$_SESSION['usuario_sesion'] = $usuario;
	 	$_SESSION['rol_sesion'] = $perfil;
		$_SESSION['nombre_sesion']=$nombre;
		$_SESSION['apellidos_sesion']=$apellidos;
		$_SESSION['especialidad_sesion']=$especialidad;
	 	}
	else
		{
		echo '<p class="centradomedio">'.$mensaje_error.'</p>';
		}
	}

/*
This file is part of SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado).

SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) is developed by Ram&oacute;n Castro P&eacute;rez. You can get more information at http://www.ramoncastro.es or mailing to ramoncastroperez@gmail.com


    Copyright (C) 2007  Ramón Castro Pérez

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo 'SIESTTA 2.0: '.$nombre_centro.''; ?></title>
<link href="index.css" rel="stylesheet" type="text/css" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/effects.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
<script src="js/funciones.js" type="text/javascript" ></script>
<script src="js/rico.js" type="text/javascript"></script>
<script src="js/litbox.js" type="text/javascript"></script>
<script src="js/litboxflash.js" type="text/javascript"></script>
</head>
<?php
$sel_citas = mysql_query("select * from agenda where docente = '".$_SESSION['usuario_sesion']."' and tipo = 'p' and fecha >= now()");
if(mysql_num_rows($sel_citas)>0)
	{
	echo '<body onload="cargaInicio('.date('d').','.date('m').','.date('Y').');new LITBox(\'cita_aviso.php\', {type:\'window\', overlay:true, height:700, width:300, resizable:true});">';
	}
else
	{
	echo '<body onload="cargaInicio('.date('d').','.date('m').','.date('Y').');">';
	}

$usuario_activo = $_SESSION['usuario_sesion'];

if (isset($_SESSION['usuario_sesion']))
{
echo '<div id="contenedor">';
echo '<div id="header">';
$nombre=$_SESSION['nombre_sesion'];
$apellidos=$_SESSION['apellidos_sesion'];
$especialidad=$_SESSION['especialidad_sesion'];
echo '<span class="blanco"><img src="imgs/usuario.png" /><a href="'.$web.'" target="_blank">'.$nombre.' '.$apellidos.'</a> ( '.$especialidad.' )</span>';
echo '<span id="cargando" /><img src="imgs/cargando.gif" title="'.$id_cargando.'" /></span>';

echo '</div>';

echo '<div id="left">';
echo '<div id="calendario">';
require('calendario.php');	
echo '</div>';
require('menu.php');
echo '<div id="parche">';
echo '</div>';
echo '</div>';

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
