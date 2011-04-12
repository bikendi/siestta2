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
$per_post = $_POST['per'];

echo '<br/><span class="negrita">'.$id_inf_tar.'</span>';

echo '<p class="centrado"><select id="agr" onchange="cargaAlumnos(\'inf_tar.php\')">';
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

//si vengo de seleccionar el agrupamiento

if($agr_post)
	{//selecciono los períodos
	echo '<select id="per" onchange="tareas(\''.$agr_post.'\')">';
	if($per_post){echo '<option selected="selected">'.$per_post.'</option>';}
	echo '<option>'.$id_elgper.'</option>';
	$sel_per=mysql_query("select * from periodos");
	$num_per=mysql_num_rows($sel_per);
	for($p=0;$p<$num_per;$p++)
		{
		$reg_per=mysql_fetch_array($sel_per);
		$periodo=$reg_per['periodo'];
		echo '<option value="'.$periodo.'">'.$id_evaluacion.' '.$periodo.'</option>';
		}
	echo '<option>'.$id_todo_curso.'</option>';
	echo '</select>';
	}

/////////////////listamos////////////////////////

if($agr_post && $per_post == $id_todo_curso)
{
	$sel_obs = mysql_query("select agenda.fecha,agenda.cita from agenda,horario where agenda.tipo = 't' and horario.sesion='$agr_post' and agenda.dia=horario.dia and agenda.franja=horario.franja and agenda.docente=horario.docente and agenda.docente = '$docente' order by agenda.fecha desc");
	$num_obs = mysql_num_rows($sel_obs);
	if($num_obs>0)
	{	
	echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_fecha.'</td><td>'.$id_tarea.'</td></tr>';
	for($o=0;$o<$num_obs;$o++)
		{
		$reg_obs = mysql_fetch_array($sel_obs);
		$fecha_obs = $reg_obs['fecha'];
		$fecha_obs_esp = cambia_fecha_a_esp($fecha_obs);
		if($o%2==0)echo '<tr class="par">';else echo '<tr>';
		echo '<td>'.$fecha_obs_esp.'</td>';
		echo '<td>'.$reg_obs['cita'].'</td></tr>';
		}
	echo '</table>';
	echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf1(\'tareas.php\',\''.$agr_post.'\',\''.$id_todo_curso.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
	}
	else
	{
	echo '<br /><br /><p class="negrita">'.$id_no_tareas.'</p>';
	}
}
if($agr_post && $per_post)
{
if($agr_post && $per_post != $id_todo_curso)
{
	$sel_fechas = mysql_query("select * from periodos where periodo = '$per_post'");
	$reg_fechas = mysql_fetch_array($sel_fechas);
	$f_ini = $reg_fechas['inicio'];
	$f_fin = $reg_fechas['fin'];
	$sel_obs = mysql_query("select agenda.fecha,agenda.cita from agenda,horario where agenda.tipo = 't' and horario.sesion='$agr_post' and agenda.dia=horario.dia and agenda.franja=horario.franja and agenda.docente=horario.docente and agenda.docente = '$docente' and agenda.fecha between '$f_ini' and '$f_fin' order by agenda.fecha desc");
	$num_obs = mysql_num_rows($sel_obs);
	if($num_obs>0)
	{
	echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_fecha.'</td><td>'.$id_tarea.'</td></tr>';
	for($o=0;$o<$num_obs;$o++)
		{
		$reg_obs = mysql_fetch_array($sel_obs);
		$fecha_obs = $reg_obs['fecha'];
		$fecha_obs_esp = cambia_fecha_a_esp($fecha_obs);
		if($o%2==0)echo '<tr class="par">';else echo '<tr>';
		echo '<td>'.$fecha_obs_esp.'</td>';
		echo '<td>'.$reg_obs['cita'].'</td></tr>';
		}
	echo '</table>';
	echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf1(\'tareas.php\',\''.$agr_post.'\',\''.$per_post.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
	}
	else
	{
	echo '<br /><br /><p class="negrita">'.$id_no_tareas.'</p>';
	}	
}




}
}//fin hay sesión

?>
