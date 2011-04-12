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

//declaramos variables
$docente = $_SESSION['usuario_sesion'];
//si venimos de clicar en el calendario, estos son los nuevos datos de fecha
$dia=$_POST['p1'];if(strlen($dia)=='1')$dia='0'.$dia.'';
$mes=$_POST['p2'];if(strlen($mes)=='1')$mes='0'.$mes.'';
$anyo=$_POST['p3'];

$fecha_ing = ''.$anyo.'-'.$mes.'-'.$dia.'';
$fecha_esp = ''.$dia.'-'.$mes.'-'.$anyo.'';

$nombre_dia_ing = date('D', mktime(0, 0, 0, $mes, $dia, $anyo));
$numero_dia = nombre_dia_a_numero($nombre_dia_ing);
$nombre_dia=encuentra_dia($numero_dia-1);

//venimos de registrar, editar o eliminar cita desde inicio.php
$accion=$_POST['accion'];
$id=$_POST['id'];
$nuevacita=$_POST['cita'];
$mensaje_pre = str_replace("[igual]","=",$nuevacita);
$mensaje = str_replace("~inte~","?",$mensaje_pre);
$franjacita=$_POST['franjacita'];
$diacita=$_POST['diacita'];
$tipocita=$_POST['tipocita'];
$numerocita=$_POST['numerocita'];

switch ($accion)
	{
	case 'elimina':
	$elimina=mysql_query("delete from agenda where id='$id'");
	break;
	case 'graba':
	$inserta=mysql_query("insert into agenda values('','$docente','$franjacita','$diacita','$fecha_ing','$mensaje','$tipocita')");
	break;
	case 'actualiza':
	$actualiza=mysql_query("update agenda set cita='$mensaje', tipo='$tipocita' where id='$numerocita'");
	break;
	}

//¿mensajes nuevos?
$sel_men_nu=mysql_query("select fecha from mensajes where destinatario='$docente' and lectura='0' or destinatario='*' and lectura='0' and remitente != '$docente'");
//¿cumpleaños hoy?
$dia_cumple = date('d');
$mes_cumple = date('m');
$sel_cumple = mysql_query("select codigo,apellidos,nombre from alumnado where month(f_nac)='$mes_cumple' and day(f_nac) = '$dia_cumple'");
if(mysql_num_rows($sel_cumple)!=0)
	{
	for($cu=0;$cu<(mysql_num_rows($sel_cumple));$cu++)
		{
		$reg_cumple=mysql_fetch_array($sel_cumple);
		$cod_cumple=$reg_cumple['codigo'];
		$sel_cumple_agr = mysql_query("select matricula.agrupamiento from matricula,agrupamientos where matricula.codigo='$cod_cumple' and matricula.agrupamiento = agrupamientos.agrupamiento and agrupamientos.docente = '$docente'");
		if(mysql_num_rows($sel_cumple_agr))
			{
			echo '<br />';
			echo '<p class="centrado"><img src="imgs/cumple.png" class="alin_bajo"/>&nbsp;'.$reg_cumple['nombre'].' '.$reg_cumple['apellidos'].'</p>';
			}
		}
	}

//saludamos
echo '<br/>'.$nombre_dia.', '.$dia.'-'.$mes.'-'.$anyo.'';
if(mysql_num_rows($sel_men_nu)>0)
	{
	echo ' <a href="#" onclick="miraMensajes()" title="'.$id_mensajes_nuevos.'"><img class="alin_bajo" src="imgs/nuevo.png" alt="'.$id_mensajes_nuevos.'"/></a>';
	}
//¿menos de 3 días para un examen?
$sel_examen=mysql_query("select * from agenda where docente='$docente' and tipo = 'e' and fecha > '$fecha_ing' order by fecha asc");
$num_examen=mysql_num_rows($sel_examen);
if($num_examen>0)
	{
	$reg_examen=mysql_fetch_array($sel_examen);
	$fecha_examen=$reg_examen['fecha'];
	$fecha_examen_esp=cambia_fecha_a_esp($fecha_examen);
	echo ' <img class="alin_bajo" src="imgs/advertencia.png" title="'.$id_exam_pdtes.': '.$num_examen.'. '.$id_fecha_prim.': '.$fecha_examen_esp.'" alt="'.$id_exam_pdtes.': '.$num_examen.'. '.$id_fecha_prim.': '.$fecha_examen_esp.'"/>';
	}

//¿han de entregar tarea hoy?/////
$sel_tareas=mysql_query("select * from agenda where docente='$docente' and tipo='t' and fecha = now()");
if(mysql_num_rows($sel_tareas)>0)
	{
	echo ' <img class="alin_bajo" src="imgs/tareas_peq.png" title="'.$id_tarea_hoy.'" alt="'.$id_tarea_hoy.'"/>';
	}

//////
//montamos agenda lectiva

