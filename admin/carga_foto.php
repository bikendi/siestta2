<?
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
//incluimos funciones,configuración e idioma
include('../funciones.php');
require('../config.php');
require('../idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']) && $_SESSION['rol_sesion'] == 'admin')
{
$usuario = $_GET['usuario'];
$imagen = 'fotos_doc/'.$usuario.'.jpg';
echo '<p style="text-align:center;">
<img style="border:1px solid black;" src="'.$imagen.'" alt="'.$usuario.'" /></p>
';
}
?> 
