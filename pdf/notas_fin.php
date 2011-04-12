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
//$codigo = $_GET['p1'];
$agrupamiento = $_GET['p1'];

//$nombre = $_GET['p4'];
//$apellidos = $_GET['p5'];
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
$sel_alum = mysql_query("select alumnado.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento = '$agrupamiento' and matricula.codigo = alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
$n = mysql_num_rows($sel_alum);
for($a=0;$a<$n;$a++)
	{
	$reg_sel_alum = mysql_fetch_array($sel_alum);
	$codigo = $reg_sel_alum['codigo'];
	$nombre = $reg_sel_alum['nombre'];
	$apellidos = $reg_sel_alum['apellidos'];


$pdf->Cell(80,10,''.decode($id_Alumno).': '.decode($nombre).' '.decode($apellidos).'',0,0,'L');
$pdf->Ln(5);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//NOTAS///////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////



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
$sel_notas = mysql_query("select * from notas where codigo='$codigo' and agrupamiento='$agrupamiento' order by fecha asc, actividad");
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
$pdf->AddPage();
}//fin for alumnos
$pdf->Output();

}//fin compruebo agrupamiento
}//fin hay sesión

?>
