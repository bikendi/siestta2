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
$alumno = $_GET['alu'];
echo '<br />';
echo '<table class="tablacentradafija">';
echo '<tr>';
echo '<td>';
if (file_exists('fotos_al/'.$alumno.'.jpg'))
	{ 
	echo '<img class="borde" src="fotos_al/'.$alumno.'.jpg" alt="'.$alumno.'" />';
	}
else
	{
	echo '<img class="borde" src="fotos_al/nofoto.jpg" alt="'.$alumno.'" />';
	}
echo '</td>';
echo '<td>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<br />';
conecta();
//seleccionamos datos del docente
$sel_alu = mysql_query("select * from alumnado where codigo = '$alumno'");
$reg_alu = mysql_fetch_array($sel_alu);
$codigo = $reg_alu['codigo'];
$nombre = $reg_alu['nombre'];
$apellidos = $reg_alu['apellidos'];
	//cambio formato fecha
	$fecha_nac_esp = cambia_fecha_a_esp($reg_alu['f_nac']);
$grupo = $reg_alu['grupo'];
$modalidad = $reg_alu['modalidad'];
$repite = $reg_alu['repite'];
	if($repite == '0') $rep = $id_no; else $rep = $id_si;
$nacionalidad = $reg_alu['nacionalidad'];
$email = $reg_alu['mail'];
$web = $reg_alu['weblog'];
$te1 = $reg_alu['telef1'];
$te2 = $reg_alu['telef2'];
$tutor1 = $reg_alu['tutor1'];
$tutor2 = $reg_alu['tutor2'];
$dir1 = $reg_alu['direccion1'];
$dir2 = $reg_alu['direccion2'];
echo '
<form>
<table class="tablacentrada">
   <tr class="encab">
     	<td>'.$id_cod.'</td>
	<td>'.$id_nom.'</td>
	<td>'.$id_ape.'</td>
	<td>'.$id_fna.'</td>	
   </tr>
   <tr>
	<td class="centrado">'.$codigo.'</td>
      	<td><input id="nombre" type="text" maxlength="40" value="'.$nombre.'" onblur="editaFichaAlu(\'nombre\',\''.$codigo.'\')" /></td>
      	<td><input id="apellidos" type="text" maxlength="60" value="'.$apellidos.'" onblur="editaFichaAlu(\'apellidos\',\''.$codigo.'\')" /></td>
      	<td><input id="f_nac" type="text" maxlength="10" value="'.$fecha_nac_esp.'" onblur="editaFichaAlu(\'f_nac\',\''.$codigo.'\')" /></td>
    </tr>
    <tr class="encab">
	<td>'.$id_gru.'</td>
	<td>'.$id_mod.'</td>
	<td>'.$id_rep.'</td>
	<td>'.$id_nac.'</td>
    </tr>
    <tr>
	<td class="centrado">
	<select id="grupo" onchange="editaFichaAlu(\'grupo\',\''.$codigo.'\')">
	<option select="selected">'.$grupo.'</option>
';

//listamos grupos para componer el select
$sel_grupos = mysql_query("select cod_grupo from grupos");
$num_grupos = mysql_num_rows($sel_grupos);
for($n=0;$n<$num_grupos;$n++)
	{
	$reg_grupos = mysql_fetch_array($sel_grupos);
	$op_grupo = $reg_grupos['cod_grupo'];
	echo '<option>'.$op_grupo.'</option>';
	}
echo '
	</select>
	</td>
	<td><input id="modalidad" type="text" maxlength="8" value="'.$modalidad.'" onblur="editaFichaAlu(\'modalidad\',\''.$codigo.'\')" /></td>
	<td class="centrado">
	<select id="repite" onchange="editaFichaAlu(\'repite\',\''.$codigo.'\')">
	<option select="selected">'.$rep.'</option>
	<option value="0">'.$id_no.'</option>
	<option value="1">'.$id_si.'</option>
	</select>
	</td>
	<td><input id="nacionalidad" type="text" maxlength="20" value="'.$nacionalidad.'" onblur="editaFichaAlu(\'nacionalidad\',\''.$codigo.'\')" /></td>
    </tr>
    <tr class="encab">
      	<td>'.$id_tu1.'</td>
      	<td>'.$id_tu2.'</td>
      	<td>'.$id_di1.'</td>
      	<td>'.$id_di2.'</td>
    </tr>
    <tr>
	<td><input id="tutor1" type="text" maxlength="100" value="'.$tutor1.'" onblur="editaFichaAlu(\'tutor1\',\''.$codigo.'\')" /></td>
	<td><input id="tutor2" type="text" maxlength="100" value="'.$tutor2.'" onblur="editaFichaAlu(\'tutor2\',\''.$codigo.'\')" /></td>
	<td><input id="direccion1" type="text" maxlength="160" value="'.$dir1.'" onblur="editaFichaAlu(\'direccion1\',\''.$codigo.'\')" /></td>
	<td><input id="direccion2" type="text" maxlength="160" value="'.$dir2.'" onblur="editaFichaAlu(\'direccion2\',\''.$codigo.'\')" /></td>
    </tr>
    <tr class="encab">
	<td>'.$id_te1.'</td>
	<td>'.$id_te2.'</td>	
	<td>'.$id_ema.'</td>
	<td>'.$id_web.'</td>
    </tr>
    <tr>
	<td><input id="telef1" type="text" maxlength="9" value="'.$te1.'" onblur="editaFichaAlu(\'telef1\',\''.$codigo.'\')" /></td>
      	<td><input id="telef2" type="text" maxlength="9" value="'.$te2.'" onblur="editaFichaAlu(\'telef2\',\''.$codigo.'\')" /></td>	
      	<td><input id="mail" type="text" maxlength="50" value="'.$email.'" onblur="editaFichaAlu(\'mail\',\''.$codigo.'\')" /></td>
      	<td><input id="weblog" type="text" maxlength="50" value="'.$web.'" onblur="editaFichaAlu(\'weblog\',\''.$codigo.'\')" /></td>
      
    </tr>
</table>
</form>
';

}//fin hay sesión

?>
