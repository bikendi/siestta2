<?
require_once('pdf/html2fpdf.php');
// activate Output-Buffer:
ob_start();
/////////////////////////////////////
//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
//conecto con MySQL
conecta();
//recogemos la información cargando la variable
$docente='ramon';
//consultamos y listamos
$sel_datos = mysql_query("select * from docentes where docente = '$docente'");
$reg_datos = mysql_fetch_array($sel_datos);
$telef1 = $reg_datos['telef1'];
$telef2 = $reg_datos['telef2'];
$nombre = $reg_datos['nombre'];
$apellidos = $reg_datos['apellidos'];
$especialidad = $reg_datos['especialidad'];
$web = $reg_datos['web'];
$email = $reg_datos['email'];
	
echo '<table style="border:1px;"><tr><td>Nombre</td><td>Apellidos</td><td>Especialidad</td></tr><tr><td>'.$nombre.'</td><td>'.$apellidos.'</td><td>'.$especialidad.'</td></tr><tr><td>Web</td><td>Mail</td><td>Tel&eacute;fono</td></tr><tr><td>'.$web.'</td><td>'.$email.'</td><td>'.$telef1.'</td></tr></table>';
//////////////////////////////////////

// Output-Buffer in variable:
$html=ob_get_contents();
// delete Output-Buffer
ob_end_clean();
$pdf = new HTML2FPDF();
$pdf->DisplayPreferences('HideWindowUI');
$pdf->AddPage();
$pdf->WriteHTML($html);
                                       
$pdf->Output('doc.pdf','I');
?>

