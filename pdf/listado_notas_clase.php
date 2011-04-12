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
$fecha = $_GET['p1'];
$agrupamiento = $_GET['p2'];
$descripcion = $_GET['p3'];
$actividad = $_GET['p4'];
$fecha_esp = cambia_fecha_a_esp($fecha);
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

$pdf->Cell(80,10,''.decode($id_agrupamiento).' '.$agrupamiento.' '.decode($actividad).' ('.decode($descripcion).') '.$id_fecha.': '.$fecha_esp.'',0,0,'L');
$pdf->Ln(5);


$sel_notas = mysql_query("select notas.codigo,notas.nota,alumnado.nombre,alumnado.apellidos from notas,alumnado where notas.fecha = '$fecha' and notas.descripcion = '$descripcion' and notas.agrupamiento = '$agrupamiento' and notas.actividad = '$actividad' and notas.codigo = alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
$num_notas=mysql_num_rows($sel_notas);
	
$html_1='
<br />
<table border=\'1\'>
<tr>
<th>'.decode($id_Alumno).'</th><th>'.decode($id_nota).'</th>
</tr>';
$pdf->WriteHTML($html_1);	

for($c=0;$c<$num_notas;$c++)
	{
	$reg_notas = mysql_fetch_array($sel_notas);
	$nombre = $reg_notas['nombre'];
	$apellidos = $reg_notas['apellidos'];
	$nota = $reg_notas['nota'];
		
	$html_2='
		<tr>
		<td align=\'justify\' width=\'70%\'>'.decode($apellidos).', '.decode($nombre).'</td>
		<td align=\'center\' width=\'30%\'>'.decode($nota).'</td>
		</tr>';
		$pdf->WriteHTML($html_2);			
		}
	$html_3='</table>';
	$pdf->WriteHTML($html_3);	

$sel_max_notas = mysql_query("select max(nota) from notas where fecha = '$fecha' and descripcion = '$descripcion' and agrupamiento = '$agrupamiento' and actividad = '$actividad'");
$reg_max_notas = mysql_fetch_array($sel_max_notas);
$max=$reg_max_notas['max(nota)'];

$sel_min_notas = mysql_query("select min(nota) from notas where fecha = '$fecha' and descripcion = '$descripcion' and agrupamiento = '$agrupamiento' and actividad = '$actividad'");
$reg_min_notas = mysql_fetch_array($sel_min_notas);
$min=$reg_min_notas['min(nota)'];

$sel_avg_notas = mysql_query("select avg(nota) from notas where fecha = '$fecha' and descripcion = '$descripcion' and agrupamiento = '$agrupamiento' and actividad = '$actividad'");
$reg_avg_notas = mysql_fetch_array($sel_avg_notas);
$avg=$reg_avg_notas['avg(nota)'];

$html_4='
	<p>'.decode($id_max).': '.$max.'</p>
	<p>'.decode($id_min).': '.$min.'</p>
	<p>'.decode($id_avg).': '.round($avg,2).'</p>
	';
$pdf->WriteHTML($html_4);	
	
$pdf->Output();

}//fin compruebo agrupamiento
}//fin hay sesión

?>

