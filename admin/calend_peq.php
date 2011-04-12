<?php

session_start();
require('../config.php');
require('../idioma/'.$idioma.'');
include('../funciones_calendario.php');
include('../funciones.php');
$docente = $_SESSION['usuario_sesion'];
//recogemos variables
$mes_actual = $_GET['mes'];
$anyo_actual = $_GET['anyo'];
$id = $_GET['id'];
conecta();
//si es la primera vez que entramos, cargamos la fecha actual
if(!isset($mes_actual)) $mes_actual = date('m');
if(!isset($anyo_actual)) $anyo_actual = date('Y');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="../index.css" rel="stylesheet" type="text/css" />
<script src="../js/prototype.js" type="text/javascript"></script>
<script src="../js/effects.js" type="text/javascript"></script>
<script src="../js/scriptaculous.js" type="text/javascript"></script>
<script src="../js/funciones.js" type="text/javascript" ></script>
<script src="../js/rico.js" type="text/javascript"></script>
<script src="../js/litbox.js" type="text/javascript"></script>
<script src="../js/litboxflash.js" type="text/javascript"></script>
</head>
<body>
<?php

//presentamos ahora el calendario del mes actual o cargado

//tabla con nombre mes y año y las flechas para navegar
echo '
<div id="calend_peq">
<table>
<tr class="encab">
<td>
<a href="#" onclick="navegaMesPeq(\''.$mes_actual.'\',\''.$anyo_actual.'\',\'menos\',\''.$id.'\')" title="'.$id_anterior.'"><img src="../imgs/anterior_peq.png" alt="'.$id_anterior.'" /></a>
';
$nombre_mes = numero_mes_a_nombre($mes_actual);
echo $nombre_mes;
echo '
<a href="#" onclick="navegaMesPeq(\''.$mes_actual.'\',\''.$anyo_actual.'\',\'mas\',\''.$id.'\')" title="'.$id_siguiente.'"><img src="../imgs/siguiente_peq.png" alt="'.$id_anterior.'" /></a>
</td>
<td>
<a href="#" onclick="navegaAnyoPeq(\''.$anyo_actual.'\',\''.$mes_actual.'\',\'menos\',\''.$id.'\')" title="'.$id_anterior.'"><img src="../imgs/anterior_peq.png" alt="'.$id_anterior.'" /></a>
';
echo $anyo_actual;
echo '
<a href="#" onclick="navegaAnyoPeq(\''.$anyo_actual.'\',\''.$mes_actual.'\',\'mas\',\''.$id.'\')" title="'.$id_siguiente.'"><img src="../imgs/siguiente_peq.png" alt="'.$id_anterior.'" /></a>
</td>
</tr>
</table>
<br />
';

//la cabecera con los nombres de los días
echo '
<table>
<tr class="encab">
<td>
'.$id_cl.'
</td>
<td>
'.$id_cm.'
</td>
<td>
'.$id_cx.'
</td>
<td>
'.$id_cj.'
</td>
<td>
'.$id_cv.'
</td>
<td>
'.$id_cs.'
</td>
<td>
'.$id_cd.'
</td>
</tr>
';

//la tabla con el calendario

//primera fila: compruebo dónde cae el día uno del mes y año cargados
echo '<tr>';

