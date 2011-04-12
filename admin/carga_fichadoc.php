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
$docente = $_GET['docente'];
echo '<p class="centrado">';
echo '<img src="fotos_doc/'.$docente.'.jpg" alt="'.$docente.'" />';
echo '</p>';
conecta();
//seleccionamos datos del docente
$sel_doc = mysql_query("select * from docentes where docente = '$docente'");
$reg_doc = mysql_fetch_array($sel_doc);
$login = $reg_doc['docente'];
$nombre = $reg_doc['nombre'];
$apellidos = $reg_doc['apellidos'];
$especialidad = $reg_doc['especialidad'];
$email = $reg_doc['email'];
$web = $reg_doc['web'];
$te1 = $reg_doc['telef1'];
$te2 = $reg_doc['telef2'];
echo '
<table class="tablacentrada">
   <tr class="encab">
      <td>'.$id_doc.'</td>
      <td>'.$id_nom.'</td>
      <td>'.$id_ape.'</td>
      <td>'.$id_esp.'</td>
    </tr>
    <tr>
      <td>'.$login.'</td>
      <td>'.$nombre.'</td>
      <td>'.$apellidos.'</td>
      <td>'.$especialidad.'</td>
    </tr>
    <tr class="encab">
      <td>'.$id_ema.'</td>
      <td>'.$id_web.'</td>
      <td>'.$id_te1.'</td>
      <td>'.$id_te2.'</td>
    </tr>
    <tr>
      <td><a href="mailto:'.$email.'">'.$email.'</a></td>
      <td><a href="'.$web.'" target="_blank">'.$web.'</a></td>
      <td>'.$te1.'</td>
      <td>'.$te2.'</td>
    </tr>
</table>
';
echo '<br /><br />';
//seleccionamos los agrupamientos a los que da clase
$sel_agrup = mysql_query("select * from agrupamientos where docente = '$docente'");
$n_agrup = mysql_num_rows($sel_agrup);
echo '
<table class="tablacentrada">
   <tr class="encab">
      <td>'.$id_agrup.'</td>
      <td>'.$id_dep.'</td>
      <td>'.$id_mat.'</td>
      <td>'.$id_cur.'</td>
      <td>'.$id_niv.'</td>
    </tr>
';
for($i=0;$i<$n_agrup;$i++)
	{
	$reg_agrup = mysql_fetch_array($sel_agrup);
	$agrupamiento = $reg_agrup['agrupamiento'];
	$departamento = $reg_agrup['departamento'];
	$materia = $reg_agrup['materia'];
	$curso = $reg_agrup['curso'];
	$nivel = $reg_agrup['nivel'];
	if($i%2==0){echo '<tr class="par">';}else{echo '<tr>';}	
	echo '
	<td>'.$agrupamiento.'</td>
      	<td>'.$departamento.'</td>
      	<td>'.$materia.'</td>
      	<td>'.$curso.'</td>
      	<td>'.$nivel.'</td>
	</tr>
	';
	}
echo '</table>';

}//fin hay sesión
