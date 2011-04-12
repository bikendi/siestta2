<?php

session_start();
//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
$docente = $_SESSION['usuario_sesion'];
//conecto con MySQL
conecta();

$agr_post=$_POST['agr'];

echo '<br/><span class="negrita">'.$id_inf_bol.'</span>';

echo '<p class="centrado"><select id="agr" onchange="pdf(\'boletines.php\',\'agr\')">';
if($agr_post){echo '<option selected="selected">'.$agr_post.'</option>';}
echo '<option>'.$id_elgagr.'</option>';
$sel_agr=mysql_query("select * from agrupamientos where docente='$docente'");
$num_agr=mysql_num_rows($sel_agr);
for($a=0;$a<$num_agr;$a++)
	{
	$reg_agr=mysql_fetch_array($sel_agr);
	$materia=$reg_agr['materia'];
	$agrupamiento=$reg_agr['agrupamiento'];
	echo '<option value="'.$agrupamiento.'">'.$agrupamiento.' ('.$materia.')</option>';
	}
echo '</select>';

}//fin hay sesión

?>