$array_dias = array($id_l,$id_m,$id_x,$id_j,$id_v,$id_s,$id_d);

	$nombre_dia_ing = date('l',mktime(0, 0, 0, $mes_actual, 1, $anyo_actual));
	$nombre_dia = dia_esp($nombre_dia_ing);	

	$posicion = array_search($nombre_dia,$array_dias);

	for($p=0;$p<$posicion;$p++)
		{
		echo '<td>  </td>';
		}
	for($p=$posicion;$p<7;$p++)
		{
		$a=$posicion-1;
		$d=$p-$posicion;
		$fecha_ing = ''.$anyo_actual.'-'.$mes_actual.'-'.($d+1).'';
		$sel_agenda = mysql_query("select cita from agenda where docente='$docente' and fecha='$fecha_ing'");
		if(mysql_num_rows($sel_agenda)>0)
			{
			$dia_actual=date('d');
			if($dia_actual>($d+1))
				{
				echo '<td class="centrado_verde">';
				}
			else
				{
				echo '<td class="centrado_rojo">';
				}
			}
		else
			{
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendarioPeq1(\''.($d+1).'\',\''.$mes_actual.'\',\''.$anyo_actual.'\',\''.$id.'\')">';
		echo ($d+1);
		echo '</a>';
		echo '</td>';
		}
	
echo '</tr>';

//segunda fila
echo '<tr>';
	for($s=($d+2);$s<($d+9);$s++)
		{
		$fecha_ing = ''.$anyo_actual.'-'.$mes_actual.'-'.($s).'';
		$sel_agenda = mysql_query("select cita from agenda where docente='$docente' and fecha='$fecha_ing'");
		if(mysql_num_rows($sel_agenda)>0)
			{
			$dia_actual=date('d');
			if($dia_actual>$s)
				{
				echo '<td class="centrado_verde">';
				}
			else
				{
				echo '<td class="centrado_rojo">';
				}
			}
		else
			{
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendarioPeq1(\''.$s.'\',\''.$mes_actual.'\',\''.$anyo_actual.'\',\''.$id.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
echo '</tr>';
//tercera fila
echo '<tr>';
	for($s=($d+9);$s<($d+16);$s++)
		{
		$fecha_ing = ''.$anyo_actual.'-'.$mes_actual.'-'.($s).'';
		$sel_agenda = mysql_query("select cita from agenda where docente='$docente' and fecha='$fecha_ing'");
		if(mysql_num_rows($sel_agenda)>0)
			{
			$dia_actual=date('d');
			if($dia_actual>$s)
				{
				echo '<td class="centrado_verde">';
				}
			else
				{
				echo '<td class="centrado_rojo">';
				}
			}
		else
			{
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendarioPeq1(\''.$s.'\',\''.$mes_actual.'\',\''.$anyo_actual.'\',\''.$id.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
echo '</tr>';	
//cuarta fila
echo '<tr>';
	for($s=($d+16);$s<($d+23);$s++)
		{
		$fecha_ing = ''.$anyo_actual.'-'.$mes_actual.'-'.($s).'';
		$sel_agenda = mysql_query("select cita from agenda where docente='$docente' and fecha='$fecha_ing'");
		if(mysql_num_rows($sel_agenda)>0)
			{
			$dia_actual=date('d');
			if($dia_actual>$s)
				{
				echo '<td class="centrado_verde">';
				}
			else
				{
				echo '<td class="centrado_rojo">';
				}
			}
		else
			{
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendarioPeq1(\''.$s.'\',\''.$mes_actual.'\',\''.$anyo_actual.'\',\''.$id.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
echo '</tr>';	
//quinta fila y adicional (en su caso)
echo '<tr>';
//numero dias del mes actual
$ultimo_dia = ultimo_dia($mes_actual,$anyo_actual);
if($ultimo_dia<($d+30))
	{
	for($s=($d+23);$s<($ultimo_dia+1);$s++)
		{
		$fecha_ing = ''.$anyo_actual.'-'.$mes_actual.'-'.($s).'';
		$sel_agenda = mysql_query("select cita from agenda where docente='$docente' and fecha='$fecha_ing'");
		if(mysql_num_rows($sel_agenda)>0)
			{
			$dia_actual=date('d');
			if($dia_actual>$s)
				{
				echo '<td class="centrado_verde">';
				}
			else
				{
				echo '<td class="centrado_rojo">';
				}
			}
		else
			{
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendarioPeq1(\''.$s.'\',\''.$mes_actual.'\',\''.$anyo_actual.'\',\''.$id.'\')">';
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
		$fecha_ing = ''.$anyo_actual.'-'.$mes_actual.'-'.($s).'';
		$sel_agenda = mysql_query("select cita from agenda where docente='$docente' and fecha='$fecha_ing'");
		if(mysql_num_rows($sel_agenda)>0)
			{
			$dia_actual=date('d');
			if($dia_actual>$s)
				{
				echo '<td class="centrado_verde">';
				}
			else
				{
				echo '<td class="centrado_rojo">';
				}
			}
		else
			{
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendarioPeq1(\''.$s.'\',\''.$mes_actual.'\',\''.$anyo_actual.'\',\''.$id.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';
	echo '<tr>';
	for($s=($d+30);$s<($ultimo_dia+1);$s++)
		{
		$fecha_ing = ''.$anyo_actual.'-'.$mes_actual.'-'.($s).'';
		$sel_agenda = mysql_query("select cita from agenda where docente='$docente' and fecha='$fecha_ing'");
		if(mysql_num_rows($sel_agenda)>0)
			{
			$dia_actual=date('d');
			if($dia_actual>$s)
				{
				echo '<td class="centrado_verde">';
				}
			else
				{
				echo '<td class="centrado_rojo">';
				}
			}
		else
			{
			echo '<td class="centrado">';
			}
		echo '<a href="#" onclick="calendarioPeq1(\''.$s.'\',\''.$mes_actual.'\',\''.$anyo_actual.'\',\''.$id.'\')">';
		echo $s;
		echo '</a>';
		echo '</td>';
		}
	echo '</tr>';
	}
	
echo '</table>';
echo '</div>';
echo '</body>';
echo '</html>';
?>
