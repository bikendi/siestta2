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
//conecto con MySQL
conecta();

require('html2fpdf.php');
$pdf=new HTML2FPDF('P','mm','A4');
$pdf->pgwidth = 180;
$pdf->SetMargins(10,5,20);
$pdf->AddPage();

$pdf->Image('logo_200.jpg',20,5); 
$pdf->Ln(5);		
$pdf->Cell(50,10,''.decode($nombre_centro).'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(50,10,''.decode($dir_centro).'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(80,10,'Tel.:'.$telefono_centro.' Fax: '.$fax_centro.'',0,0,'L');
$pdf->Ln(10);
$pdf->Cell(80,10,''.decode($id_horario_lectivo).'',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(80,10,''.decode($id_doc).': '.decode($_SESSION['nombre_sesion']).' '.decode($_SESSION['apellidos_sesion']).'',0,0,'L');
$pdf->Ln();

$html_1='<table border=\'1\'>
	<tr>
	<th>'.decode($id_inicio).'</th><th>'.decode($id_fin).'</th><th>'.decode($id_l).'</th><th>'.decode($id_m).'</th><th>'.decode($id_x).'</th><th>'.decode($id_j).'</th><th>'.decode($id_v).'</th>
	</tr>';
$pdf->WriteHTML($html_1);
$sel_franjas = mysql_query("select franja from franjas where docente='$docente' order by franja desc");
$num_franjas = mysql_num_rows($sel_franjas);
for($h=0;$h<$num_franjas;$h++)
	{
	$f = $h+1;
	$sel_hor = mysql_query("select hini,hfin from franjas where docente='$docente' and franja='$f'");
	$reg_hor = mysql_fetch_array($sel_hor);
	$html_2='
		<tr>
		<td width=\'7%\' height=\'15\' align=\'center\'>'.$reg_hor['hini'].'</td>
		<td width=\'7%\' height=\'15\' align=\'center\'>'.$reg_hor['hfin'].'</td>
		';
	$pdf->WriteHTML($html_2);
	for($d=1;$d<6;$d++)
		{
		$sel_dia = mysql_query("select sesion from horario where docente='$docente' and franja='$f' and dia='$d'");
		$reg_dia = mysql_fetch_array($sel_dia);
		$html_3='<td width=\'18%\' height=\'50\' align=\'center\'>'.$reg_dia['sesion'].'</td>';
		$pdf->WriteHTML($html_3);
		}
	$html_4='</tr>';
	$pdf->WriteHTML($cadena4);
	}
$html_5='</table>';
$pdf->WriteHTML($html_5);	
$pdf->Output();

}//fin hay sesión

?>