$sel_agenda = mysql_query("select franjas.hini,franjas.franja,franjas.docente,horario.docente,horario.franja,horario.dia,horario.sesion from franjas,horario where franjas.docente = '$docente' and franjas.docente=horario.docente and franjas.franja = horario.franja and horario.dia = '$numero_dia' order by franjas.franja");
$num_agenda = mysql_num_rows($sel_agenda);
if($num_agenda>0)
	{
	echo '<br />';
	echo '<table class="tablacentrada_agenda">';
	echo '<tr class="encab">';
	echo '<td>'.$id_horaini.'</td><td>'.$id_sesion.'</td><td>'.$id_cita.'</td>';
	echo '</tr>';
	for($ns=0;$ns<$num_agenda;$ns++)
		{
		$reg_agenda = mysql_fetch_array($sel_agenda);
		if($ns%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		$hini_actual=$reg_agenda['hini'];
		echo '<td class="centrado">'.$hini_actual.'</td>';
		$sesion_actual=$reg_agenda['sesion'];
		$sel_agr = mysql_query("select agrupamiento from agrupamientos where agrupamiento='$sesion_actual'");
		if(mysql_num_rows($sel_agr)>0)
			{
			echo '<td class="centrado"><a href="#" onclick="abreAgrup(\''.$sesion_actual.'\',\''.$fecha_ing.'\',\''.$hini_actual.'\')">'.$sesion_actual.'</a></td>';
			}
		else
			{
			echo '<td class="centrado">'.$sesion_actual.'</td>';
			}
		$franja = $reg_agenda['franja'];

		echo '<td>';

		$sel_citas = mysql_query("select * from agenda where docente = '$docente' and franja = '$franja' and dia = '$numero_dia' and fecha='$fecha_ing'");
		$num_citas = mysql_num_rows($sel_citas);
		if($num_citas>0)
			{
			echo '<table class="tabla_agenda">';
			for($cpub=0;$cpub<(mysql_num_rows($sel_citas));$cpub++)
				{
				$reg_citas = mysql_fetch_array($sel_citas);
				$tipo = $reg_citas['tipo'];
					switch($tipo)
						{
						case $id_abr_tarea:
						$tipo_c=$id_tarea;
						break;
						case $id_abr_examen:
						$tipo_c=$id_examen;
						break;
						case $id_abr_obs:
						$tipo_c=$id_inf_nb;
						break;
						case $id_abr_privado:
						$tipo_c=$id_privado;
						break;
						}
				$texto_cita = $reg_citas['cita'];
				$texto_cita_pre = str_replace("[igual]","=",$texto_cita);
				$texto_f = str_replace("~inte~","?",$texto_cita_pre);
				$id_cita = $reg_citas['id'];
				echo '<tr>';
				echo '<td class="alin_alto_justif">';
				echo '<a href="#" onclick="borraCita(\''.$id_cita.'\',\''.$dia.'\',\''.$mes.'\',\''.$anyo.'\')" title="'.$id_elicita.'"><img class="alin_bajo" src="imgs/borra_peq.png" alt="'.$id_elicita.'" /"'.$id_cita.'></a>';
				echo '</td>';
				echo '<td class="alin_alto_justif">';
				echo '<a href="#" onclick="new LITBox(\'citas.php?idcita='.$id_cita.'&dia='.$dia.'&mes='.$mes.'&anyo='.$anyo.'&franja='.$franja.'&numero_dia='.$numero_dia.'\', {type:\'window\', overlay:true, height:300, width:500, resizable:true});" title="'.$id_edicita.'"><img class="alin_bajo" src="imgs/edita_peq.png" alt="'.$id_edicita.'" /></a>';	

				echo '</td>';
				echo '<td class="alin_alto_justif">';		
				echo '<span class="negrita">'.$tipo_c.':</span>';
				echo '</td>';
				echo '<td class="alin_alto_justif">';
				echo $texto_f;
				echo '</td>';				
				echo '</tr>';			
				}
			
			echo '</table>';
			echo '<br/>';
			echo '<a href="#" onclick="new LITBox(\'citas.php?id='.$ns.'&dia='.$dia.'&mes='.$mes.'&anyo='.$anyo.'&franja='.$franja.'&numero_dia='.$numero_dia.'\', {type:\'window\', overlay:true, height:300, width:500, resizable:true});" title="'.$id_nocita.'"><img src="imgs/mas.png" alt="'.$id_nocita.'" /></a>';			
			}
	
		else
			{
			echo '<a href="#" onclick="new LITBox(\'citas.php?id='.$ns.'&dia='.$dia.'&mes='.$mes.'&anyo='.$anyo.'&franja='.$franja.'&numero_dia='.$numero_dia.'\', {type:\'window\', overlay:true, height:300, width:500, resizable:true});" title="'.$id_nocita.'"><img src="imgs/mas.png" alt="'.$id_nocita.'" /></a>';	
			}
		echo '</td>';

				
		echo '</tr>';

		}
	echo '</table>';
	}//fin if este dia tienes clase

else
	{
	echo '<br/><p class="texto_centrado">'.$id_noclase.'</p>';
	}//fin else hoy no hay clase

}//fin if hay sesión

?>
