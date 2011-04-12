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
$alu_post = $_POST['alu'];
$accion = $_POST['p1'];

if($_POST['fecha']) 
	{
	$fecha = $_POST['fecha'];
	}
else
	{
	$fecha = date('Y-m-d');
	}

echo '<br/><span class="negrita">'.$id_inf_eva.'</span>';

if(!$accion)
{
echo '<p class="centrado"><select id="agr" onchange="cargaAlumnos(\'inf_eva.php\')">';
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
	{
	echo '<select id="alu" onchange="presentaEval(\''.$agr_post.'\')">';
	if($alu_post)
		{
		$sel_alu=mysql_query("select nombre,apellidos from alumnado where codigo='$alu_post'");
		if(mysql_num_rows($sel_alu)>0)
			{
			$reg_alu=mysql_fetch_array($sel_alu);
			$nombre=$reg_alu['nombre'];
			$apellidos=$reg_alu['apellidos'];
			echo '<option selected="selected">'.$nombre.' '.$apellidos.'</option>';
			}
		}
	echo '<option>'.$id_elgalu.'</option>';
	$sel_alu=mysql_query("select matricula.codigo,matricula.agrupamiento,alumnado.codigo,alumnado.nombre,alumnado.apellidos from matricula,alumnado where matricula.agrupamiento='$agr_post' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alu=mysql_num_rows($sel_alu);
	for($b=0;$b<$num_alu;$b++)
		{
		$reg_alu=mysql_fetch_array($sel_alu);
		$codigo=$reg_alu['codigo'];
		$nombre=$reg_alu['nombre'];
		$apellidos=$reg_alu['apellidos'];
		echo '<option value="'.$codigo.'">'.$apellidos.', '.$nombre.'</option>';
		}
	echo '</select>';
	}

//si ya he seleccionado el alumno

if($alu_post)
	{
	$sel_inf = mysql_query("select distinct fecha from evaluacion where codigo='$alu_post' and agrupamiento = '$agr_post' order by fecha");
	if(mysql_num_rows($sel_inf)>0)
		{
		echo '<br /><br /><table class="tablacentrada">';
		echo '<tr><td>'.$id_accion.'</td><td>'.$id_fecha.'</td></tr>';
		$num_inf = mysql_num_rows($sel_inf);
		for($i=0;$i<$num_inf;$i++)
			{
			if($i%2==0)echo '<tr class="par">';else echo'<tr>';
			$reg_inf = mysql_fetch_array($sel_inf);
			$fecha = $reg_inf['fecha'];
			$fecha_esp = cambia_fecha_a_esp($fecha);
			$descrip = $reg_inf['descripcion'];
			echo '<td class="centrado">';
			echo '<br />';
			echo '<a href="#" title="'.$id_pdf.'" onclick="pdf2(\'evaluacion.php\',\''.$alu_post.'\',\''.$agr_post.'\',\''.$fecha.'\')"><img src="imgs/informe_peq.png" alt="'.$id_pdf.'" /></a>';
			echo '<br />';echo '<br />';
			echo '<a href="#" onclick="editaEvaluacion(\''.$agr_post.'\',\''.$alu_post.'\',\''.$fecha.'\')" title="'.$id_editar.'"><img src="imgs/edita_peq.png" alt="'.$id_editar.'" /></a>';
			echo '<br />';
			echo '</td>';
			echo '<td>'.$fecha_esp.'</td></tr>';
			}
		echo '</table>';
		}
	else
		{
		echo '<br /><p class="negrita">'.$id_no_inf.'</p>';
		}
	echo '<br /><p class="centrado"><a href="#" onclick="redactaEvaluacion(\''.$agr_post.'\',\''.$alu_post.'\')" title="'.$id_red_eval.'"><img src="imgs/mas.png" alt="'.$id_red_eval.'" /></a></p>';

	}
}

else

{

switch($accion)
	{
	case 'redacta':
	$mat_post = $_POST['materia'];
	if($mat_post)
		{
		$not_post = $_POST['nota'];
		$obs_post = $_POST['observaciones'];
		$ins = mysql_query("insert into evaluacion values('','$alu_post','$agr_post','$fecha','$mat_post','$obs_post','$not_post')");
		}
	echo '<br /><br /><select id="alu" onchange="redactaEvaluacion1(\''.$agr_post.'\',\''.$fecha.'\')">';
	if($alu_post)
		{
		$sel_alu=mysql_query("select nombre,apellidos from alumnado where codigo='$alu_post'");
		if(mysql_num_rows($sel_alu)>0)
			{
			$reg_alu=mysql_fetch_array($sel_alu);
			$nombre=$reg_alu['nombre'];
			$apellidos=$reg_alu['apellidos'];
			echo '<option selected="selected">'.$nombre.' '.$apellidos.'</option>';
			}
		}
	echo '<option>'.$id_elgalu.'</option>';
	$sel_alu=mysql_query("select matricula.codigo,matricula.agrupamiento,alumnado.codigo,alumnado.nombre,alumnado.apellidos from matricula,alumnado where matricula.agrupamiento='$agr_post' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alu=mysql_num_rows($sel_alu);
	for($b=0;$b<$num_alu;$b++)
		{
		$reg_alu=mysql_fetch_array($sel_alu);
		$codigo=$reg_alu['codigo'];
		$nombre=$reg_alu['nombre'];
		$apellidos=$reg_alu['apellidos'];
		echo '<option value="'.$codigo.'">'.$apellidos.', '.$nombre.'</option>';
		}
	echo '</select>';
	echo '<br /><span class="negrita">'.cambia_fecha_a_esp($fecha).'</span>';
	echo '<br /><table class="tablacentrada"><tr><td>'.$id_mat.'</td><td>'.$id_nota.'</td><td>'.$id_obs.'</td></tr>';
	$sel_anotaciones = mysql_query("select * from evaluacion where codigo='$alu_post' and agrupamiento='$agr_post' and fecha = '$fecha'");
	$num_anotaciones = mysql_num_rows($sel_anotaciones);
	if($num_anotaciones > 0)
		{
		for($a=0;$a<$num_anotaciones;$a++)
			{
			$reg_anotaciones = mysql_fetch_array($sel_anotaciones);
			$id = $reg_anotaciones['id'];
			$materia = $reg_anotaciones['materia'];
			$observaciones = $reg_anotaciones['observaciones'];
			$nota = $reg_anotaciones['nota'];
			if($a%2==0)echo '<tr class="par">';else echo '<tr>';
			echo '<td class="justificado">';
			echo '<a href="#" title="'.$id_editar.'" id="materia_'.$a.'" onclick="editaApunteEval(\'materia_'.$a.'\',\'materia\',\''.$id.'\')">'.$materia.'</a>';
			echo '</td>';
			echo '<td>';
			echo '<a href="#" title="'.$id_editar.'" id="nota_'.$a.'" onclick="editaApunteEval(\'nota_'.$a.'\',\'nota\',\''.$id.'\')">'.$nota.'</a>';
			echo '</td>';
			echo '<td class="justificado">';
			echo '<a href="#" title="'.$id_editar.'" id="obs_'.$a.'" onclick="editaApunteEval(\'obs_'.$a.'\',\'observaciones\',\''.$id.'\')">';
			if($observaciones == '') echo $id_editar; else echo $observaciones;
			echo '</a>';
			echo '</td></tr>';
			}
		echo '<tr><td>';
		echo '<input type="text" maxlength="50" id="materia"  />';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" size="4" maxlength="5" id="nota" />';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" id="observaciones"  />';
		echo '&nbsp;<a href="#" title="'.$id_guardar.'" onclick="registraApunteEval(\''.$agr_post.'\',\''.$alu_post.'\',\''.$fecha.'\')"><img src="imgs/guarda_peq.png" alt="'.$id_guardar.'" /></a>';
		echo '</td></tr>';
		}
	else
		{
		echo '<tr class="par"><td>';
		echo '<input type="text" maxlength="50" id="materia"  />';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" size="4" maxlength="5" id="nota" />';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" id="observaciones"  />';
		echo '&nbsp;<a href="#" title="'.$id_guardar.'" onclick="registraApunteEval(\''.$agr_post.'\',\''.$alu_post.'\',\''.$fecha.'\')"><img src="imgs/guarda_peq.png" alt="'.$id_guardar.'" /></a>';
		echo '</td></tr>';
		}
	echo '</table>';
	echo '<br /><a href="#" title="'.$id_volver.'" onclick="atrasEval(\''.$agr_post.'\',\''.$alu_post.'\')"><img src="imgs/volver.png" alt="'.$id_volver.'" /></a>';
	break;
	}//fin switch


}




}//fin hay sesión

?>
