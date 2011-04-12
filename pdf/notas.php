<?php
session_start();
//incluimos funciones,configuración e idioma
include('../funciones.php');
require('../config.php');
require('../idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
$docente = $_SESSION['usuario_sesion'];
$codigo = $_GET['p1'];
$agrupamiento = $_GET['p2'];
$actividad = $_GET['p3'];
$periodo = $_GET['p4'];
//conecto con MySQL
conecta();

//compruebo agrupamiento
$sel_agr = mysql_query("select agrupamiento from agrupamientos where agrupamiento = '$agrupamiento' and docente = '$docente'");
if(mysql_num_rows($sel_agr)>0)
{
require('html2fpdf.php');
$pdf=new HTML2FPDF('P','mm','A4');
$pdf->pgwidth = 180;
$pdf->SetMargins(20,5,20);
$pdf->AddPage();

$pdf->Image('logo_200.jpg',20,5); 
$pdf->Ln(5);		
$pdf->Cell(50,10,''.decode($nombre_centro).'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(50,10,''.decode($dir_centro).'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(80,10,'Tel.:'.$telefono_centro.' Fax: '.$fax_centro.'',0,0,'L');
$pdf->Ln(10);

$sel_det = mysql_query("select materia from agrupamientos where agrupamiento = '$agrupamiento'");
$reg_det = mysql_fetch_array($sel_det);
$materia = $reg_det['materia'];

$pdf->Cell(80,10,''.decode($id_inf_not).' ('.decode($materia).')',0,0,'L');
$pdf->Ln(5);

if($codigo <> '*')
	{
	$sel_alu=mysql_query("select nombre,apellidos from alumnado where codigo='$codigo'");
	$reg_alu=mysql_fetch_array($sel_alu);
	$nombre=$reg_alu['nombre'];
	$apellidos=$reg_alu['apellidos'];
	$pdf->Cell(300,10,''.decode($id_Alumno).': '.decode($nombre).' '.decode($apellidos).'',0,0,'L');
	}			
else
	{
	$pdf->Cell(300,10,''.decode($id_agr).': '.decode($agrupamiento).' ('.decode($materia).')',0,0,'L');
	}
$pdf->Ln(10);

////////////////////////////////////////////////////////////
//caso 1: 1 alumno + 1 actividad + 1 período////////////////
////////////////////////////////////////////////////////////
if($codigo != '*' && $actividad != '*' && $periodo != $id_final && $periodo != $id_finalF)
	{
	
	$pdf->Cell(80,10,''.decode($id_activ).': '.decode($actividad).'',0,0,'L');
	$pdf->Ln(5);
	
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($periodo).'',0,0,'L');
	$pdf->Ln();
	
	$sel_notas = mysql_query("select notas.codigo,notas.agrupamiento,notas.fecha,notas.actividad,notas.nota,notas.descripcion,notas.comentario,periodos.periodo,periodos.inicio,periodos.fin from notas,periodos where notas.codigo='$codigo' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$periodo' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
	$num_notas = mysql_num_rows($sel_notas);

	$html_1='<table border=\'1\'>
		<tr>
		<th>'.decode($id_fecha).'</th><th>'.decode($id_descripcion).'</th>
		<th>'.decode($id_nota).'</th><th>'.decode($id_coment).'</th>
		</tr>';
	$pdf->WriteHTML($html_1);

	for($n=0;$n<$num_notas;$n++)
		{
		$reg_notas = mysql_fetch_array($sel_notas);
		$fecha_nota = $reg_notas['fecha'];
		$fecha_nota_esp = cambia_fecha_a_esp($fecha_nota);
		
		$html_2='
		<tr>
		<td align=\'center\' width=\'10%\'>'.$fecha_nota_esp.'</td>
		<td align=\'justify\' width=\'30%\'>'.decode($reg_notas['descripcion']).'</td>
		<td align=\'center\' width=\'10%\'>'.$reg_notas['nota'].'</td>
		<td align=\'justify\' width=\'50%\'>'.decode($reg_notas['comentario']).'</td>
		</tr>
		';			
		$matriz[]=$reg_notas['nota'];
		$pdf->WriteHTML($html_2);
		}
	$suma=array_sum($matriz);
	$media=$suma/$num_notas; 
	$html_3='</table>';
	
	$pdf->WriteHTML($html_3);

	$pdf->Cell(80,4,''.decode($id_nota_media).' '.decode($id_de).' '.decode($actividad).': '.round($media,2).'',0,0,'L');
}//fin caso 1/////////////

////////////////////////////////////////////////////////////
//caso 2: 1 alumno + 1 actividad + FINAL////////////////////
////////////////////////////////////////////////////////////
if($codigo != '*' && $actividad != '*' && $periodo == $id_final)
	{
	$pdf->Cell(80,10,''.decode($id_activ).': '.decode($actividad).'',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($id_final).'',0,0,'L');
	$pdf->Ln();
	$sel_per=mysql_query("select * from periodos");
	$num_per=mysql_num_rows($sel_per);
	for($p=0;$p<$num_per;$p++)
		{
		$reg_per=mysql_fetch_array($sel_per);
		$periodo=$reg_per['periodo'];
		$sel_notas = mysql_query("select notas.codigo,notas.agrupamiento,notas.fecha,notas.actividad,notas.nota,notas.descripcion,notas.comentario,periodos.periodo,periodos.inicio,periodos.fin from notas,periodos where notas.codigo='$codigo' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$periodo' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
		$num_notas = mysql_num_rows($sel_notas);
		if($num_notas>0)
			{
			$html_1='<table border=\'1\'>
			<tr>
			<th>'.decode($id_fecha).'</th><th>'.decode($id_descripcion).'</th>
			<th>'.decode($id_nota).'</th><th>'.decode($id_coment).'</th>
			</tr>';
			$pdf->WriteHTML($html_1);

			for($n=0;$n<$num_notas;$n++)
				{
				$reg_notas = mysql_fetch_array($sel_notas);
				$fecha_nota = $reg_notas['fecha'];
				$fecha_nota_esp = cambia_fecha_a_esp($fecha_nota);
		
				$html_2='
				<tr>
				<td align=\'center\' width=\'10%\'>'.$fecha_nota_esp.'</td>
				<td align=\'justify\' width=\'30%\'>'.decode($reg_notas['descripcion']).'</td>
				<td align=\'center\' width=\'10%\'>'.$reg_notas['nota'].'</td>
				<td align=\'justify\' width=\'50%\'>'.decode($reg_notas['comentario']).'</td>
				</tr>
				';			
				$matriz[]=$reg_notas['nota'];
				$pdf->WriteHTML($html_2);
				}
			$suma=array_sum($matriz);
			$media=$suma/$num_notas; 
			$html_3='</table>';
			$matriz_media[]=$media;
			$pdf->WriteHTML($html_3);	
			$pdf->Cell(80,4,''.decode($id_evaluacion).' '.decode($periodo).': '.decode($id_nota_media).' '.decode($id_de).' '.decode($actividad).': '.round($media,2).'',0,0,'L');
			unset($matriz);
			$pdf->Ln(10);
			}//fin hay notas
		else
			{
			$pdf->Ln();
			$pdf->Cell(80,4,''.decode($id_evaluacion).' '.decode($periodo).': '.decode($id_no_calif).' '.decode($id_de).' '.decode($actividad).'',0,0,'L');
			}
	}
}//fin caso  2////////////

////////////////////////////////////////////////////////////
//caso 3: 1 alumno + 1 actividad + FINAL_F//////////////////
////////////////////////////////////////////////////////////
if($codigo != '*' && $actividad != '*' && $periodo == $id_finalF)
	{
	$pdf->Cell(80,10,''.decode($id_activ).': '.decode($actividad).'',0,0,'L');
	$pdf->Ln(5);	
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($id_todo_curso).'',0,0,'L');
	$pdf->Ln();
	
	$sel_notas = mysql_query("select * from notas where codigo = '$codigo' and agrupamiento = '$agrupamiento' and actividad = '$actividad' order by fecha desc");
	$num_notas = mysql_num_rows($sel_notas);
	$html_1='<table border=\'1\'>
		<tr>
		<th>'.decode($id_fecha).'</th><th>'.decode($id_descripcion).'</th>
		<th>'.decode($id_nota).'</th><th>'.decode($id_coment).'</th>
		</tr>';
	$pdf->WriteHTML($html_1);

	for($n=0;$n<$num_notas;$n++)
		{
		$reg_notas = mysql_fetch_array($sel_notas);
		$fecha_nota = $reg_notas['fecha'];
		$fecha_nota_esp = cambia_fecha_a_esp($fecha_nota);
		
		$html_2='
		<tr>
		<td align=\'center\' width=\'10%\'>'.$fecha_nota_esp.'</td>
		<td align=\'justify\' width=\'30%\'>'.decode($reg_notas['descripcion']).'</td>
		<td align=\'center\' width=\'10%\'>'.$reg_notas['nota'].'</td>
		<td align=\'justify\' width=\'50%\'>'.decode($reg_notas['comentario']).'</td>
		</tr>
		';			
		$matriz[]=$reg_notas['nota'];
		$pdf->WriteHTML($html_2);
		}
	$suma=array_sum($matriz);
	$media=$suma/$num_notas; 
	$html_3='</table>';
	
	$pdf->WriteHTML($html_3);

	$pdf->Cell(80,4,''.decode($id_nota_media).' '.decode($id_de).' '.decode($actividad).': '.round($media,2).'',0,0,'L');
}//fin caso 3////////////

////////////////////////////////////////////////////////////
//caso 4: 1 alumno + Todas las actividades + 1 período//////
////////////////////////////////////////////////////////////
if($codigo != '*' && $actividad == '*' && $periodo != $id_final && $periodo != $id_finalF)
	{
	$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agrupamiento' and periodo='$periodo' or agrupamiento='$agrupamiento' and periodo='*'");
	$num_activ = mysql_num_rows($sel_activ);
	
	$pdf->Cell(80,10,''.decode($id_todas_act).'',0,0,'L');
	$pdf->Ln(5);
	
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($periodo).'',0,0,'L');
	$pdf->Ln();
	
	$html_1='<table border=\'1\'>
		<tr>
		<th>'.decode($id_activ).'</th><th>'.decode($id_nota_media).'</th>
		<th>'.decode($id_ponderacion).'</th><th>'.decode($id_nota_media_pond).'</th>
		</tr>';
	$pdf->WriteHTML($html_1);

	for($a=0;$a<$num_activ;$a++)
		{
		$reg_activ = mysql_fetch_array($sel_activ);
		$actividad = $reg_activ['actividad'];
		$pond = $reg_activ['ponderacion'];
		$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$codigo' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$periodo' and notas.fecha between periodos.inicio and periodos.fin");
		$num_nota = mysql_num_rows($sel_nota);
		if($num_nota>0)
			{
			$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$codigo' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$periodo' and notas.fecha between periodos.inicio and periodos.fin");
			$num_notas = mysql_num_rows($sel_notas);		
			$reg_notas = mysql_fetch_array($sel_notas);
			$nota_media = $reg_notas['avg(notas.nota)'];
			
			$html_2='
			<tr>
			<td align=\'justify\' width=\'35%\'>'.decode($actividad).'</td>
			<td align=\'center\' width=\'25%\'>'.round($nota_media,2).'</td>
			<td align=\'center\' width=\'15%\'>'.$pond.'</td>
			<td align=\'center\' width=\'25%\'>'.round($nota_media*$pond/100,2).'</td>
			</tr>
			';	

			$matriz_nota_media_pond[]=$nota_media*$pond/100;
			}
		else
			{
			$html_2='
			<tr>
			<td align=\'justify\' width=\'35%\'>'.decode($actividad).'</td>
			<td align=\'center\' width=\'25%\'>'.decode($id_no_calif).'</td>
			<td align=\'center\' width=\'15%\'>'.$pond.'</td>
			<td align=\'center\' width=\'25%\'>'.decode($id_no_calif).'</td>
			</tr>
			';
			}
		$pdf->WriteHTML($html_2);
		}//fin for actividades
	$count =  count($matriz_nota_media_pond);
	
	if($count > 0)
		{
		$suma_nota_media = array_sum($matriz_nota_media_pond);
			
				$html_3='
				<tr>
				<th align=\'justify\' width=\'35%\'>'.decode($id_total).'</th>
				<th align=\'center\' width=\'25%\'></th>
				<th align=\'center\' width=\'15%\'></th>
				<th align=\'center\' width=\'25%\'>'.round($suma_nota_media,2).'</th>
				</tr>
				';
				
		$pdf->WriteHTML($html_3);
		}
	$html_4='</table>';
	$pdf->WriteHTML($html_4);
	
	}//fin caso 4////////////

////////////////////////////////////////////////////////////
//caso 5: 1 alumno + Todas las actividades + FINAL//////////
////////////////////////////////////////////////////////////
if($codigo != '*' && $actividad == '*' && $periodo == $id_final)
	{
	//selecciono períodos y monto el for
	$sel_per = mysql_query("select * from periodos");
	$num_per = mysql_num_rows($sel_per);
	for ($p=0;$p<$num_per;$p++)
		{
		$reg_per = mysql_fetch_array($sel_per);
		$per_post = $reg_per['periodo'];
		$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agrupamiento' and periodo='$per_post' or agrupamiento='$agrupamiento' and periodo='*'");
		$num_activ = mysql_num_rows($sel_activ);
		if($num_activ>0)
			{			
			$pdf->Cell(80,10,''.decode($id_evaluacion).' '.decode($per_post).'',0,0,'L');
			$pdf->Ln();
			$html_1='<table border=\'1\'>
			<tr>
			<th>'.decode($id_activ).'</th><th>'.decode($id_nota_media).'</th>
			<th>'.decode($id_ponderacion).'</th><th>'.decode($id_nota_media_pond).'</th>
			</tr>';
			$pdf->WriteHTML($html_1);
			for($a=0;$a<$num_activ;$a++)
				{
				$reg_activ = mysql_fetch_array($sel_activ);
				$actividad = $reg_activ['actividad'];
				$pond = $reg_activ['ponderacion'];
				$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$codigo' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
				$num_nota = mysql_num_rows($sel_nota);
				if($num_nota>0)
					{
					$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$codigo' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
					$num_notas = mysql_num_rows($sel_notas);		
					$reg_notas = mysql_fetch_array($sel_notas);
					$nota_media = $reg_notas['avg(notas.nota)'];

					$html_2='
					<tr>
					<td align=\'justify\' width=\'35%\'>'.decode($actividad).'</td>
					<td align=\'center\' width=\'25%\'>'.round($nota_media,2).'</td>
					<td align=\'center\' width=\'15%\'>'.$pond.'</td>
					<td align=\'center\' width=\'25%\'>'.round($nota_media*$pond/100,2).'</td>
					</tr>
					';					

					$matriz_nota_media_pond[]=$nota_media*$pond/100;
					}
				else
					{
					$html_2='
					<tr>
					<td align=\'justify\' width=\'35%\'>'.decode($actividad).'</td>
					<td align=\'center\' width=\'25%\'>'.decode($id_no_calif).'</td>
					<td align=\'center\' width=\'15%\'>'.$pond.'</td>
					<td align=\'center\' width=\'25%\'>'.decode($id_no_calif).'</td>
					</tr>
					';
					}
				$pdf->WriteHTML($html_2);
				}//fin for actividades
					
			$count =  count($matriz_nota_media_pond);
			if($count > 0)
				{
				$suma_nota_media = array_sum($matriz_nota_media_pond);
				$html_3='
				<tr>
				<th align=\'justify\' width=\'35%\'>'.decode($id_total).'</th>
				<th align=\'center\' width=\'25%\'></th>
				<th align=\'center\' width=\'15%\'></th>
				<th align=\'center\' width=\'25%\'>'.round($suma_nota_media,2).'</th>
				</tr>
				';
				$matriz_final_ev[] = $suma_nota_media;
				unset($matriz_nota_media_pond);
				$pdf->WriteHTML($html_3);
				}
			$html_4='</table>';
			$pdf->WriteHTML($html_4);
			}//fin if actividades
		else
			{
			$pdf->Cell(80,10,''.decode($id_no_activ).'',0,0,'L');
			$pdf->Ln();
			}
		}//fin del for períodos
	if(count($matriz_final_ev)>0)
		{
	$notafinal = array_sum($matriz_final_ev)/$num_per;
	$notafinalred = round($notafinal,2);
	$pdf->Cell(80,10,''.decode($id_total).' '.decode($id_todo_curso).': '.decode($notafinalred).'',0,0,'L');
		}
	}//fin caso 5///////////

////////////////////////////////////////////////////////////
//caso 6: Todos los alumnos + 1 actividad + 1 período///////
////////////////////////////////////////////////////////////
if($codigo == '*' && $actividad != '*' && $periodo != $id_final && $periodo != $id_finalF)
	{
	$pdf->Cell(80,10,''.decode($id_activ).': '.decode($actividad).'',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($periodo).'',0,0,'L');
	$pdf->Ln();
	
	$html_1='<table border=\'1\'>
	<tr>
	<th>'.decode($id_Alumno).'</th><th>'.decode($id_nota).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);
	
	$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agrupamiento' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alum = mysql_num_rows($sel_alum);
	for($a=0;$a<$num_alum;$a++)
		{
		$reg_alum = mysql_fetch_array($sel_alum);
		$alu_post=$reg_alum['codigo'];
		$nom_post=$reg_alum['nombre'];
		$ape_post=$reg_alum['apellidos'];
		$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$periodo' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
		$num_notas = mysql_num_rows($sel_nota);
		if($num_notas>0)
			{
			$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$periodo' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
			$reg_notas = mysql_fetch_array($sel_notas);

			$html_2='
			<tr>
			<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
			<td align=\'center\' width=\'25%\'>'.round($reg_notas['avg(notas.nota)'],2).'</td>
			</tr>
			';
			}
		else
			{
			$html_2='
			<tr>
			<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
			<td align=\'center\' width=\'25%\'>'.decode($id_no_calif).'</td>
			</tr>
			';
			}
		$pdf->WriteHTML($html_2);
		}//fin for alumnos
	$html_3='</table>';
	$pdf->WriteHTML($html_3);
	}//fin caso 6///////////

////////////////////////////////////////////////////////////
//caso 7: Todos los alumnos + 1 actividad + FINAL///////////
////////////////////////////////////////////////////////////
if($codigo == '*' && $actividad != '*' && $periodo == $id_final)
	{
	$pdf->Cell(80,10,''.decode($id_activ).': '.decode($actividad).'',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($id_final).'',0,0,'L');
	$pdf->Ln();
	$html_1='<table border=\'1\'>
	<tr>
	<th>'.decode($id_Alumno).'</th><th>'.decode($id_nota).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);
	$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agrupamiento' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alum = mysql_num_rows($sel_alum);
	for($a=0;$a<$num_alum;$a++)
		{
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
			$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
			$num_notas = mysql_num_rows($sel_nota);
			if($num_notas>0)
				{
				$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin order by notas.fecha desc");
				$reg_notas = mysql_fetch_array($sel_notas);
				$nota_eva[] = $reg_notas['avg(notas.nota)'];
				}
			}//fin for periodos
		if(count($nota_eva) != 0)
			{
			$nota_final = round((array_sum($nota_eva)/count($nota_eva)),2);
			$html_2='
			<tr>
			<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
			<td align=\'center\' width=\'25%\'>'.$nota_final.'</td>
			</tr>
			';
			array_splice($nota_eva,0,count($nota_eva));
			}
		else
			{
			$html_2='
			<tr>
			<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
			<td align=\'center\' width=\'25%\'>'.decode($id_no_calif).'</td>
			</tr>
			';
			}
		$pdf->WriteHTML($html_2);
		}//fin for alumnos
	$html_3='</table>';
	$pdf->WriteHTML($html_3);
	}//fin caso 7//////////

////////////////////////////////////////////////////////////
//caso 8: Todos los alumnos + 1 actividad + FINAL_F/////////
////////////////////////////////////////////////////////////
if($codigo == '*' && $actividad != '*' && $periodo == $id_finalF)
	{
	$pdf->Cell(80,10,''.decode($id_activ).': '.decode($actividad).'',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($id_todo_curso).'',0,0,'L');
	$pdf->Ln();

	$html_1='<table border=\'1\'>
	<tr>
	<th>'.decode($id_Alumno).'</th><th>'.decode($id_nota).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);

	$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agrupamiento' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alum = mysql_num_rows($sel_alum);
	for($a=0;$a<$num_alum;$a++)
		{
		$reg_alum = mysql_fetch_array($sel_alum);
		$alu_post=$reg_alum['codigo'];
		$nom_post=$reg_alum['nombre'];
		$ape_post=$reg_alum['apellidos'];
		$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad'");
		$num_notas = mysql_num_rows($sel_nota);
		if($num_notas>0)
			{
			$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad'");
			$reg_notas = mysql_fetch_array($sel_notas);
			$nota_eva[] = $reg_notas['avg(notas.nota)'];
			}
		if(count($nota_eva) != 0)
			{
			$nota_final = round((array_sum($nota_eva)/count($nota_eva)),2);
			$html_2='
			<tr>
			<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
			<td align=\'center\' width=\'25%\'>'.$nota_final.'</td>
			</tr>
			';
			array_splice($nota_eva,0,count($nota_eva));
			}
		else
			{
			$html_2='
			<tr>
			<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
			<td align=\'center\' width=\'25%\'>'.decode($id_no_calif).'</td>
			</tr>
			';
			}
		$pdf->WriteHTML($html_2);
		}//fin for alumnos
	$html_3='</table>';
	$pdf->WriteHTML($html_3);
	}//fin caso 8//////////

///////////////////////////////////////////////////////////////////
//caso 9: Todos los alumnos + Todas las actividades + 1 período////
///////////////////////////////////////////////////////////////////
if($codigo == '*' && $actividad == '*' && $periodo != $id_final && $periodo != $id_finalF)
	{
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($periodo).'',0,0,'L');
	$pdf->Ln();
	
	$html_1='<table border=\'1\'>
	<tr>
	<th>'.decode($id_Alumno).'</th><th>'.decode($id_nota).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);


	$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agrupamiento' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alum = mysql_num_rows($sel_alum);
	for($al=0;$al<$num_alum;$al++)
		{
		$reg_alum = mysql_fetch_array($sel_alum);
		$alu_post=$reg_alum['codigo'];
		$nom_post=$reg_alum['nombre'];
		$ape_post=$reg_alum['apellidos'];
		$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agrupamiento' and periodo='$periodo' or agrupamiento='$agrupamiento' and periodo='*'");
		$num_activ = mysql_num_rows($sel_activ);
		if($num_activ>0)
			{
			for($a=0;$a<$num_activ;$a++)
			{
			$reg_activ = mysql_fetch_array($sel_activ);
			$actividad = $reg_activ['actividad'];
			$pond = $reg_activ['ponderacion'];
			$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$periodo' and notas.fecha between periodos.inicio and periodos.fin");
			$num_nota = mysql_num_rows($sel_nota);
			if($num_nota>0)
				{
				$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$periodo' and notas.fecha between periodos.inicio and periodos.fin");
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
			$sel_recu = mysql_query("select nota from recuperaciones where periodo = '$periodo' and codigo ='$alu_post' and agrupamiento = '$agrupamiento'");
			$num_recu = mysql_num_rows($sel_recu);
			if($num_recu>0)
				{
				$reg_recu = mysql_fetch_array($sel_recu);
				$html_2='
				<tr>
				<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
				<td align=\'center\' width=\'25%\'>'.round($suma_nota_media,2).' (R '.$reg_recu['nota'].')</td>
				</tr>
				';
				}
			else
				{
				$sel_notas_rev=mysql_query("select * from notas_rev where codigo='$alu_post' and agrupamiento='$agrupamiento' and periodo='".$periodo."'");
				if(mysql_num_rows($sel_notas_rev)>0)
					{
					$reg_notas_rev=mysql_fetch_array($sel_notas_rev);
					$html_2='
					<tr>
					<th align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</th>
					<th align=\'center\' width=\'25%\'>Final  Revisada: '.$nota_rev=$reg_notas_rev['nota'].'</th>
					</tr>
					';
					} else {
					$html_2='
					<tr>
					<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
					<td align=\'center\' width=\'25%\'>'.round($suma_nota_media,2).'</td>
					</tr>
					';
					}
				}
			unset($matriz_nota_media_pond);
			}
		else
			{
			$html_2='
			<tr>
			<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
			<td align=\'center\' width=\'25%\'>'.decode($id_no_calif).'</td>
			</tr>
			';
			}	
		}
	$pdf->WriteHTML($html_2);
	}//fin for alumnos
	$html_3='</table>';
	$pdf->WriteHTML($html_3);
	}//fin caso 9/////////

///////////////////////////////////////////////////////////////////
//caso 10: Todos los alumnos + Todas las actividades + FINAL///////
///////////////////////////////////////////////////////////////////
if($codigo == '*' && $actividad == '*' && $periodo == $id_final)
	{
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($id_final).'',0,0,'L');
	$pdf->Ln();
	
	$html_1='<table border=\'1\'>
	<tr>
	<th>'.decode($id_Alumno).'</th><th>'.decode($id_nota).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);

	$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agrupamiento' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alum = mysql_num_rows($sel_alum);
	for($al=0;$al<$num_alum;$al++)
		{
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
$sel_notas_rev=mysql_query("select * from notas_rev where codigo='$alu_post' and agrupamiento='$agrupamiento' and periodo='".$per_post."'");
//si hay nota revisada, no hacemos la media ponderada de las actividades
if(mysql_num_rows($sel_notas_rev)>0)
{
$reg_notas_rev=mysql_fetch_array($sel_notas_rev);
$matriz_nota_media_pond[]=$reg_notas_rev['nota'];
} 
else
{
			$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agrupamiento' and periodo='$per_post' or agrupamiento='$agrupamiento' and periodo='*'");
			$num_activ = mysql_num_rows($sel_activ);
			if($num_activ>0)
				{
				for($a=0;$a<$num_activ;$a++)
					{
					$reg_activ = mysql_fetch_array($sel_activ);
					$actividad = $reg_activ['actividad'];
					$pond = $reg_activ['ponderacion'];
					$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
					$num_nota = mysql_num_rows($sel_nota);
					if($num_nota>0)
						{
						$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad' and periodos.periodo='$per_post' and notas.fecha between periodos.inicio and periodos.fin");
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
					$sel_recu = mysql_query("select nota from recuperaciones where periodo = '$per_post' and codigo ='$alu_post' and agrupamiento = '$agrupamiento'");
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
				$html_2='
				<tr>
				<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
				<td align=\'center\' width=\'25%\'>'.round($nota_final,2).' (R: '.round($nota_finalR,2).')</td>
				</tr>
				';
				}
			else
				{			
				$html_2='
				<tr>
				<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
				<td align=\'center\' width=\'25%\'>'.round($nota_final,2).'</td>
				</tr>
				';
				}
			unset($matriz_eval);
			unset($matriz_eval_recu);
			unset($recu);
			}
		else
			{
			$html_2='
			<tr>
			<td align=\'justify\' width=\'75%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
			<td align=\'center\' width=\'25%\'>'.decode($id_no_calif).'</td>
			</tr>
			';
			}
		$pdf->WriteHTML($html_2);
		}//fin for alumnos
	$html_3='</table>';
	$pdf->WriteHTML($html_3);
	}//fin caso 10////////

///////////////////////////////////////////////////////////////////
//caso 11: Todos los alumnos + Todas las actividades + FINAL (*)///
///////////////////////////////////////////////////////////////////
if($codigo == '*' && $actividad == '*' && $periodo != $id_final && $periodo == $id_finalF)
	{
	$pdf->Cell(80,10,''.decode($id_periodo).' '.decode($id_de).' '.decode($id_evaluacion).': '.decode($id_todo_curso).'',0,0,'L');
	$pdf->Ln();
	
	$html_1='<table border=\'1\'>
	<tr>
	<th>'.decode($id_Alumno).'</th><th>'.decode($id_nota).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);


	$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agrupamiento' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alum = mysql_num_rows($sel_alum);
	for($al=0;$al<$num_alum;$al++)
		{
		$reg_alum = mysql_fetch_array($sel_alum);
		$alu_post=$reg_alum['codigo'];
		$nom_post=$reg_alum['nombre'];
		$ape_post=$reg_alum['apellidos'];
		$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agrupamiento' and periodo='$periodo' or agrupamiento='$agrupamiento' and periodo='*'");
		$num_activ = mysql_num_rows($sel_activ);
		if($num_activ>0)
			{
			for($a=0;$a<$num_activ;$a++)
			{
			$reg_activ = mysql_fetch_array($sel_activ);
			$actividad = $reg_activ['actividad'];
			$pond = $reg_activ['ponderacion'];
			$sel_nota = mysql_query("select notas.nota from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad'");
			$num_nota = mysql_num_rows($sel_nota);
			if($num_nota>0)
				{
				$sel_notas = mysql_query("select avg(notas.nota) from notas,periodos where notas.codigo='$alu_post' and notas.agrupamiento='$agrupamiento' and notas.actividad='$actividad'");
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
			$sel_recu = mysql_query("select nota,periodo from recuperaciones where codigo ='$alu_post' and agrupamiento = '$agrupamiento'");
			$num_recu = mysql_num_rows($sel_recu);
			if($num_recu>0)
				{
				$html_2a='
				<tr>
				<td align=\'justify\' width=\'60%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
				<td align=\'center\' width=\'40%\'>'.round($suma_nota_media,2).'';
				$pdf->WriteHTML($html_2a);
				for($r=0;$r<$num_recu;$r++)
					{
					$reg_recu = mysql_fetch_array($sel_recu);
					$html_2b=' (R'.$reg_recu['periodo'].': '.$reg_recu['nota'].')';
					$pdf->WriteHTML($html_2b);
					}
				$html_2c='
				</td>
				</tr>
				';
				$pdf->WriteHTML($html_2c);
				}
			else
				{
				$html_2='
				<tr>
				<td align=\'justify\' width=\'60%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
				<td align=\'center\' width=\'40%\'>'.round($suma_nota_media,2).'</td>
				</tr>
				';
				}
			$pdf->WriteHTML($html_2);
			unset($matriz_nota_media_pond);
			}
		else
			{
			$html_2='
			<tr>
			<td align=\'justify\' width=\'60%\'>'.decode($ape_post).', '.decode($nom_post).'</td>
			<td align=\'center\' width=\'40%\'>'.decode($id_no_calif).'</td>
			</tr>
			';
			$pdf->WriteHTML($html_2);
			}	
		}
	}//fin for alumnos
	$html_3='</table>';
	$pdf->WriteHTML($html_3);
	}//fin caso 11/////////

$pdf->Output();

}//fin compruebo agrupamiento
}//fin hay sesión

?>