<?php
session_start();

/*///////////////////////////////////////////////////////////////////////////////////////////////////////////
///Este archivo es parte de SIESTTA 2.0 y forma parte del él. Por tanto, es aplicable////////////////////////
///su licencia GNU GPL///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Aplicación: SIESTTA 2.0 (Solución Informática Especializada en el Seguimiento TuTorial del Alumnado)//////
///Web del proyecto: http://siestta.org//////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Autor: Ramón Castro Pérez/////////////////////////////////////////////////////////////////////////////////
///Web: http://ramoncastro.es////////////////////////////////////////////////////////////////////////////////
///Mail: ramoncastroperez@gmail.com//////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Esta aplicación es software libre: puede redistribuirlo y/o modificarlo///////////////////////////////////
///bajo los términos de la GNU General Public License publicada por la///////////////////////////////////////
///Free Software Foundation, en su versión 3 o posterior/////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Este programa es distribuido con la intención de que sea útil, pero sin///////////////////////////////////
///ninguna garantía. Vea los términos de la licencia GNU GPL para más detalles///////////////////////////////
///Puede encontrar la licencia en http://www.gnu.org/copyleft/gpl.es.html////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///SIESTTA 2.0 usa://////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///PHP -> http://php.net							/////////////////////////////
///MySQL -> http://www.mysql.com/						/////////////////////////////
///FPDF -> http://www.fpdf.org/						        /////////////////////////////      
///html2pdf -> http://html2fpdf.sourceforge.net/				/////////////////////////////
///AJAX -> http://es.wikipedia.org/wiki/Ajax 					/////////////////////////////
///Prototype -> http://www.prototypejs.org/					/////////////////////////////
///Scriptaculous -> http://script.aculo.us/					/////////////////////////////
///LitBox -> http://www.ryanjlowe.com/?p=9					/////////////////////////////
///FCK Editor -> http://www.fckeditor.net/					/////////////////////////////
///Dropline Neu -> http://www.silvestre.com.ar/					/////////////////////////////
///Tango Desktop Project -> http://tango.freedesktop.org/Tango_Desktop_Project	/////////////////////////////
///CSS Easy -> http://www.csseasy.com/						/////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////*/ 

