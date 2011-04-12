<?php 

session_start();
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
if($_SESSION['familia_sesion'])
	{
	$usuario_a_desconectar = $_SESSION['familia_sesion'];
	}
else
	{
	$usuario_a_desconectar = $_SESSION['usuario_sesion'];
	}

include ('../funciones.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Refresh" content="3; url=index.html">
<title>Desconexi&oacute;n del sistema</title>
<link href="index.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php 

	unset($_SESSION);
	$estado_desconexion = session_destroy();
	if (!empty($usuario_a_desconectar))
		{
			if ($estado_desconexion)
			{
			// si estaban conectados y ahora están desconectados
			$mensaje = 'Gracias por usar Siestta 2.0';
			echo '<p class="centradomedio">'.$mensaje.'</p>';
			echo '</body></html>';
			exit;
			}
			else
			{
			// estaban conectados y no se podían desconectar
			$mensaje = 'No podemos desconectarte en estos momentos.';
			echo '<p class="centradomedio">'.$mensaje.'</p>';
			echo '</body></html>';
			exit;
			}
		}
	else
		{
		// si no estaban conectados pero han llegado aquí de alguna manera
		$mensaje = 'No estabas conectad@, as&iacute; que no puedes desconectarte';
		echo '<p class="centradomedio">'.$mensaje.'</p>';
		echo '</body></html>';
		exit;
		}
?>




