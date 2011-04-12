<?php

session_start();
//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
include("fckeditor/fckeditor.php") ;
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
$docente = $_SESSION['usuario_sesion'];
//conecto con MySQL
conecta();

//recojo variables
$sesion = $_POST['p1'];
$fecha_ing = $_POST['p2'];
$hini = $_POST['p3'];
$accion = $_POST['p4'];
$codigo = $_POST['codigo'];

if(isset($_POST['apellidos']) && isset($_POST['nombre']))
	{
	$nombre_rap = $_POST['nombre'];	
	$ape_rap = $_POST['apellidos'];
	$sel_cod_rap = mysql_query("select matricula.codigo from matricula,alumnado where alumnado.nombre='$nombre_rap' and alumnado.apellidos = '$ape_rap' and matricula.codigo=alumnado.codigo and matricula.agrupamiento='$sesion'");
	$num_cod_rap = mysql_num_rows($sel_cod_rap);
	if($num_cod_rap=='1')
		{
		$reg_cod_rap = mysql_fetch_array($sel_cod_rap);
		$codigo = $reg_cod_rap['codigo'];
		}
	else
		{
		echo '<p class="centrado">';
		for($r=0;$r<$num_cod_rap;$r++)
			{
			$reg_cod_rap = mysql_fetch_array($sel_cod_rap);
			$codigo = $reg_cod_rap['codigo'];
			echo '<a href="#" onclick="abreFicha(\''.$codigo.'\',\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$accion.'\')">'.$nombre_rap.' '.$ape_rap.'</a>&nbsp;';
			}
		echo '</p>';
		}
	}


$sel_alu=mysql_query("select * from alumnado where codigo='$codigo'");
$reg_alu=mysql_fetch_array($sel_alu);
$nombre=$reg_alu['nombre'];
$apellidos=$reg_alu['apellidos'];
$fecha_nac=$reg_alu['f_nac'];
$fecha_nac_esp = cambia_fecha_a_esp($fecha_nac);
$edad=calcula_edad($fecha_nac);
$repite=$reg_alu['repite'];
if($repite=='0'){$repite_sn = $id_no;}else{$repite_sn = $id_si;}
$grupo=$reg_alu['grupo'];

if($hini)
{
echo '<span class="negrita"><a href="#" title="'.$id_volver.'" onclick="abreAgrup(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\')"><img class="alin_bajo" src="imgs/volver.png" alt="'.$id_volver.'" /></a> '.$nombre.' '.$apellidos.'. '.$id_agr.': '.$sesion.'. '.$id_fecha.': '.cambia_fecha_a_esp($fecha_ing).'</span>';
}
else
{
echo '<span class="negrita">'.$nombre.' '.$apellidos.'. '.$id_agr.': '.$sesion.'. '.$id_fecha.': '.cambia_fecha_a_esp($fecha_ing).'</span>';
}
echo '<p class="centrado">';
//consultamos el anterior alumno
$sel_numero_alumnos = mysql_query("select alumnado.codigo from alumnado,matricula where matricula.agrupamiento='$sesion' and matricula.codigo=alumnado.codigo order by apellidos,nombre");
$numero_alumnos = mysql_num_rows($sel_numero_alumnos);
for($na=0;$na<$numero_alumnos;$na++)
	{
	$reg_numero_alumnos = mysql_fetch_array($sel_numero_alumnos);
	$codigo_alumno = $reg_numero_alumnos['codigo'];
	if($codigo_alumno==$codigo)
		{
		if($na+1==1)
			{
			$numero_alumno = $numero_alumnos-1;
			}
		else
			{
			$numero_alumno = $na-1;
			}
		$na=($numero_alumnos-1);
		}
	}
$sel_anterior_alumno = mysql_query("select alumnado.codigo from alumnado,matricula where matricula.agrupamiento='$sesion' and matricula.codigo=alumnado.codigo order by apellidos,nombre limit ".$numero_alumno.",1");
$reg_anterior_alumno = mysql_fetch_array($sel_anterior_alumno);
$codigo_anterior = $reg_anterior_alumno['codigo'];
//listo 
echo '<br /><span><a href="#" onclick="iniFicha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo_anterior.'\')" title="'.$id_anterior.'"><img class="alin_alto" src="imgs/anterior_peq.png" alt="'.$id_anterior.'"/></a></span>';echo '&nbsp;';echo '&nbsp;';echo '&nbsp;';echo '&nbsp;';
echo '<span><a href="#" onclick="iniFicha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\')" title="'.$id_ficha.'"><img src="imgs/ficha.png" alt="'.$id_ficha.'"/></a></span>';echo '&nbsp;';
echo '<span><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'tarea\')" title="'.$id_tareas.'"><img src="imgs/tarea.png" alt="'.$id_tareas.'"/></a></span>';echo '&nbsp;';
echo '<span><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'obs\')" title="'.$id_red_obs.'"><img src="imgs/obs.png" alt="'.$id_red_obs.'"/></a></span>';echo '&nbsp;';
echo '<span><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'carta\')" title="'.$id_red_carta.'"><img src="imgs/carta.png" alt="'.$id_red_carta.'"/></a></span>';echo '&nbsp;';
echo '<span><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'entrev\')" title="'.$id_red_entrev.'"><img src="imgs/entrev.png" alt="'.$id_red_entrev.'"/></a></span>';echo '&nbsp;';
echo '<span><a href="#" onclick="pdf4(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\'boletin\',\''.$nombre.'\',\''.$apellidos.'\')" title="'.$id_gen_bol.'"><img src="imgs/informe.png" alt="'.$id_gen_bol.'"/></a></span>';echo '&nbsp;';

echo '<span><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'faltas\')" title="'.$id_inf_asi.'"><img src="imgs/asistencia.png" alt="'.$id_inf_asi.'"/></a></span>';echo '&nbsp;';
echo '<span><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'notas\')" title="'.$id_inf_not.'"><img src="imgs/notas.png" alt="'.$id_inf_not.'"/></a></span>';echo '&nbsp;';
echo '<span><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'tutoria\')" title="'.$id_inf_tut.'"><img src="imgs/tutoria.png" alt="'.$id_inf_tut.'"/></a></span>';echo '&nbsp;';echo '&nbsp;';echo '&nbsp;';echo '&nbsp;';
//consultamos el siguiente alumno
$sel_numero_alumnos = mysql_query("select alumnado.codigo from alumnado,matricula where matricula.agrupamiento='$sesion' and matricula.codigo=alumnado.codigo order by apellidos,nombre");
$numero_alumnos = mysql_num_rows($sel_numero_alumnos);
for($na=0;$na<$numero_alumnos;$na++)
	{
	$reg_numero_alumnos = mysql_fetch_array($sel_numero_alumnos);
	$codigo_alumno = $reg_numero_alumnos['codigo'];
	if($codigo_alumno==$codigo)
		{
		if($na+1==$numero_alumnos)
			{
			$numero_alumno = 0;
			}
		else
			{
			$numero_alumno = $na+1;
			}
		$na=($numero_alumnos-1);
		}
	}