//incluimos funciones,configuración e idioma
include('../funciones.php');
require('../config.php');
require('../idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']) || isset($_SESSION['familia_sesion']))
{
$docente = $_SESSION['usuario_sesion'];
$codigo = $_GET['p1'];
$agrupamiento = $_GET['p2'];
$informe = $_GET['p3'];
$nombre = $_GET['p4'];
$apellidos = $_GET['p5'];
//conecto con MySQL
conecta();

//compruebo agrupamiento o matrícula
$sel_agr = mysql_query("select agrupamiento from agrupamientos where agrupamiento = '$agrupamiento' and docente = '$docente'");
$sel_matric = mysql_query("select codigo from matricula where agrupamiento = '$agrupamiento' and codigo = '".$_SESSION['familia_sesion']."'");
if(mysql_num_rows($sel_agr)>0 || mysql_num_rows($sel_matric)>0)
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
$pdf->Cell(80,10,''.decode($id_Alumno).': '.decode($nombre).' '.decode($apellidos).'',0,0,'L');
$pdf->Ln(5);

switch($informe)
{
//////////////////////////////////////////////////////////////////
//TAREAS//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
case 'tarea':
$sel_det = mysql_query("select materia from agrupamientos where agrupamiento = '$agrupamiento'");
$reg_det = mysql_fetch_array($sel_det);
$materia = $reg_det['materia'];
$pdf->Cell(80,10,''.decode($id_inf_tar).': '.decode($materia).'',0,0,'L');
$pdf->Ln();
$html_1='
<table border=\'1\'>
<tr>
<th>'.decode($id_tarea).'</th><th>'.decode($id_fecha_reg).'</th><th>'.decode($id_fecha_ent).'</th>
</tr>';
$pdf->WriteHTML($html_1);
$sel_tareas = mysql_query("select * from tareas where codigo='$codigo' and agrupamiento='$agrupamiento' order by fecha_reg desc");
$num_tareas = mysql_num_rows($sel_tareas);
for($t=0;$t<$num_tareas;$t++)
	{
	$reg_tareas = mysql_fetch_array($sel_tareas);
	$id = $reg_tareas['id'];
	$tarea = $reg_tareas['tarea'];
	$fecha_reg = $reg_tareas['fecha_reg'];
	$fecha_ent = $reg_tareas['fecha_ent'];
	$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
	$fecha_ent_esp = cambia_fecha_a_esp($fecha_ent);
	//la tarea puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
	//las etiquetas <p> por <br />
	$busqueda = '<p>';
	$reemplazo = '<br />';
	$tar_br = ereg_replace($busqueda,$reemplazo,$tarea);
	$busqueda = '</p>';
	$reemplazo = '';
	$tar_br2 = ereg_replace($busqueda,$reemplazo,$tar_br);
	$html_2='
	<tr>
	<td align=\'justify\' width=\'60%\'>'.decode($tar_br2).'</td>
	<td align=\'center\' width=\'20%\'>'.$fecha_reg_esp.'</td>
	<td align=\'center\' width=\'20%\'>'.$fecha_ent_esp.'</td>	
	</tr>';
	$pdf->WriteHTML($html_2);
	}
$html_3='</table>';
$pdf->WriteHTML($html_3);
break;

//////////////////////////////////////////////////////////////////
//OBSERVACIONES///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
case 'obs':
$sel_det = mysql_query("select materia from agrupamientos where agrupamiento = '$agrupamiento'");
$reg_det = mysql_fetch_array($sel_det);
$materia = $reg_det['materia'];
$pdf->Cell(80,10,''.decode($id_inf_obs).': '.decode($materia).'',0,0,'L');
$pdf->Ln();
$html_1='
<table border=\'1\'>
<tr>
<th>'.decode($id_obs).'</th><th>'.decode($id_fecha_reg).'</th>
</tr>';
$pdf->WriteHTML($html_1);
$sel_obs = mysql_query("select * from observaciones where codigo='$codigo' and agrupamiento='$agrupamiento' order by fecha desc");
$num_obs = mysql_num_rows($sel_obs);
for($o=0;$o<$num_obs;$o++)
	{
	$reg_obs = mysql_fetch_array($sel_obs);
	$id = $reg_obs['id'];
	$observacion = $reg_obs['observacion'];
	$fecha_reg = $reg_obs['fecha'];
	$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
	//la observación puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
	//las etiquetas <p> por <br />
	$busqueda = '<p>';
	$reemplazo = '<br />';
	$obs_br = ereg_replace($busqueda,$reemplazo,$observacion);
	$busqueda = '</p>';
	$reemplazo = '';
	$obs_br2 = ereg_replace($busqueda,$reemplazo,$obs_br);
	$html_2='
	<tr>
	<td align=\'justify\' width=\'60%\'>'.decode($obs_br2).'</td>
	<td align=\'center\' width=\'20%\'>'.$fecha_reg_esp.'</td>
	</tr>';
	$pdf->WriteHTML($html_2);
	}
$html_3='</table>';
$pdf->WriteHTML($html_3);
break;
//////////////////////////////////////////////////////////////////
//CARTAS//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
case 'carta':
$id_carta = $_GET['p6'];
$sel_carta = mysql_query("select texto from cartas where id = '$id_carta'");
$reg_carta = mysql_fetch_array($sel_carta);
$texto_carta = $reg_carta['texto'];
$sel_dir = mysql_query("select direccion1,direccion2,tutor1,tutor2 from alumnado where codigo='$codigo'");
$reg_dir = mysql_fetch_array($sel_dir);
$tutor2=$reg_dir['tutor2'];
	if($tutor2=='ND')
		{
		$tutor2 = '';
		}
//solamente hay una dirección en la base de datos
if($reg_dir['direccion2'] == '')
	{
	$html_1='
	<html>
	<body>
	<table align=\'right\'>
	<tr><td>'.decode($reg_dir['tutor1']).'<br />'.decode($tutor2).'<br />'.decode($reg_dir['direccion1']).'</td></tr>
	</table>
	<br />
	<div text-align=\'justify\'>
	'.decode($texto_carta).'
	</div>
	</body>
	</html>
	';
	$pdf->WriteHTML($html_1);
	}//fin una sola dirección
else
	{
	$html_1='
	<html>
	<body>
	<table align=\'right\'>
	<tr><td>'.decode($reg_dir['tutor1']).'<br />'.decode($reg_dir['direccion1']).'</td></tr>
	</table>
	<br />
	<div text-align=\'justify\'>
	'.decode($texto_carta).'
	</div>
	</body>
	</html>
	';
	$html_2='
	<html>
	<body>
	<table align=\'right\'>
	<tr><td>'.decode($reg_dir['tutor2']).'<br />'.decode($reg_dir['direccion2']).'</td></tr>
	</table>
	<br />
	<div text-align=\'justify\'>
	'.decode($texto_carta).'
	</div>
	</body>
	</html>
	';
	$pdf->WriteHTML($html_1);
	$pdf->AddPage();
	$pdf->Image('logo_200.jpg',20,5); 
	$pdf->Ln(5);		
	$pdf->Cell(50,10,''.decode($nombre_centro).'',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(50,10,''.decode($dir_centro).'',0,0,'L');
	$pdf->Ln(5);
	$pdf->Cell(80,10,'Tel.:'.$telefono_centro.' Fax: '.$fax_centro.'',0,0,'L');
	$pdf->Ln(10);
	$pdf->Cell(80,10,''.decode($id_Alumno).': '.decode($nombre).' '.decode($apellidos).'',0,0,'L');
	$pdf->Ln(5);
	$pdf->WriteHTML($html_2);
	}//fin dos direcciones
break;
//////////////////////////////////////////////////////////////////
//ENTREVISTAS/////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
case 'entrev':
$id_entrev = $_GET['p6'];
$sel_entrev = mysql_query("select texto from entrevistas where id = '$id_entrev'");
$reg_entrev = mysql_fetch_array($sel_entrev);
$texto_entrev = $reg_entrev['texto'];
$html_1='
	<html>
	<body>
	<div text-align=\'justify\'>
	'.decode($texto_entrev).'
	</div>
	</body>
	</html>
	';
$pdf->WriteHTML($html_1);
break;

//////////////////////////////////////////////////////////////////
//BOLETÍN/////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
case 'boletin':
$hoy = date('Y-m-d');
$sel_fechas_per = mysql_query("select * from periodos where '$hoy' between inicio and fin");
if(mysql_num_rows($sel_fechas_per)>0)
{ 
$reg_fechas_per = mysql_fetch_array($sel_fechas_per);
$fecha_inicio = $reg_fechas_per['inicio'];
$fecha_fin = $reg_fechas_per['fin'];
$per_post = $reg_fechas_per['periodo'];

$sel_det = mysql_query("select materia from agrupamientos where agrupamiento = '$agrupamiento'");
$reg_det = mysql_fetch_array($sel_det);
$materia = $reg_det['materia'];
$pdf->Cell(80,10,''.decode($id_inf_Bol).': '.decode($materia).'',0,0,'L');
$pdf->Ln();	


///////////////////ASISTENCIA//////////////////////////////

$pdf->Cell(80,10,''.decode($id_inf_asi).'',0,0,'L');
$pdf->Ln();
$pdf->SetFont('','',6);
$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agrupamiento' and codigo = '$codigo' and dato <> 'a' order by fecha asc");
$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
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
						//si el pdf es para las familias tengo que consultar el docente titular
						//del agrupamiento
						if(isset($_SESSION['familia_sesion']))
							{
							$sel_doc_fam=mysql_query("select docente from agrupamientos where agrupamiento='$agrupamiento'");
							$reg_doc_fam=mysql_fetch_array($sel_doc_fam);
							$doc_fam=$reg_doc_fam['docente'];
							$sel_f=mysql_query("select franja from franjas where docente='$doc_fam' and hini='$hini'");
							}
						else
							{
							$sel_f=mysql_query("select franja from franjas where docente='$docente' and hini='$hini'");
							}
						$reg_f=mysql_fetch_array($sel_f);
						$pdf->Cell(5,5,''.$reg_falta['dato'].'('.$reg_f['franja'].')',1,0,'C');
						}
					if(mysql_num_rows($sel_falta)==2)
						{					
						for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
							{
							$reg_falta=mysql_fetch_array($sel_falta);
							$hini=$reg_falta['hini'];
							//si el pdf es para las familias tengo que consultar el docente titular
						//del agrupamiento
						if(isset($_SESSION['familia_sesion']))
							{
							$sel_doc_fam=mysql_query("select docente from agrupamientos where agrupamiento='$agrupamiento'");
							$reg_doc_fam=mysql_fetch_array($sel_doc_fam);
							$doc_fam=$reg_doc_fam['docente'];
							$sel_f=mysql_query("select franja from franjas where docente='$doc_fam' and hini='$hini'");
							}
						else
							{
							$sel_f=mysql_query("select franja from franjas where docente='$docente' and hini='$hini'");
							}
							$reg_f=mysql_fetch_array($sel_f);
							$pdf->SetFont('','',4);
							$pdf->Cell(2.5,5,''.$reg_falta['dato'].''.$reg_f['franja'].'',1,0,'C');
							$pdf->SetFont('','',6);
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
		}//fin asistencia

///////////////////LISTADO DE FRANJAS HORARIAS///////////////////////////////////
			
$sel_fr = mysql_query("select * from franjas where docente='$docente' or docente='$doc_fam'");
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


///////////////////NOTAS/////////////////////////////////////////////////////////

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



///////////////////OBSERVACIONES/////////////////////////////////////////////////

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

///////////////////TAREAS Y EXÁMENES PENDIENTES//////////////////////////////////

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
}
break;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//ASISTENCIA//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 'faltas':
$sel_det = mysql_query("select materia from agrupamientos where agrupamiento = '$agrupamiento'");
$reg_det = mysql_fetch_array($sel_det);
$materia = $reg_det['materia'];
$pdf->Cell(80,10,''.decode($id_inf_asi).': '.decode($materia).'',0,0,'L');
$pdf->Ln();
$pdf->SetFont('','',6);
$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agrupamiento' and codigo = '$codigo' and dato <> 'a' order by fecha asc");
$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
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
						//si el pdf es para las familias tengo que consultar el docente titular
						//del agrupamiento
						if(isset($_SESSION['familia_sesion']))
							{
							$sel_doc_fam=mysql_query("select docente from agrupamientos where agrupamiento='$agrupamiento'");
							$reg_doc_fam=mysql_fetch_array($sel_doc_fam);
							$doc_fam=$reg_doc_fam['docente'];
							$sel_f=mysql_query("select franja from franjas where docente='$doc_fam' and hini='$hini'");
							}
						else
							{
							$sel_f=mysql_query("select franja from franjas where docente='$docente' and hini='$hini'");
							}
						$reg_f=mysql_fetch_array($sel_f);
						$pdf->Cell(5,5,''.$reg_falta['dato'].'('.$reg_f['franja'].')',1,0,'C');
						}
					if(mysql_num_rows($sel_falta)==2)
						{					
						for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
							{
							$reg_falta=mysql_fetch_array($sel_falta);
							$hini=$reg_falta['hini'];
						//si el pdf es para las familias tengo que consultar el docente titular
						//del agrupamiento
						if(isset($_SESSION['familia_sesion']))
							{
							$sel_doc_fam=mysql_query("select docente from agrupamientos where agrupamiento='$agrupamiento'");
							$reg_doc_fam=mysql_fetch_array($sel_doc_fam);
							$doc_fam=$reg_doc_fam['docente'];
							$sel_f=mysql_query("select franja from franjas where docente='$doc_fam' and hini='$hini'");
							}
						else
							{
							$sel_f=mysql_query("select franja from franjas where docente='$docente' and hini='$hini'");
							}
							$reg_f=mysql_fetch_array($sel_f);
							$pdf->SetFont('','',4);
							$pdf->Cell(2.5,5,''.$reg_falta['dato'].''.$reg_f['franja'].'',1,0,'C');
							$pdf->SetFont('','',6);
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
		}//fin asistencia

///////////////////LISTADO DE FRANJAS HORARIAS///////////////////////////////////
			
$sel_fr = mysql_query("select * from franjas where docente='$docente' or docente='$doc_fam'");
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
break;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//NOTAS///////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 'notas':
$sel_det = mysql_query("select materia from agrupamientos where agrupamiento = '$agrupamiento'");
$reg_det = mysql_fetch_array($sel_det);
$materia = $reg_det['materia'];
$pdf->Cell(80,10,''.decode($id_inf_not).': '.decode($materia).'',0,0,'L');
$pdf->Ln();
$html_1='
<table border=\'1\'>
<tr>
<th>'.decode($id_fecha).'</th><th>'.decode($id_descripcion).'</th><th>'.decode($id_nota).'</th>
<th>'.decode($id_activ).'</th><th>'.decode($id_coment).'</th>
</tr>';
$pdf->WriteHTML($html_1);
$sel_notas = mysql_query("select * from notas where codigo='$codigo' and agrupamiento='$agrupamiento' order by fecha desc, actividad");
$num_notas = mysql_num_rows($sel_notas);
for($n=0;$n<$num_notas;$n++)
	{
	$reg_notas = mysql_fetch_array($sel_notas);
	$id = $reg_notas['id'];
	$fecha = $reg_notas['fecha'];
	$fecha_esp = cambia_fecha_a_esp($fecha);
	$descripcion = $reg_notas['descripcion'];
	$nota = $reg_notas['nota'];
	$actividad = $reg_notas['actividad'];
	$comentario = $reg_notas['comentario'];
	if($comentario == ''){$comentario = $id_no_coment;}
	//el comentario puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
	//las etiquetas <p> por <br />
	$busqueda = '<p>';
	$reemplazo = '<br />';
	$com_br = ereg_replace($busqueda,$reemplazo,$comentario);
	$busqueda = '</p>';
	$reemplazo = '';
	$com_br2 = ereg_replace($busqueda,$reemplazo,$com_br);
	$html_2='
	<tr>
	<td align=\'center\' width=\'15%\'>'.$fecha_esp.'</td>
	<td align=\'justify\' width=\'20%\'>'.decode($descripcion).'</td>
	<td align=\'center\' width=\'10%\'>'.$nota.'</td>
	<td align=\'justify\' width=\'20%\'>'.decode($actividad).'</td>
	<td align=\'justify\' width=\'35%\'>'.decode($com_br2).'</td>
	</tr>';
	$pdf->WriteHTML($html_2);
	}
$html_3='</table>';
$pdf->WriteHTML($html_3);
break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//INFORME PDF EN BLANCO///////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 'inf_blanco':
$num_items = $_GET['numero'];
for($i=0;$i<$num_items;$i++)
	{
	$cb = $_GET['cb_inc_'.$i.''];
	if($cb)
		{
		$item = $_GET['hid_item_'.$i.''];
		$matriz_items[]=$item;
		}
	}
$pdf->Ln(5);
$pdf->Cell(120,10,''.decode($id_mat).':',1,0,'L');
$pdf->Ln();
$pdf->Cell(120,10,''.decode($id_doc).':',1,0,'L');
$pdf->Ln();
if(count($matriz_items)>0)
{
$html_1='
	<br /><table align=\'left\'>
	<tr><th>'.decode($id_item).'</th>
	<th>'.decode($id_si).'</th>
	<th>'.decode($id_no).'</th>
	<th>'.decode($id_av).'</th></tr>	
	';
$pdf->WriteHTML($html_1);
for($i=0;$i<$num_items;$i++)
	{
	$item = $matriz_items[$i];
	$html_2='
		<tr>
		<td align=\'justify\'>'.decode($item).'</td>
		<td border=\'1\'></td><td border=\'1\'></td>
		<td border=\'1\'></td>
		</tr>
		';
	$pdf->WriteHTML($html_2);
	}
$html_3='</table>';
$pdf->WriteHTML($html_3);
}

$pdf->Cell(80,10,''.decode($id_inf_asi).': '.decode($materia).'',0,0,'L');
$pdf->Ln();
$pdf->SetFont('','',6);

$header_faltas=array(''.$id_mes.'','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
	
$w_faltas=array(15,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5);
for($x_faltas=0;$x_faltas<32;$x_faltas++)
	{
	$pdf->Cell($w_faltas[$x_faltas],6,$header_faltas[$x_faltas],1,0,'C');
	}    			
$pdf->Ln();

$nombre_ing_mes_anterior=date('M', mktime(0, 0, 0, date('m')-1,date('d'),date('Y')));
$pdf->Cell(15,5,decode(nombre_mes($nombre_ing_mes_anterior)),1,0,'C');
					
for($d=0;$d<31;$d++)
	{
	$dia = $d + 1;
	$nombre_dia = date('D', mktime(0, 0, 0, date('m')-1, $dia, date('Y')));
	$numero_dia = nombre_dia_a_numero($nombre_dia);
	if($numero_dia == '6' || $numero_dia == '7')
		{
		$pdf->Cell(5,5,$pdf->SetFillColor(0,0,0),1,0,'C',1);
		}
	else
		{
		$pdf->Cell(5,5,'',1,0,'C');
		}
	}
$pdf->Ln();
$pdf->Cell(15,5,decode(nombre_mes(date('M'))),1,0,'C');
					
for($d=0;$d<31;$d++)
	{
	$dia = $d + 1;
	$nombre_dia = date('D', mktime(0, 0, 0, date('m'), $dia, date('Y')));
	$numero_dia = nombre_dia_a_numero($nombre_dia);
	if($numero_dia == '6' || $numero_dia == '7')
		{
		$pdf->Cell(5,5,$pdf->SetFillColor(0,0,0),1,0,'C',1);
		}
	else
		{
		$pdf->Cell(5,5,'',1,0,'C');
		}
	}
$pdf->SetFont('Arial','',11);
$pdf->Ln();
$pdf->Cell(120,10,''.decode($id_inf_obs).':',0,0,'L');
break;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//INFORME PDF TUTORIA/////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 'tutoria':
$sel_det = mysql_query("select materia from agrupamientos where agrupamiento = '$agrupamiento'");
$reg_det = mysql_fetch_array($sel_det);
$materia = $reg_det['materia'];
$pdf->Cell(80,10,''.decode($materia).' ('.decode($_SESSION['nombre_sesion']).' '.decode($_SESSION['apellidos_sesion']).')',0,0,'L');
$pdf->Ln();
$id_informe = $_GET['p6'];
$sel_items = mysql_query("select * from items where informe = '$id_informe'");
$num_items = mysql_num_rows($sel_items);
if($num_items>0)
	{
	$html_1='
	<br /><table align=\'left\'>
	';
	$pdf->WriteHTML($html_1);
	for($i=0;$i<$num_items;$i++)
		{
		$reg_items=mysql_fetch_array($sel_items);
		$item = $reg_items['item'];
		$valor = $reg_items['valor'];
		$html_2='
			<tr>
			<td align=\'justify\'>'.decode($item).'</td>
			<td align=\'center\' border=\'1\'>'.decode($valor).'</td>
			</tr>
			';
		$pdf->WriteHTML($html_2);
		}
	$html_3='</table>';
	$pdf->WriteHTML($html_3);
	}
$pdf->Cell(80,10,''.decode($id_inf_asi).'',0,0,'L');
$pdf->Ln();
$pdf->SetFont('','',6);
$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agrupamiento' and codigo = '$codigo' and dato <> 'a' order by fecha asc");
$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
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
					}
				else
					{
					$pdf->Cell(5,5,'',1,0,'C');
					}
				}
			}
			$pdf->Ln();
		}//fin asistencia

