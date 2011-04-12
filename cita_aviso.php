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
echo '<p class="centrado">Citas pendientes</p>';
//consultamos
$sel_citas = mysql_query("select * from agenda where docente = '".$_SESSION['usuario_sesion']."' and tipo = 'p' and fecha >= now()");
echo '<br />';
echo '<table class="tablacentrada">';
for($c=0;$c<(mysql_num_rows($sel_citas));$c++)
	{
	$reg_citas = mysql_fetch_array($sel_citas);
	$fecha = $reg_citas['fecha'];
	$fecha_esp = cambia_fecha_a_esp($fecha);
	$cita = $reg_citas['cita'];
	if($c%2==0){echo '<tr class="par">';}else{echo '<tr>';}
	echo '<td class="encab">'.$fecha_esp.'</td><td class="justificado">'.$cita.'</td>';
	echo '</tr>';
	}
echo '</table>';
}

?>
