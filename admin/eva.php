<?php

session_start();
//incluimos funciones,configuración e idioma
include('../funciones.php');
require('../config.php');
require('../idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']) && $_SESSION['rol_sesion'] == 'admin')
{
//conecto con MySQL
conecta();

//montamos un switch para llevar a cabo las acciones
	
	echo '<br /><span class="negrita">'.$id_reg_eva.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_reg_eva.'</p>';
	//vamos a presentar el formulario para agregar un período de evaluación

	echo '<p class="negrita">'.$id_agregar.' '.$id_un.' '.$id_periodo.' '.$id_de.' '.$id_evaluacion.'</p>';
	
	echo '<form name="guardaper" id="guardaper">';
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_periodo.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_inicio.' (dd-mm-aaaa)</td>';
	echo '<td>'.$id_fin.' (dd-mm-aaaa)</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td class="centrado"><input type="text" name="txt_per" size="1" maxlength="2" id="txt_per" value=""/></td>';
	echo '<td class="centrado"><input type="text" name="txt_nom" maxlength="30" id="txt_nom" value=""/></td>';
	echo '<td><input type="text" name="txt_fec1" readonly="readonly" size="7" id="txt_fec1" onclick="calend_peq1(\'txt_fec1\')" /></td>';
	echo '<td><input type="text" name="txt_fec2" readonly="readonly" size="7" id="txt_fec2" onclick="calend_peq1(\'txt_fec2\')" /></td>';
	echo '</tr>';
	echo '</table>';
	echo '<p><a href="#" onclick="evaGuarda()" title="'.$id_guardar.'">';
	echo '<img src="../imgs/guardar.png" alt="'.$id_guardar.'" />';
	echo '</a></p>';
	echo '</form>';

	echo '<b />';

	//si venimos de grabar o editar
	$accion = $_POST['p2'];
	
	switch ($accion)
	{

	case 'graba':
	
	$periodo = $_POST['txt_per'];
	$nombre_per = $_POST['txt_nom'];
	$fecha_ini = $_POST['txt_fec1'];
	$fecha_fin = $_POST['txt_fec2'];
	$fecha_ini_ing = cambia_fecha_a_ing($fecha_ini);
	$fecha_fin_ing = cambia_fecha_a_ing($fecha_fin);
	$inserta_per = mysql_query("insert into periodos values('$periodo','$nombre_per','$fecha_ini_ing','$fecha_fin_ing')");

	break;

	case 'edita':
	$valor = $_POST['p3'];
	$per = $_POST['p4'];
	$campo = $_POST['p5'];
	$campo_abr = substr($campo,0,3);
	if($campo_abr == 'ini' || $campo_abr == 'fin') $valor = cambia_fecha_a_ing($valor);
	if($campo_abr == 'ini')
		{
		$act_per = mysql_query("update periodos set inicio='$valor' where periodo='$per'");
		}
	if($campo_abr == 'fin')
		{
		$act_per = mysql_query("update periodos set fin='$valor' where periodo='$per'");
		}

	break;

	case 'borra':
	$per = $_POST['p3'];
	$elim_per = mysql_query("delete from periodos where periodo='$per'");

	break;

	}//fin switch

	//listo períodos existentes con inputs para edición rápida

	$sel_per = mysql_query("select * from periodos");
	$num_per = mysql_num_rows($sel_per);
	if($num_per > 0)
	{
	echo '<br />';
	echo '<p class="negrita_cursiva">'.$id_per_activo.'</p>'; 
	echo '<form>';
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_periodo.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_inicio.' (dd-mm-aaaa)</td>';
	echo '<td>'.$id_fin.' (dd-mm-aaaa)</td>';
	echo '</tr>';
	}
	for($n=0;$n<$num_per;$n++)
	{
	$reg_per = mysql_fetch_array($sel_per);
	$f_ini = cambia_fecha_a_esp($reg_per['inicio']);
	$f_fin = cambia_fecha_a_esp($reg_per['fin']);
	echo '<tr>';
	echo '<td class="centrado"><a href="#" title="'.$id_eliminar.'" onclick="evaBorra(\''.$reg_per['periodo'].'\')"><img src="../imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a>    '.$reg_per['periodo'].'</td>';
	echo '<td class="centrado"><input type="text" name="nombre_'.$n.'" id="nombre_'.$n.'" maxlength="30" value="'.$reg_per['nombre'].'" onblur="editaPer(\'nombre_'.$n.'\',\''.$reg_per['periodo'].'\')" /></td>';
	echo '<td class="centrado"><input type="text" name="inicio_'.$n.'" id="inicio_'.$n.'" maxlength="10" value="'.$f_ini.'" onblur="editaPer(\'inicio_'.$n.'\',\''.$reg_per['periodo'].'\')" /></td>';
	echo '<td class="centrado"><input type="text" name="fin_'.$n.'" id="fin_'.$n.'" maxlength="10" value="'.$f_fin.'" onblur="editaPer(\'fin_'.$n.'\',\''.$reg_per['periodo'].'\')" /></td>';
	echo '</tr>';
	}	
	echo '</table>';
	echo '</form>';

}//fin hay sesión
?>