///////////////////LISTADO DE FRANJAS HORARIAS///////////////////////////////////
			
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
$pdf->Ln();

//incluyo las últimas 3 notas del alumno
$sel_notas = mysql_query("select * from notas where codigo='$codigo' and agrupamiento='$agrupamiento' order by fecha desc, actividad limit 3");
$num_notas = mysql_num_rows($sel_notas);
if($num_notas>0)
{
$pdf->Cell(120,10,''.decode($id_ultimas_not).':',0,0,'L');
$pdf->Ln();
$html_1='
<table border=\'1\'>
<tr>
<th>'.decode($id_fecha).'</th><th>'.decode($id_descripcion).'</th><th>'.decode($id_nota).'</th>
<th>'.decode($id_activ).'</th><th>'.decode($id_coment).'</th>
</tr>';
$pdf->WriteHTML($html_1);

for($n=0;$n<$num_notas;$n++)
	{
	$reg_notas = mysql_fetch_array($sel_notas);
	$id = $reg_notas['id'];
	$fecha = $reg_notas['fecha'];
	$fecha_esp = cambia_fecha_a_esp($fecha);
	$descripcion = $reg_notas['descripcion'];
	$nota = $reg_notas['nota'];
	$actividad = $reg_notas['actividad'];
	$comentario = $reg_notas['comentario'];
	if($comentario == ''){$comentario = $id_no_coment;}
	//el comentario puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
	//las etiquetas <p> por <br />
	$busqueda = '<p>';
	$reemplazo = '<br />';
	$com_br = ereg_replace($busqueda,$reemplazo,$comentario);
	$busqueda = '</p>';
	$reemplazo = '';
	$com_br2 = ereg_replace($busqueda,$reemplazo,$com_br);
	$html_2='
	<tr>
	<td align=\'center\' width=\'15%\'>'.$fecha_esp.'</td>
	<td align=\'justify\' width=\'20%\'>'.decode($descripcion).'</td>
	<td align=\'center\' width=\'10%\'>'.$nota.'</td>
	<td align=\'justify\' width=\'20%\'>'.decode($actividad).'</td>
	<td align=\'justify\' width=\'35%\'>'.decode($com_br2).'</td>
	</tr>';
	$pdf->WriteHTML($html_2);
	}
$html_3='</table>';
$pdf->WriteHTML($html_3);
}
$sel_texto_tut = mysql_query("select texto from tutoria where id='$id_informe'");
if(mysql_num_rows($sel_texto_tut)>0)
	{
	$pdf->Cell(120,10,''.decode($id_inf_obs).':',0,0,'L');
	$pdf->Ln();
	$reg_texto_tut = mysql_fetch_array($sel_texto_tut);
	//el comentario puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
	//las etiquetas <p> por <br />
	$busqueda = '<p>';
	$reemplazo = '<br />';
	$com_br = ereg_replace($busqueda,$reemplazo,$reg_texto_tut['texto']);
	$busqueda = '</p>';
	$reemplazo = '';
	$com_br2 = ereg_replace($busqueda,$reemplazo,$com_br);
	$html = '
	<table border=\'1\'>
	<tr>
	<td align=\'justify\'> 
	'.decode($com_br2).'
	</td>
	</tr>
	</table>
	';
	$pdf->WriteHTML($html);
	}
