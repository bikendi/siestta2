<?php

session_start();

//incluimos funciones,configuración e idioma
include('../funciones.php');
require('../config.php');
require('../idioma/'.$idioma.'');

include("../fckeditor/fckeditor.php") ;

//conectamos con MySQL
conecta();

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
$agr = $_POST['agr'];
$hini = $_POST['hini'];
$accion = $_POST['accion'];
$fecha_ing = $_POST['fecha'];
$dia_ing = date('w',strtotime($fecha_ing));
$dia_esp=encuentra_dia($dia_ing-1);
//compruebo agrupamiento
$sel_agr = mysql_query("select * from agrupamientos where docente = '$usuario_activo' and agrupamiento = '$agr'");
if(mysql_num_rows($sel_agr)>0)
{
//si vamos a grabar
$registro = $_POST['registro'];
switch($registro)
	{
	case 'asi':
	$codigo = $_POST['codigo'];
	$dato = $_POST['dato'];
	//veo si hay algo
	$sel_asi=mysql_query("select * from asistencia where agrupamiento='$agr' and codigo='$codigo' and fecha='$fecha_ing' and hini='$hini'");
	if(mysql_num_rows($sel_asi)>0)
		{
		if($dato == 'A')
			{
			$eli_asi=mysql_query("delete from asistencia where agrupamiento='$agr' and codigo='$codigo' and fecha='$fecha_ing' and hini='$hini'");
			}
		else
			{
			$act_asi=mysql_query("update asistencia set dato='$dato' where agrupamiento='$agr' and codigo='$codigo' and fecha='$fecha_ing' and hini='$hini'");
			}
		}
	else
		{
		$ins_asi=mysql_query("insert into asistencia values('$codigo','$agr','$fecha_ing','$hini','$dato')");
		}
	break;

	case 'not':
	$actividad=$_POST['actividad'];
	$descripcion=$_POST['descripcion'];
	echo '<br /><span>'.$id_inf_not.' '.$actividad.' ('.$descripcion.')</span>';
	$numero=$_POST['numero'];
	echo '<ol class="negrita">';
	for($l=0;$l<$numero;$l++)
		{
		$nota[$l] = $_POST['nota_'.$l.''];
		$codigo[$l] = $_POST['cod_'.$l.''];
		$nom[$l] = $_POST['nom_'.$l.''];
		$ape[$l] = $_POST['ape_'.$l.''];
		if(isset($nota[$l]) && $nota[$l] != '')
			{
			$ins_not=mysql_query("insert into notas values('','$codigo[$l]','$agr','$fecha_ing','$actividad','$nota[$l]','$descripcion','')");
			echo '<li>'.$ape[$l].', '.$nom[$l].' '.$nota[$l].' '.$coment[$l].'</li>';
			}
		}
	echo '</ol>';
	break;

	case 'obs':
	echo '<br /><span>'.$id_inf_obs.'</span>';
	$numero=$_POST['numero'];
	echo '<ol class="negrita">';
	for($l=0;$l<$numero;$l++)
		{
		$codigo[$l] = $_POST['cod_'.$l.''];
		$observ[$l] = $_POST['com_'.$l.''];
		$nom[$l] = $_POST['nom_'.$l.''];
		$ape[$l] = $_POST['ape_'.$l.''];
		if(isset($observ[$l]) && $observ[$l] != '')
			{
			$ins_observ=mysql_query("insert into observaciones values('','$codigo[$l]','$agr','$observ[$l]','$fecha_ing')");
			echo '<li>'.$ape[$l].', '.$nom[$l].' '.$observ[$l].'</li>';
			}
		}
	echo '</ol>';
	break;

	case 'tar':
	$tarea = $_POST['tarea'];
	$destin = $_POST['destin'];
	if($destin == '1')
		{
		//tarea para todo el mundo --> va a la agenda (necesito conocer la franja y el dia del agrupamiento en la fecha de tarea)
		$nombre_dia_ing = date('D',strtotime($fecha_ing));
		$numero_dia = nombre_dia_a_numero($nombre_dia_ing);
		$sel_franja = mysql_query("select franja from horario where docente = '$usuario_activo' and sesion = '$agr' and dia= '$numero_dia'");
		$reg_franja = mysql_fetch_array($sel_franja);
		$franja = $reg_franja['franja'];
		$ins_tar = mysql_query("insert into agenda values ('','$usuario_activo','$franja','$numero_dia','$fecha_ing','$tarea','T')");
		if($ins_tar)
			{
			echo '<br /><span>'.$id_reg_exito.'</span><br /><br />';
			}
		else
			{
			echo '<br /><span>'.$id_error_ins.'</span><br /><br />';
			}
		}
	else
		{
		//tarea individual --> va a la tabla tareas
		$ins_tar = mysql_query("insert into tareas values ('','$destin','$agr','$tarea',now(),'$fecha_ing')");
		if($ins_tar)
			{
			echo '<br /><span>'.$id_reg_exito.'</span><br /><br />';
			}
		else
			{
			echo '<br /><span>'.$id_error_ins.'</span><br /><br />';
			}
		}
	break;

	case 'exa':
	$examen = $_POST['examen'];
	$dia = $_POST['dia'];
	$mes = $_POST['mes'];
	$anyo = $_POST['anyo'];
	$nombre_dia_ing = date('D',strtotime($fecha_ing));
	$numero_dia = nombre_dia_a_numero($nombre_dia_ing);
	$sel_franja = mysql_query("select franja from horario where docente = '$usuario_activo' and sesion = '$agr' and dia= '$numero_dia'");
	$reg_franja = mysql_fetch_array($sel_franja);
	$franja = $reg_franja['franja'];
	$ins_exa = mysql_query("insert into agenda values ('','$usuario_activo','$franja','$numero_dia','$fecha_ing','$examen','E')");
	if($ins_exa)
		{
		echo '<br /><span>'.$id_reg_exito.'</span><br /><br />';
		}
	else
		{
		echo '<br /><span>'.$id_error_ins.'</span><br /><br />';
		}
	break;
	}//fin switch registro

//fin vamos a grabar
echo '<div class="justificado">';
echo '<span><a href="panel_pda.php"><img src="imgs/anterior.png" title="'.$id_volver.'" /></a></span>';
echo '<span>'.$dia_esp.', '.cambia_fecha_a_esp($fecha_ing).'</span>';
echo '<span id="cargando" /><img src="imgs/cargando.gif" title="'.$id_cargando.'" /></span><br /><br />';
echo '<table class="centrada">';
echo '<tr class="encab">';
echo '<td class="centrado">ASI</td><td class="centrado">CAL</td><td class="centrado">OBS</td><td class="centrado">TAR</td><td class="centrado">EXA</td></tr>';
if(($accion)==$id_inf_asi){$checked='checked';}else{$checked='';}
echo '<tr><td class="centrado"><input type="radio" name="rd_accion" id="rd_accion_a" value="'.$id_inf_asi.'" '.$checked.' onclick="abreAgrup1(\''.$agr.'\',\''.$hini.'\',\''.$fecha_ing.'\',\'a\')";/></td>';
if(($accion)==$id_inf_not){$checked='checked';}else{$checked='';}
echo '<td class="centrado"><input type="radio" name="rd_accion" id="rd_accion_c" value="'.$id_inf_not.'" '.$checked.' onclick="abreAgrup1(\''.$agr.'\',\''.$hini.'\',\''.$fecha_ing.'\',\'c\')"; /></td>';
if(($accion)==$id_inf_obs){$checked='checked';}else{$checked='';}
echo '<td class="centrado"><input type="radio" name="rd_accion" id="rd_accion_o" value="'.$id_inf_obs.'" '.$checked.' onclick="abreAgrup1(\''.$agr.'\',\''.$hini.'\',\''.$fecha_ing.'\',\'o\')"; /></td>';
if(($accion)==$id_inf_tar){$checked='checked';}else{$checked='';}
echo '<td class="centrado"><input type="radio" name="rd_accion" id="rd_accion_t" value="'.$id_inf_tar.'" '.$checked.' onclick="abreAgrup1(\''.$agr.'\',\''.$hini.'\',\''.$fecha_ing.'\',\'t\')"; /></td>';
if(($accion)==$id_inf_exa){$checked='checked';}else{$checked='';}
echo '<td class="centrado"><input type="radio" name="rd_accion" id="rd_accion_e" value="'.$id_inf_exa.'" '.$checked.' onclick="abreAgrup1(\''.$agr.'\',\''.$hini.'\',\''.$fecha_ing.'\',\'e\')"; /></td></tr></table>';

switch($accion)
	{
	case $id_inf_asi:
	echo '<p class="centrado"><span>'.$id_agr.': '.$agr.' ('.$id_inf_asi.')</span></p>';
	echo '<table class="centrada">';
	echo '<tr class="encab"><td class="radio"> FAL RET </td><td>'.$id_Alumno.'</td></tr>';
	$sel_alu=mysql_query("select matricula.codigo,matricula.agrupamiento,alumnado.codigo,alumnado.nombre,alumnado.apellidos from matricula,alumnado where matricula.agrupamiento='$agr' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alu=mysql_num_rows($sel_alu);
	for($b=0;$b<($num_alu);$b++)
		{
		$reg_alu=mysql_fetch_array($sel_alu);
		$codigo=$reg_alu['codigo'];
		$nombre=$reg_alu['nombre'];
		$apellidos=$reg_alu['apellidos'];
		$sel_dato = mysql_query("select dato from asistencia where codigo='$codigo' and agrupamiento='$agr' and fecha='$fecha_ing' and hini='$hini'");
		if(mysql_num_rows($sel_dato)>0)
			{
			$reg_dato = mysql_fetch_array($sel_dato);
			if($b%2==0){echo '<tr>';}else{echo '<tr class="impar">';}
			echo '<td class="radio">';
			if($reg_dato['dato']=='F'){$checked="checked";}else{$checked="";}
			echo '<input type="radio" name="rd_'.$b.'" id="rd_'.$b.'_f" value="F" '.$checked.' onclick="regAsiPda(\''.$codigo.'\',\''.$agr.'\',\''.$hini.'\',\''.$b.'\',\''.$id_inf_asi.'\',\''.$fecha_ing.'\',\'f\')"; />';
			if($reg_dato['dato']=='R'){$checked="checked";}else{$checked="";}
			echo '<input type="radio" name="rd_'.$b.'" id="rd_'.$b.'_r" value="R" '.$checked.' onclick="regAsiPda(\''.$codigo.'\',\''.$agr.'\',\''.$hini.'\',\''.$b.'\',\''.$id_inf_asi.'\',\''.$fecha_ing.'\',\'r\')"; />';
			echo '</td>';
			}
		else
			{
			if($b%2==0){echo '<tr>';}else{echo '<tr class="impar">';}
			echo '<td class="radio">';
			echo '<input type="radio" name="rd_'.$b.'" id="rd_'.$b.'_f" value="F" onclick="regAsiPda(\''.$codigo.'\',\''.$agr.'\',\''.$hini.'\',\''.$b.'\',\''.$id_inf_asi.'\',\''.$fecha_ing.'\',\'f\')"; />';
			echo '<input type="radio" name="rd_'.$b.'" id="rd_'.$b.'_r" value="R" onclick="regAsiPda(\''.$codigo.'\',\''.$agr.'\',\''.$hini.'\',\''.$b.'\',\''.$id_inf_asi.'\',\''.$fecha_ing.'\',\'r\')"; />';
			echo '</td>';
			}
			
		echo '<td><a href="#" onclick="abreFichaPda(\''.$codigo.'\',\''.$agr.'\',\''.$hini.'\',\''.$fecha_ing.'\')";>'.$nombre.'</a> '.$apellidos.'</span><span><a href="#" onclick="abreJustifPda(\''.$codigo.'\',\''.$agr.'\',\''.$hini.'\',\'justif\',\''.$fecha_ing.'\')";>(J)</a>';
		if(mysql_num_rows($sel_dato)>0)
			{
			echo '<a href="#" onclick="eliAsiPda(\''.$codigo.'\',\''.$agr.'\',\''.$hini.'\',\''.$id_inf_asi.'\',\''.$fecha_ing.'\')";> <img src="imgs/eliminar.png" alt="'.$id_eliminar.' '.$id_faltajust.'" title="'.$id_eliminar.' '.$id_faltajust.'" /></a>';
			}
		echo '</td></tr>';
		}//fin for
	echo '<tr class="encab"><td class="radio"> FAL RET </td><td>'.$id_Alumno.'</td></tr>';
	echo '</table>';
	break;

	case $id_inf_not:
	echo '<p class="centrado"><span>'.$id_agr.': '.$agr.' ('.$id_inf_not.')</span></p>';
	echo '<form id="notas" name="notas">';
	echo '<div class="centrado"><select id="list_act" name="list_act">';
	echo '<option value="0">'.$id_activ.'</option>';
	$sel_act = mysql_query("select actividad from actividades where agrupamiento = '$agr'");
	$num_act = mysql_num_rows($sel_act);
	for($a=0;$a<$num_act;$a++)
		{
		$reg_act = mysql_fetch_array($sel_act);
		echo '<option>'.$reg_act['actividad'].'</option>';
		}
	echo '</select>';
	echo '<br/>';
	echo '<br/>';
	echo '<input type="text" maxlength="150" name="txt_descrip" id="txt_descrip" size="35" value="'.$id_descripcion.'"/></div>';
	echo '<br/>';
	echo '<table class="centrada">';
	echo '<tr class="encab"><td class="centrado">'.$id_nota.'</td><td>'.$id_Alumno.'</td></tr>';
	$sel_alu=mysql_query("select matricula.codigo,matricula.agrupamiento,alumnado.codigo,alumnado.nombre,alumnado.apellidos from matricula,alumnado where matricula.agrupamiento='$agr' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alu=mysql_num_rows($sel_alu);
	for($b=0;$b<$num_alu;$b++)
		{
		if($b%2==0){echo '<tr>';}else{echo '<tr class="impar">';}
		$reg_alu=mysql_fetch_array($sel_alu);
		$codigo=$reg_alu['codigo'];
		$nombre=$reg_alu['nombre'];
		$apellidos=$reg_alu['apellidos'];
		echo '<td class="centrado"><input type="text" id="nota_'.$b.'" name="nota_'.$b.'" maxlength="5" size="4" /><input type="hidden" id="cod_'.$b.'" name="cod_'.$b.'" value="'.$codigo.'" /><input type="hidden" id="nom_'.$b.'" name="nom_'.$b.'" value="'.$nombre.'" /><input type="hidden" id="ape_'.$b.'" name="ape_'.$b.'" value="'.$apellidos.'" /></td><td>'.$nombre.' '.$apellidos.'</td></tr>';
		}//fin for
	echo '<tr class="encab"><td class="centrado">'.$id_nota.'</td><td>'.$id_Alumno.'</td></tr>';
	echo '</table>';
	echo '<p class="centrado"><a href="#" onclick="grabaNotaPda(\''.$agr.'\',\''.$hini.'\',\''.$num_alu.'\',\''.$fecha_ing.'\')" title="'.$id_regnotas.'"><img src="../imgs/guardar.png" alt="'.$id_regnotas.'" /></a></p>';
	echo '</form>';
	break;

	case $id_inf_obs:
	echo '<p class="centrado"><span>'.$id_agr.': '.$agr.' ('.$id_inf_obs.')</span></p>';
	echo '<form id="obs" name="obs">';
	echo '<table class="centrada">';
	echo '<tr class="encab"><td>'.$id_Alumno.'<br />'.$id_obs.'</td></tr>';
	$sel_alu=mysql_query("select matricula.codigo,matricula.agrupamiento,alumnado.codigo,alumnado.nombre,alumnado.apellidos from matricula,alumnado where matricula.agrupamiento='$agr' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alu=mysql_num_rows($sel_alu);
	for($b=0;$b<$num_alu;$b++)
		{
		if($b%2==0){echo '<tr>';}else{echo '<tr class="impar">';}
		$reg_alu=mysql_fetch_array($sel_alu);
		$codigo=$reg_alu['codigo'];
		$nombre=$reg_alu['nombre'];
		$apellidos=$reg_alu['apellidos'];
		echo '<td>'.$nombre.' '.$apellidos.'<br /><select class="obs" name="com_'.$b.'">
		<option></option>
		<option>No trae los deberes</option>
		<option>No trae el material</option>
		<option>No trabaja en clase</option>
		<option>No para de hablar</option>
		<option>Está trabajando otra asignatura</option>
		<option>Parte disciplinario</option>
		<option>Participa</option>
		<option>Ayuda a sus compañeros/as</option>
		<option>Sale voluntario/a</option>
		<option>Muestra interés</option>
		<option>Pregunta las dudas</option>
		<option>Realiza los ejercicios bien</option>
		</select>
		<input type="hidden" id="cod_'.$b.'" name="cod_'.$b.'" value="'.$codigo.'" /><input type="hidden" id="nom_'.$b.'" name="nom_'.$b.'" value="'.$nombre.'" /><input type="hidden" id="ape_'.$b.'" name="ape_'.$b.'" value="'.$apellidos.'" />
		</td></tr>';
		}//fin for
	echo '<tr class="encab"><td>'.$id_Alumno.'<br />'.$id_obs.'</td></tr>';
	echo '</table>';
	echo '<p class="centrado"><a href="#" onclick="grabaObsPda(\''.$agr.'\',\''.$hini.'\',\''.$num_alu.'\',\''.$fecha_ing.'\')" title="'.$id_regnotas.'"><img src="../imgs/guardar.png" alt="'.$id_reg.'" /></a></p>';	
	echo '</form>';
	break;

	case $id_inf_tar:
	echo '<p class="centrado"><span>'.$id_agr.': '.$agr.' ('.$id_inf_tar.')</span></p>';
	echo '<p class="centrado"><input class="exatarea" type="text" id="area_tarea" name="area_tarea" /></p>';
	echo '<p class="centrado"><select name="list_tarea" id="list_tarea" onchange="grabaTareaPda(\''.$agr.'\',\''.$hini.'\',\''.$id_inf_tar.'\',\''.$fecha_ing.'\')";>';
	echo '<option value="0">Para:</option>';
	echo '<option value="1">'.$id_marcar_todos.'</option>';
	$sel_alu=mysql_query("select matricula.codigo,matricula.agrupamiento,alumnado.codigo,alumnado.nombre,alumnado.apellidos from matricula,alumnado where matricula.agrupamiento='$agr' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alu=mysql_num_rows($sel_alu);
	for($b=0;$b<$num_alu;$b++)
		{
		$reg_alu=mysql_fetch_array($sel_alu);
		$codigo=$reg_alu['codigo'];
		$nombre=$reg_alu['nombre'];
		$apellidos=$reg_alu['apellidos'];
		echo '<option value="'.$codigo.'">'.$nombre.' '.$apellidos.'</option>';
		}//fin for
	echo '</select></p>';
	break;

	case $id_inf_exa:
	echo '<p class="centrado"><span>'.$id_agr.': '.$agr.' ('.$id_inf_exa.')</span></p>';
	echo '<p class="centrado"><input class="exatarea" type="text" id="area_examen" name="area_examen" /></p>';
	echo '<p class="centrado"><a href="#" onclick="grabaExaPda(\''.$agr.'\',\''.$hini.'\',\''.$id_inf_exa.'\',\''.$fecha_ing.'\')" title="'.$id_regnotas.'"><img src="../imgs/guardar.png" alt="'.$id_regnotas.'" /></a></p>';
	break;

	case 'ficha':
	$codigo = $_POST['codigo'];
	$sel_datos = mysql_query("select * from alumnado where codigo = '$codigo'");
	$reg_datos = mysql_fetch_array($sel_datos);
	if($reg_datos['repite']=='0'){$repite = $id_no;}else{$repite = $id_si;}
	echo '<br /><br />';
	echo '<table class="centrada">';
	echo '<tr>';
	echo '<td class="top"><img class="alu" src="../admin/fotos_al/'.$codigo.'.jpg" /><br />'.$reg_datos['nombre'].'<br />'.$reg_datos['apellidos'].'<br/>'.cambia_fecha_a_esp($reg_datos['f_nac']).'<br/>'.$id_gru.': '.$reg_datos['grupo'].'<br />'.$id_rep.': '.$repite.'</td>';
	echo '<td class="top">';	
	echo '<img src="imgs/tel.png" /> '.$reg_datos['telef1'].'';
	echo '<br />';
	echo '<img src="imgs/tel.png" /> '.$reg_datos['telef2'].'';
	echo '<br />';
	echo '<img src="imgs/tut.png" /> '.$reg_datos['tutor1'].'';
	echo '<br />';
	echo '<img src="imgs/tut.png" /> '.$reg_datos['tutor2'].'';
	echo '<br />';
	$sel_faltas = mysql_query("select dato from asistencia where codigo = '$codigo' and agrupamiento = '$agr' and dato = 'F'");
	$num_faltas = mysql_num_rows($sel_faltas);
	$sel_justif = mysql_query("select dato from asistencia where codigo = '$codigo' and agrupamiento = '$agr' and dato = 'J'");
	$num_justif = mysql_num_rows($sel_justif);
	$sel_retra = mysql_query("select dato from asistencia where codigo = '$codigo' and agrupamiento = '$agr' and dato = 'R'");
	$num_retra = mysql_num_rows($sel_justif);
	echo '<img src="imgs/faltas.png" /> F: '.$num_faltas.' | J: '.$num_justif.' | R: '.$num_retra.'';
	echo '<br />';
	//períodos de evaluación	
	$sel_per = mysql_query("select * from periodos");
	$num_per = mysql_num_rows($sel_per);
	for($p=0;$p<$num_per;$p++)
		{
		$reg_per = mysql_fetch_array($sel_per);
		$fecha_ini = $reg_per['inicio'];
		$fecha_fin = $reg_per['fin'];
		$nombre_eval = $reg_per['nombre'];
	//vamos con las notas
		//selecciono mis actividades de este agrupamiento
		//busco notas de cada actividad, calculo su media y las pondero. Introduzco en matriz.
		//sumo elementos de la matriz
		//vacío la matriz
	$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agr'");
	$num_activ = mysql_num_rows($sel_activ);
	for($a=0;$a<$num_activ;$a++)
		{
		$reg_activ = mysql_fetch_array($sel_activ);
		$activ = $reg_activ['actividad'];
		$pond = $reg_activ['ponderacion'];
		$sel_notas = mysql_query("select avg(nota) from notas where codigo='$codigo' and agrupamiento='$agr' and actividad='$activ' and fecha between '$fecha_ini' and '$fecha_fin'");
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
			echo '<p><a href="#" onclick="abreNotasPda(\''.$codigo.'\',\''.$agr.'\',\''.$fecha_ini.'\',\''.$fecha_fin.'\',\''.$hini.'\',\''.$fecha_ing.'\',\''.$reg_datos['nombre'].'\',\''.$reg_datos['apellidos'].'\')";>'.$nombre_eval.'</a>: '.$nota_media_red.'';
			$sel_rec=mysql_query("select * from recuperaciones where codigo='$codigo' and agrupamiento='$sesion' and periodo='".$reg_per['periodo']."'");
			if(mysql_num_rows($sel_rec)>0)
				{
				$reg_rec=mysql_fetch_array($sel_rec);
				$nota_rec=$reg_rec['nota'];
				echo '(Rec: '.$nota_rec.')</p>';
				}
			}
	unset($matriz_notas_pond);
	echo '<br />';
	}//fin for períodos de evaluación

	echo '</td>';
	echo '</tr>';

	echo '</table>';
	break;

	case 'lista_notas':
	$codigo = $_POST['codigo'];
	$fecha_ini = $_POST['fecha_ini'];
	$fecha_fin = $_POST['fecha_fin'];
	$nombre = $_POST['nombre'];
	$apellidos = $_POST['apellidos'];
	echo '<p class="centrado"><a href="#" onclick="abreFichaPda(\''.$codigo.'\',\''.$agr.'\',\''.$hini.'\',\''.$fecha_ing.'\')";><img src="imgs/anterior.png" title="'.$id_volver.'" alt = "'.$id_volver.'" /></a>'.$nombre.' '.$apellidos.' ('.cambia_fecha_a_esp($fecha_ini).' a '.cambia_fecha_a_esp($fecha_fin).')</p>';
	echo '<table class="centrada">';
	echo '<tr class="encab">';
	echo '<td class="centrado">'.$id_fecha.'</td><td>'.$id_descripcion.'</td><td>'.$id_nota.'</td></tr>';
	$sel_notas = mysql_query("select * from notas where codigo = '$codigo' and agrupamiento = '$agr' and fecha between '$fecha_ini' and '$fecha_fin' order by fecha desc");
	$num_notas = mysql_num_rows($sel_notas);
	for($ln=0;$ln<$num_notas;$ln++)
		{
		if($ln%2==0){echo '<tr>';}else{echo '<tr class="impar">';} 
		$reg_notas = mysql_fetch_array($sel_notas);
		$id = $reg_notas['id'];
		echo '<td class="centrado">'.cambia_fecha_a_esp($reg_notas['fecha']).'</td>';
		echo '<td>'.$reg_notas['descripcion'].'</td>';
		echo '<td><a href="#" title="'.$id_editar.'" id="nota_'.$ln.'" onclick="editaNota(\'nota_'.$ln.'\',\'nota\',\''.$id.'\')">'.$reg_notas['nota'].'</a></td>';
		echo '</tr>';
		}//fin for lista de notas
	echo '</table>';
	break;

	case 'justif':
	if($_POST['mes'])
		{
		$mes = $_POST['mes'];
		}
	else
		{
		$mes = date('m');
		}
	$codigo = $_POST['codigo'];
	$sel_alum = mysql_query("select nombre,apellidos from alumnado where codigo='$codigo'");
	$reg_alum = mysql_fetch_array($sel_alum);
	$nombre  = $reg_alum['nombre'];
	$apellidos = $reg_alum['apellidos'];

	if($_POST['j'] == 'si')
		{
		//hago la misma consulta
		$sel_faltas = mysql_query("select asistencia.agrupamiento,asistencia.fecha,asistencia.hini,asistencia.dato from asistencia,agrupamientos where agrupamientos.docente = '$usuario_activo' and agrupamientos.agrupamiento = asistencia.agrupamiento and asistencia.codigo = '$codigo' and asistencia.dato != 'r' and asistencia.dato != 'a' and month(asistencia.fecha) = '$mes' order by asistencia.fecha,asistencia.hini");
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

	$sel_faltas = mysql_query("select asistencia.agrupamiento,asistencia.fecha,asistencia.hini,asistencia.dato from asistencia,agrupamientos where agrupamientos.docente = '$usuario_activo' and agrupamientos.agrupamiento = asistencia.agrupamiento and asistencia.codigo = '$codigo' and asistencia.dato != 'r' and asistencia.dato != 'a' and month(asistencia.fecha) = '$mes' order by asistencia.fecha,asistencia.hini");
	$num_faltas = mysql_num_rows($sel_faltas);

	echo '<br /><br />';
	echo '<div class="centrado"><a href="#" onclick="justiFicaPda(\''.$agr.'\',\''.$hini.'\',\''.$codigo.'\',\''.$mes.'\',\''.$fecha_ing.'\')" title="'.$id_reg.'"><img src="../imgs/guardar.png" alt="'.$id_reg.'" /></a></span><span>'.$nombre.' '.$apellidos.'</div>';
	echo '<br />';
	echo '<form id="lista" name="lista">';
	echo '<table class="centrada">';
	echo '<tr class="encab">';
	echo '<td class="centrado"><a href="#" onclick="abreJustifAnteriorPda(\''.$codigo.'\',\''.$agr.'\',\''.$hini.'\',\'justif\',\''.$mes.'\',\''.$fecha_ing.'\')"><img src="imgs/anterior.png" title="'.$id_anterior.'" /></a>'.nombre_mes2($mes).'<a href="#" onclick="abreJustifSiguientePda(\''.$codigo.'\',\''.$agr.'\',\''.$hini.'\',\'justif\',\''.$mes.'\',\''.$fecha_ing.'\')"><img src="imgs/siguiente.png" title = "'.$id_siguiente.'" /></a></td>';
	echo '<td class="centrado"><a href="#" onclick="marcaTodos(\''.$num_faltas.'\')"><img src="imgs/todos.png" title="'.$id_marcar_todos.'" /></a> <a href="#" onclick="desmarcaTodos(\''.$num_faltas.'\')"><img src="imgs/ninguno.png" title="'.$id_ninguno.'" /></a></td>';
	echo '</tr>';
	
	for($f=0;$f<$num_faltas;$f++)
		{
		$reg_faltas = mysql_fetch_array($sel_faltas);
		$agrupamiento = $reg_faltas['agrupamiento'];
		$fecha = $reg_faltas['fecha'];
		$fecha_esp = cambia_fecha_a_esp($fecha);
		$hini = $reg_faltas['hini'];
		$dato = $reg_faltas['dato'];
		if($f%2==0){echo '<tr>';}else{echo '<tr class="impar">';}
		echo '<td class="centrado">'.$fecha_esp.' ('.$hini.')</td>';
		echo '<td class="centrado">'.$dato.' ';
		if($dato == 'J')
			{
			echo '<input name="just_'.$f.'" id="just_'.$f.'" type="checkbox" checked="checked" />';
			}
		else
			{
			echo '<input name="just_'.$f.'" id="just_'.$f.'" type="checkbox" />';
			}
		echo ' ('.$agrupamiento.')</td>';
		echo '</tr>';
		}
	echo '</table>';
	echo '</form>';

	break;
	}
echo '</div>';
}
}


?>

</body>
</html>
