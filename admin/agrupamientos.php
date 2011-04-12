<?php

session_start();
//incluimos funciones,configuración e idioma
include('../funciones.php');
require('../config.php');
require('../idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']) && $_SESSION['rol_sesion'] == 'admin')
{
//conecto con MySQL
conecta();
//recogemos la información cargando la variable
$accion=$_POST['p1'];
$agrupamiento=$_POST['p2'];
/*las acciones que se pueden llevar a cabo con los agrupamientos en el plano de la administración son:
	- Listado/Edición de agrupamiento ($accion='li')
	- Registro masivo de agrupamientos mediante carga de archivo CSV ($accion='rm')
	- Agregar un agrupamiento ($accion='aa')*/
//montamos un switch para llevar a cabo las acciones
switch($accion)
	{
	//registro masivo (presentamos formulario de entrada)
	case 'rm':

	echo '<br /><span class="negrita">'.$id_reg_mas.' '.$id_de.' '.$id_agrup.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_rm_agr.'</p>';
	//mostramos formulario para subir el archivo csv a la carpeta temporal
	echo '
	<form method="post" enctype="multipart/form-data" action="agrupamientos.php" target="iframeUpload"></p>
	<p>'.$id_csv.': <input name="fileUpload" type="file" onchange="javascript: submit()" /></p>
	<iframe name="iframeUpload" style="display:none"></iframe>
	</form>
	';
	break;

	//listado-edición de agrupamientos cargados en el sistema
	case 'li':
	echo '<br /><span class="negrita">'.$id_list_edi.' '.$id_de.' '.$id_agrup.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_li_agr.'</p><br />';
	//vamos a consultar y a listar en una tabla
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_agr.'</td>';
	echo '<td>'.$id_dep.'</td>';
	echo '<td>'.$id_mat.'</td>';
	echo '<td>'.$id_doc.'</td>';
	echo '<td>'.$id_cur.'</td>';
	echo '<td>'.$id_niv.'</td>';
	echo '</tr>';
	$consulta_agr = mysql_query("select * from agrupamientos order by departamento,materia");
	//monto bucle y listo
	$n_agr = mysql_num_rows($consulta_agr);
	for($i=0;$i<$n_agr;$i++)
		{
		$registro_agr = mysql_fetch_array($consulta_agr);
		if($i%2==0){echo '<tr class="par">';}else{echo '<tr>';}		
		echo '<td>';
			echo '
			<a href="#" onclick="agrSolicitaEdita(\''.$registro_agr['agrupamiento'].'\')" title="'.$id_editar.'">
			<img src="../imgs/edita.png" alt="'.$id_editar.'" />
			</a>
			';
			echo $registro_agr['agrupamiento'];
		echo '</td>';
		echo '<td>'.$registro_agr['departamento'].'</td>';
		echo '<td>'.$registro_agr['materia'].'</td>';
		echo '<td>'.$registro_agr['docente'].'</td>';
		echo '<td>'.$registro_agr['curso'].'</td>';
		echo '<td>'.$registro_agr['nivel'].'</td>';
		echo '</tr>';
		}
	echo '</table>';
	echo '<p><a id="eliminar" href="#" onclick="agrBorraTodos()" title="'.$id_elim_todos.'">';
	echo '<img src="../imgs/eliminatodos.png" alt="'.$id_elim_todos.'" /></a></p><br />';
	break;

	//para eliminar todos los agrupamientos
	case 'eliminatodo':
	$borratodos = mysql_query("delete from agrupamientos");
	if($borratodos)
		{
		echo '<span class="negrita">'.$id_eli.'</span>';
		}
	else
		{
		echo '<span class="negrita">'.$id_borra_error.'</span>';
		}
	break;
	
	//editamos
	case 'edita':
	
	echo '<br /><span class="negrita">'.$id_editar.' '.$id_datos.' '.$id_de.' '.$agrupamiento.'</span><br />';
	echo '<br /><p><a href="#" id="eliminar" onclick="agrElimina(\''.$agrupamiento.'\')" title="'.$id_eliminar.'"><img src="../imgs/eliminar.png" alt="'.$id_eliminar.'"></a>';
	echo '</p>';
	echo '<p class="texto_centrado">'.$id_texto_edi_agr.'</p><br />';
	//seleccionamos los datos del agrupamiento
	$consulta_datos = mysql_query("select * from agrupamientos where agrupamiento = '$agrupamiento'");
	$registro_datos = mysql_fetch_array($consulta_datos);
	//presentamos un formulario y los inputs con los valores existentes en la base de datos
	echo '<form name="edita" id="edita">';
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_dep.'</td>';
	echo '<td>'.$id_mat.'</td>';
	echo '<td>'.$id_doc.'</td>';
	echo '<td>'.$id_cur.'</td>';
	echo '<td>'.$id_niv.'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="text" name="txt_dep" maxlength="30" id="txt_dep" value="'.$registro_datos['departamento'].'"/></td>';
	echo '<td><input type="text" name="txt_mat" maxlength="50" id="txt_mat" value="'.$registro_datos['materia'].'"/></td>';
	echo '<td><select name="list_doc" id="list_doc">';
	echo '<option selected="selected">'.$registro_datos['docente'].'</option>';
	$consulta_docentes = mysql_query("select docente from docentes");
	$n_docentes = mysql_num_rows($consulta_docentes);
	for($d=0;$d<$n_docentes;$d++)
		{
		$reg_consulta_docentes = mysql_fetch_array($consulta_docentes);
		echo '<option>'.$reg_consulta_docentes['docente'].'</option>';
		}
	echo '</select>';
	echo '<td><input type="text" name="txt_cur" id="txt_cur" maxlength="1" size="1" value="'.$registro_datos['curso'].'"/></td>';
	echo '<td><input type="text" name="txt_niv" id="txt_niv" maxlength="6" value="'.$registro_datos['nivel'].'"/></td>';
	echo '</tr>';
	echo '</table>';
	echo '<p><a href="#" onclick="agrEdita(\''.$agrupamiento.'\')" title="'.$id_guardar.'">';
	echo '<img src="../imgs/guardar.png" alt="'.$id_guardar.'" />';
	echo '</a></p>';
	echo '</form>';
	break;

	//guardamos los datos editados
	case 'guarda':
	$agr_dep=$_POST['txt_dep'];
	$agr_mat=$_POST['txt_mat'];
	$agr_doc=$_POST['list_doc'];
	$agr_cur=$_POST['txt_cur'];
	$agr_niv=$_POST['txt_niv'];
	
	$consulta_actualiza = mysql_query("update agrupamientos set departamento='$agr_dep',materia='$agr_mat',docente='$agr_doc',curso='$agr_cur',nivel='$agr_niv' where agrupamiento = '$agrupamiento'");
		
	if($consulta_actualiza)
		{
		echo '<span class="negrita">'.$id_datos_agr_edit.'</span>';
		}
	else
		{
		echo '<span class="negrita">'.$id_error_editar.'</span>';
		}
	break;

	//eliminamos
	case 'elimina':
	$consulta_elimina = mysql_query("delete from agrupamientos where agrupamiento = '$agrupamiento'");
	if($consulta_elimina)
		{
		echo '<span class="negrita">'.$id_agr_eliminado.'</span>';
		}
	break;

	case 'agrega':
	//presentamos formulario
	echo '<br /><span class="negrita">'.$id_agregar.' '.$id_un.' '.$id_agr.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_ag_agr.'</p><br />';
	echo '<form name="guardaagr" id="guardaagr">';
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_agr.'</td>';
	echo '<td>'.$id_dep.'</td>';
	echo '<td>'.$id_mat.'</td>';
	echo '<td>'.$id_doc.'</td>';
	echo '<td>'.$id_cur.'</td>';
	echo '<td>'.$id_niv.'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="text" name="txt_agr" maxlength="10" id="txt_agr" value=""/></td>';
	echo '<td><input type="text" name="txt_dep" maxlength="30" id="txt_dep" value=""/></td>';
	echo '<td><input type="text" name="txt_mat" maxlength="50" id="txt_mat" value=""/></td>';
	echo '<td><select name="list_doc" id="list_doc">';
	echo '<option selected="selected">'.$id_elige_doc.'</option>';
	$consulta_docentes = mysql_query("select docente from docentes");
	$n_docentes = mysql_num_rows($consulta_docentes);
	for($d=0;$d<$n_docentes;$d++)
		{
		$reg_consulta_docentes = mysql_fetch_array($consulta_docentes);
		echo '<option>'.$reg_consulta_docentes['docente'].'</option>';
		}
	echo '</select>';
	echo '<td><input type="text" name="txt_cur" id="txt_cur" maxlength="1" size="1" value=""/></td>';
	echo '<td><input type="text" name="txt_niv" id="txt_niv" maxlength="6" value=""/></td>';
	echo '</tr>';
	echo '</table>';
	echo '<p><a href="#" onclick="agrGuarda()" title="'.$id_guardar.'">';
	echo '<img src="../imgs/guardar.png" alt="'.$id_guardar.'" />';
	echo '</a></p>';
	echo '</form>';
	break;

	//grabamos el docente
	case 'grabaagr':
	//cargamos variables pasadas
	$agr_agr=$_POST['txt_agr'];
	$agr_dep=$_POST['txt_dep'];
	$agr_mat=$_POST['txt_mat'];
	$agr_doc=$_POST['list_doc'];
	$agr_cur=$_POST['txt_cur'];
	$agr_niv=$_POST['txt_niv'];
	
	$inserta_agr = mysql_query("insert into agrupamientos values('$agr_agr','$agr_dep','$agr_mat','$agr_doc','$agr_cur','$agr_niv')");
	if ($inserta_agr)
		{
		echo '<span class="negrita">'.$id_ins.'</span>';
		}
	else
		{
		echo '<span class="negrita">'.$id_error_ins.'</span>';
		}
	break;

	}//fin switch

//copiamos el archivo a la carpeta temporal
  //    Script Que copia el archivo temporal subido al servidor en un directorio.
$tipo = $_FILES['fileUpload']['type'];

//    Definimos Directorio donde se guarda el archivo
$dir = 'archivos/';

//    Intentamos Subir Archivo
//    (1) Comprobamos que existe el nombre temporal del archivo
if (isset($_FILES['fileUpload']['tmp_name'])) {
//    (2) - Comprobamos que se trata de un archivo de imágen
if ($tipo == 'text/comma-separated-values' || $tipo == 'text/x-comma-separated-values' || $tipo == 'text/csv') {
//    (3) Por ultimo se intenta copiar el archivo al servidor.
if (!copy($_FILES['fileUpload']['tmp_name'], $dir.$_FILES['fileUpload']['name']))
echo '<script> alert("'.$id_error_upload.'");</script>';

//una vez transferido, lo abrimos e insertamos en la base de datos la información
//abro el archivo

	$fp=fopen($dir.$_FILES['fileUpload']['name'],"r") or die("Error al abrir el fichero");
	$line = fgets( $fp, 2024 );

	while(!feof($fp))
	{
	list($n_agr,$n_dep,$n_mat,$n_doc,$n_cur,$n_niv) =split( ",", $line);
	$line = fgets( $fp, 2024 );
	//encripto la clave
	$n_cla_crip = crypt($n_cla,'siestta');
	
	$inserta =mysql_query("insert into agrupamientos values('$n_agr','$n_dep','$n_mat','$n_doc','$n_cur','$n_niv')");
	}
	//cerramos el archivo
	fclose($fp);

	//finalmente, eliminamos el archivo
	move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$_FILES['fileUpload']['name']);

	//elimino el registro de cabecera
	$borra_cab = mysql_query("delete from agrupamientos where agrupamiento='col_a'");

	//si todo ha ido bien, presento mensaje
	if($inserta)echo'<script> alert("'.$id_reg_exito.'");</script>';
	

}
else echo '<script> alert("'.$id_error_formato.'");</script>';
}
else echo '<script> alert("'.$id_error_transf.'");</script>';
}//fin hay sesión
?>

