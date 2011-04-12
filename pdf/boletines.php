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
$agrupamiento = $_GET['p1'];
//conecto con MySQL
conecta();
$hoy=date('Y-m-d');
///////////voy a seleccionar las fechas del período actual de evaluación 
////////////////////////////////////////////////////////////////////////
$sel_fechas_per = mysql_query("select * from periodos where '$hoy' between inicio and fin");
if(mysql_num_rows($sel_fechas_per)>0)
{ 
$reg_fechas_per = mysql_fetch_array($sel_fechas_per);
$fecha_inicio = $reg_fechas_per['inicio'];
$fecha_fin = $reg_fechas_per['fin'];
$per_post = $reg_fechas_per['periodo'];
//compruebo agrupamiento
$sel_agr = mysql_query("select agrupamiento from agrupamientos where agrupamiento = '$agrupamiento' and docente = '$docente'");
if(mysql_num_rows($sel_agr)>0)
{
require('html2fpdf.php');
$pdf=new HTML2FPDF('P','mm','A4');
$pdf->pgwidth = 180;
$pdf->SetMargins(20,5,20);
$pdf->AddPage();

$sel_alum = mysql_query("select alumnado.codigo from alumnado,matricula where matricula.agrupamiento = '$agrupamiento' and matricula.codigo = alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
$n = mysql_num_rows($sel_alum);
for($a=0;$a<$n;$a++)
	{
	$reg_sel_alum = mysql_fetch_array($sel_alum);
	$codigo = $reg_sel_alum['codigo'];
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

	$pdf->Cell(80,10,''.decode($id_inf_Bol).' ('.decode($materia).'). '.$id_fecha.': '.cambia_fecha_a_esp($hoy).'',0,0,'L');
	$pdf->Ln(5);
	$sel_alu = mysql_query("select apellidos,nombre from alumnado where codigo='$codigo'");
	$reg_alu = mysql_fetch_array($sel_alu);
	$pdf->Cell(80,10,''.decode($id_Alumno).': '.decode($reg_alu['nombre']).' '.decode($reg_alu['apellidos']).'',0,0,'L');
	$pdf->Ln();

///////////////////////////////////////////////////////////
///////////////////ASISTENCIA//////////////////////////////
///////////////////////////////////////////////////////////
$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agrupamiento' and codigo = '$codigo' and dato <> 'a' order by fecha asc");
$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
if($num_mes_faltas)
{
$pdf->Cell(80,10,''.decode($id_inf_asi).'',0,0,'L');
$pdf->Ln();
$pdf->SetFont('','',6);
$header_faltas=array(''.$id_mes.'','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
	
$w_faltas=array(15,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5);
for($x_faltas=0;$x_faltas<32;$x_faltas++)
	{
	$pdf->Cell($w_faltas[$x_faltas],6,$header_faltas[$x_faltas],1,0,'C');
	}    			
	$pdf->Ln();
	
	for($fa=0;$fa<$num_mes_faltas;$fa++)
		{
		$reg_mes_faltas=mysql_fetch_array($sel_mes_faltas);
		$mes_faltas=$reg_mes_faltas['month(fecha)'];
		$anyo_faltas=$reg_mes_faltas['year(fecha)'];
		$name_mes = date('M',mktime(0,0,0,$mes_faltas+1,0,0));
		$nombre_mes = nombre_mes($name_mes);
		
		$pdf->Cell(15,5,decode($nombre_mes),1,0,'C');
					
		for($d=0;$d<31;$d++)
			{
			$dia = $d + 1;
			$nombre_dia = date('D', mktime(0, 0, 0, $mes_faltas, $dia, $anyo_faltas));
			$numero_dia = nombre_dia_a_numero($nombre_dia);
			if($numero_dia == '6' || $numero_dia == '7')
				{
				$pdf->Cell(5,5,$pdf->SetFillColor(0,0,0),1,0,'C',1);
				}
			else
				{
				$fecha_consulta = ''.$anyo_faltas.'-'.$mes_faltas.'-'.$dia.'';
				$sel_falta = mysql_query("select hini,dato from asistencia where agrupamiento='$agrupamiento' and codigo = '$codigo' and fecha = '$fecha_consulta' and dato <> 'a'");
				if(mysql_num_rows($sel_falta)>0)
					{
					if(mysql_num_rows($sel_falta)==1)
						{
						$reg_falta=mysql_fetch_array($sel_falta);
						$hini=$reg_falta['hini'];
						$sel_f=mysql_query("select franja from franjas where docente='$docente' and hini='$hini'");
						$reg_f=mysql_fetch_array($sel_f);
						$pdf->Cell(5,5,''.$reg_falta['dato'].'('.$reg_f['franja'].')',1,0,'C');
						}
					if(mysql_num_rows($sel_falta)==2)
						{					
						for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
							{
							$reg_falta=mysql_fetch_array($sel_falta);
							$hini=$reg_falta['hini'];
							$sel_f=mysql_query("select franja from franjas where docente='$docente' and hini='$hini'");
							$reg_f=mysql_fetch_array($sel_f);
							$pdf->SetFont('','',4);
							$pdf->Cell(2.5,5,''.$reg_falta['dato'].''.$reg_f['franja'].'',1,0,'C');
							$pdf->SetFont('','',6);
							}
						}	
					if(mysql_num_rows($sel_falta)==3)
						{					
						for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
							{
							$reg_falta=mysql_fetch_array($sel_falta);
							$hini=$reg_falta['hini'];
							$sel_f=mysql_query("select franja from franjas where docente='$docente' and hini='$hini'");
							$reg_f=mysql_fetch_array($sel_f);
							$pdf->SetFont('Arial','',3);
							$pdf->Cell(1.7,5,''.$reg_falta['dato'].''.$reg_f['franja'].'',1,0,'C');					$pdf->SetFont('Arial','',8);
							}
						}								
					}
				else
					{
					$pdf->Cell(5,5,'',1,0,'C');
					}
				}
			}
			$pdf->Ln();
		}
/////////////////////////////////////////////////////////////////////////////////
///////////////////LISTADO DE FRANJAS HORARIAS///////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////			
$sel_fr = mysql_query("select * from franjas where docente='$docente'");
$num_fr = mysql_num_rows($sel_fr);
$pdf->SetFont('Arial','',6);
$pdf->Ln(4);
for($fra=0;$fra<$num_fr;$fra++)
	{
	$reg_fr = mysql_fetch_array($sel_fr);
	$pdf->Cell(18,4,'('.decode($reg_fr['franja']).'): '.$reg_fr['hini'].'-'.$reg_fr['hfin'].'',0,0,'L');
	}
	$pdf->Ln();

$pdf->SetFont('Arial','',11);
	}//fin hay faltas
else
	{
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(80,10,''.decode($id_no_asi).'',0,0,'L');
	$pdf->Ln();
	}//fin asistencia


/////////////////////////////////////////////////////////////////////////////////
///////////////////NOTAS/////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
$pdf->Cell(80,10,''.decode($id_inf_not).'',0,0,'L');
$pdf->Ln(5);

	
	$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agrupamiento' and periodo='$per_post' or agrupamiento='$agrupamiento' and periodo='*'");
	$num_activ = mysql_num_rows($sel_activ);
	if($num_activ>0)
		{
		//veo si hay nota de recuperación
		$sel_rec = mysql_query("select nota from recuperaciones where agrupamiento = '$agrupamiento' and codigo = '$codigo' and periodo = '$per_post'");
		if(mysql_num_rows($sel_rec)>0)
			{
			$reg_rec = mysql_fetch_array($sel_rec);
			$pdf->Cell(80,10,''.decode($id_evaluacion).' '.decode($per_post).' ('.decode($id_recupera).': '.$reg_rec['nota'].')',0,0,'L');
			}
		else
			{
			$pdf->Cell(80,10,''.decode($id_evaluacion).' '.decode($per_post).'',0,0,'L');
			}
		$pdf->Ln();

		$html_1='
		<table border=\'1\'>
		<tr>
		<th>'.decode($id_activ).'</th><th>'.decode($id_nota_media).'</th>
		<th>'.decode($id_ponderacion).'</th><th>'.decode($id_nota_media_pond).'</th>
		</tr>';
		$pdf->WriteHTML($html_1);
		
		for($ac=0;$ac<$num_activ;$ac++)
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
				<td align=\'justify\' width=\'40%\'>'.decode($actividad).'</td>
				<td align=\'center\' width=\'20%\'><div>'.round($nota_media,2).'</div></td>
				<td align=\'center\' width=\'20%\'><div>'.$pond.'</div></td>
				<td align=\'center\' width=\'20%\'><div>'.round($nota_media*$pond/100,2).'</div></td>
				</tr>';
				$matriz_nota_media_pond[]=$nota_media*$pond/100;
				}
			else
				{
				$html_2='
				<tr>
				<td align=\'justify\' width=\'40%\'>'.decode($actividad).'</td>
				<td align=\'center\' width=\'20%\'><div>'.decode($id_no_calif).'</div></td>
				<td align=\'center\' width=\'20%\'><div>'.$pond.'</div></td>
				<td align=\'center\' width=\'20%\'><div>'.decode($id_no_calif).'</div></td>
				</tr>';
				}
			$pdf->WriteHTML($html_2);
			}//fin for actividades

		$count =  count($matriz_nota_media_pond);
		if($count > 0)
			{
			$suma_nota_media = array_sum($matriz_nota_media_pond);
			$html_3='
			<tr>
			<td align=\'justify\' width=\'40%\'>'.decode($id_total).'</td>
			<td align=\'center\' width=\'20%\'></td>
			<td align=\'center\' width=\'20%\'></td>
			<td align=\'center\' width=\'20%\'><div>'.round($suma_nota_media,2).'</div></td>
			</tr>';
			
			$matriz_final_ev[]=$suma_nota_media;
			unset($matriz_nota_media_pond);
			$pdf->WriteHTML($html_3);
			}
		$html_4='</table>';
		$pdf->WriteHTML($html_4);
		//veo si hay nota de evaluación revisada
		$sel_rev = mysql_query("select nota from notas_rev where agrupamiento = '$agrupamiento' and codigo = '$codigo' and periodo = '$per_post'");
		if(mysql_num_rows($sel_rev)>0)
			{
			$reg_rev = mysql_fetch_array($sel_rev);
			$pdf->SetFont('Arial','B',14);
			$pdf->Cell(80,10,''.decode('NOTA FINAL DE EVALUACIÓN '.decode($per_post).'(ver observaciones)').': '.$reg_rev['nota'].'',0,0,'L');
			$pdf->Ln();
			$pdf->SetFont('Arial','',11);
			}
		}//fin if actividades
	else
		{
		$pdf->Cell(80,10,''.decode($id_no_activ).'',0,0,'L');
		$pdf->Ln();
		}


/////////////////////////////////////////////////////////////////////////////////
///////////////////OBSERVACIONES/////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
$sel_obs = mysql_query("select * from observaciones where codigo='$codigo' and agrupamiento = '$agrupamiento' and fecha between '$fecha_inicio' and '$fecha_fin' order by fecha asc");
$num_obs = mysql_num_rows($sel_obs);
if($num_obs>0)
	{
	$pdf->Cell(80,10,''.decode($id_inf_obs).'',0,0,'L');
	$pdf->Ln();
	$html_1='
	<table border=\'1\'>
	<tr>
	<th>'.decode($id_fecha).'</th><th>'.decode($id_obs).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);
	for($o=0;$o<$num_obs;$o++)
		{
		$reg_obs = mysql_fetch_array($sel_obs);
		$obs_pdf = $reg_obs['observacion'];
		//la observación puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
		//las etiquetas <p> por <br />
		$busqueda = '<p>';
		$reemplazo = '<br />';
		$obs_br = ereg_replace($busqueda,$reemplazo,$obs_pdf);
		$busqueda = '</p>';
		$reemplazo = '';
		$obs_br2 = ereg_replace($busqueda,$reemplazo,$obs_br);
		$html_2='
		<tr>
		<td align=\'center\' width=\'20%\'>'.cambia_fecha_a_esp($reg_obs['fecha']).'</td>
		<td align=\'justify\' width=\'80%\'><div>'.decode($obs_br2).'</div></td>
		</tr>';
		$pdf->WriteHTML($html_2);
		}
	$html_3='</table>';
	$pdf->WriteHTML($html_3);				
	}
else
	{
	$pdf->Cell(80,10,''.decode($id_no_obs).'',0,0,'L');
	$pdf->Ln();
	}
/////////////////////////////////////////////////////////////////////////////////
///////////////////TAREAS Y EXÁMENES PENDIENTES//////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
$sel_tar = mysql_query("select distinct agenda.fecha,agenda.cita from agenda,horario,agrupamientos where agrupamientos.agrupamiento = '$agrupamiento' and agrupamientos.docente = agenda.docente and agenda.franja=horario.franja and agenda.dia=horario.dia and horario.sesion='$agrupamiento' and agenda.tipo='T' and agenda.fecha>=now() order by agenda.fecha desc");
$num_tar = mysql_num_rows($sel_tar);
if($num_tar>0)
	{
	$pdf->Cell(80,10,''.decode($id_inf_tar).'',0,0,'L');
	$pdf->Ln(10);
	$html_1='
	<table border=\'1\'>
	<tr>
	<th>'.decode($id_fecha_ent).'</th><th>'.decode($id_tarea).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);
	for($t=0;$t<$num_tar;$t++)
		{
		$reg_tar = mysql_fetch_array($sel_tar);
		$tar_pdf = $reg_tar['cita'];
		//la tarea puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
		//las etiquetas <p> por <br />
		$busqueda = '<p>';
		$reemplazo = '<br />';
		$tar_br = ereg_replace($busqueda,$reemplazo,$tar_pdf);
		$busqueda = '</p>';
		$reemplazo = '';
		$tar_br2 = ereg_replace($busqueda,$reemplazo,$tar_br);
		$html_2='
		<tr>
		<td align=\'center\' width=\'20%\'>'.cambia_fecha_a_esp($reg_tar['fecha']).'</td>
		<td align=\'justify\' width=\'80%\'><div>'.decode($tar_br2).'</div></td>
		</tr>';
		$pdf->WriteHTML($html_2);
		}
	$sel_tar_ind = mysql_query("select * from tareas where agrupamiento='$agrupamiento' and codigo='$codigo' and fecha_ent >= now() order by fecha_ent asc");
	$num_tar_ind = mysql_num_rows($sel_tar_ind);
	for($ti=0;$ti<$num_tar_ind;$ti++)
		{
		$reg_tar_ind = mysql_fetch_array($sel_tar_ind);
		$tar_ind_pdf = $reg_tar_ind['tarea'];
		//la tarea puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
		//las etiquetas <p> por <br />
		$busqueda = '<p>';
		$reemplazo = '<br />';
		$tar_ind_br = ereg_replace($busqueda,$reemplazo,$tar_ind_pdf);
		$busqueda = '</p>';
		$reemplazo = '';
		$tar_ind_br2 = ereg_replace($busqueda,$reemplazo,$tar_ind_br);
		$html_3='
		<tr>
		<td align=\'center\' width=\'20%\'>'.cambia_fecha_a_esp($reg_tar_ind['fecha_ent']).'</td>
		<td align=\'justify\' width=\'80%\'><div>'.decode($tar_ind_br2).'</div></td>
		</tr>';
		$pdf->WriteHTML($html_3);
		}
	$html_4='</table>';
	$pdf->WriteHTML($html_4);		
	}
else/////////////////////////////////////////////
	{
	$sel_tar_ind = mysql_query("select * from tareas where agrupamiento='$agrupamiento' and codigo='$codigo' and fecha_ent >= now() order by fecha_ent asc");
	$num_tar_ind = mysql_num_rows($sel_tar_ind);
	if($num_tar_ind>0)
		{
		$pdf->Cell(80,10,''.decode($id_inf_tar).'',0,0,'L');
		$pdf->Ln(10);
		$html_1='
		<table border=\'1\'>
		<tr>
		<th>'.decode($id_fecha_ent).'</th><th>'.decode($id_tarea).'</th>
		</tr>';
		$pdf->WriteHTML($html_1);
		for($ti=0;$ti<$num_tar_ind;$ti++)
			{
			$reg_tar_ind = mysql_fetch_array($sel_tar_ind);
			$tar_ind_pdf = $reg_tar_ind['tarea'];
			//la tarea puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
			//las etiquetas <p> por <br />
			$busqueda = '<p>';
			$reemplazo = '<br />';
			$tar_ind_br = ereg_replace($busqueda,$reemplazo,$tar_ind_pdf);
			$busqueda = '</p>';
			$reemplazo = '';
			$tar_ind_br2 = ereg_replace($busqueda,$reemplazo,$tar_ind_br);
			$html_2='
			<tr>
			<td align=\'center\' width=\'20%\'>'.cambia_fecha_a_esp($reg_tar_ind['fecha_ent']).'</td>
			<td align=\'justify\' width=\'80%\'><div>'.decode($tar_ind_br2).'</div></td>
			</tr>';
			$pdf->WriteHTML($html_2);
			}
		$html_3='</table>';
		$pdf->WriteHTML($html_3);
		}
	else
		{	
		$pdf->Cell(80,10,''.decode($id_no_tareas).'',0,0,'L');
		$pdf->Ln();
		}
	}

/////////////los exámenes
$sel_exa = mysql_query("select distinct agenda.fecha,agenda.cita from agenda,horario,agrupamientos where agrupamientos.agrupamiento = '$agrupamiento' and agrupamientos.docente = agenda.docente and agenda.franja=horario.franja and agenda.dia=horario.dia and horario.sesion='$agrupamiento' and agenda.tipo='E' and agenda.fecha>=now() order by agenda.fecha asc");
$num_exa = mysql_num_rows($sel_exa);
if($num_exa>0)
	{
	$pdf->Cell(80,10,''.decode($id_examen_pdtes).'',0,0,'L');
	$pdf->Ln();
	$html_1='
	<table border=\'1\'>
	<tr>
	<th>'.decode($id_fecha).'</th><th>'.decode($id_examen).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);
	for($e=0;$e<$num_exa;$e++)
		{
		$reg_exa = mysql_fetch_array($sel_exa);
		$exa_pdf = $reg_exa['cita'];
		//el examen puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
		//las etiquetas <p> por <br />
		$busqueda = '<p>';
		$reemplazo = '<br />';
		$exa_br = ereg_replace($busqueda,$reemplazo,$exa_pdf);
		$busqueda = '</p>';
		$reemplazo = '';
		$exa_br2 = ereg_replace($busqueda,$reemplazo,$exa_br);
		$html_2='
		<tr>
		<td align=\'center\' width=\'20%\'>'.cambia_fecha_a_esp($reg_exa['fecha']).'</td>
		<td align=\'justify\' width=\'80%\'><div>'.decode($exa_br2).'</div></td>
		</tr>';
		$pdf->WriteHTML($html_2);
		}
	$html_3='</table>';
	$pdf->WriteHTML($html_3);
	}
	
/////////////////////////////////FIRMA/////////////////////////////////////////////////////
$pdf->Ln();
$pdf->Cell(110,6,''.decode($id_firma_tut).'',0,0,'L');
//////////////////////////////////////////////////////
	if(($n-$a) > 1)
		{ 
		$pdf->AddPage();
		}
}//fin for alumnos

$pdf->Output();

}//fin compruebo agrupamiento
}//fin estamos en período de evaluación
}//fin hay sesión

?>