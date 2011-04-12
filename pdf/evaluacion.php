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
$fecha = $_GET['p3'];

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
$pdf->Cell(300,10,''.decode($id_inf_eva).': '.decode($fecha_esp).'',0,0,'L');
$pdf->Ln(5);
$sel_alu = mysql_query("select nombre,apellidos from alumnado where codigo = '$codigo'");
$reg_alu = mysql_fetch_array($sel_alu);
$pdf->Cell(300,10,''.decode($id_Alumno).': '.decode($reg_alu['nombre']).' '.decode($reg_alu['apellidos']).'',0,0,'L');
$pdf->Ln(10);

$html_1='<table border=\'1\'>
	<tr>
	<th>'.decode($id_mat).'</th><th>'.decode($id_nota).'</th><th>'.decode($id_obs).'</th>
	</tr>';
	$pdf->WriteHTML($html_1);

$sel_anotaciones = mysql_query("select * from evaluacion where codigo='$codigo' and agrupamiento='$agrupamiento' and fecha = '$fecha'");
$num_anotaciones = mysql_num_rows($sel_anotaciones);
for($a=0;$a<$num_anotaciones;$a++)
	{
	$reg_anotaciones = mysql_fetch_array($sel_anotaciones);
	$materia = $reg_anotaciones['materia'];
	$observaciones = $reg_anotaciones['observaciones'];
	$nota = $reg_anotaciones['nota'];
	
	$html_2='
	<tr>
	<td align=\'justify\' width=\'30%\'>'.decode($materia).'</td>
	<td align=\'center\' width=\'10%\'>'.$nota.'</td>
	<td align=\'justify\' width=\'60%\'>'.decode($observaciones).'</td>
	</tr>
	';
	$pdf->WriteHTML($html_2);
	}

$html_3='</table>';
$pdf->WriteHTML($html_3);

$pdf->Output();

}//fin compruebo agrupamiento
}//fin hay sesión

?>
