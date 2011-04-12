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
$grupo=$_POST['p2'];
/*las acciones que se pueden llevar a cabo con los grupos en el plano de la administración son:
	- Listado/Edición de grupos ($accion='li')
	- Registro masivo de grupos mediante carga de archivo CSV ($accion='rm')
	- Agregar un grupo ($accion='agrega')
	- Eliminar un grupo ($accion='edita')*/
//montamos un switch para llevar a cabo las acciones
switch($accion)
	{
	//registro masivo (presentamos formulario de entrada)
	case 'rm':

	echo '<br /><span class="negrita">'.$id_reg_mas.' '.$id_de.' '.$id_grupos.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_rm_gru.'</p>';
	//mostramos formulario para subir el archivo csv a la carpeta temporal
	echo '
	<form method="post" enctype="multipart/form-data" action="grupos.php" target="iframeUpload"></p>
	<p>'.$id_csv.': <input name="fileUpload" type="file" onchange="javascript: submit()" /></p>
	<iframe name="iframeUpload" style="display:none"></iframe>
	</form>
	';
	break;

	//listado-edición de grupos cargados en el sistema
	case 'li':
	echo '<br /><span class="negrita">'.$id_list_edi.' '.$id_de.' '.$id_grupos.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_li_gru.'</p><br />';
	//vamos a consultar y a listar en una tabla
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_gru.'</td>';
	echo '<td>'.$id_tu1.'</td>';
	echo '<td>'.$id_tu2.'</td>';
	echo '<td>'.$id_niv.'</td>';
	echo '<td>'.$id_cur.'</td>';	
	echo '</tr>';
	$consulta_gru = mysql_query("select * from grupos order by niv_grupo,cur_grupo");
	//monto bucle y listo
	$n_gru = mysql_num_rows($consulta_gru);
	for($i=0;$i<$n_gru;$i++)
		{
		$registro_gru = mysql_fetch_array($consulta_gru);
		if($i%2==0){echo '<tr class="par">';}else{echo '<tr>';}		
		echo '<td>';
			echo '
			<a href="#" onclick="gruSolicitaEdita(\''.$registro_gru['cod_grupo'].'\')" title="'.$id_editar.'">
			<img src="../imgs/edita.png" alt="'.$id_editar.'" />
			</a>
			';
			echo $registro_gru['cod_grupo'];
		echo '</td>';
		echo '<td>
		<a href="#" onclick="new LITBox(\'carga_fichadoc.php?docente='.$registro_gru['tut1_grupo'].'\', {type:\'window\', overlay:true});">'.$registro_gru['tut1_grupo'].'</a></td>';
		echo '<td>
		<a href="#" onclick="new LITBox(\'carga_fichadoc.php?docente='.$registro_gru['tut2_grupo'].'\', {type:\'window\', overlay:true});">'.$registro_gru['tut2_grupo'].'</a></td>';
		echo '<td>'.$registro_gru['niv_grupo'].'</td>';
		echo '<td>'.$registro_gru['cur_grupo'].'</td>';
		echo '</tr>';
		}
	echo '</table>';
	echo '<p><a id="eliminar" href="#" onclick="gruBorraTodos()" title="'.$id_elim_todos.'">';
	echo '<img src="../imgs/eliminatodos.png" alt="'.$id_elim_todos.'" /></a></p><br />';
	break;

	//para eliminar todos los grupos de referencia
	case 'eliminatodo':
	$borratodos = mysql_query("delete from grupos");
	if($borratodos)
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_eli.'</span>';
		}
	else
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_borra_error.'</span>';
		}
	break;

	//editamos
	case 'edita':
	
	echo '<br /><span class="negrita">'.$id_editar.' '.$id_datos.' '.$id_de.' '.$grupo.'</p><br />';
	echo '<br /><p><a href="#" id="eliminar" onclick="gruElimina(\''.$grupo.'\')" title="'.$id_eliminar.'"><img src="../imgs/eliminar.png" alt="'.$id_eliminar.'"></a>';
	echo '</p>';
	echo '<p class="texto_centrado">'.$id_texto_edi_gru.'</p><br />';
	//seleccionamos los datos del agrupamiento
	$consulta_datos = mysql_query("select * from grupos where cod_grupo = '$grupo'");
	$registro_datos = mysql_fetch_array($consulta_datos);
	//presentamos un formulario y los inputs con los valores existentes en la base de datos
	echo '<form name="edita" id="edita">';
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_tu1.'</td>';
	echo '<td>'.$id_tu2.'</td>';
	echo '<td>'.$id_niv.'</td>';
	echo '<td>'.$id_cur.'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><select name="list_tu1" id="list_tu1">';
	echo '<option selected="selected">'.$registro_datos['tut1_grupo'].'</option>';
	$consulta_docentes = mysql_query("select docente from docentes");
	$n_docentes = mysql_num_rows($consulta_docentes);
	for($d=0;$d<$n_docentes;$d++)
		{
		$reg_consulta_docentes = mysql_fetch_array($consulta_docentes);
		echo '<option>'.$reg_consulta_docentes['docente'].'</option>';
		}
	echo '</select>';
	echo '<td><select name="list_tu2" id="list_tu2">';
	echo '<option selected="selected">'.$registro_datos['tut2_grupo'].'</option>';
	$consulta_docentes = mysql_query("select docente from docentes");
	$n_docentes = mysql_num_rows($consulta_docentes);
	for($d=0;$d<$n_docentes;$d++)
		{
		$reg_consulta_docentes = mysql_fetch_array($consulta_docentes);
		echo '<option>'.$reg_consulta_docentes['docente'].'</option>';
		}
	echo '</select>';
	echo '<td><input type="text" name="txt_niv" maxlength="6" id="txt_niv" value="'.$registro_datos['niv_grupo'].'"/></td>';
	echo '<td><input type="text" name="txt_cur" maxlength="1" id="txt_cur" size="1" value="'.$registro_datos['cur_grupo'].'"/></td>';
	echo '</tr>';
	echo '</table class="tablacentrada">';
	echo '<p><a href="#" onclick="gruEdita(\''.$grupo.'\')" title="'.$id_guardar.'">';
	echo '<img src="../imgs/guardar.png" alt="'.$id_guardar.'" />';
	echo '</a></p>';
	echo '</form>';
	break;

	//eliminamos
	case 'elimina':
	$consulta_elimina = mysql_query("delete from grupos where cod_grupo = '$grupo'");
	if($consulta_elimina)
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_agr_eliminado.'</span>';
		}
	break;

	//guardamos los datos editados
	case 'guarda':
	$tut1_grupo=$_POST['list_tu1'];
	$tut2_grupo=$_POST['list_tu2'];
	$niv_grupo=$_POST['txt_niv'];
	$cur_grupo=$_POST['txt_cur'];
	
	$consulta_actualiza = mysql_query("update grupos set tut1_grupo='$tut1_grupo',tut2_grupo='$tut2_grupo',niv_grupo='$niv_grupo',cur_grupo='$cur_grupo' where cod_grupo = '$grupo'");
		
	if($consulta_actualiza)
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_datos_gru_edit.'</span>';
		}
	else
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_error_editar.'</span>';
		}
	break;

	case 'agrega':
	//presentamos formulario
	echo '<br /><span class="negrita">'.$id_agregar.' '.$id_un.' '.$id_gru.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_ag_gru.'</p><br />';
	echo '<form name="guardagru" id="guardagru">';
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_gru.'</td>';
	echo '<td>'.$id_tu1.'</td>';
	echo '<td>'.$id_tu2.'</td>';
	echo '<td>'.$id_niv.'</td>';
	echo '<td>'.$id_cur.'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="text" name="txt_gru" maxlength="8" id="txt_gru" value=""/></td>';
	echo '<td><select name="list_tu1" id="list_tu1">';
	echo '<option selected="selected" value="">'.$id_elige_tut1.'</option>';
	$consulta_docentes = mysql_query("select docente from docentes");
	$n_docentes = mysql_num_rows($consulta_docentes);
	for($d=0;$d<$n_docentes;$d++)
		{
		$reg_consulta_docentes = mysql_fetch_array($consulta_docentes);
		echo '<option>'.$reg_consulta_docentes['docente'].'</option>';
		}
	echo '</select>';
	echo '<td><select name="list_tu2" id="list_tu2">';
	echo '<option selected="selected" value="ND">'.$id_elige_tut2.'</option>';
	$consulta_docentes = mysql_query("select docente from docentes");
	$n_docentes = mysql_num_rows($consulta_docentes);
	for($d=0;$d<$n_docentes;$d++)
		{
		$reg_consulta_docentes = mysql_fetch_array($consulta_docentes);
		echo '<option>'.$reg_consulta_docentes['docente'].'</option>';
		}
	echo '</select>';
	echo '<td><input type="text" name="txt_niv" maxlength="6" id="txt_niv" value=""/></td>';
	echo '<td><input type="text" name="txt_cur" maxlength="1" id="txt_cur" size="1" value=""/></td>';
	echo '</tr>';
	echo '</table>';
	echo '<p><a href="#" onclick="gruGuarda()" title="'.$id_guardar.'">';
	echo '<img src="../imgs/guardar.png" alt="'.$id_guardar.'" />';
	echo '</a></p>';
	echo '</form>';
	break;

	//grabamos el grupo
	case 'grabagru':
	//cargamos variables pasadas
	$cod_grupo=$_POST['txt_gru'];
	$tut1_grupo=$_POST['list_tu1'];
	$tut2_grupo=$_POST['list_tu2'];
	if($tut2_grupo == 'ND')
		{
		$tut2_grupo_ins = '';
		}		
	$niv_grupo=$_POST['txt_niv'];
	$cur_grupo=$_POST['txt_cur'];
		
	$inserta_gru = mysql_query("insert into grupos values('$cod_grupo','$tut1_grupo','$tut2_grupo_ins','$niv_grupo','$cur_grupo')");
	if ($inserta_gru)
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_ins.'</span>';
		}
	else
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_error_ins.'</span>';
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
	list($n_cod,$n_tu1,$n_tu2,$n_niv,$n_cur) =split( ",", $line);
	$line = fgets( $fp, 2024 );
		
	$inserta =mysql_query("insert into grupos values('$n_cod','$n_tu1','$n_tu2','$n_niv','$n_cur')");
	}
	//cerramos el archivo
	fclose($fp);

	//finalmente, eliminamos el archivo
	move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$_FILES['fileUpload']['name']);

	//elimino el registro de cabecera
	$borra_cab = mysql_query("delete from grupos where cod_grupo='col_c'");

	//si todo ha ido bien, presento mensaje
	if($inserta)echo'<script> alert("'.$id_reg_exito.'");</script>';
	

}
else echo '<script> alert("'.$id_error_formato.'");</script>';
}
else echo '<script> alert("'.$id_error_transf.'");</script>';
}//fin hay sesión
?>

