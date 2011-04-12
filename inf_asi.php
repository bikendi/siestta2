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

echo '<br/><span class="negrita">'.$id_inf_asi.'</span>';

echo '<p class="centrado"><select id="agr" onchange="cargaAlumnos(\'inf_asi.php\')">';
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
	echo '<select id="alu" onchange="listaFaltas(\''.$agr_post.'\')">';
	if($alu_post)
		{
		$sel_alu=mysql_query("select nombre,apellidos from alumnado where codigo='$alu_post'");
		$reg_alu=mysql_fetch_array($sel_alu);
		$nombre=$reg_alu['nombre'];
		$apellidos=$reg_alu['apellidos'];
		if($alu_post == '*')
			{
			echo '<option selected="selected">'.$id_todos_al.'</option>';
			}
		else
			{
			echo '<option selected="selected">'.$nombre.' '.$apellidos.'</option>';
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

echo '</p>';

//si vengo ya de seleccionar alumno

if($alu_post && $alu_post <> '*')
	{
	$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agr_post' and codigo = '$alu_post' and dato <> 'a' order by fecha asc");
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
			$nombre_dia = date('D', mktime(0, 0, 0, $mes_faltas, $dia, $anyo_faltas));
			$numero_dia = nombre_dia_a_numero($nombre_dia);
			if($numero_dia == '6' || $numero_dia == '7')
				{
				echo '<td class="naranja"></td>';
				}
			else
				{
				$fecha_consulta = ''.$anyo_faltas.'-'.$mes_faltas.'-'.$dia.'';
				$sel_falta = mysql_query("select dato,hini from asistencia where agrupamiento='$agr_post' and codigo = '$alu_post' and fecha = '$fecha_consulta' and dato <> 'a'");
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
	echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf1(\'asistencia.php\',\''.$alu_post.'\',\''.$agr_post.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p><br />';
	}
	else
	{
	echo '<br /><span class="negrita">'.$id_no_asi.'</span>';
	}
	}//fin alu_post

if($alu_post && $alu_post == '*')
	{
	$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agr_post' and dato <> 'a' order by fecha desc");
	$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
	if($num_mes_faltas>0)
	{
	for($fa=0;$fa<$num_mes_faltas;$fa++)
		{
		$reg_mes_faltas=mysql_fetch_array($sel_mes_faltas);
		$mes_faltas=$reg_mes_faltas['month(fecha)'];
		$name_mes=date('M',mktime(0,0,0,$mes_faltas+1,0,0));
		$nombre_mes=nombre_mes($name_mes);
		$anyo_faltas=$reg_mes_faltas['year(fecha)'];
		echo '<br />'.$nombre_mes.' '.$anyo_faltas.'';	
		echo '<br /><table class="tablacentrada">';
		echo '<tr>';
		echo '<td class="justificado">'.$id_Alumno.'</td>';
		for($d=0;$d<31;$d++)
			{
			$dia = $d + 1;
			$nombre_dia = date('D', mktime(0, 0, 0, $mes_faltas, $dia, $anyo_faltas));
			$numero_dia = nombre_dia_a_numero($nombre_dia);
			$nombre_dia=encuentra_dia_abr($numero_dia-1);
			echo '<td class="centrado">'.$nombre_dia.'<br />'.$dia.'</td>';
			}
		echo '</tr>';
		//seleccionamos los alumnos
		$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agr_post' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
		$num_alum = mysql_num_rows($sel_alum);
		for($a=0;$a<$num_alum;$a++)
			{
			$reg_alum = mysql_fetch_array($sel_alum);
			$codigo = $reg_alum['codigo'];
			if($a%2==0)echo '<tr class="par">';else echo '<tr>';
			echo '<td class="justificado">'.$reg_alum['apellidos'].', '.$reg_alum['nombre'].'</td>';
			for($d=0;$d<31;$d++)
				{
				$dia = $d + 1;
				$nombre_dia = date('D', mktime(0, 0, 0, $mes_faltas, $dia, $anyo_faltas));
				$numero_dia = nombre_dia_a_numero($nombre_dia);
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
			}
		echo '</table>';
		}//fin de for
	echo '<br /><p><a title="'.$id_pdf.'" href="#" onclick="pdf1(\'asistencia.php\',\'*\',\''.$agr_post.'\')"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p><br />';
	}
	else
	{
	echo '<br /><span class="negrita">'.$id_no_asi.'</span>';
	}
	}


}//fin if hay sesión

?>
