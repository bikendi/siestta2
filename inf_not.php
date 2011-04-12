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
$act_post = $_POST['act'];
$per_post = $_POST['per'];

echo '<br/><span class="negrita">'.$id_inf_not.'</span>';

echo '<p class="centrado"><select id="agr" onchange="cargaAlumnos(\'inf_not.php\')">';
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
	echo '<select id="alu" onchange="listaActividades(\''.$agr_post.'\')">';
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
		else
			{
			echo '<option selected="selected">'.$id_todos_al.'</option>';
			}
		}
	echo '<option>'.$id_elgalu.'</option>';
	echo '<option value="*">'.$id_todos_al.'</option>';
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

//echo '</p>';

//si vengo ya de seleccionar alumno

if($alu_post)
	{
	echo '<select id="act" onchange="listaPerEval(\''.$agr_post.'\',\''.$alu_post.'\')">';
	if($act_post)
		{
		if($act_post=='*')
			{
			echo '<option selected="selected">'.$id_todas_act.'</option>';
			}
		else
			{
			echo '<option selected="selected">'.$act_post.'</option>';
			}
		}
	echo '<option>'.$id_elgact.'</option>';
	echo '<option value="*">'.$id_todas_act.'</option>';
	$sel_act=mysql_query("select * from actividades where agrupamiento='$agr_post'");
	$num_act=mysql_num_rows($sel_act);
	for($ac=0;$ac<$num_act;$ac++)
		{
		$reg_act=mysql_fetch_array($sel_act);
		$actividad=$reg_act['actividad'];
		$ponderacion=$reg_act['ponderacion'];
		echo '<option>'.$actividad.'</option>';
		}
	echo '</select>';
	}//fin alu_post

