<?php

session_start();

//incluimos funciones,configuración e idioma
include('../funciones.php');
include('../funciones_calendario.php');
require('../config.php');
require('../idioma/'.$idioma.'');

//conectamos con MySQL
conecta();

//comprobamos usuario y clave
if (isset($_POST['txt_login']) && isset($_POST['pwd_clave']))
	{
	$usuario = $_POST['txt_login'];
	$clave = $_POST['pwd_clave'];
	$clave_crip = crypt($clave,'siestta');
	$sel_usuario = mysql_query("select * from docentes where docente = '$usuario' and clave = '$clave_crip'");
	 
	 if(mysql_num_rows($sel_usuario) > 0)
	 	{
	 	$reg_usuario = mysql_fetch_array($sel_usuario);
	 	$nombre = $reg_usuario['nombre'];
	 	$apellidos = $reg_usuario['apellidos'];
	 	$especialidad = $reg_usuario['especialidad'];
	 		 	
	 	$_SESSION['usuario_sesion'] = $usuario;
	 	$_SESSION['nombre_sesion']=$nombre;
		$_SESSION['apellidos_sesion']=$apellidos;
		}
	else
		{
		echo '<p>'.$mensaje_error.'</p>';
		}
	}

/*
This file is part of SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado).

SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) is developed by Ram&oacute;n Castro P&eacute;rez. You can get more information at http://www.ramoncastro.es or mailing to ramoncastroperez@gmail.com


    Copyright (C) 2007  Ramón Castro Pérez

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo 'SIESTTA 2.0: '.$nombre_centro.' Acceso PDA'; ?></title>
<link href="index.css" rel="stylesheet" type="text/css" />
<script src="../js/prototype.js" type="text/javascript"></script>
<script src="../js/effects.js" type="text/javascript"></script>
<script src="../js/scriptaculous.js" type="text/javascript"></script>
<script src="pda.js" type="text/javascript" ></script>
</head>
<body>
<?php
$usuario_activo = $_SESSION['usuario_sesion'];

if (isset($_SESSION['usuario_sesion']))
{
//montamos agenda lectiva
$dia=$_POST['p1'];
$mes=$_POST['p2'];
$anyo=$_POST['p3'];

if(isset($mes)&isset($anyo))
	{
	if(isset($dia))
		{
		$nombre_dia_ing0 = date('D',mktime(0, 0, 0, $mes, $dia, $anyo));
		$fecha = ''.$anyo.'-'.$mes.'-'.$dia.'';
		}
	else
		{
		$dia=date('d');
		$nombre_dia_ing0 = date('D',mktime(0, 0, 0, $mes, $dia, $anyo));
		$fecha = ''.$anyo.'-'.$mes.'-'.$dia.'';
		}
	}
else
	{
	if($_POST['fecha'])
		{
		$fecha = $_POST['fecha'];
		$nombre_dia_ing0 = date('D',strtotime($fecha));
		$dia = date('d',strtotime($fecha));
		$mes = date('m',strtotime($fecha));
		$anyo = date('Y',strtotime($fecha));
		}
	else
		{
		$nombre_dia_ing0 = date('D');
		$fecha = date('Y-m-d');
		$dia = date('d');
		$mes = date('m');
		$anyo = date('Y');
		}
	}
$numero_dia0 = nombre_dia_a_numero($nombre_dia_ing0);
$nombre_dia0=encuentra_dia($numero_dia0-1);
$sel_agenda = mysql_query("select franjas.hini,franjas.franja,franjas.docente,horario.docente,horario.franja,horario.dia,horario.sesion from franjas,horario where franjas.docente = '$usuario_activo' and franjas.docente=horario.docente and franjas.franja = horario.franja and horario.dia = '$numero_dia0' order by franjas.franja");
$num_agenda = mysql_num_rows($sel_agenda);

echo '<div id="center" class="justificado">';

if($num_agenda>0)
	{
	echo '<span>'.$_SESSION['nombre_sesion'].' '.$_SESSION['apellidos_sesion'].'</span><span id="cargando" style="display:none;" /><img src="imgs/cargando.gif" title="'.$id_cargando.'" /></span>';
	
	echo '<br />';
	//¿cumpleaños hoy?
	$sel_cumple = mysql_query("select codigo,apellidos,nombre from alumnado where month(f_nac)='$mes' and day(f_nac) = '$dia'");
	if(mysql_num_rows($sel_cumple)!=0)
		{
		for($cu=0;$cu<(mysql_num_rows($sel_cumple));$cu++)
			{
			$reg_cumple=mysql_fetch_array($sel_cumple);
			$cod_cumple=$reg_cumple['codigo'];
			$sel_cumple_agr = mysql_query("select matricula.agrupamiento from matricula,agrupamientos where matricula.codigo='$cod_cumple' and matricula.agrupamiento = agrupamientos.agrupamiento and agrupamientos.docente = '$usuario_activo'");
			if(mysql_num_rows($sel_cumple_agr))
				{
				echo '<br />';
				echo '<span class="centrado"><img src="../imgs/cumple.png" class="alin_bajo"/>&nbsp;'.$reg_cumple['nombre'].' '.$reg_cumple['apellidos'].'</span>';
				}
			}
		}
	//¿hay examen pronto? /////
	$sel_exa=mysql_query("select * from agenda where docente='$usuario_activo' and tipo='e' and fecha > '$fecha'");
	if(mysql_num_rows($sel_exa)>0)
		{
		echo '<br /><span><a href="#" onclick="abreListaExamen(\''.$fecha.'\')";><img src="imgs/exa.png" title="'.$id_examen_pdtes.'" alt="'.$id_examen_pdtes.'" title="'.$id_examen_pdtes.'" /></a></span>';
		}
	if($_POST['lista_examen'] == 'si')
	{
	echo '<span><a href="panel_pda.php"><img src="imgs/anterior.png" title="'.$id_volver.'" /></a></span>';
	$sel_examen=mysql_query("select * from agenda where docente='$usuario_activo' and tipo='e' and fecha >= '$fecha'");
	$num_examenes=mysql_num_rows($sel_examen);
	echo '<ul>';
	for($ex=0;$ex<$num_examenes;$ex++)
		{
		$reg_examenes = mysql_fetch_array($sel_examen);
		$examen = $reg_examenes['cita'];
		$franja_gen = $reg_examenes['franja'];
		$dia_gen =$reg_examenes['dia'];
		$fecha_examen = $reg_examenes['fecha'];
		$sel_agr = mysql_query("select sesion from horario where docente = '$usuario_activo' and dia = '$dia_gen' and franja = '$franja_gen'");
		$reg_agr = mysql_fetch_array($sel_agr);
		$agr_gen = $reg_agr['sesion'];
		echo '<li>'.cambia_fecha_a_esp($fecha_examen).' '.$agr_gen.': '.$examen.'</li>';
		}
	echo '</ul>';
	}
	///fin aviso hay examen

	//¿han de entregar tarea hoy?/////
	$sel_tareas=mysql_query("select * from agenda where docente='$usuario_activo' and tipo='t' and fecha = '$fecha'");
	$sel_tareas_ind=mysql_query("select tareas.tarea from tareas,agrupamientos where tareas.fecha_ent = '$fecha' and tareas.agrupamiento=agrupamientos.agrupamiento and agrupamientos.docente = '$usuario_activo'"); 
	if(mysql_num_rows($sel_tareas)>0 || mysql_num_rows($sel_tareas_ind)>0)
		{
		echo '<br /><span><a href="#" onclick="abreListaTareas(\''.$fecha.'\')";><img src="../imgs/tareas_peq.png" title="'.$id_tareas_pendientes.'" alt="'.$id_tareas_pendientes.'" title="'.$id_tareas_pendientes.'" /></a></span>';
		}

	if($_POST['lista_tareas'] == 'si')
	{
	$fecha_entrega=$_POST['fecha_tarea'];
	
	echo '<span><a href="panel_pda.php"><img src="imgs/anterior.png" title="'.$id_volver.'" /></a></span>';
	$sel_tareas=mysql_query("select * from agenda where docente='$usuario_activo' and tipo='t' and fecha = '$fecha_entrega'");
	$num_tareas=mysql_num_rows($sel_tareas);
	echo '<ul>';
	for($tg=0;$tg<$num_tareas;$tg++)
		{
		$reg_tareas = mysql_fetch_array($sel_tareas);
		$tarea_gen = $reg_tareas['cita'];
		$franja_gen = $reg_tareas['franja'];
		$dia_gen =$reg_tareas['dia'];
		$sel_agr = mysql_query("select sesion from horario where docente = '$usuario_activo' and dia = '$dia_gen' and franja = '$franja_gen'");
		$reg_agr = mysql_fetch_array($sel_agr);
		$agr_gen = $reg_agr['sesion'];
		echo '<li>'.$agr_gen.': '.$tarea_gen.'</li>';
		}
	$sel_tareas_ind=mysql_query("select tareas.tarea,tareas.codigo,tareas.agrupamiento from tareas,agrupamientos where tareas.fecha_ent = '$fecha_entrega' and tareas.agrupamiento=agrupamientos.agrupamiento and agrupamientos.docente = '$usuario_activo'"); 
	$num_tareas_ind = mysql_num_rows($sel_tareas_ind);
	for($ti=0;$ti<$num_tareas_ind;$ti++)
		{
		$reg_tareas_ind = mysql_fetch_array($sel_tareas_ind);
		$tarea_ind = $reg_tareas_ind['tarea'];
		$codigo_ind = $reg_tareas_ind['codigo'];
		$agr_ind = $reg_tareas_ind['agrupamiento'];
		$sel_datos = mysql_query("select nombre,apellidos from alumnado where codigo = '$codigo_ind'");
		$reg_datos = mysql_fetch_array($sel_datos);
		echo '<li>'.$reg_datos['nombre'].' '.$reg_datos['apellidos'].' ('.$agr_ind.'): '.$tarea_ind.'</li>';
		}
	echo '</ul>';
	}
	else
	{
	echo '<br /><br /><table class="centrada_cal">';
	echo '<tr class="encab"><td>'.$id_horaini.'</td><td>'.$id_sesion.'</td></tr>';
	for($ns=0;$ns<($num_agenda);$ns++)
		{
		if($ns%2==0){echo '<tr>';}else{echo '<tr class="impar">';}
		$reg_agenda = mysql_fetch_array($sel_agenda);
		$hini=$reg_agenda['hini'];
		echo '<td>'.$hini.'</td>';
		$sesion=$reg_agenda['sesion'];
		$sel_agr = mysql_query("select agrupamiento from agrupamientos where agrupamiento='$sesion'");
		if(mysql_num_rows($sel_agr)>0)
			{
			echo '<td><a href="#" onclick="abreAgrup(\''.$sesion.'\',\''.$hini.'\',\''.$id_inf_asi.'\',\''.$fecha.'\')";>'.$sesion.'</a></span></td>';
			}
		else
			{
			echo '<td>'.$sesion.'</td></tr>';
			}
		}//fin de for
	echo '</table>';

	echo '<br />';
	/////////////////////////////////////////////////////////////////////////////////////////////////
	//presentamos calendario/////////////////////////////////////////////////////////////////////////
	//la cabecera con los nombres de los días////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////
	
	//tabla con nombre mes y año y las flechas para navegar
	echo '
	<table class="centrada_nav"><tr><td><a href="#" onclick="navegaMes(\''.$mes.'\',\''.$anyo.'\',\'menos\')" title="'.$id_anterior.'"><img src="imgs/anterior.png" alt="'.$id_anterior.'" /></a>
	';
	$nombre_mes = numero_mes_a_nombre($mes);
	echo $nombre_mes;
	echo '
	<a href="#" onclick="navegaMes(\''.$mes.'\',\''.$anyo.'\',\'mas\')" title="'.$id_siguiente.'"><img src="imgs/siguiente.png" alt="'.$id_anterior.'" /></a>
	
	<a href="#" onclick="navegaAnyo(\''.$anyo.'\',\''.$mes.'\',\'menos\')" title="'.$id_anterior.'"><img src="imgs/anterior.png" alt="'.$id_anterior.'" /></a>
	';
	echo $anyo;
	echo '
	<a href="#" onclick="navegaAnyo(\''.$anyo.'\',\''.$mes.'\',\'mas\')" title="'.$id_siguiente.'"><img src="imgs/siguiente.png" alt="'.$id_anterior.'" /></a></td></tr></table>
	<br />
	';

	echo '
	<table class="centrada_cal">
	<tr>
	<td class="centrado">
	'.$id_cl.'
	</td>
	<td class="centrado">
	'.$id_cm.'
	</td>
	<td class="centrado">
	'.$id_cx.'
	</td>
	<td class="centrado">
	'.$id_cj.'
	</td>
	<td class="centrado">
	'.$id_cv.'
	</td>
	<td class="centrado">
	'.$id_cs.'
	</td>
	<td class="centrado">
	'.$id_cd.'
	</td>
	</tr>
	';
	//primera fila: compruebo dónde cae el día uno del mes y año cargados
	echo '<tr>';

	$array_dias = array($id_l,$id_m,$id_x,$id_j,$id_v,$id_s,$id_d);

	$nombre_dia_ing = date('l',mktime(0, 0, 0, $mes, 1, $anyo));
	$nombre_dia = dia_esp($nombre_dia_ing);	

	$posicion = array_search($nombre_dia,$array_dias);

	for($p=0;$p<$posicion;$p++)
		{
		echo '<td></td>';
		}
	for($p=$posicion;$p<7;$p++)
		{
		$a=$posicion-1;
		$d=$p-$posicion;
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($d+1).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
			
		echo '<a href="#" onclick="calendario(\''.($d+1).'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo ($d+1);
		echo '</a>';
		echo '</td>';
		}
	
	echo '</tr>';

	//segunda fila
	echo '<tr>';
	for($s=($d+2);$s<($d+9);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
			
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';
	//tercera fila
	echo '<tr>';
	for($s=($d+9);$s<($d+16);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';	
	//cuarta fila
	echo '<tr>';
	for($s=($d+16);$s<($d+23);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';	
	//quinta fila y adicional (en su caso)
	echo '<tr>';
	//numero dias del mes actual
	$ultimo_dia = ultimo_dia($mes,$anyo);
	if($ultimo_dia<($d+30))
	{
	for($s=($d+23);$s<($ultimo_dia+1);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';
	}
	else
	{
	for($s=($d+23);$s<($d+30);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		
			echo '<td class="centrado">';
			
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';
	echo '<tr>';
	for($s=($d+30);$s<($ultimo_dia+1);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';
	}

	echo '</table>';

	
	///////////////////////////////////////////////////////////////////////////////////////////////////////
	//fin presentar calendario/////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////

	

	}//fin de else (no estoy mirando lista de tareas)
	echo '<br/><div class="centrado"><a href="salir.php" title="'.$id_descon.'"><img src="../imgs/salir.png" alt="'.$id_descon.'" /></a></div>';
	}//fin if este dia tienes clase
else
	{
	echo '<span>'.$_SESSION['nombre_sesion'].' '.$_SESSION['apellidos_sesion'].'</span>';
	echo '<br />';
	/////////////////////////////////////////////////////////////////////////////////////////////////
	//presentamos calendario/////////////////////////////////////////////////////////////////////////
	//la cabecera con los nombres de los días////////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////

	//tabla con nombre mes y año y las flechas para navegar
	echo '
	<table class="centrada_nav"><tr><td>
	<a href="#" onclick="navegaMes(\''.$mes.'\',\''.$anyo.'\',\'menos\')" title="'.$id_anterior.'"><img src="imgs/anterior.png" alt="'.$id_anterior.'" /></a></span>
	';
	$nombre_mes = numero_mes_a_nombre($mes);
	echo $nombre_mes;
	echo '
	<span><a href="#" onclick="navegaMes(\''.$mes.'\',\''.$anyo.'\',\'mas\')" title="'.$id_siguiente.'"><img src="imgs/siguiente.png" alt="'.$id_anterior.'" /></a></span>
	<span>
	<a href="#" onclick="navegaAnyo(\''.$anyo.'\',\''.$mes.'\',\'menos\')" title="'.$id_anterior.'"><img src="imgs/anterior.png" alt="'.$id_anterior.'" /></a></span>
	';
	echo $anyo;
	echo '<span>
	<a href="#" onclick="navegaAnyo(\''.$anyo.'\',\''.$mes.'\',\'mas\')" title="'.$id_siguiente.'"><img src="imgs/siguiente.png" alt="'.$id_anterior.'" /></a></td></tr></table>
	<br />
	';

	echo '
	<table class="centrada_cal">
	<tr>
	<td class="centrado">
	'.$id_cl.'
	</td>
	<td class="centrado">
	'.$id_cm.'
	</td>
	<td class="centrado">
	'.$id_cx.'
	</td>
	<td class="centrado">
	'.$id_cj.'
	</td>
	<td class="centrado">
	'.$id_cv.'
	</td>
	<td class="centrado">
	'.$id_cs.'
	</td>
	<td class="centrado">
	'.$id_cd.'
	</td>
	</tr>
	';
	//primera fila: compruebo dónde cae el día uno del mes y año cargados
	echo '<tr>';

	$array_dias = array($id_l,$id_m,$id_x,$id_j,$id_v,$id_s,$id_d);

	$nombre_dia_ing = date('l',mktime(0, 0, 0, $mes, 1, $anyo));
	$nombre_dia = dia_esp($nombre_dia_ing);	

	$posicion = array_search($nombre_dia,$array_dias);

	for($p=0;$p<$posicion;$p++)
		{
		echo '<td></td>';
		}
	for($p=$posicion;$p<7;$p++)
		{
		$a=$posicion-1;
		$d=$p-$posicion;
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($d+1).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.($d+1).'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo ($d+1);
		echo '</a>';
		echo '</td>';
		}
	
	echo '</tr>';

	//segunda fila
	echo '<tr>';
	for($s=($d+2);$s<($d+9);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';
	//tercera fila
	echo '<tr>';
	for($s=($d+9);$s<($d+16);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';	
	//cuarta fila
	echo '<tr>';
	for($s=($d+16);$s<($d+23);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';	
	//quinta fila y adicional (en su caso)
	echo '<tr>';
	//numero dias del mes actual
	$ultimo_dia = ultimo_dia($mes,$anyo);
	if($ultimo_dia<($d+30))
	{
	for($s=($d+23);$s<($ultimo_dia+1);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';
	}
	else
	{
	for($s=($d+23);$s<($d+30);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';
	echo '<tr>';
	for($s=($d+30);$s<($ultimo_dia+1);$s++)
		{
		$fecha_ing = ''.$anyo.'-'.$mes.'-'.($s).'';
		if($fecha_ing==$fecha)
			{
			echo '<td class="centrado_hoy">';
			}
		else
			{		
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendario(\''.$s.'\',\''.$mes.'\',\''.$anyo.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';
	}

	echo '</table>';

	

	///////////////////////////////////////////////////////////////////////////////////////////////////////
	//fin presentar calendario/////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////

	echo '<br/><p>'.$id_noclase.'</p><br /><div class="centrado"><a href="salir.php" title="'.$id_descon.'"><img src="../imgs/salir.png" alt="'.$id_descon.'" /></a></div>';
	}//fin else hoy no hay clase
	echo '</div>';
}//fin de if sesión
?>

</body>
</html>
