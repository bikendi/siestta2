<?php

session_start();

//si acabamos de subir el paquete, debemos configurarlo

if (file_exists('instalacion/index.php'))
	{
	$self = str_replace( '/index.php','', strtolower( $_SERVER['PHP_SELF'] ) ). '/';
	header("Location: http://" . $_SERVER['HTTP_HOST'] . $self . "instalacion/index.php" );
	exit();
	}

/*
This file is part of SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado).

SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) is developed by Ram&oacute;n Castro P&eacute;rez. You can get more information at http://www.ramoncastro.es

SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) includes  the FPDF class (http://www.fpdf.org) in the “pdf” directory and some scripts use this class.

SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	
You cand find a copy of the GNU General Public License in the "license" directory.

You should have received a copy of the GNU General Public License along with SIESTTA; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA.  
*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIESTTA 2.0</title>
<link href="index.css" rel="stylesheet" type="text/css" />
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js" type="text/javascript"></script>
<script type="text/javascript">
function carga(){
new Effect.Appear(document.getElementById('login'));
new Effect.Appear(document.getElementById('licencia'));
}
</script>
<script type="text/javascript">
var navegador = navigator.appName
if (navegador == "Microsoft Internet Explorer")
	{
	alert('SIESTTA 2.0 no funciona con este navegador. Se recomienda el uso de Firefox 2.0');
	}
</script>


</head>
<body onload="carga()" style="background:#eec;">
<br />
<br />
<br />
<br />
<br />
<div id="logo">
<br />
<img src="imgs/logo.png" alt="SIESTTA 2.0" />
<br />
<span id="licencia" style="display:none">
SIESTTA 2.0
<br />
Gesti&oacute;n Integral de Aula
<br />
<a href="http://siestta.org" target="_blank">SIESTTA</a> es Software Libre bajo licencia <a id="gnu" href="http://www.gnu.org/copyleft/gpl.html" target="_blank">GNU General Public License</a>
</span>
</div>
<div id="entrada">
<form action="panel.php" method="post">
<span id="login" style="display:none">
Nombre: <input type="text" name="txt_login" maxlength="6" size="6" />
Clave: <input type="password" name="pwd_clave" maxlength="6" size="6" />
<input type="submit" value="Entrar" />
</span>
</form>
</div>
<br />
<br />
<br />
<br />
<br />
<p id="pd">
<a href="pd.php">Protección de datos</a>
<p>
</body>
</html>
