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
//conecto con MySQL
conecta();

//compruebo agrupamiento
$sel_agr = mysql_query("select agrupamiento from agrupamientos where agrupamiento = '$agrupamiento' and docente = '$docente'");
if(mysql_num_rows($sel_agr)>0)
{
require('html2fpdf.php');
$pdf=new HTML2FPDF('L','mm','A4');
$pdf->pgwidth = 180;
$pdf->SetMargins(20,5,20);
$pdf->AddPage();
$nombre_usuario = $_SESSION['nombre_sesion'];
$apellidos_usuario = $_SESSION['apellidos_sesion'];
$especialidad = $_SESSION['especialidad_sesion'];   
$pdf->Image('logo_200.jpg',20,5); 
$pdf->Ln(5);		
$pdf->Cell(50,10,''.decode($nombre_centro).'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(50,10,''.decode($dir_centro).'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(80,10,'Tel.:'.$telefono_centro.' Fax: '.$fax_centro.'',0,0,'L');
$pdf->Ln(10);
$pdf->Cell(80,10,''.$id_inf_asi.'',0,0,'L');
$pdf->Ln(5);
if($codigo <> '*')
	{
	$pdf->SetFont('Arial','',10);
	$sel_alu=mysql_query("select nombre,apellidos from alumnado where codigo='$codigo'");
	$reg_alu=mysql_fetch_array($sel_alu);
	$nombre=$reg_alu['nombre'];
	$apellidos=$reg_alu['apellidos'];
	$pdf->Cell(300,10,''.$id_Alumno.': '.decode($nombre).' '.decode($apellidos).'',0,0,'L');
	}			
else
	{
	$sel_det = mysql_query("select materia from agrupamientos where agrupamiento = '$agrupamiento'");
	$reg_det = mysql_fetch_array($sel_det);
	$materia = $reg_det['materia'];
	$pdf->Cell(300,10,''.$id_agr.': '.decode($agrupamiento).' ('.decode($materia).')',0,0,'L');
	}
$pdf->Ln(10);
if($codigo <> '*')
	{
	$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agrupamiento' and codigo = '$codigo' and dato <> 'a' order by fecha asc");
	$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
	$header_faltas=array(''.$id_mes.'','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
	
	$w_faltas=array(25,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8);
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
			
			$pdf->Cell(25,8,decode($nombre_mes),1,0,'C');
					
			for($d=0;$d<31;$d++)
				{
				$dia = $d + 1;
				$nombre_dia = date('D', mktime(0, 0, 0, $mes_faltas, $dia, $anyo_faltas));
				$numero_dia = nombre_dia_a_numero($nombre_dia);
				if($numero_dia == '6' || $numero_dia == '7')
					{
					$pdf->Cell(8,8,$pdf->SetFillColor(0,0,0),1,0,'C',1);
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
							$pdf->Cell(8,8,''.$reg_falta['dato'].'('.$reg_f['franja'].')',1,0,'L');
							}
						if(mysql_num_rows($sel_falta)==2)
							{					
							for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
								{
								$reg_falta=mysql_fetch_array($sel_falta);
								$hini=$reg_falta['hini'];
								$sel_f=mysql_query("select franja from franjas where docente='$docente' and hini='$hini'");
								$reg_f=mysql_fetch_array($sel_f);
								$pdf->SetFont('Arial','',6);
								$pdf->Cell(4,8,''.$reg_falta['dato'].'('.$reg_f['franja'].')',1,0,'C');
								$pdf->SetFont('Arial','',8);
								}
							}						
						}
					else
						{
						$pdf->Cell(8,8,'',1,0,'C');
						}
					}
				}
				$pdf->Ln();
				}
			//listo los horarios de las franjas
			$sel_fr = mysql_query("select * from franjas where docente='$docente'");
			$num_fr = mysql_num_rows($sel_fr);
			
			$pdf->Ln(4);
			$pdf->Cell(40,8,$id_franjas,0,0,'L');
			$pdf->Ln(4);

			for($fra=0;$fra<$num_fr;$fra++)
				{
				$reg_fr = mysql_fetch_array($sel_fr);
				$pdf->Cell(25,8,'('.$reg_fr['franja'].'): '.$reg_fr['hini'].'-'.$reg_fr['hfin'].'',0,0,'L');
				$pdf->Ln(4);
				}
			
			}//fin de if código individual (informe para un alumno)
		else//informe para todo el agrupamiento
			{
			$pdf->SetFont('Arial','',8);
			$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agrupamiento' and dato <> 'a' order by fecha desc");
			$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
			for($fa=0;$fa<$num_mes_faltas;$fa++)
				{
				$reg_mes_faltas=mysql_fetch_array($sel_mes_faltas);
				$mes_faltas=$reg_mes_faltas['month(fecha)'];
				$name_mes=date('M',mktime(0,0,0,$mes_faltas+1,0,0));
				$nombre_mes=nombre_mes($name_mes);
				$anyo_faltas=$reg_mes_faltas['year(fecha)'];
				$pdf->Cell(60,6,''.decode($nombre_mes).' '.$anyo_faltas.'',0,0,'L');
				$pdf->Ln();
		
				$header_faltas=array(''.$id_Alumno.'','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
				$w_faltas=array(60,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6);
        			for($x_faltas=0;$x_faltas<32;$x_faltas++)
					{
					$pdf->Cell($w_faltas[$x_faltas],6,$header_faltas[$x_faltas],1,0,'C');
					}    			
				$pdf->Ln();
		
				//seleccionamos los alumnos
				$sel_alum = mysql_query("select matricula.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agrupamiento' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
				$num_alum = mysql_num_rows($sel_alum);
				for($al=0;$al<$num_alum;$al++)
					{
					$reg_alum = mysql_fetch_array($sel_alum);
					$codigo_al = $reg_alum['codigo'];
					$pdf->Cell(60,6,''.decode($reg_alum['apellidos']).', '.decode($reg_alum['nombre']).'',1,0,'L');
			
					for($d=0;$d<31;$d++)
						{
						$dia = $d + 1;
						$nombre_dia = date('D', mktime(0, 0, 0, $mes_faltas, $dia, $anyo_faltas));
						$numero_dia = nombre_dia_a_numero($nombre_dia);
						if($numero_dia == '6' || $numero_dia == '7')
							{
							$pdf->Cell(6,6,$pdf->SetFillColor(0,0,0),1,0,'L',1);
							}
						else
							{
							$fecha_consulta = ''.$anyo_faltas.'-'.$mes_faltas.'-'.$dia.'';
							$sel_falta = mysql_query("select dato,hini from asistencia where agrupamiento='$agrupamiento' and codigo = '$codigo_al' and fecha = '$fecha_consulta' and dato <> 'a'");
							if(mysql_num_rows($sel_falta)>0)
								{
								if(mysql_num_rows($sel_falta)==1)
									{
									$reg_falta=mysql_fetch_array($sel_falta);
									$hini=$reg_falta['hini'];
									$sel_f=mysql_query("select franja from franjas where docente='$docente' and hini='$hini'");
									$reg_f=mysql_fetch_array($sel_f);
									$pdf->Cell(6,6,''.$reg_falta['dato'].''.$reg_f['franja'].'',1,0,'L');
									}
								if(mysql_num_rows($sel_falta)==2)
									{					
									for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
										{
										$reg_falta=mysql_fetch_array($sel_falta);
										$hini=$reg_falta['hini'];
										$sel_f=mysql_query("select franja from franjas where docente='$docente' and hini='$hini'");
										$reg_f=mysql_fetch_array($sel_f);
										$pdf->SetFont('Arial','',6);
										$pdf->Cell(3,6,''.$reg_falta['dato'].''.$reg_f['franja'].'',1,0,'C');
										$pdf->SetFont('Arial','',8);
										}
									}	
								}
							else
								{
								$pdf->Cell(6,6,'',1,0,'L');
								}
							}
						}
					$pdf->Ln();
					}//fin de for $a
				//listo los horarios de las franjas
				$sel_fr = mysql_query("select * from franjas where docente='$docente'");
				$num_fr = mysql_num_rows($sel_fr);
			
				$pdf->Ln(4);
				$pdf->Cell(40,8,$id_franjas,0,0,'L');
				$pdf->Ln(4);

				for($fra=0;$fra<$num_fr;$fra++)
					{
					$reg_fr = mysql_fetch_array($sel_fr);
					$pdf->Cell(25,8,'('.$reg_fr['franja'].'): '.$reg_fr['hini'].'-'.$reg_fr['hfin'].'',0,0,'L');
					$pdf->Ln(4);
					}
				if($fa<($num_mes_faltas-1))
					{
					$pdf->AddPage();
					}	
				}//fin de for $fa
			
			}//fin de else (informe para todos los alumnos del agrupamiento)
		
$pdf->Output();

}//fin compruebo agrupamiento
}//fin hay sesión

?>
