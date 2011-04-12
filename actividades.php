<?php

session_start();
//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
//conecto con MySQL
conecta();
//recogemos la información cargando la variable
$docente=$_POST['p1'];
$accion=$_POST['p2'];

switch($accion)
{
case 'registro':
//recogemos variables de formulario
$numero = $_POST['numero'];
//nombre de actividad y ponderación
$activ = $_POST['activ'];
$pond = $_POST['ponderacion'];
$per = $_POST['per'];
//grabamos en la base de datos
for($n=0;$n<$numero;$n++)
	{
	$agrupa[$n] = $_POST[$n];
	if($agrupa[$n])
		{
		$reg_activ = mysql_query("insert into actividades values('$activ','$agrupa[$n]','$pond','$per')");
		}
	}
break;
case 'elimina':
$agrup_eli = $_POST['agrup_eli'];
$activ_eli = $_POST['activ_eli'];
//eliminamos la actividad
$borra_act = mysql_query("delete from actividades where actividad = '$activ_eli' and agrupamiento = '$agrup_eli'");
break;
}//fin switch($accion)

echo '<br/><span class="negrita">'.$id_misactividades.'</span>';
echo '<p>'.$id_texto_actividades.'</p>';

//presento formulario para registrar actividad
echo '<p class="negrita">'.$id_reg_activ.'</p>';
echo '<form id="reg_act" name="reg_act">';
echo '<p>'.$id_nom_activ.': <input id="activ" name="activ" maxlength="20" onclick="presenta(\'oculto\')" /></p>';
	//seleccionamos agrupamientos
	$sel_agr = mysql_query("select agrupamiento from agrupamientos where docente='$docente'");
	$num_agr = mysql_num_rows($sel_agr);
	if($num_agr==0) {echo '<p class="negrita">'.$id_noagrup.'</p>';}
	else
	{
	echo '<div class="oculto" id="oculto">';
	echo '<p class="negrita">'.$id_agr_activ.'</p>';
	echo '<table class="tablacentrada"><tr><td><table><tr>';
	for($a=0;$a<$num_agr;$a++)
		{
		$reg_agr = mysql_fetch_array($sel_agr);
		$agr = $reg_agr['agrupamiento'];
		echo '<td>'.$agr.'<input type="checkbox" id="'.$a.'" name="'.$a.'" value="'.$agr.'" /></td>';
		}//fin for
	echo '</tr></table></td></tr><tr>';
	echo '<td>'.$id_ponderacion_txt.': <input type="text" id="ponderacion" name="ponderacion" size="5" maxlength="5" /></td></tr>';
	echo '<td>'.$id_periodo_txt.':';

	echo '<select id="per" name="per">';
	echo '<option selected="selected" value="*">'.$id_todo_curso.'</option>';
	$sel_per = mysql_query("select * from periodos");
	for($p=0;$p<mysql_num_rows($sel_per);$p++)
		{
		$reg_per = mysql_fetch_array($sel_per);
		echo '<option value="'.$reg_per['periodo'].'">'.$id_evaluacion.' '.$reg_per['periodo'].'</option>';
		}
	echo '</select>';
	echo '</td></tr>';
	echo '<tr><td>';
	echo '<a href="#" title="'.$id_guardar.'" onclick="registraActividad(\''.$docente.'\',\''.$num_agr.'\')"><img src="imgs/guardar.png" alt="'.$id_guardar.'" /></a>&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<a href="#" title="'.$id_cancelar.'" onclick="oculta(\'oculto\')"><img src="imgs/cancelar.png" alt="'.$id_cancelar.'" /></a>';

	echo '</td></tr>';
	echo '</table><br /></div>';
	}//fin de else (sí que hay agrupamientos)
echo '</form>';

//consultamos las actividades ya registradas
$sel_act = mysql_query("select actividades.actividad,actividades.agrupamiento,actividades.ponderacion,actividades.periodo,agrupamientos.agrupamiento from actividades,agrupamientos where agrupamientos.docente = '$docente' and agrupamientos.agrupamiento = actividades.agrupamiento order by actividades.agrupamiento,actividades.actividad");
$num_act = mysql_num_rows($sel_act);
if($num_act == 0)
	{
	echo '<p class="negrita">'.$id_noactiv.'</p>';
	}
