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

//recogemos variables
$sesion = $_POST['p1'];
$fecha_ing = $_POST['p2'];
$hini = $_POST['p3'];

$codigo = $_POST['p4'];

//estamos en el mes?
if($_POST['p5'])
	{
	$mes = $_POST['p5'];
	}
else
	{
	$mes = date('m');
	}

//¿vengo de ordenar justificar?
if($_POST['p6']=='justifica')
	{
	//hago la misma consulta
	$sel_faltas = mysql_query("select asistencia.agrupamiento,asistencia.fecha,asistencia.hini,asistencia.dato from asistencia,agrupamientos where agrupamientos.docente = '$docente' and agrupamientos.agrupamiento = asistencia.agrupamiento and asistencia.codigo = '$codigo' and asistencia.dato != 'r' and asistencia.dato != 'a' and month(asistencia.fecha) = '$mes' order by asistencia.fecha,asistencia.hini");
	$num_faltas = mysql_num_rows($sel_faltas);
	//monto for para ir recogiendo variables post
	for($p=0;$p<$num_faltas;$p++)
		{
		$reg_faltas = mysql_fetch_array($sel_faltas);
		$agrupamiento = $reg_faltas['agrupamiento'];
		$fecha = $reg_faltas['fecha'];
		$hini = $reg_faltas['hini'];
		$dato = $reg_faltas['dato'];
		$cb = $_POST['just_'.$p.''];
		if($cb)
			{
			$act=mysql_query("update asistencia set dato='J' where codigo='$codigo' and agrupamiento='$agrupamiento' and fecha='$fecha' and hini='$hini'");
			}
		else
			{
			$act=mysql_query("update asistencia set dato='F' where codigo='$codigo' and agrupamiento='$agrupamiento' and fecha='$fecha' and hini='$hini'");
			}		
		}
	}

//consulto datos del alumno

$sel_alum = mysql_query("select nombre,apellidos from alumnado where codigo='$codigo'");
$reg_alum = mysql_fetch_array($sel_alum);
$nombre  = $reg_alum['nombre'];
$apellidos = $reg_alum['apellidos'];

echo '<br />';
echo '<p class="centrado"><a href="#" onclick="abreAgrup(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\')" title="'.$id_volver.'"><img src="imgs/volver.png" alt="'.$id_volver.'" /></a> '.$nombre.' '.$apellidos.'</p>';

//lo más importante: presentar el formulario para justificar con las franjas horarias que interesan

$sel_faltas = mysql_query("select asistencia.agrupamiento,asistencia.fecha,asistencia.hini,asistencia.dato from asistencia,agrupamientos where agrupamientos.docente = '$docente' and agrupamientos.agrupamiento = asistencia.agrupamiento and asistencia.codigo = '$codigo' and asistencia.dato != 'r' and asistencia.dato != 'a' and month(asistencia.fecha) = '$mes' order by asistencia.fecha,asistencia.hini");
$num_faltas = mysql_num_rows($sel_faltas);

echo '<br />';
echo '<p class="centrado"><a href="#" onclick="justiFica(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\''.$mes.'\')" title="'.$id_reg.'"><img src="imgs/guardar.png" alt="'.$id_reg.'" /></a></p>';
echo '<br />';
echo '<form id="lista" name="lista">';
echo '<table class="tablacentrada">';
echo '<tr class="encab">';
echo '<td>'.$id_fecha.'<br /><a href="#" onclick="abreJustifAnt(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\''.$mes.'\')">'.$id_anterior.'</a> / <a href="#" onclick="abreJustifSig(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$codigo.'\',\''.$mes.'\')">'.$id_siguiente.'</a></td>';
echo '<td>'.$id_horaini.'</td><td>'.$id_agr.'</td><td>'.$id_faltajust.'</td>';
echo '<td>'.$id_justificar.'<br /><a href="#" onclick="marcaTodos(\''.$num_faltas.'\')">'.$id_marcar_todos.'</a> / <a href="#" onclick="desmarcaTodos(\''.$num_faltas.'\')">'.$id_ninguno.'</a></td>';
echo '</tr>';

for($f=0;$f<$num_faltas;$f++)
	{
	$reg_faltas = mysql_fetch_array($sel_faltas);
	$agrupamiento = $reg_faltas['agrupamiento'];
	$fecha = $reg_faltas['fecha'];
	$fecha_esp = cambia_fecha_a_esp($fecha);
	$hini = $reg_faltas['hini'];
	$dato = $reg_faltas['dato'];
	if($f%2==0){echo '<tr class="par">';}else{echo '<tr>';}
	echo '<td>'.$fecha_esp.'</td>';
	echo '<td>'.$hini.'</td>';
	echo '<td>'.$agrupamiento.'</td>';
	echo '<td>'.$dato.'</td>';
	echo '<td>';
	if($dato == 'J')
		{
		echo '<input name="just_'.$f.'" id="just_'.$f.'" type="checkbox" checked="checked" />';
		}
	else
		{
		echo '<input name="just_'.$f.'" id="just_'.$f.'" type="checkbox" />';
		}
	echo '</td>';
	echo '</tr>';
	}
echo '</table>';
echo '</form>';
}

?>
