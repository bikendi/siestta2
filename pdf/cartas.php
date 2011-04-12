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
$id = $_GET['p2'];
//conecto con MySQL
conecta();

//compruebo agrupamiento
$sel_agr = mysql_query("select agrupamiento from agrupamientos where agrupamiento = '$agrupamiento' and docente = '$docente'");
if(mysql_num_rows($sel_agr)>0)
{
$sel_det = mysql_query("select materia from agrupamientos where agrupamiento = '$agrupamiento'");
$reg_det = mysql_fetch_array($sel_det);
$materia = $reg_det['materia'];
$nombre_usuario = $_SESSION['nombre_sesion'];
$apellidos_usuario = $_SESSION['apellidos_sesion'];
$sel_car = mysql_query("select texto from cartas where id='$id'");
$reg_car = mysql_fetch_array($sel_car);
$texto = $reg_car['texto'];
$sel_alum = mysql_query("select alumnado.codigo from alumnado,matricula where matricula.agrupamiento = '$agrupamiento' and matricula.codigo = alumnado.codigo order by alumnado.apellidos,alumnado.nombre");

require('html2fpdf.php');
$pdf=new HTML2FPDF('P','mm','A4');
$pdf->pgwidth = 180;
$pdf->SetMargins(20,20,20);
$pdf->AddPage();

$n = mysql_num_rows($sel_alum);
for($a=0;$a<$n;$a++)
	{
	$reg_sel_alum = mysql_fetch_array($sel_alum);
	$codigo = $reg_sel_alum['codigo'];
	$sel_dir = mysql_query("select direccion1,direccion2,tutor1,tutor2 from alumnado where codigo='$codigo'");
	$reg_dir = mysql_fetch_array($sel_dir);
	$tutor2=$reg_dir['tutor2'];
	if($tutor2=='ND')
		{
		$tutor2 = '';
		}
	//solamente hay una dirección en la base de datos
	if($reg_dir['direccion2'] == '' || $reg_dir['direccion2'] == 'ND')
			{
	
$strContent="
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title>SIESTTA 2.0</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=uft-8\" />
</head>
<body>
<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"2\" align=\"left\">
<tr>
<td>".decode($nombre_centro)."<br />".decode($dir_centro)."<br />Tel.:".$telefono_centro." Fax: ".$fax_centro."</td>
<td><img src=\"logo.jpg\" width=\"130\" height=\"65\" alt=\"\" /></td>
</tr>
<tr>
<td>".$id_doc.": ".decode($nombre_usuario)." ".decode($apellidos_usuario)."</td>
<td></td>
</tr>
<tr>
<td>".$id_agr.": ".decode($agrupamiento)." (".decode($materia).")</td>
<td></td>
</tr>
</table>
<br />
<table align=\"right\">
<tr><td>".decode($reg_dir['tutor1'])."<br />".decode($tutor2)."<br />".decode($reg_dir['direccion1'])."</td></tr>
</table>
<br />
<div text-align=\"justify\">
".decode($texto)."
</div>
</body>
</html>
";
$pdf->WriteHTML($strContent);
			}//fin 1 sola dirección
		else
			{
$strContent="
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title>Correspondencia</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=uft-8\" />
</head>
<br /><br />
<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"2\" align=\"left\">
<tr>
<td>".decode($nombre_centro)."<br />".decode($dir_centro)."<br />Tel.:".$telefono_centro." Fax: ".$fax_centro."</td>
<td><img src=\"logo.jpg\" width=\"130\" height=\"65\" alt=\"\" /></td>
</tr>
<tr>
<td>".$id_doc.": ".decode($nombre_usuario)." ".decode($apellidos_usuario)."</td>
<td></td>
</tr>
<tr>
<td>".$id_agr.": ".decode($agrupamiento)." (".decode($materia).")</td>
<td></td>
</tr>
</table>
<br />
<table align=\"right\">
<tr><td>".decode($reg_dir['tutor1'])."<br />".decode($reg_dir['direccion1'])."</td></tr>
</table>
<br />
<div text-align=\"justify\">
".decode($texto)."
</div>
<body>
</body>
</html>
";
$strContent2="
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<title>Correspondencia</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=uft-8\" />
</head>
<br /><br />
<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"2\" align=\"left\">
<tr>
<td>".decode($nombre_centro)."<br />".decode($dir_centro)."<br />Tel.:".$telefono_centro." Fax: ".$fax_centro."</td>
<td><img src=\"logo.jpg\" width=\"130\" height=\"65\" alt=\"\" /></td>
</tr>
<tr>
<td>".$id_doc.": ".decode($nombre_usuario)." ".decode($apellidos_usuario)."</td>
<td></td>
</tr>
<tr>
<td>".$id_agr.": ".decode($agrupamiento)." (".decode($materia).")</td>
<td></td>
</tr>
</table>
<br />
<table align=\"right\">
<tr><td>".decode($tutor2)."<br />".decode($reg_dir['direccion2'])."</td></tr>
</table>
<br />
<div text-align=\"justify\">
".decode($texto)."
</div>
<body>
</body>
</html>
";
$pdf->WriteHTML($strContent);
$pdf->AddPage();
$pdf->WriteHTML($strContent2);
			}//fin 2 direcciones
	
	if(($n-$a) > 1)
		{ 
		$pdf->AddPage();
		}
	}
$pdf->Output();
}//fin compruebo agrupamiento
}//fin hay sesión

?>