else
	{
	echo '<p class="negrita">'.$id_activ_reg.'</p>';
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_eliminar.'</td><td>'.$id_activ.'</td><td>'.$id_agrupamiento.'</td><td>'.$id_ponderacion.'</td><td>'.$id_periodo.'</td>';
	echo '</tr>';
	for($b=0;$b<$num_act;$b++)
		{
		$reg_act = mysql_fetch_array($sel_act);
		$actividad_r = $reg_act['actividad'];
		$agrupamiento_r = $reg_act['agrupamiento'];
		$ponderacion_r = $reg_act['ponderacion'];
		$periodo_r = $reg_act['periodo'];
		if($b%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		echo '<td class="centrado"><a href="#" title="'.$id_eliminar.'" onclick="eliminaActividad(\''.$docente.'\',\''.$actividad_r.'\',\''.$agrupamiento_r.'\')"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a></td>';
		echo '<td class="justificado">';
		//no parece recomendable andar cambiando el nombre a las actividades
		//echo '<a href="#" title="'.$id_edita_act.'" id="actividad_'.$b.'" onclick="editaActividad(\'actividad_'.$b.'\',\'actividad\',\''.$actividad_r.'\',\''.$agrupamiento_r.'\')">'.$actividad_r.'</a>';
		echo ''.$actividad_r.'';
		echo '</td>';
		echo '<td class="justificado">';
		//seleccionamos agrupamientos del docente
		$sel_agr = mysql_query("select agrupamiento from agrupamientos where docente = '$docente'");
		$num_agr = mysql_num_rows($sel_agr);
			for($ag=0;$ag<$num_agr;$ag++)
				{
				$reg_agr = mysql_fetch_array($sel_agr);
				$agr_lis = $reg_agr['agrupamiento'];
				echo '<input id="'.$ag.'" value="'.$agr_lis.'" type="hidden" />';			
				}//fin for agr
		echo '<a href="#" title="'.$id_edita_act.'" id="agrupamiento_'.$b.'" onclick="editaActividadAgr(\'agrupamiento_'.$b.'\',\'agrupamiento\',\''.$actividad_r.'\',\''.$agrupamiento_r.'\',\''.$num_agr.'\')">'.$agrupamiento_r.'</a>';
		echo '</td>';
		echo '<td>';
		echo '<a href="#" title="'.$id_edita_act.'" id="ponderacion_'.$b.'" onclick="editaActividad(\'ponderacion_'.$b.'\',\'ponderacion\',\''.$actividad_r.'\',\''.$agrupamiento_r.'\')">'.$ponderacion_r.'</a>';
		echo '</td>';
		echo '<td>';
		if($periodo_r=='*') $nombre_per=$id_todo_curso;
		else $nombre_per=''.$id_evaluacion.' '.$periodo_r.'';
		//seleccionamos períodos de evaluación
		$sel_periodos = mysql_query("select periodo from periodos");
		$num_periodos = mysql_num_rows($sel_periodos);
			for($pe=0;$pe<$num_periodos;$pe++)
				{
				$reg_periodos = mysql_fetch_array($sel_periodos);
				$per_lis = $reg_periodos['periodo'];
				echo '<input id="p'.$pe.'" value="'.$per_lis.'" type="hidden" />';			
				}//fin for per
				$t=$num_periodos;
				echo '<input id="p'.$t.'" value="*" type="hidden" />';
		echo '<a href="#" title="'.$id_edita_act.'" id="periodo_'.$b.'" onclick="editaActividadPer(\'periodo_'.$b.'\',\'periodo\',\''.$actividad_r.'\',\''.$agrupamiento_r.'\',\''.$num_periodos.'\')">'.$nombre_per.'</a>';
		echo '</td>';
		echo '</tr>';
		}//fin de for
	echo '</table><br />';
	}//fin de else (sí que hay actividades registradas)

}//fin hay sesión

?>


