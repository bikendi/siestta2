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

$pdf->Cell(80,10,''.decode($id_inf_cla).'',0,0,'L');
$pdf->Ln(5);


$sel_claves = mysql_query("SELECT alumnado.codigo, alumnado.nombre, alumnado.apellidos, familias.clave
FROM alumnado, familias, matricula
WHERE matricula.agrupamiento = '$agrupamiento'
AND matricula.codigo = alumnado.codigo
AND matricula.codigo = familias.codigo
AND alumnado.codigo = familias.codigo
ORDER BY alumnado.apellidos, alumnado.nombre");
$num_cla=mysql_num_rows($sel_claves);
	
$html_1='
<br />
<table border=\'1\'>
<tr>
<th>'.decode($id_Alumno).'</th><th>'.decode($id_num_fam).'</th><th>'.decode($id_cla_fam).'</th>
</tr>';
$pdf->WriteHTML($html_1);	

for($c=0;$c<$num_cla;$c++)
	{
	$reg_claves = mysql_fetch_array($sel_claves);
	$nombre = $reg_claves['nombre'];
	$apellidos = $reg_claves['apellidos'];
	$codigo = $reg_claves['codigo'];
	$clave = $reg_claves['clave'];		
	
	$html_2='
		<tr>
		<td align=\'justify\' width=\'60%\'>'.decode($apellidos).', '.decode($nombre).'</td>
		<td align=\'center\' width=\'20%\'>'.decode($codigo).'</td>
		<td align=\'center\' width=\'20%\'>'.decode($clave).'</td>
		</tr>';
		$pdf->WriteHTML($html_2);			
		}
	$html_3='</table>';
	$pdf->WriteHTML($html_3);		
	
$pdf->Output();

}//fin compruebo agrupamiento
}//fin hay sesión

?>