$sel_siguiente_alumno = mysql_query("select alumnado.codigo from alumnado,matricula where matricula.agrupamiento='$sesion' and matricula.codigo=alumnado.codigo order by apellidos,nombre limit ".$numero_alumno.",1");
$reg_siguiente_alumno = mysql_fetch_array($sel_siguiente_alumno);
$codigo_siguiente = $reg_siguiente_alumno['codigo'];
//listo 
echo '<span><a href="#" onclick="iniFicha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo_siguiente.'\')" title="'.$id_siguiente.'"><img class="alin_alto" src="imgs/siguiente_peq.png" alt="'.$id_siguiente.'"/></a></span>';
echo '</p>';

if($_GET['ini'])
{
echo '<br /><table class="tablacentrada">';
echo '<tr>';
echo '<td class="alin_alto_justif" style="border:1px solid black;">';
echo '<p class="centrado_negrita">'.$id_datos_personales.'</p>';
echo '<p><img src="admin/fotos_al/'.$codigo.'.jpg" class="foto" /></p>';
echo '<p>'.$id_nom.': '.$nombre.'</p>';
echo '<p>'.$id_ape.': '.$apellidos.'</p>';
echo '<p>'.$id_fna.': '.$fecha_nac_esp.' ('.$edad.') '.$id_nac.': '.$reg_alu['nacionalidad'].'</p>';
echo '<p>'.$id_te1.': '.$reg_alu['telef1'].' '.$id_te2.': '.$reg_alu['telef2'].'</p>';
echo '<p>'.$id_tu1.': '.$reg_alu['tutor1'].'</p>';
echo '<p>'.$id_tu2.': '.$reg_alu['tutor2'].'</p>';
echo '<p>'.$id_di1.': '.$reg_alu['direccion1'].'</p>';
echo '<p>'.$id_di2.': '.$reg_alu['direccion2'].'</p>';
echo '</td>';
echo '<td class="alin_alto_justif" style="background-color:#d8dc9a;border:1px solid black;">';
echo '<p class="centrado_negrita">'.$id_datos_escolares.'</p>';
echo '<p>'.$id_exped.': '.$codigo.'</p>';
echo '<p>'.$id_rep.': '.$repite_sn.'</p>';
$sel_tut=mysql_query("select * from grupos where cod_grupo='$grupo'");
$reg_tut=mysql_fetch_array($sel_tut);
$tut1_grupo=$reg_tut['tut1_grupo'];
$tut2_grupo=$reg_tut['tut2_grupo'];
$niv_grupo=$reg_tut['niv_grupo'];
$cur_grupo=$reg_tut['cur_grupo'];
echo '<p>'.$id_cur.': '.$cur_grupo.' '.$id_niv.': '.$niv_grupo.'</p>';
echo '<p>'.$id_mod.': '.$reg_alu['modalidad'].'</p>';
echo '<p>'.$id_gru.': '.$grupo.'</p>';
echo '<p>'.$id_tu1.': '.$tut1_grupo.'</p>';
echo '<p>'.$id_tu2.': '.$tut2_grupo.'</p>';
echo '<p>'.$id_ema.': '.$reg_alu['mail'].'</p>';
echo '<p>'.$id_web.': <a href="'.$reg_alu['weblog'].'" target="_blank">'.$reg_alu['weblog'].'</a></p>';
echo '</td>';
echo '<td class="alin_alto_justif" style="border:1px solid black;">';
echo '<p class="centrado_negrita">'.$id_datos_agrupamiento.'</p>';
$sel_per = mysql_query("select * from periodos");
$num_per = mysql_num_rows($sel_per);
for($p=0;$p<$num_per;$p++)
	{
	$reg_per = mysql_fetch_array($sel_per);
	echo '<p class="subrayado">'.$reg_per['nombre'].'</p>';
	echo '<ul>';
	$fecha_ini = $reg_per['inicio'];
	$fecha_fin = $reg_per['fin'];
	$sel_faltas = mysql_query("select * from asistencia where codigo='$codigo' and agrupamiento='$sesion' and dato='f' and fecha between '$fecha_ini' and '$fecha_fin'");
	$num_faltas = mysql_num_rows($sel_faltas);
	$sel_justif = mysql_query("select * from asistencia where codigo='$codigo' and agrupamiento='$sesion' and dato='j' and fecha between '$fecha_ini' and '$fecha_fin'");
	$num_justif = mysql_num_rows($sel_justif);
	$sel_retrasos = mysql_query("select * from asistencia where codigo='$codigo' and agrupamiento='$sesion' and dato='r' and fecha between '$fecha_ini' and '$fecha_fin'");
	$num_retrasos = mysql_num_rows($sel_retrasos);
	echo '<li><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'faltastodas\')" title="'.$id_todas_faltas.'"><img class="alin_bajo" src="imgs/info.png" alt="'.$id_todas_faltas.'" /></a><span class="negrita">'.$id_faltas.':</span> '.$num_faltas.' <span class="negrita">'.$id_justificadas.':</span> '.$num_justif.' <span class="negrita">'.$id_retrasos.':</span> '.$num_retrasos.'</li>';
	$sel_obs = mysql_query("select * from observaciones where codigo='$codigo' and agrupamiento='$sesion' and fecha between '$fecha_ini' and '$fecha_fin'");
	$num_obs = mysql_num_rows($sel_obs);
	echo '<li><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'obstodas\')" title="'.$id_todas_observaciones.'"><img class="alin_bajo" src="imgs/info.png" alt="'.$id_todas_observaciones.'" /></a><span class="negrita">'.$id_inf_obs.': </span>'.$num_obs.'</li>';  
	//vamos con las notas
		//selecciono mis actividades de este agrupamiento
		//busco notas de cada actividad, calculo su media y las pondero. Introduzco en matriz.
		//sumo elementos de la matriz
		//vacío la matriz
	$sel_activ = mysql_query("select * from actividades where agrupamiento = '$sesion'");
	$num_activ = mysql_num_rows($sel_activ);
	for($a=0;$a<$num_activ;$a++)
		{
		$reg_activ = mysql_fetch_array($sel_activ);
		$activ = $reg_activ['actividad'];
		$pond = $reg_activ['ponderacion'];
		$sel_notas = mysql_query("select avg(nota) from notas where codigo='$codigo' and agrupamiento='$sesion' and actividad='$activ' and fecha between '$fecha_ini' and '$fecha_fin'");
			$hay_nota=mysql_num_rows($sel_notas);
			if($hay_nota>0)
			{
			$reg_nota = mysql_fetch_array($sel_notas);
			$nota_media = $reg_nota['avg(nota)'];
			$nota_pond = ($nota_media*$pond)/100;
			$matriz_notas_pond[]=$nota_pond;
			}
		}
		if(count($matriz_notas_pond)>0)
			{
			$nota_media = array_sum($matriz_notas_pond);
			$nota_media_red = round($nota_media,2);
			echo '<li><span class="negrita">'.$id_calificacion.':</span> '.$nota_media_red.'</li>';
			$sel_rec=mysql_query("select * from recuperaciones where codigo='$codigo' and agrupamiento='$sesion' and periodo='".$reg_per['periodo']."'");
			echo '<li><img class="alin_bajo" src="imgs/act_peq.png" title="'.$id_recupera.'" alt="'.$id_recupera.'" /></a>&nbsp;&nbsp;';

			if(mysql_num_rows($sel_rec)>0)
				{
				$reg_rec=mysql_fetch_array($sel_rec);
				$nota_rec=$reg_rec['nota'];
				echo '<a id="nota_rec_'.$p.'" href="#" onclick="editaRecuperacion(\'nota_rec_'.$p.'\',\'nota\',\''.$reg_per['periodo'].'\',\''.$codigo.'\',\''.$sesion.'\',\'edita\')">'.$nota_rec.'</a>';
				echo '</li>';
				}
			else
				{
				echo '<a id="nota_rec_'.$p.'" href="#" onclick="editaRecuperacion(\'nota_rec_'.$p.'\',\'nota\',\''.$reg_per['periodo'].'\',\''.$codigo.'\',\''.$sesion.'\',\'inserta\')">'.$id_nota.'</a></li>';
				}
			//espacio para revisar nota final de evaluación
			$sel_notas_rev=mysql_query("select * from notas_rev where codigo='$codigo' and agrupamiento='$sesion' and periodo='".$reg_per['periodo']."'");
			echo '<li>Nota revisada:</a>&nbsp;&nbsp;';

			if(mysql_num_rows($sel_notas_rev)>0)
				{
				$reg_notas_rev=mysql_fetch_array($sel_notas_rev);
				$nota_rev=$reg_notas_rev['nota'];
				echo '<a id="nota_rev_'.$p.'" href="#" onclick="cambiaNota(\'nota_rev_'.$p.'\',\'nota\',\''.$reg_per['periodo'].'\',\''.$codigo.'\',\''.$sesion.'\',\'edita\')">'.$nota_rev.'</a>';
				echo '</li>';
				}
			else
				{
				echo '<a id="nota_rev_'.$p.'" href="#" onclick="cambiaNota(\'nota_rev_'.$p.'\',\'nota\',\''.$reg_per['periodo'].'\',\''.$codigo.'\',\''.$sesion.'\',\'inserta\')">'.$id_nota.'</a></li>';
				}
			}
	echo '</ul>';
	unset($matriz_notas_pond);
	}
echo '</td>';
echo '</tr>';
echo '</table>';
}