if($act_post)
	{
	echo '<select id="per" onchange="notas(\''.$agr_post.'\',\''.$alu_post.'\',\''.$act_post.'\')">';
	if($per_post)
		{
		echo '<option selected="selected" value="'.$per_post.'">'.$id_evaluacion.' '.$per_post.'</option>';
		}
	echo '<option>'.$id_elgper.'</option>';
	$sel_per=mysql_query("select * from periodos");
	$num_per=mysql_num_rows($sel_per);
	for($p=0;$p<$num_per;$p++)
		{
		$reg_per=mysql_fetch_array($sel_per);
		$periodo=$reg_per['periodo'];
		echo '<option value="'.$periodo.'">'.$id_evaluacion.' '.$periodo.'</option>';
		}
	echo '<option>'.$id_final.'</option>';
	echo '<option>'.$id_finalF.'</option>';
	echo '</select>';
	}

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////LISTADOS DE NOTAS////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
if($agr_post && $alu_post && $act_post && $per_post)
{

///////////////////////////////////////1 ALUMNO + 1 ACTIVIDAD + 1 PERÍODO/////////////////////////////
//listaré todas las notas y luego calculo su media /////////////////
if($agr_post != $elgagr && $alu_post != '*' && $alu_post != $id_elgalu && $act_post != '*' && $act_post != $id_elgact && $per_post != $id_final && $per_post != $id_finalF && $per_post != $id_elgper)
{
$sel_notas = mysql_query("select notas.codigo,notas.agrupamiento,notas.fecha,notas.actividad,notas.nota,notas.descripcion,notas.comentario,periodos.periodo,periodos.inicio,periodos.fin from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$act_post' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
$num_notas = mysql_num_rows($sel_notas);
if($num_notas>0)
	{
	echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_fecha.'</td><td>'.$id_descrip.'</td><td>'.$id_nota.'</td><td>'.$id_coment.'</td></tr>';
	for($n=0;$n<$num_notas;$n++)
		{
		$reg_notas = mysql_fetch_array($sel_notas);
		$fecha_nota = $reg_notas['fecha'];
		$fecha_nota_esp = cambia_fecha_a_esp($fecha_nota);
		if($n%2==0)echo '<tr class="par">';else echo '<tr>';
		echo '<td>'.$fecha_nota_esp.'</td>';
		echo '<td>'.$reg_notas['descripcion'].'</td>';
		echo '<td>'.$reg_notas['nota'].'</td>';
		echo '<td>'.$reg_notas['comentario'].'</td>';
		echo '</tr>';
		$matriz[]=$reg_notas['nota'];
		}
	echo '</table>';
	$suma=array_sum($matriz);
	$media=$suma/$num_notas; 
	echo '<p>'.$id_nota_media.': '.round($media,2).'</p>';
	echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\''.$alu_post.'\',\''.$agr_post.'\',\''.$act_post.'\', \''.$per_post.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
	}
else
	{
	echo '<br /><p>'.$id_no_calif.'</p>';
	}


}

///////////////////////////////////////1 ALUMNO + 1 ACTIVIDAD + FINAL/////////////////////////////
//listaré todas las notas, período por período y luego calculo su media /////////////////
if($agr_post != $elgagr && $alu_post != '*' && $alu_post != $id_elgalu && $act_post != '*' && $act_post != $id_elgact && $per_post == $id_final && $per_post != $id_finalF && $per_post != $id_elgper)
{
$sel_per=mysql_query("select * from periodos");
	$num_per=mysql_num_rows($sel_per);
	for($p=0;$p<$num_per;$p++)
		{
		$reg_per=mysql_fetch_array($sel_per);
		$periodo=$reg_per['periodo'];
$sel_notas = mysql_query("select notas.codigo,notas.agrupamiento,notas.fecha,notas.actividad,notas.nota,notas.descripcion,notas.comentario,periodos.periodo,periodos.inicio,periodos.fin from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$act_post' and periodos.periodo='$periodo' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
$num_notas = mysql_num_rows($sel_notas);
if($num_notas>0)
	{
	echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_fecha.'</td><td>'.$id_descrip.'</td><td>'.$id_nota.'</td><td>'.$id_coment.'</td></tr>';
	for($n=0;$n<$num_notas;$n++)
		{
		$reg_notas = mysql_fetch_array($sel_notas);
		$fecha_nota = $reg_notas['fecha'];
		$fecha_nota_esp = cambia_fecha_a_esp($fecha_nota);
		if($n%2==0)echo '<tr class="par">';else echo '<tr>';
		echo '<td>'.$fecha_nota_esp.'</td>';
		echo '<td>'.$reg_notas['descripcion'].'</td>';
		echo '<td>'.$reg_notas['nota'].'</td>';
		echo '<td>'.$reg_notas['comentario'].'</td>';
		echo '</tr>';
		$matriz[]=$reg_notas['nota'];
		}
	echo '</table>';
	$suma=array_sum($matriz);
	$media=$suma/$num_notas; 
	$matriz_media[]=$media;
	echo '<p>'.$id_evaluacion.' '.$periodo.': '.$id_nota_media.': '.round($media,2).'</p>';
	unset($matriz);
	}
else
	{
	echo '<br /><p>'.$id_evaluacion.' '.$periodo.': '.$id_no_calif.'</p>';
	}

		}//fin del for de los períodos
/*$nota_final = array_sum($matriz_media)/$num_per;
$nota_final_red = round($nota_final,2);
echo '<p>'.$id_evaluacion.' '.$per_post.': '.$nota_final_red.'</p>';*/
echo '<p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\''.$alu_post.'\',\''.$agr_post.'\',\''.$act_post.'\', \''.$per_post.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
}


///////////////////////////////////////1 ALUMNO + 1 ACTIVIDAD + FINAL(*)/////////////////////////////
//listaré todas las notas de todos los períodos juntos y luego calculo su media /////////////////
if($agr_post != $elgagr && $alu_post != '*' && $alu_post != $id_elgalu && $act_post != '*' && $act_post != $id_elgact && $per_post != $id_final && $per_post == $id_finalF && $per_post != $id_elgper)
{
$sel_notas = mysql_query("select * from notas where codigo = '$alu_post' and agrupamiento = '$agr_post' and actividad = '$act_post' order by fecha desc");
$num_notas = mysql_num_rows($sel_notas);
if($num_notas>0)
	{
	echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_fecha.'</td><td>'.$id_descrip.'</td><td>'.$id_nota.'</td><td>'.$id_coment.'</td></tr>';
	for($n=0;$n<$num_notas;$n++)
		{
		$reg_notas = mysql_fetch_array($sel_notas);
		$fecha_nota = $reg_notas['fecha'];
		$fecha_nota_esp = cambia_fecha_a_esp($fecha_nota);
		if($n%2==0)echo '<tr class="par">';else echo '<tr>';
		echo '<td>'.$fecha_nota_esp.'</td>';
		echo '<td>'.$reg_notas['descripcion'].'</td>';
		echo '<td>'.$reg_notas['nota'].'</td>';
		echo '<td>'.$reg_notas['comentario'].'</td>';
		echo '</tr>';
		$matriz[]=$reg_notas['nota'];
		}
	echo '</table>';
	$suma=array_sum($matriz);
	$media=$suma/$num_notas; 
	echo '<p>'.$id_nota_media.': '.round($media,2).'</p>';
	echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\''.$alu_post.'\',\''.$agr_post.'\',\''.$act_post.'\', \''.$per_post.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
	}
else
	{
	echo '<br /><p>'.$id_no_calif.'</p>';
	}


}

///////////////////////////////////////1 ALUMNO + TODAS LAS ACTIVIDADES + 1 PERÍODO/////////////////////////////
//calculo la media de cada actividad, la ofrezco, la filtro por ponderación y las sumo finalmente/////////////
if($agr_post != $elgagr && $alu_post != '*' && $alu_post != $id_elgalu && $act_post == '*' && $act_post != $id_elgact && $per_post != $id_final && $per_post != $id_finalF && $per_post != $id_elgper)
{
$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agr_post' and periodo='$per_post' or agrupamiento='$agr_post' and periodo='*'");
$num_activ = mysql_num_rows($sel_activ);
if($num_activ>0)
	{
	echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_activ.'</td><td>'.$id_nota_media.'</td><td>'.$id_ponderacion.'</td><td>'.$id_nota_media_pond.'</td></tr>';
	for($a=0;$a<$num_activ;$a++)
		{
		$reg_activ = mysql_fetch_array($sel_activ);
		$actividad = $reg_activ['actividad'];
 		$pond = $reg_activ['ponderacion'];
		$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
		$num_nota = mysql_num_rows($sel_nota);
		if($num_nota>0)
			{
			$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
			$num_notas = mysql_num_rows($sel_notas);		
			$reg_notas = mysql_fetch_array($sel_notas);
			$nota_media = $reg_notas['avg(notas.nota)'];
			if($a%2==0)echo '<tr class="par">';else echo '<tr>';
			echo '<td class="justif">'.$actividad.'</td><td>'.round($nota_media,2).'</td><td>'.$pond.'</td><td>'.round($nota_media*$pond/100,2).'</td></tr>';
			$matriz_nota_media_pond[]=$nota_media*$pond/100;
			$matriz_pond[]=$pond;
			}
		else
			{
			if($a%2==0)echo '<tr class="par">';else echo '<tr>';
			echo '<td>'.$actividad.'</td><td>'.$id_no_calif.'</td><td>'.$pond.'</td><td>'.$id_no_calif.'</td></tr>';
			}
		}
	$count =  count($matriz_nota_media_pond);
	$count_2 = count($matriz_pond);
	if($count > 0 && $count_2 > 0)
	{
	$suma_nota_media = array_sum($matriz_nota_media_pond);
	$suma_pond = array_sum($matriz_pond);
	echo '<tr class="negrita"><td>'.$id_total.'</td><td>'.round($suma_nota_media,2).'</td><td>'.$suma_pond.'</td><td>'.round($suma_nota_media,2).'</td></tr>';
	}
	
	echo '</table>';
	echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\''.$alu_post.'\',\''.$agr_post.'\',\''.$act_post.'\', \''.$per_post.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
	}
else
	{
	echo '<br /><p>'.$id_no_activ.'</p>';
	}


}




///////////////////////////////////////1 ALUMNO + TODAS LAS ACTIVIDADES + FINAL/////////////////////////////
//calculo la media de cada actividad, la ofrezco, la filtro por ponderación y las sumo finalmente/////////////
//////////////////eso para cada período, luego ofrezco la media de las tres evaluaciones////////////////////
if($agr_post != $elgagr && $alu_post != '*' && $alu_post != $id_elgalu && $act_post == '*' && $act_post != $id_elgact && $per_post == $id_final && $per_post != $id_finalF && $per_post != $id_elgper)
{
//selecciono períodos y monto el for
$sel_per = mysql_query("select * from periodos");
$num_per = mysql_num_rows($sel_per);
for ($p=0;$p<$num_per;$p++)
{
$reg_per = mysql_fetch_array($sel_per);
$per_post = $reg_per['periodo'];
$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agr_post' and periodo='$per_post' or agrupamiento='$agr_post' and periodo='*'");
$num_activ = mysql_num_rows($sel_activ);
if($num_activ>0)
	{
	echo '<br />'.$id_evaluacion.' '.$per_post.'<br /><table class="tablacentrada"><tr><td>'.$id_activ.'</td><td>'.$id_nota_media.'</td><td>'.$id_ponderacion.'</td><td>'.$id_nota_media_pond.'</td></tr>';
	for($a=0;$a<$num_activ;$a++)
		{
		$reg_activ = mysql_fetch_array($sel_activ);
		$actividad = $reg_activ['actividad'];
 		$pond = $reg_activ['ponderacion'];
		$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
		$num_nota = mysql_num_rows($sel_nota);
		if($num_nota>0)
			{
			$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
			$num_notas = mysql_num_rows($sel_notas);		
			$reg_notas = mysql_fetch_array($sel_notas);
			$nota_media = $reg_notas['avg(notas.nota)'];
			if($a%2==0)echo '<tr class="par">';else echo '<tr>';
			echo '<td class="justif">'.$actividad.'</td><td>'.round($nota_media,2).'</td><td>'.$pond.'</td><td>'.round($nota_media*$pond/100,2).'</td></tr>';
			$matriz_nota_media_pond[]=$nota_media*$pond/100;
			$matriz_pond[]=$pond;
			}
		else
			{
			if($a%2==0)echo '<tr class="par">';else echo '<tr>';
			echo '<td>'.$actividad.'</td><td>'.$id_no_calif.'</td><td>'.$pond.'</td><td>'.$id_no_calif.'</td></tr>';
			}
		}
	$count =  count($matriz_nota_media_pond);
	$count_2 = count($matriz_pond);
	if($count > 0 && $count_2 > 0)
	{
	$suma_nota_media = array_sum($matriz_nota_media_pond);
	$suma_pond = array_sum($matriz_pond);
	echo '<tr class="negrita"><td>'.$id_total.'</td><td>'.round($suma_nota_media,2).'</td><td>'.$suma_pond.'</td><td>'.round($suma_nota_media,2).'</td></tr>';
	$matriz_final_ev[] = $suma_nota_media;
	unset($matriz_nota_media_pond);
	unset($matriz_pond);
	}
	
	echo '</table>';
	}
else
	{
	echo '<br /><p>'.$id_no_activ.'</p>';
	}

}//fin del for períodos
if(count($matriz_final_ev)>0)
			{
$notafinal = array_sum($matriz_final_ev)/$num_per;
$notafinalred = round($notafinal,2);
echo '<p class="negrita">'.$id_total.': '.$notafinalred.'</p>';
			}
echo '<p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\''.$alu_post.'\',\''.$agr_post.'\',\''.$act_post.'\', \''.$id_final.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p><br />';

}




///////////////////////////////////////1 ALUMNO + TODAS LAS ACTIVIDADES + FINAL(*)/////////////////////////////
if($agr_post != $elgagr && $alu_post != '*' && $alu_post != $id_elgalu && $act_post == '*' && $act_post != $id_elgact && $per_post != $id_final && $per_post == $id_finalF && $per_post != $id_elgper)
{
echo '<br /><br /><p class="negrita">'.$id_texto_no_informecalif.'</p>';
}
///////////////////////////////////////TODOS LOS ALUMNOS + 1 ACTIVIDAD + 1 PERÍODO/////////////////////////////
////consulto alumnos-monto for y listo////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($agr_post != $elgagr && $alu_post == '*' && $alu_post != $id_elgalu && $act_post != '*' && $act_post != $id_elgact && $per_post != $id_final && $per_post != $id_finalF && $per_post != $id_elgper)
{
$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agr_post' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
$num_alum = mysql_num_rows($sel_alum);
echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_Alumno.'</td><td>'.$id_nota.'</td></tr>';
for($a=0;$a<$num_alum;$a++)
{
if($a%2==0)echo '<tr class="par">';else echo '<tr>';
$reg_alum = mysql_fetch_array($sel_alum);
$alu_post=$reg_alum['codigo'];
$nom_post=$reg_alum['nombre'];
$ape_post=$reg_alum['apellidos'];
$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$act_post' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
$num_notas = mysql_num_rows($sel_nota);
if($num_notas>0)
	{
	$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$act_post' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
	$reg_notas = mysql_fetch_array($sel_notas);
	echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td>';
	echo '<td>'.round($reg_notas['avg(notas.nota)'],2).'</td>';
	echo '</tr>';
	}
else
	{
	echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td>';
	echo '<td>'.$id_no_calif.'</td>';
	echo '</tr>';
	}


}//fin for alumnos
echo '</table>';
echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\'*\',\''.$agr_post.'\',\''.$act_post.'\', \''.$per_post.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
}




///////////////////////////////////////TODOS LOS ALUMNOS + 1 ACTIVIDAD + FINAL/////////////////////////////
//idem anterior pero con for delante para los períodos//////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($agr_post != $elgagr && $alu_post == '*' && $alu_post != $id_elgalu && $act_post != '*' && $act_post != $id_elgact && $per_post == $id_final && $per_post != $id_finalF && $per_post != $id_elgper)
{
$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agr_post' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
$num_alum = mysql_num_rows($sel_alum);
echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_Alumno.'</td><td>'.$id_nota.'</td></tr>';
for($a=0;$a<$num_alum;$a++)
{
if($a%2==0)echo '<tr class="par">';else echo '<tr>';
$reg_alum = mysql_fetch_array($sel_alum);
$alu_post=$reg_alum['codigo'];
$nom_post=$reg_alum['nombre'];
$ape_post=$reg_alum['apellidos'];
//selecciono períodos y monto el for
$sel_per = mysql_query("select * from periodos");
$num_per = mysql_num_rows($sel_per);
for ($p=0;$p<$num_per;$p++)
{
$reg_per = mysql_fetch_array($sel_per);
$per_post = $reg_per['periodo'];
$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$act_post' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
$num_notas = mysql_num_rows($sel_nota);
if($num_notas>0)
	{
	$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$act_post' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
	$reg_notas = mysql_fetch_array($sel_notas);
	$nota_eva[] = $reg_notas['avg(notas.nota)'];
	}
}//fin for periodos
if(count($nota_eva) != 0)
	{
	$nota_final = round((array_sum($nota_eva)/count($nota_eva)),2);
	echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td>';
	echo '<td>'.$nota_final.'</td>';
	echo '</tr>';
	array_splice($nota_eva,0,count($nota_eva));
	}
else
	{
	echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td>';
	echo '<td>'.$id_no_calif.'</td>';
	echo '</tr>';
	}
}//fin for alumnos
echo '</table>';
echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\'*\',\''.$agr_post.'\',\''.$act_post.'\', \''.$id_final.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
}




///////////////////////////////////////TODOS LOS ALUMNOS + 1 ACTIVIDAD + FINAL(*)/////////////////////////////
//igual anterior pero sin distinguir períodos/////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($agr_post != $elgagr && $alu_post == '*' && $alu_post != $id_elgalu && $act_post != '*' && $act_post != $id_elgact && $per_post != $id_final && $per_post == $id_finalF && $per_post != $id_elgper)
{
$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agr_post' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
$num_alum = mysql_num_rows($sel_alum);
echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_Alumno.'</td><td>'.$id_nota.'</td></tr>';
for($a=0;$a<$num_alum;$a++)
{
if($a%2==0)echo '<tr class="par">';else echo '<tr>';
$reg_alum = mysql_fetch_array($sel_alum);
$alu_post=$reg_alum['codigo'];
$nom_post=$reg_alum['nombre'];
$ape_post=$reg_alum['apellidos'];

$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$act_post'");
$num_notas = mysql_num_rows($sel_nota);
if($num_notas>0)
	{
	$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$act_post'");
	$reg_notas = mysql_fetch_array($sel_notas);
	$nota_eva[] = $reg_notas['avg(notas.nota)'];
	}
if(count($nota_eva) != 0)
	{
	$nota_final = round((array_sum($nota_eva)/count($nota_eva)),2);
	echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td>';
	echo '<td>'.$nota_final.'</td>';
	echo '</tr>';
	array_splice($nota_eva,0,count($nota_eva));
	}
else
	{
	echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td>';
	echo '<td>'.$id_no_calif.'</td>';
	echo '</tr>';
	}
}//fin for alumnos
echo '</table>';
echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\'*\',\''.$agr_post.'\',\''.$act_post.'\', \''.$id_finalF.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
}


///////////////////////////////////////TODOS LOS ALUMNOS + TODAS LAS ACTIVIDADES + 1 PERÍODO/////////////////////////////
//hago for de alumnos y luego el caso todas las act y 1 período///////////////////////////////////////////////////
if($agr_post != $elgagr && $alu_post == '*' && $alu_post != $id_elgalu && $act_post == '*' && $act_post != $id_elgact && $per_post != $id_final && $per_post != $id_finalF && $per_post != $id_elgper)
{
$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agr_post' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
$num_alum = mysql_num_rows($sel_alum);
echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_Alumno.'</td><td>'.$id_nota.'</td></tr>';
for($al=0;$al<$num_alum;$al++)
{
if($al%2==0)echo '<tr class="par">';else echo '<tr>';
$reg_alum = mysql_fetch_array($sel_alum);
$alu_post=$reg_alum['codigo'];
$nom_post=$reg_alum['nombre'];
$ape_post=$reg_alum['apellidos'];


$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agr_post' and periodo='$per_post' or agrupamiento='$agr_post' and periodo='*'");
$num_activ = mysql_num_rows($sel_activ);
if($num_activ>0)
	{
	for($a=0;$a<$num_activ;$a++)
		{
		$reg_activ = mysql_fetch_array($sel_activ);
		$actividad = $reg_activ['actividad'];
 		$pond = $reg_activ['ponderacion'];
		$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
		$num_nota = mysql_num_rows($sel_nota);
		if($num_nota>0)
			{
			$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
			$num_notas = mysql_num_rows($sel_notas);		
			$reg_notas = mysql_fetch_array($sel_notas);
			$nota_media = $reg_notas['avg(notas.nota)'];
			$matriz_nota_media_pond[]=$nota_media*$pond/100;			
			}		
		}//fin for actividades
	$count =  count($matriz_nota_media_pond);
	if($count > 0)
		{
		$suma_nota_media = array_sum($matriz_nota_media_pond);
		//veremos si hay nota de recuperación
		$sel_recu = mysql_query("select nota from recuperaciones where periodo = '$per_post' and codigo ='$alu_post' and agrupamiento = '$agr_post'");
		$num_recu = mysql_num_rows($sel_recu);
		if($num_recu>0)
			{
			$reg_recu = mysql_fetch_array($sel_recu);
			echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td><td>'.round($suma_nota_media,2).' (R '.$reg_recu['nota'].')</td></tr>';
			}
		else
			{
			$reg_recu = mysql_fetch_array($sel_recu);
			echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td><td>'.round($suma_nota_media,2).'';
			//si hay nota revisada
			$sel_notas_rev=mysql_query("select * from notas_rev where codigo='$alu_post' and agrupamiento='$agr_post' and periodo='".$per_post."'");
			if(mysql_num_rows($sel_notas_rev)>0)
				{
				$reg_notas_rev=mysql_fetch_array($sel_notas_rev);
				echo '<br/>Calificación final: '.$nota_rev=$reg_notas_rev['nota'].'';
				}
			echo'</td></tr>';
			}
		unset($matriz_nota_media_pond);
		}
	else
		{
		echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td><td>'.$id_no_calif.'</td></tr>';
		}	
	}

}//fin for alumnos
echo '</table>';
echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\'*\',\''.$agr_post.'\',\'*\', \''.$per_post.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
}



///////////////////////////////////////TODOS LOS ALUMNOS + TODAS LAS ACTIVIDADES + FINAL/////////////////////////////
//igual que el anterior pero con el for de períodos dentro de cada alumno////////////////////////////////////////////////////
if($agr_post != $elgagr && $alu_post == '*' && $alu_post != $id_elgalu && $act_post == '*' && $act_post != $id_elgact && $per_post == $id_final && $per_post != $id_finalF && $per_post != $id_elgper)
{
$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agr_post' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
$num_alum = mysql_num_rows($sel_alum);
echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_Alumno.'</td><td>'.$id_nota.'</td></tr>';
for($al=0;$al<$num_alum;$al++)
{
if($al%2==0)echo '<tr class="par">';else echo '<tr>';
$reg_alum = mysql_fetch_array($sel_alum);
$alu_post=$reg_alum['codigo'];
$nom_post=$reg_alum['nombre'];
$ape_post=$reg_alum['apellidos'];

//selecciono períodos y monto el for
$sel_per = mysql_query("select * from periodos");
$num_per = mysql_num_rows($sel_per);
for ($p=0;$p<$num_per;$p++)
{
$reg_per = mysql_fetch_array($sel_per);
$per_post = $reg_per['periodo'];
//comprobamos si para el período hay nota revisada
$sel_notas_rev=mysql_query("select * from notas_rev where codigo='$alu_post' and agrupamiento='$agr_post' and periodo='".$per_post."'");
//si hay nota revisada, no hacemos la media ponderada de las actividades
if(mysql_num_rows($sel_notas_rev)>0)
{
$reg_notas_rev=mysql_fetch_array($sel_notas_rev);
$matriz_nota_media_pond[]=$reg_notas_rev['nota'];
} 
else
{
$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agr_post' and periodo='$per_post' or agrupamiento='$agr_post' and periodo='*'");
$num_activ = mysql_num_rows($sel_activ);
if($num_activ>0)
	{
	for($a=0;$a<$num_activ;$a++)
		{
		$reg_activ = mysql_fetch_array($sel_activ);
		$actividad = $reg_activ['actividad'];
 		$pond = $reg_activ['ponderacion'];
		$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
		$num_nota = mysql_num_rows($sel_nota);
		if($num_nota>0)
			{
			$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
			$num_notas = mysql_num_rows($sel_notas);		
			$reg_notas = mysql_fetch_array($sel_notas);
			$nota_media = $reg_notas['avg(notas.nota)'];
			$matriz_nota_media_pond[]=$nota_media*$pond/100;			
			}		
		}//fin for actividades
}//fin de else
	$count =  count($matriz_nota_media_pond);
	if($count > 0)
		{
		$suma_nota_media = array_sum($matriz_nota_media_pond);
		//veremos si hay nota de recuperación
		$sel_recu = mysql_query("select nota from recuperaciones where periodo = '$per_post' and codigo ='$alu_post' and agrupamiento = '$agr_post'");
		$num_recu = mysql_num_rows($sel_recu);
		if($num_recu>0)
			{
			$recu='si';
			$reg_recu = mysql_fetch_array($sel_recu);
			$matriz_eval[]=$suma_nota_media;
			$matriz_eval_recu[]=$reg_recu['nota'];
			}
		else
			{
			$matriz_eval[]=$suma_nota_media;
			$matriz_eval_recu[]=$suma_nota_media;
			}
		unset($matriz_nota_media_pond);
		}
	}
}//fin for períodos
if(count($matriz_eval)>0)
	{
	$suma_eval = array_sum($matriz_eval);
	$nota_final = $suma_eval/count($matriz_eval);
	if($recu=='si')
		{
		$suma_eval_recu = array_sum($matriz_eval_recu);
		$nota_finalR = $suma_eval_recu/count($matriz_eval_recu);
		echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td><td>'.round($nota_final,2).' (R: '.round($nota_finalR,2).')</td></tr>';
		}
	else
		{
		echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td><td>'.round($nota_final,2).'</td></tr>';
		}
	unset($matriz_eval);
	unset($matriz_eval_recu);
	unset($recu);
	}
else
	{
	echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td><td>'.$id_no_calif.'</td></tr>';
	}
}//fin for alumnos

echo '</table>';
echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\'*\',\''.$agr_post.'\',\'*\', \''.$id_final.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
}






///////////////////////////////////////TODOS LOS ALUMNOS + TODAS LAS ACTIVIDADES + FINAL_F/////////////////////////////
if($agr_post != $elgagr && $alu_post == '*' && $alu_post != $id_elgalu && $act_post == '*' && $act_post != $id_elgact && $per_post != $id_final && $per_post == $id_finalF && $per_post != $id_elgper)
{
//comprobamos si el docente no tiene actividades específicas por período
$sel_per_act = mysql_query("select * from actividades where agrupamiento = '$agr_post' and periodo != '*'");
$num_per_act = mysql_num_rows($sel_per_act);
if($num_per_act == 0)
	{
	$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agr_post' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alum = mysql_num_rows($sel_alum);
	echo '<br /><br /><table class="tablacentrada"><tr><td>'.$id_Alumno.'</td><td>'.$id_nota.'</td></tr>';
	for($al=0;$al<$num_alum;$al++)
		{
		if($al%2==0)echo '<tr class="par">';else echo '<tr>';
		$reg_alum = mysql_fetch_array($sel_alum);
		$alu_post=$reg_alum['codigo'];
		$nom_post=$reg_alum['nombre'];
		$ape_post=$reg_alum['apellidos'];


		$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agr_post' and periodo='*'");
		$num_activ = mysql_num_rows($sel_activ);
		if($num_activ>0)
			{
			for($a=0;$a<$num_activ;$a++)
				{
				$reg_activ = mysql_fetch_array($sel_activ);
				$actividad = $reg_activ['actividad'];
 				$pond = $reg_activ['ponderacion'];
				$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$actividad'");
			$num_nota = mysql_num_rows($sel_nota);
			if($num_nota>0)
				{
				$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agr_post' and notas.actividad='$actividad'");
				$num_notas = mysql_num_rows($sel_notas);		
				$reg_notas = mysql_fetch_array($sel_notas);
				$nota_media = $reg_notas['avg(notas.nota)'];
				$matriz_nota_media_pond[]=$nota_media*$pond/100;			
				}		
			}//fin for actividades
		$count =  count($matriz_nota_media_pond);
		if($count > 0)
			{
			$suma_nota_media = array_sum($matriz_nota_media_pond);
			//veremos si hay nota de recuperación
			$sel_recu = mysql_query("select nota,periodo from recuperaciones where codigo ='$alu_post' and agrupamiento = '$agr_post'");
			$num_recu = mysql_num_rows($sel_recu);
			if($num_recu>0)
				{
				echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td><td>'.round($suma_nota_media,2).'';
				for($r=0;$r<$num_recu;$r++)
					{
					$reg_recu=mysql_fetch_array($sel_recu);
					echo ' (R'.$reg_recu['periodo'].': '.$reg_recu['nota'].')';
					}
				echo '</td></tr>';
				}
			else
				{
				$reg_recu = mysql_fetch_array($sel_recu);
				echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td><td>'.round($suma_nota_media,2).'</td></tr>';
				}
			unset($matriz_nota_media_pond);
			}
		else
			{
			echo '<td class="justificado">'.$ape_post.', '.$nom_post.'</td><td>'.$id_no_calif.'</td></tr>';
			}	
		}

	}//fin for alumnos
	echo '</table>';
	echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf3(\'notas.php\',\'*\',\''.$agr_post.'\',\'*\', \''.$id_finalF.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
		}
else
	{
	echo '<br /><br /><p class="negrita">'.$id_texto_no_informecalif.'</p>';
	}
}


////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////FIN LISTADOS DE NOTAS////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////
}//fin if listado de notas
}//fin if hay sesión

?>