break;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//INFORME PDF TUTORIA RECIBIDOS///////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

case 'tutoria_recib':
$id_informe = $_GET['p6'];
$sel_informe = mysql_query("select * from  tutoria where id='$id_informe'");
$reg_informe = mysql_fetch_array($sel_informe);
$agr_informe = $reg_informe['agrupamiento'];
$sel_doc = mysql_query("select agrupamientos.materia,docentes.docente,docentes.nombre,docentes.apellidos from agrupamientos,docentes where agrupamientos.docente=docentes.docente and agrupamientos.agrupamiento='$agr_informe'");
$reg_doc = mysql_fetch_array($sel_doc);
$docente_informe = $reg_doc['docente'];
$pdf->Cell(80,10,''.decode($reg_doc['materia']).' ('.decode($reg_doc['nombre']).' '.decode($reg_doc['apellidos']).')',0,0,'L');
$pdf->Ln();

$sel_items = mysql_query("select * from items where informe = '$id_informe'");
$num_items = mysql_num_rows($sel_items);
if($num_items>0)
	{
	$html_1='
	<br /><table align=\'left\'>
	';
	$pdf->WriteHTML($html_1);
	for($i=0;$i<$num_items;$i++)
		{
		$reg_items=mysql_fetch_array($sel_items);
		$item = $reg_items['item'];
		$valor = $reg_items['valor'];
		$html_2='
			<tr>
			<td align=\'justify\'>'.decode($item).'</td>
			<td align=\'center\' border=\'1\'>'.decode($valor).'</td>
			</tr>
			';
		$pdf->WriteHTML($html_2);
		}
	$html_3='</table>';
	$pdf->WriteHTML($html_3);
	}