switch($accion)
{
case 'tarea':
if($_POST['id'])
	{
	$id_eli = $_POST['id'];
	$borra=mysql_query("delete from tareas where id='$id_eli'");
	}
if($_POST['texto'])
	{
	$texto = $_POST['texto'];
	$fecha_ent = $_POST['fecha_ent'];
	$fecha_ent_ing = cambia_fecha_a_ing($fecha_ent);
	$mensaje_pre = str_replace("[igual]","=",$texto);
	$mensaje = str_replace("~inte~","?",$mensaje_pre);
	$ins = mysql_query("insert into tareas values('','$codigo','$sesion','$mensaje','$fecha_ing','$fecha_ent_ing')");
	}
$sel_tareas = mysql_query("select * from tareas where codigo='$codigo' and agrupamiento='$sesion' order by fecha_reg desc");
$num_tareas = mysql_num_rows($sel_tareas);
if($num_tareas>0)
	{
	echo '<br /><table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_accion.'</td><td>'.$id_tarea.'</td><td>'.$id_fecha_reg.'</td><td>'.$id_fecha_ent.'</td>';
	echo '</tr>';
	for($t=0;$t<$num_tareas;$t++)
		{
		$reg_tareas = mysql_fetch_array($sel_tareas);
		$id = $reg_tareas['id'];
		$tarea = $reg_tareas['tarea'];
		$fecha_reg = $reg_tareas['fecha_reg'];
		$fecha_ent = $reg_tareas['fecha_ent'];
		$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
		$fecha_ent_esp = cambia_fecha_a_esp($fecha_ent);
		if($t%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		echo '<td class="centrado">';
		echo '<a href="#" title="'.$id_eliminar.'" onclick="eliminaNota(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'tarea\',\''.$id.'\')"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a>';
		echo '</td>';
		echo '<td class="justificado">';
		echo '<a href="#" title="'.$id_editar.'" id="tarea_'.$t.'" onclick="editaTarea(\'tarea_'.$t.'\',\'tarea\',\''.$id.'\')">';
		echo $tarea;
		echo '</a>';
		echo '</td>';
		echo '<td class="centrado">';		
		echo '<a href="#" title="'.$id_editar.'" id="fechareg_'.$t.'" onclick="editaTareaFecha(\'fechareg_'.$t.'\',\'fecha_reg\',\''.$id.'\')">';
		echo $fecha_reg_esp;
		echo '</a>';
		echo '</td>';
		echo '<td class="centrado">';
		echo '<a href="#" title="'.$id_editar.'" id="fechaent_'.$t.'" onclick="editaTareaFecha(\'fechaent_'.$t.'\',\'fecha_ent\',\''.$id.'\')">';
		echo $fecha_ent_esp;
		echo '</a>';
		echo '</td>';
		echo '</tr>';
		}
	echo '</table>';
	}
else
	{
	echo '<br /><p class="texto_centrado">'.$id_no_tareas.'</p>';
	}
echo '<br /><p class="centrado"><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'redactatarea\')" title="'.$id_red_tarea.'"><img src="imgs/mas.png" alt="'.$id_red_tarea.'" /></a></p><br />';
echo '<p class="centrado"><a href="#" onclick="pdf4(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\''.$accion.'\',\''.$nombre.'\',\''.$apellidos.'\')" title="'.$id_pdf.'"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
break;

case 'redactatarea':
echo '<br /><form id="tarea" name="tarea" class="centrado">';
echo '<p class="texto_centrado"> '.$id_red_tarea.'</p><br />';
echo '<p class="centrado">'.$id_fecha_ent.': <input size="7" readonly="readonly" type="text" id="fecha_ent" name="fecha_ent" onclick="calend_peq()" /></p>';
echo '<br />';
$oFCKeditor = new FCKeditor('area') ;
$oFCKeditor->ToolbarSet = 'Tarea';
$oFCKeditor->BasePath = 'fckeditor/';
$oFCKeditor->Value = 'Escribe aqu&iacute;';
$oFCKeditor->Create() ;
echo '<br /><p class="centrado">';
echo '<a href="#" class="padding" onclick="registraEditor(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'tarea\',\'fecha_ent\')" title="'.$id_guardar.'"><img src="imgs/guardar.png" alt="'.$id_guardar.'"/></a>';
echo '</p>';
echo '</form>';
break;

case 'obs':
if($_POST['id'])
	{
	$id_eli = $_POST['id'];
	$borra=mysql_query("delete from observaciones where id='$id_eli'");
	}
if($_POST['texto'])
	{
	$texto = $_POST['texto'];
	$mensaje_pre = str_replace("[igual]","=",$texto);
	$mensaje = str_replace("~inte~","?",$mensaje_pre);
	$ins = mysql_query("insert into observaciones values('','$codigo','$sesion','$mensaje','$fecha_ing')");
	}
$sel_obs = mysql_query("select * from observaciones where codigo='$codigo' and agrupamiento='$sesion' order by fecha desc");
$num_obs = mysql_num_rows($sel_obs);
if($num_obs>0)
	{
	echo '<br /><table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_accion.'</td><td>'.$id_obs.'</td><td>'.$id_fecha_reg.'</td>';
	echo '</tr>';
	for($o=0;$o<$num_obs;$o++)
		{
		$reg_obs = mysql_fetch_array($sel_obs);
		$id = $reg_obs['id'];
		$observacion = $reg_obs['observacion'];
		$fecha_reg = $reg_obs['fecha'];
		$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
		if($o%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		echo '<td class="centrado">';
		echo '<a href="#" title="'.$id_eliminar.'" onclick="eliminaNota(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'obs\',\''.$id.'\')"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a>';
		echo '</td>';
		echo '<td class="justificado">';
		echo '<a href="#" title="'.$id_editar.'" id="obs_'.$o.'" onclick="editaObs(\'obs_'.$o.'\',\'observacion\',\''.$id.'\')">';
		echo $observacion;
		echo '</a>';
		echo '</td>';
		echo '<td class="centrado">';		
		echo '<a href="#" title="'.$id_editar.'" id="fechareg_'.$o.'" onclick="editaObsFecha(\'fechareg_'.$o.'\',\'fecha\',\''.$id.'\')">';
		echo $fecha_reg_esp;
		echo '</a>';
		echo '</td>';
		echo '</tr>';
		}
	echo '</table>';
	}
else
	{
	echo '<br /><p class="texto_centrado">'.$id_no_obs.'</p>';
	}
echo '<br /><p class="centrado"><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'redactaobs\')" title="'.$id_red_obs.'"><img src="imgs/mas.png" alt="'.$id_red_obs.'" /></a></p><br />';
echo '<p class="centrado"><a href="#" onclick="pdf4(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\''.$accion.'\',\''.$nombre.'\',\''.$apellidos.'\')" title="'.$id_pdf.'"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
break;

case 'redactaobs':
echo '<br /><form id="obs" name="obs" class="centrado">';
echo '<p class="texto_centrado"> '.$id_red_obs.'</p><br />'; 
$oFCKeditor = new FCKeditor('area') ;
$oFCKeditor->ToolbarSet = 'Carta';
$oFCKeditor->BasePath = 'fckeditor/';
$oFCKeditor->Value = 'Escribe aqu&iacute;';
$oFCKeditor->Create() ;
echo '<br /><p class="centrado">';
echo '<a href="#" class="padding" onclick="registraEditor2(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'obs\')" title="'.$id_guardar.'"><img src="imgs/guardar.png" alt="'.$id_guardar.'"/></a>';
echo '</p>';
echo '</form>';
break;

case 'carta':
if($_POST['id'])
	{
	$id_eli = $_POST['id'];
	$borra=mysql_query("delete from cartas where id='$id_eli'");
	}
if($_POST['texto'])
	{
	$texto = $_POST['texto'];
	$mensaje_pre = str_replace("[igual]","=",$texto);
	$mensaje = str_replace("~inte~","?",$mensaje_pre);
	$ins = mysql_query("insert into cartas values('','$docente','$mensaje','$codigo','$fecha_ing')");
	}
$sel_cartas = mysql_query("select * from cartas where docente='$docente' and destinatario='$codigo' order by fecha asc");
$num_cartas = mysql_num_rows($sel_cartas);
if($num_cartas>0)
	{
	echo '<br /><table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_accion.'</td><td>'.$id_fecha_reg.'</td><td>'.$id_texto.'</td>';
	echo '</tr>';
	for($c=0;$c<$num_cartas;$c++)
		{
		$reg_cartas = mysql_fetch_array($sel_cartas);
		$id = $reg_cartas['id'];
		$carta = $reg_cartas['texto'];
		$carta_f = htmlspecialchars($carta);
		$subcarta=substr($carta,0,200);
		$fecha_reg = $reg_cartas['fecha'];
		$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
		if($t%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		echo '<td class="centrado">';
		echo '<a href="#" title="'.$id_eliminar.'" onclick="eliminaNota(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'carta\',\''.$id.'\')"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a>';
		echo '<br />';echo '<br />';
		echo '<a href="#" title="'.$id_con_ed.'" onclick="ficha2(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'redactacarta\',\''.$carta_f.'\')"><img src="imgs/edita_peq.png" alt="'.$id_editar.'" /></a>';
		echo '<br />';echo '<br />';
		echo '<a href="#" title="'.$id_pdf.'" onclick="pdf5(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\''.$accion.'\',\''.$nombre.'\',\''.$apellidos.'\',\''.$id.'\')"><img src="imgs/informe_peq.png" alt="'.$id_pdf.'" /></a>';
		echo '</td>';
		echo '<td class="centrado">';		
		echo $fecha_reg_esp;
		echo '</td>';
		echo '<td class="justificado">';
		echo ''.$subcarta.'...';
		echo '</td>';
		echo '</tr>';
		}
	echo '</table>';
	}
else
	{
	echo '<br /><p class="texto_centrado">'.$id_no_cartas.'</p>';
	}
echo '<br /><p class="centrado"><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'redactacarta\')" title="'.$id_red_carta.'"><img src="imgs/mas.png" alt="'.$id_red_carta.'" /></a></p>';

break;

case 'redactacarta':
echo '<br /><form id="carta" name="carta" class="centrado">';
echo '<p class="texto_centrado"> '.$id_red_carta.'</p><br />'; 
$oFCKeditor = new FCKeditor('area') ;
$oFCKeditor->ToolbarSet = 'Carta';
$oFCKeditor->BasePath = 'fckeditor/';
if($_POST['texto'])
	{
	$texto_carta = $_POST['texto'];
	$oFCKeditor->Value = $texto_carta;
	}
else
	{
	$oFCKeditor->Value = 'Escribe aqu&iacute;';
	}
$oFCKeditor->Create() ;
echo '<br /><p class="centrado">';
echo '<a href="#" class="padding" onclick="registraEditor2(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'carta\')" title="'.$id_guardar.'"><img src="imgs/guardar.png" alt="'.$id_guardar.'"/></a>';
echo '</p>';
echo '</form>';
break;

case 'entrev':
if($_POST['id'])
	{
	$id_eli = $_POST['id'];
	$borra=mysql_query("delete from entrevistas where id='$id_eli'");
	}
if($_POST['texto'])
	{
	$texto = $_POST['texto'];
	$mensaje_pre = str_replace("[igual]","=",$texto);
	$mensaje = str_replace("~inte~","?",$mensaje_pre);
	$ins = mysql_query("insert into entrevistas values('','$docente','$mensaje','$codigo','$fecha_ing')");
	}
$sel_entrev = mysql_query("select * from entrevistas where docente='$docente' and codigo='$codigo' order by fecha asc");
$num_entrev = mysql_num_rows($sel_entrev);
if($num_entrev>0)
	{
	echo '<br /><table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_accion.'</td><td>'.$id_fecha_reg.'</td><td>'.$id_texto.'</td>';
	echo '</tr>';
	for($e=0;$e<$num_entrev;$e++)
		{
		$reg_entrev = mysql_fetch_array($sel_entrev);
		$id = $reg_entrev['id'];
		$entrev = $reg_entrev['texto'];
		$entrev_f = htmlspecialchars($entrev);
		$subentrev=substr($entrev,0,200);
		$fecha_reg = $reg_entrev['fecha'];
		$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
		if($e%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		echo '<td class="centrado">';
		echo '<a href="#" title="'.$id_eliminar.'" onclick="eliminaNota(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'entrev\',\''.$id.'\')"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a>';
		echo '<br />';echo '<br />';
		echo '<a href="#" title="'.$id_con_ed.'" onclick="ficha2(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'redactaentrev\',\''.$entrev_f.'\')"><img src="imgs/edita_peq.png" alt="'.$id_editar.'" /></a>';
		echo '<br />';echo '<br />';
		echo '<a href="#" title="'.$id_pdf.'" onclick="pdf5(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\''.$accion.'\',\''.$nombre.'\',\''.$apellidos.'\',\''.$id.'\')"><img src="imgs/informe_peq.png" alt="'.$id_pdf.'" /></a>';
		echo '</td>';
		echo '<td class="centrado">';		
		echo $fecha_reg_esp;
		echo '</td>';
		echo '<td class="justificado">';
		echo ''.$subentrev.'...';
		echo '</td>';
		echo '</tr>';
		}
	echo '</table>';
	}
else
	{
	echo '<br /><p class="texto_centrado">'.$id_no_entrev.'</p>';
	}
echo '<br /><p class="centrado"><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'redactaentrev\')" title="'.$id_red_entrev.'"><img src="imgs/mas.png" alt="'.$id_red_entrev.'" /></a></p>';

break;

case 'redactaentrev':
echo '<br /><form id="entrev" name="entrev" class="centrado">';
echo '<p class="texto_centrado"> '.$id_red_entrev.'</p><br />'; 
$oFCKeditor = new FCKeditor('area') ;
$oFCKeditor->ToolbarSet = 'Carta';
$oFCKeditor->BasePath = 'fckeditor/';
if($_POST['texto'])
	{
	$texto_entrev = $_POST['texto'];
	$oFCKeditor->Value = $texto_entrev;
	}
else
	{
	$oFCKeditor->Value = 'Escribe aqu&iacute;';
	}
$oFCKeditor->Create() ;
echo '<br /><p class="centrado">';
echo '<a href="#" class="padding" onclick="registraEditor2(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'entrev\')" title="'.$id_guardar.'"><img src="imgs/guardar.png" alt="'.$id_guardar.'"/></a>';
echo '</p>';
echo '</form>';
break;

case 'faltas':
echo '<br /><table class="tablacentrada">';
	echo '<tr>';
	echo '<td class="justificado">'.$id_mes.'</td>';
	for($d=0;$d<31;$d++)
		{
		$dia = $d + 1;
		echo '<td class="centrado">'.$dia.'</td>';
		}
	echo '</tr>';
	$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$sesion' and codigo = '$codigo' and dato <> 'a' order by fecha asc");
	$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
	for($fa=0;$fa<$num_mes_faltas;$fa++)
		{
		$reg_mes_faltas=mysql_fetch_array($sel_mes_faltas);
		$mes_faltas=$reg_mes_faltas['month(fecha)'];
		$anyo_faltas=$reg_mes_faltas['year(fecha)'];
		$name_mes = date('M',mktime(0,0,0,$mes_faltas+1,0,0));
		$nombre_mes = nombre_mes($name_mes);
			
		if($fa%2==0)echo '<tr class="par">';else echo '<tr>';
		echo '<td class="justificado">'.$nombre_mes.'</td>';
		for($d=0;$d<31;$d++)
			{
			$dia = $d + 1;
			$nombre_dia_ing = date('D', mktime(0, 0, 0, $mes_faltas, $dia, $anyo_faltas));
			$numero_dia = nombre_dia_a_numero($nombre_dia_ing);
			if($numero_dia == '6' || $numero_dia == '7')
				{
				echo '<td class="naranja"></td>';
				}
			else
				{
				$fecha_consulta = ''.$anyo_faltas.'-'.$mes_faltas.'-'.$dia.'';
				$sel_falta = mysql_query("select dato,hini from asistencia where agrupamiento='$sesion' and codigo = '$codigo' and fecha = '$fecha_consulta' and dato <> 'a'");
				if(mysql_num_rows($sel_falta)>0)
					{
					echo '<td class="centrado">';
					for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
						{
						$reg_falta = mysql_fetch_array($sel_falta);
						$horafalta=$reg_falta['hini'];
						echo '<a href="#" title="'.$horafalta.'">'.$reg_falta['dato'].'</a>';
						}
					echo '</td>';
					}
				else
					{
					echo '<td></td>';
					}
				}
			}
			echo '</tr>';
		
		
		}//fin de for
	echo '</table>';
	echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf4(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\''.$accion.'\',\''.$nombre.'\',\''.$apellidos.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p><br />';

break;

case 'faltastodas':

$agr_post = $_POST['item'];

echo '<br/><span class="negrita">'.$id_todas_faltas.'</span>';

echo '<p class="centrado"><select id="texto_item" onchange="ficha3(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'faltastodas\')">';
if($agr_post){echo '<option selected="selected">'.$agr_post.'</option>';}
echo '<option>'.$id_elgagr.'</option>';
$sel_agr=mysql_query("select agrupamiento from matricula where codigo='$codigo'");
$num_agr=mysql_num_rows($sel_agr);
for($a=0;$a<$num_agr;$a++)
	{
	$reg_agr=mysql_fetch_array($sel_agr);
	$agrupamiento=$reg_agr['agrupamiento'];
	echo '<option value="'.$agrupamiento.'">'.$agrupamiento.'</option>';
	}
echo '</select>';

//si vengo de seleccionar el agrupamiento

if($agr_post)
	{	
	$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agr_post' and codigo = '$codigo' and dato <> 'a' order by fecha asc");
	$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
	if($num_mes_faltas>0)
	{
	echo '<br /><table class="tablacentrada">';
	echo '<tr>';
	echo '<td class="justificado">'.$id_mes.'</td>';
	for($d=0;$d<31;$d++)
		{
		$dia = $d + 1;
		echo '<td class="centrado">'.$dia.'</td>';
		}
	echo '</tr>';
	
	
	for($fa=0;$fa<$num_mes_faltas;$fa++)
		{
		$reg_mes_faltas=mysql_fetch_array($sel_mes_faltas);
		$mes_faltas=$reg_mes_faltas['month(fecha)'];
		$anyo_faltas=$reg_mes_faltas['year(fecha)'];
		$name_mes = date('M',mktime(0,0,0,$mes_faltas+1,0,0));
		$nombre_mes = nombre_mes($name_mes);
			
		if($fa%2==0)echo '<tr class="par">';else echo '<tr>';
		echo '<td class="justificado">'.$nombre_mes.'</td>';
		for($d=0;$d<31;$d++)
			{
			$dia = $d + 1;
			$nombre_dia_ing = date('D', mktime(0, 0, 0, $mes_faltas, $dia, $anyo_faltas));
			$numero_dia = nombre_dia_a_numero($nombre_dia_ing);
			if($numero_dia == '6' || $numero_dia == '7')
				{
				echo '<td class="naranja"></td>';
				}
			else
				{
				$fecha_consulta = ''.$anyo_faltas.'-'.$mes_faltas.'-'.$dia.'';
				$sel_falta = mysql_query("select dato,hini from asistencia where agrupamiento='$agr_post' and codigo = '$codigo' and fecha = '$fecha_consulta' and dato <> 'a'");
				if(mysql_num_rows($sel_falta)>0)
					{
					echo '<td class="centrado">';
					for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
						{
						$reg_falta = mysql_fetch_array($sel_falta);
						$horafalta=$reg_falta['hini'];
						echo '<a href="#" title="'.$horafalta.'">'.$reg_falta['dato'].'</a>';
						}
					echo '</td>';
					}
				else
					{
					echo '<td></td>';
					}
				}
			}
			echo '</tr>';
		
		
		}//fin de for
	echo '</table>';
	echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf5(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\''.$accion.'\',\''.$nombre.'\',\''.$apellidos.'\',\''.$agr_post.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p><br />';
	}//fin hay faltas
	else
	{
	echo '<br /><span class="negrita">'.$id_no_asi.'</span>';
	}
	}
break;

case 'obstodas':

$sel_obs = mysql_query("select * from observaciones where codigo='$codigo' order by fecha desc");
$num_obs = mysql_num_rows($sel_obs);
if($num_obs>0)
	{
	echo '<br /><table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_agr.'</td>'.$id_obs.'</td><td>'.$id_fecha_reg.'</td>';
	echo '</tr>';
	for($o=0;$o<$num_obs;$o++)
		{
		$reg_obs = mysql_fetch_array($sel_obs);
		$id = $reg_obs['id'];
		$agr_obs = $reg_obs['agrupamiento'];
		$observacion = $reg_obs['observacion'];
		$fecha_reg = $reg_obs['fecha'];
		$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
		if($o%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		echo '<td class="centrado">';
		echo $agr_obs;
		echo '</td>';
		echo '<td class="justificado">';
		echo $observacion;
		echo '</td>';
		echo '<td class="centrado">';		
		echo $fecha_reg_esp;
		echo '</td>';
		echo '</tr>';
		}
	echo '</table>';
	}
else
	{
	echo '<br /><p class="texto_centrado">'.$id_no_obs.'</p>';
	}
echo '<br /><p class="centrado"><a href="#" onclick="pdf4(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\''.$accion.'\',\''.$nombre.'\',\''.$apellidos.'\')" title="'.$id_pdf.'"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';	

break;

case 'notas':
if($_POST['id'])
	{
	$id_eli = $_POST['id'];
	$borra=mysql_query("delete from notas where id='$id_eli'");
	}
$sel_notas = mysql_query("select * from notas where codigo='$codigo' and agrupamiento='$sesion' order by fecha desc, actividad");
$num_notas = mysql_num_rows($sel_notas);
if($num_notas>0)
{
echo '<br /><table class="tablacentrada">';
echo '<tr class="encab">';
echo '<td>'.$id_accion.'</td><td>'.$id_fecha.'</td><td>'.$id_descripcion.'</td><td>'.$id_nota.'</td><td>'.$id_activ.'</td><td>'.$id_coment.'</td>';
echo '</tr>';
for($n=0;$n<$num_notas;$n++)
	{
	if($n%2==0){echo '<tr class="par">';}else{echo '<tr>';}
	$reg_notas = mysql_fetch_array($sel_notas);
	$id = $reg_notas['id'];
	$fecha = $reg_notas['fecha'];
	$fecha_esp = cambia_fecha_a_esp($fecha);
	$descripcion = $reg_notas['descripcion'];
	$nota = $reg_notas['nota'];
	$actividad = $reg_notas['actividad'];
	$comentario = $reg_notas['comentario'];
	if($comentario == ''){$comentario = $id_no_coment;}
	echo '<td class="centrado">';
	echo '<a href="#" title="'.$id_eliminar.'" onclick="eliminaNota(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'notas\',\''.$id.'\')"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a>';
	echo '&nbsp;';
	echo '<a href="#" title="'.$id_listado_clase.'" onclick="pdf3(\'listado_notas_clase.php\',\''.$fecha.'\',\''.$sesion.'\',\''.$descripcion.'\',\''.$actividad.'\')"><img src="imgs/informe_peq.png" alt="'.$id_listado_clase.'" /></a>';
	echo '</td>';
	echo '<td>';
	echo '<a href="#" title="'.$id_editar.'" id="fecha_'.$n.'" onclick="editaNotaFecha(\'fecha_'.$n.'\',\'fecha\',\''.$id.'\')">';
	echo $fecha_esp;
	echo '</a>';
	echo '</td>';
	echo '<td class="justificado">';
	echo '<a href="#" title="'.$id_editar.'" id="descrip_'.$n.'" onclick="editaNota(\'descrip_'.$n.'\',\'descripcion\',\''.$id.'\')">';	
	echo $descripcion;
	echo '</a>';
	echo '</td>';
	echo '<td>';
	echo '<a href="#" title="'.$id_editar.'" id="nota_'.$n.'" onclick="editaNota(\'nota_'.$n.'\',\'nota\',\''.$id.'\')">';	
	echo $nota;
	echo '</a>';
	echo '</td>';
	$sel_activ = mysql_query("select actividad from actividades where agrupamiento = '$sesion'");
	$num_activ = mysql_num_rows($sel_activ);
		for($ac=0;$ac<$num_activ;$ac++)
			{
			$reg_activ = mysql_fetch_array($sel_activ);
			$activ_lis = $reg_activ['actividad'];
			echo '<input id="'.$ac.'" value="'.$activ_lis.'" type="hidden" />';
			}//fin for ac
	echo '<td class="justificado">';
	echo '<a href="#" title="'.$id_editar.'" id="actividad_'.$n.'" onclick="editaNotaActividad(\'actividad_'.$n.'\',\'actividad\',\''.$id.'\',\''.$num_activ.'\')">';
	
	echo $actividad;
	echo '</td>';
	echo '<td class="justificado">';
	echo '<a href="#" title="'.$id_editar.'" id="coment_'.$n.'" onclick="editaNota(\'coment_'.$n.'\',\'comentario\',\''.$id.'\')">';	
	echo $comentario;
	echo '</a>';
	echo '</td>';
	echo '</tr>';
	}
echo '</table>';
echo '<br /><p class="centrado"><a title="'.$id_pdf.'" href="#" onclick="pdf4(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\''.$accion.'\',\''.$nombre.'\',\''.$apellidos.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
}
else
{
echo '<br /><p class="texto_centrado">'.$id_no_calif.'</p>';
}
break;

case 'tutoria':
if($_POST['id'])
	{
	$id_eli = $_POST['id'];
	if($_POST['recibido'])
		{
		$act=mysql_query("update tutoria set estado_recibido='1' where id='$id_eli'");
		}
	else
		{
		$act=mysql_query("update tutoria set estado_envio='1' where id='$id_eli'");
		}
	}
if($_POST['texto'])
	{
	$texto = $_POST['texto'];
	$mensaje_pre = str_replace("[igual]","=",$texto);
	$mensaje = str_replace("~inte~","?",$mensaje_pre);
	$destin = $_POST['destin'];
	$ins = mysql_query("insert into tutoria values('','$codigo','$sesion','$fecha_ing','$mensaje','$destin','0','0')");
	$sel_id = mysql_query("select id from tutoria where codigo='$codigo' and agrupamiento='$sesion' and fecha='$fecha_ing' and destin='$destin' and texto='$mensaje'");
	$reg_id = mysql_fetch_array($sel_id);
	$id = $reg_id['id'];
	$num_items = $_POST['numero_items'];
	for($ni=0;$ni<$num_items;$ni++)
		{
		$cb = $_POST['cb_inc_'.$ni.''];
		$texto_item = $_POST['hid_item_'.$ni.''];
	 	if($cb)
			{
			$rd = $_POST['rd_item_'.$ni.''];
			$ins_item = mysql_query("insert into items values('','$id','$texto_item','$rd')");
			}
		}
	}
$sel_tutoria_recib = mysql_query("select * from tutoria where destin='$docente' and codigo='$codigo' and agrupamiento <> '$sesion' and estado_recibido = '0' order by fecha asc");
$num_tutoria_recib = mysql_num_rows($sel_tutoria_recib);
if($num_tutoria_recib>0)
	{
	echo '<br /><p class="texto_centrado">'.$id_tutoria_recib.'</p>';
	echo '<br /><table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_accion.'</td><td>'.$id_fecha_reg.'</td><td>'.$id_texto.'</td><td>'.$id_procede.'</td>';
	echo '</tr>';
	for($tr=0;$tr<$num_tutoria_recib;$tr++)
		{
		$reg_tutoria_recib = mysql_fetch_array($sel_tutoria_recib);
		$id_recib = $reg_tutoria_recib['id'];
		$informe_recib = $reg_tutoria_recib['texto'];
		$informe_f_recib = htmlspecialchars($informe_recib);
		$subinforme_recib=substr($informe_recib,0,200);
		$fecha_reg_recib = $reg_tutoria_recib['fecha'];
		$fecha_reg_esp_recib = cambia_fecha_a_esp($fecha_reg_recib);
		if($tr%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		echo '<td class="centrado">';
		echo '<a href="#" title="'.$id_eliminar.'" onclick="eliminaNota1(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'tutoria\',\''.$id_recib.'\')"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a>';
		echo '<br />';echo '<br />';
		echo '<a href="#" title="'.$id_pdf.'" onclick="pdf5(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\'tutoria_recib\',\''.$nombre.'\',\''.$apellidos.'\',\''.$id_recib.'\')"><img src="imgs/informe_peq.png" alt="'.$id_pdf.'" /></a>';
		echo '</td>';
		echo '<td class="centrado">';		
		echo $fecha_reg_esp_recib;
		echo '</td>';
		echo '<td class="justificado">';
		echo ''.$subinforme_recib.'...';
		echo '</td>';
		echo '<td>';
		$agrup_tut = $reg_tutoria_recib['agrupamiento'];
		$sel_doc_recib = mysql_query("select docentes.apellidos,docentes.nombre,docentes.docente,agrupamientos.agrupamiento,agrupamientos.docente from docentes,agrupamientos where agrupamientos.agrupamiento='$agrup_tut' and docentes.docente=agrupamientos.docente");
		$reg_doc_recib = mysql_fetch_array($sel_doc_recib);
		echo ''.$reg_doc_recib['nombre'].' '.$reg_doc_recib['apellidos'].'';
		echo '</td>';
		echo '</tr>';
		}
	echo '</table>';
	}

$sel_tutoria = mysql_query("select * from tutoria where agrupamiento='$sesion' and codigo='$codigo' and estado_envio = '0' order by fecha asc");
$num_tutoria = mysql_num_rows($sel_tutoria);
if($num_tutoria>0)
	{
	echo '<br /><p class="texto_centrado">'.$id_tutoria_prop.'</p>';
	echo '<br /><table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_accion.'</td><td>'.$id_fecha_reg.'</td><td>'.$id_texto.'</td><td>'.$id_destinatario.'</td>';
	echo '</tr>';
	for($t=0;$t<$num_tutoria;$t++)
		{
		$reg_tutoria = mysql_fetch_array($sel_tutoria);
		$id = $reg_tutoria['id'];
		$informe = $reg_tutoria['texto'];
		$informe_f = htmlspecialchars($informe);
		$subinforme=substr($informe,0,200);
		$fecha_reg = $reg_tutoria['fecha'];
		$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
		if($t%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		echo '<td class="centrado">';
		echo '<a href="#" title="'.$id_eliminar.'" onclick="eliminaNota(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'tutoria\',\''.$id.'\')"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a>';
		echo '<br />';echo '<br />';
		echo '<a href="#" title="'.$id_pdf.'" onclick="pdf5(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\''.$accion.'\',\''.$nombre.'\',\''.$apellidos.'\',\''.$id.'\')"><img src="imgs/informe_peq.png" alt="'.$id_pdf.'" /></a>';
		echo '</td>';
		echo '<td class="centrado">';		
		echo $fecha_reg_esp;
		echo '</td>';
		echo '<td class="justificado">';
		echo ''.$subinforme.'...';
		echo '</td>';
		echo '<td>';
		$destin_tut = $reg_tutoria['destin'];
		if($destin_tut == '1'){echo $id_todos_doc;}
	 	if($destin_tut == '2'){echo $id_ningun_doc;}
		if($destin_tut <> '1' && $destin_tut <> '2' && $destin_tut <> '0')
		{
		$sel_doc = mysql_query("select apellidos,nombre from docentes where docente='$destin_tut'");
		$reg_doc = mysql_fetch_array($sel_doc);
		echo ''.$reg_doc['nombre'].' '.$reg_doc['apellidos'].'';
		}
		echo '</td>';
		echo '</tr>';
		}
	echo '</table>';
	}
else
	{
	echo '<br /><p class="texto_centrado">'.$id_no_tutoria.'</p>';
	}
echo '<br /><p class="centrado"><a href="#" onclick="ficha(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'redactatutoria\')" title="'.$id_red_tutoria.'"><img src="imgs/mas.png" alt="'.$id_red_tutoria.'" /></a></p>';

break;

case 'redactatutoria':
if($_POST['item'])
	{
	$item = $_POST['item'];
	$ins_item = mysql_query("insert into items values('','','$item','')");	
	}
echo '<br/><form id="tut" name="tut" class="centrado">';
echo '<p class="texto_centrado"> '.$id_red_tutoria.'</p><br />'; 
echo '<p class="centrado">'.$id_destinatario.': ';
$sel_doc = mysql_query("select nombre,apellidos,docente from docentes where docente <> '$docente' order by apellidos,nombre");
$num_doc = mysql_num_rows($sel_doc);
echo '<select id="doc">';
echo '<option value="0">'.$id_elige_doc.'</option>';
for($d=0;$d<$num_doc;$d++)
	{
	$reg_doc = mysql_fetch_array($sel_doc);
	echo '<option value="'.$reg_doc['docente'].'">'.$reg_doc['nombre'].' '.$reg_doc['apellidos'].'</option>';
	}
echo '<option value="2" class="negrita">'.$id_ningun_doc.'</option>';
echo '</select>';
echo '</p>';
echo '<p><a href="#" onclick="presenta(\'item\')" title="'.$id_mas_item.'"><img src="imgs/item.png" alt="'.$id_mas_item.'" /></a></p>';
echo '<p class="oculto" id="item"><input type="text" size="60" id="texto_item" onblur="ficha3(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'redactatutoria\')" /><p>';
$oFCKeditor = new FCKeditor('area') ;
$oFCKeditor->ToolbarSet = 'Carta';
$oFCKeditor->BasePath = 'fckeditor/';
$oFCKeditor->Value = 'Escribe aqu&iacute;';
$oFCKeditor->Create();

echo '<br />';
$sel_items = mysql_query("select * from items where informe='0'");
$num_items = mysql_num_rows($sel_items);
if($num_items>0)
	{
	echo '<table class="tablacentrada">';
	echo '<tr>';
	echo '<td>'.$id_incluir.'</td><td>'.$id_texto.'</td><td>'.$id_si.'</td><td>'.$id_no.'</td><td>'.$id_av.'</td>';
	echo '</tr>';
	for($i=0;$i<$num_items;$i++)
		{
		$reg_items = mysql_fetch_array($sel_items);
		if($i%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		echo '<td><input type="checkbox" name="cb_inc_'.$i.'" id="cb_inc_'.$i.'" /></td>';
		echo '<td class="justificado">'.$reg_items['item'].'</td>';
		echo '<td><input type="radio" name="rd_item_'.$i.'" id="rd_item_'.$i.'" value="s"/></td>';
		echo '<td><input type="radio" name="rd_item_'.$i.'" id="rd_item_'.$i.'" value="n"/></td>';
		echo '<td><input type="radio" name="rd_item_'.$i.'" id="rd_item_'.$i.'" value="v"/><input type="hidden" name="hid_item_'.$i.'" id="hid_item_'.$i.'" value="'.$reg_items['item'].'" /></td>';
		echo '</tr>';
		}
	echo '</table>';
	}
else
	{
	echo $id_no_item;
	}
echo '<p><a href="#" class="padding" onclick="registraEditor3(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\'tutoria\',\''.$num_items.'\')" title="'.$id_guardar.'"><img src="imgs/guardar.png" alt="'.$id_guardar.'"/></a>&nbsp;&nbsp;<a href="#" onclick="pdfTutoriaBlanco(\'ficha_pdf.php\',\''.$codigo.'\',\''.$sesion.'\',\'inf_blanco\',\''.$nombre.'\',\''.$apellidos.'\',\''.$num_items.'\')" title="'.$id_pdf_tut.'"><img src="imgs/informe.png" alt="'.$id_pdf_tut.'" /></a></p>';

echo '<br /><p class="centrado">';
echo '</form>';
break;

}//fin switch($accion)

}//fin if hay sesión

?>