$pdf->Cell(80,10,''.decode($id_inf_asi).'',0,0,'L');
$pdf->Ln();
$pdf->SetFont('','',6);
$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agr_informe' and codigo = '$codigo' and dato <> 'a' order by fecha asc");
$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
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
				$sel_falta = mysql_query("select hini,dato from asistencia where agrupamiento='$agr_informe' and codigo = '$codigo' and fecha = '$fecha_consulta' and dato <> 'a'");
				if(mysql_num_rows($sel_falta)>0)
					{
					if(mysql_num_rows($sel_falta)==1)
						{
						$reg_falta=mysql_fetch_array($sel_falta);
						$hini=$reg_falta['hini'];
						$sel_f=mysql_query("select franja from franjas where docente='$docente_informe' and hini='$hini'");
						$reg_f=mysql_fetch_array($sel_f);
						$pdf->Cell(5,5,''.$reg_falta['dato'].'('.$reg_f['franja'].')',1,0,'C');
						}
					if(mysql_num_rows($sel_falta)==2)
						{					
						for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
							{
							$reg_falta=mysql_fetch_array($sel_falta);
							$hini=$reg_falta['hini'];
							$sel_f=mysql_query("select franja from franjas where docente='$docente_informe' and hini='$hini'");
							$reg_f=mysql_fetch_array($sel_f);
							$pdf->SetFont('','',4);
							$pdf->Cell(2.5,5,''.$reg_falta['dato'].''.$reg_f['franja'].'',1,0,'C');
							$pdf->SetFont('','',6);
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
		}//fin asistencia

///////////////////LISTADO DE FRANJAS HORARIAS///////////////////////////////////
			
$sel_fr = mysql_query("select * from franjas where docente='$docente_informe'");
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
$pdf->Ln();

//incluyo las últimas 3 notas del alumno
$sel_notas = mysql_query("select * from notas where codigo='$codigo' and agrupamiento='$agr_informe' order by fecha desc, actividad limit 3");
$num_notas = mysql_num_rows($sel_notas);
if($num_notas>0)
{
$pdf->Cell(120,10,''.decode($id_ultimas_not).':',0,0,'L');
$pdf->Ln();
$html_1='
<table border=\'1\'>
<tr>
<th>'.decode($id_fecha).'</th><th>'.decode($id_descripcion).'</th><th>'.decode($id_nota).'</th>
<th>'.decode($id_activ).'</th><th>'.decode($id_coment).'</th>
</tr>';
$pdf->WriteHTML($html_1);

for($n=0;$n<$num_notas;$n++)
	{
	$reg_notas = mysql_fetch_array($sel_notas);
	$id = $reg_notas['id'];
	$fecha = $reg_notas['fecha'];
	$fecha_esp = cambia_fecha_a_esp($fecha);
	$descripcion = $reg_notas['descripcion'];
	$nota = $reg_notas['nota'];
	$actividad = $reg_notas['actividad'];
	$comentario = $reg_notas['comentario'];
	if($comentario == ''){$comentario = $id_no_coment;}
	//el comentario puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
	//las etiquetas <p> por <br />
	$busqueda = '<p>';
	$reemplazo = '<br />';
	$com_br = ereg_replace($busqueda,$reemplazo,$comentario);
	$busqueda = '</p>';
	$reemplazo = '';
	$com_br2 = ereg_replace($busqueda,$reemplazo,$com_br);
	$html_2='
	<tr>
	<td align=\'center\' width=\'15%\'>'.$fecha_esp.'</td>
	<td align=\'justify\' width=\'20%\'>'.decode($descripcion).'</td>
	<td align=\'center\' width=\'10%\'>'.$nota.'</td>
	<td align=\'justify\' width=\'20%\'>'.decode($actividad).'</td>
	<td align=\'justify\' width=\'35%\'>'.decode($com_br2).'</td>
	</tr>';
	$pdf->WriteHTML($html_2);
	}
$html_3='</table>';
$pdf->WriteHTML($html_3);
}
$sel_texto_tut = mysql_query("select texto from tutoria where id='$id_informe'");
if(mysql_num_rows($sel_texto_tut)>0)
	{
	$pdf->Cell(120,10,''.decode($id_inf_obs).':',0,0,'L');
	$pdf->Ln();
	$reg_texto_tut = mysql_fetch_array($sel_texto_tut);
	//el comentario puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
	//las etiquetas <p> por <br />
	$busqueda = '<p>';
	$reemplazo = '<br />';
	$com_br = ereg_replace($busqueda,$reemplazo,$reg_texto_tut['texto']);
	$busqueda = '</p>';
	$reemplazo = '';
	$com_br2 = ereg_replace($busqueda,$reemplazo,$com_br);
	$html = '
	<table border=\'1\'>
	<tr>
	<td align=\'justify\'> 
	'.decode($com_br2).'
	</td>
	</tr>
	</table>
	';
	$pdf->WriteHTML($html);
	}

break;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//TODAS LAS OBSERVACIONES/////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 'obstodas':
$pdf->Cell(80,10,''.decode($id_inf_obs).'',0,0,'L');
$pdf->Ln();
$html_1='
<table border=\'1\'>
<tr>
<th>'.decode($id_agr).'</th><th>'.decode($id_obs).'</th><th>'.decode($id_fecha_reg).'</th>
</tr>';
$pdf->WriteHTML($html_1);
$sel_obs = mysql_query("select * from observaciones where codigo='$codigo' order by fecha desc");
$num_obs = mysql_num_rows($sel_obs);
for($o=0;$o<$num_obs;$o++)
	{
	$reg_obs = mysql_fetch_array($sel_obs);
	$id = $reg_obs['id'];
	$agr_obs = $reg_obs['agrupamiento'];
	$sel_det = mysql_query("select materia from agrupamientos where agrupamiento = '$agr_obs'");
	$reg_det = mysql_fetch_array($sel_det);
	$materia = $reg_det['materia'];
	$observacion = $reg_obs['observacion'];
	$fecha_reg = $reg_obs['fecha'];
	$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
	//la observación puede venir con <p> y esto dentro de la tabla no lo interpreta. Así que voy a sustituir
	//las etiquetas <p> por <br />
	$busqueda = '<p>';
	$reemplazo = '<br />';
	$obs_br = ereg_replace($busqueda,$reemplazo,$observacion);
	$busqueda = '</p>';
	$reemplazo = '';
	$obs_br2 = ereg_replace($busqueda,$reemplazo,$obs_br);
	$html_2='
	<tr>
	<td align=\'justify\' width=\'35%\'>'.decode($materia).'</td>
	<td align=\'justify\' width=\'50%\'>'.decode($obs_br2).'</td>
	<td align=\'center\' width=\'15%\'>'.$fecha_reg_esp.'</td>
	</tr>';
	$pdf->WriteHTML($html_2);
	}
$html_3='</table>';
$pdf->WriteHTML($html_3);
break;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//TODAS LAS OBSERVACIONES/////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
case 'faltastodas':
$agr_faltas = $_GET['p6'];
$sel_det = mysql_query("select materia,docente from agrupamientos where agrupamiento = '$agr_faltas'");
$reg_det = mysql_fetch_array($sel_det);
$materia = $reg_det['materia'];
$doc_faltas = $reg_det['docente'];
$pdf->Cell(80,10,''.decode($id_inf_asi).': '.decode($materia).'',0,0,'L');
$pdf->Ln();
$pdf->SetFont('','',6);
$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agr_faltas' and codigo = '$codigo' and dato <> 'a' order by fecha asc");
$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
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
				$sel_falta = mysql_query("select hini,dato from asistencia where agrupamiento='$agr_faltas' and codigo = '$codigo' and fecha = '$fecha_consulta' and dato <> 'a'");
				if(mysql_num_rows($sel_falta)>0)
					{
					if(mysql_num_rows($sel_falta)==1)
						{
						$reg_falta=mysql_fetch_array($sel_falta);
						$hini=$reg_falta['hini'];
						$sel_f=mysql_query("select franja from franjas where docente='$doc_faltas' and hini='$hini'");
						$reg_f=mysql_fetch_array($sel_f);
						$pdf->Cell(5,5,''.$reg_falta['dato'].'('.$reg_f['franja'].')',1,0,'C');
						}
					if(mysql_num_rows($sel_falta)==2)
						{					
						for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
							{
							$reg_falta=mysql_fetch_array($sel_falta);
							$hini=$reg_falta['hini'];
							$sel_f=mysql_query("select franja from franjas where docente='$doc_faltas' and hini='$hini'");
							$reg_f=mysql_fetch_array($sel_f);
							$pdf->SetFont('','',4);
							$pdf->Cell(2.5,5,''.$reg_falta['dato'].''.$reg_f['franja'].'',1,0,'C');
							$pdf->SetFont('','',6);
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
		}//fin asistencia

///////////////////LISTADO DE FRANJAS HORARIAS///////////////////////////////////
			
$sel_fr = mysql_query("select * from franjas where docente='$doc_faltas'");
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
break;

}//fin del switch

$pdf->Output();

}//fin compruebo agrupamiento
}//fin hay sesión

?>