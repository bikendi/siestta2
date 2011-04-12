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
$usuario=$_POST['p2'];
/*las acciones que se pueden llevar a cabo con los docentes en el plano de la administración son:
	- Listado/Edición de docentes ($accion='li')
	- Registro masivo de docentes mediante carga de archivo CSV ($accion='rm')
	- Agregar un docente ($accion='agrega')
	- Eliminar un docente ($accion='edita')*/
//montamos un switch para llevar a cabo las acciones
switch($accion)
	{
	//registro masivo (presentamos formulario de entrada)
	case 'rm':

	echo '<br /><span class="negrita">'.$id_reg_mas.' '.$id_de.' '.$id_docentes.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_rm_doc.'</p>';
	//mostramos formulario para subir el archivo csv a la carpeta temporal
	echo '
	<form method="post" enctype="multipart/form-data" action="docentes.php" target="iframeUpload"></p>
	<p>'.$id_csv.': <input name="fileUpload" type="file" onchange="javascript: submit()" /></p>
	<iframe name="iframeUpload" style="display:none"></iframe>
	</form>
	';
	break;

	//listado-edición de docentes cargados en el sistema
	case 'li':
	echo '<br /><span class="negrita">'.$id_list_edi.' '.$id_de.' '.$id_docentes.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_li_doc.'</p><br />';
		
	//vamos a consultar y a listar en una tabla
	echo '<table class="tablacentrada" id="tabla">';
	echo '<tr class="encab">';
	echo '<td>'.$id_doc.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_ape.'</td>';
	echo '<td>'.$id_esp.'</td>';
	echo '<td>'.$id_ema.'</td>';
	echo '<td>'.$id_web.'</td>';
	echo '<td>'.$id_te1.'</td>';
	echo '<td>'.$id_te2.'</td>';
	echo '<td>'.$id_rol.'</td>';
	echo '</tr>';
	$consulta_doc = mysql_query("select * from docentes order by apellidos,nombre");
	//monto bucle y listo
	$n_doc = mysql_num_rows($consulta_doc);
	for($i=0;$i<$n_doc;$i++)
		{
		$registro_doc = mysql_fetch_array($consulta_doc);
		if($i%2==0){echo '<tr class="par">';}else{echo '<tr>';}		
		echo '<td>';
			echo '
			<a href="#" onclick="docSolicitaEdita(\''.$registro_doc['docente'].'\')" title="'.$id_editar.'">
			<img src="../imgs/edita.png" alt="'.$id_editar.'" />
			</a>
			';
			echo '<a href="#" onclick="new LITBox(\'carga_foto.php?usuario='.$registro_doc['docente'].'\', {type:\'window\', overlay:true, height:190, width:120, resizable:false});">';
			echo $registro_doc['docente'];
			echo '</a>';
		echo '</td>';
		echo '<td>'.$registro_doc['nombre'].'</td>';
		echo '<td>'.$registro_doc['apellidos'].'</td>';
		echo '<td>'.$registro_doc['especialidad'].'</td>';
		echo '<td>'.$registro_doc['email'].'</td>';
		echo '<td>'.$registro_doc['web'].'</td>';
		echo '<td>'.$registro_doc['telef1'].'</td>';
		echo '<td>'.$registro_doc['telef2'].'</td>';
		echo '<td>'.$registro_doc['rol'].'</td>';
		echo '</tr>';
		}
	echo '</table>';
	echo '<p><a id="eliminar" href="#" onclick="docBorraTodos()" title="'.$id_elim_todos.'">';
	echo '<img src="../imgs/eliminatodos.png" alt="'.$id_elim_todos.'" /></a></p>';
	break;
	//editamos
	case 'edita':
	
	echo '<br /><span class="negrita">'.$id_editar.' '.$id_datos.' '.$id_de.' '.$usuario.'</span><br />';
	echo '<br /><p><a href="#" id="eliminar" onclick="docElimina(\''.$usuario.'\')" title="'.$id_eliminar.'"><img src="../imgs/eliminar.png" alt="'.$id_eliminar.'"></a>';
	echo '</p>';
	echo '<p class="texto_centrado">'.$id_texto_edi_doc.'</p><br />';
	//seleccionamos los datos del docente
	$consulta_datos = mysql_query("select * from docentes where docente = '$usuario'");
	$registro_datos = mysql_fetch_array($consulta_datos);
	//presentamos un formulario y los inputs con los valores existentes en la base de datos
	echo '<form name="edita" id="edita">';
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_ape.'</td>';
	echo '<td>'.$id_esp.'</td>';
	echo '<td>'.$id_ema.'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="text" name="txt_nom" maxlength="40" id="txt_nom" value="'.$registro_datos['nombre'].'"/></td>';
	echo '<td><input type="text" name="txt_ape" maxlength="60" id="txt_ape" value="'.$registro_datos['apellidos'].'"/></td>';
	echo '<td><input type="text" name="txt_esp" maxlength="30" id="txt_esp" value="'.$registro_datos['especialidad'].'"/></td>';
	echo '<td><input type="text" name="txt_ema" maxlength="50" id="txt_ema" value="'.$registro_datos['email'].'"/></td>';
	echo '</tr>';
	echo '<tr class="encab">';
	echo '<td>'.$id_web.'</td>';
	echo '<td>'.$id_te1.'</td>';
	echo '<td>'.$id_te2.'</td>';
	echo '<td>'.$id_rol.'</td>';
	echo '</tr>';
	echo '<tr>';	
	echo '<td><input type="text" name="txt_web" maxlength="50" id="txt_web" value="'.$registro_datos['web'].'"/></td>';
	echo '<td><input type="text" name="txt_te1" maxlength="9" id="txt_te1" value="'.$registro_datos['telef1'].'"/></td>';
	echo '<td><input type="text" name="txt_te2" maxlength="9" id="txt_te2" value="'.$registro_datos['telef2'].'"/></td>';
	echo '<td>';
	echo '<select name="list_rol" id="list_rol">';
	if($registro_datos['rol']==0)
		{
		echo '<option selected="selected" value="0">'.$id_doc.'</option>';
		echo '<option value="1">'.$id_admin.'</option>';
		}
	else
		{
		echo '<option selected="selected" value="1">'.$id_admin.'</option>';
		echo '<option value="0">'.$id_doc.'</option>';
		}
	echo '</select>';
	echo '</td>';
	echo '</tr>';
	echo '</table><br />';
	echo '<p class="texto_centrado">';
	echo $id_cambio_cla;
	echo '<br />';
	echo $id_intro_cla1;
	echo '<input type="password" name="pwd_1" id="pwd_1" maxlength="6" size="6" />';
	echo '<br />';
	echo $id_intro_cla2;
	echo '<input type="password" name="pwd_2" id="pwd_2" maxlength="6" size="6" />';
	echo '</p><br />';
	echo '<a href="#" onclick="docEdita(\''.$usuario.'\')" title="'.$id_guardar.'">';
	echo '<img src="../imgs/guardar.png" alt="'.$id_guardar.'" />';
	echo '</a>';
	echo '</form>';
	break;

	//eliminamos
	case 'elimina':
	$consulta_elimina = mysql_query("delete from docentes where docente = '$usuario'");
	if($consulta_elimina)
		{
		echo '<span class="texto_centrado">'.$id_doc_eliminado.'</span>';
		}
	break;

	//guardamos los datos editados
	case 'guarda':
	$doc_nom=$_POST['txt_nom'];
	$doc_ape=$_POST['txt_ape'];
	$doc_esp=$_POST['txt_esp'];
	$doc_ema=$_POST['txt_ema'];
	$doc_web=$_POST['txt_web'];
	$doc_te1=$_POST['txt_te1'];
	$doc_te2=$_POST['txt_te2'];
	$doc_rol=$_POST['list_rol'];
	$doc_cla1=$_POST['pwd_1'];
	$doc_cla2=$_POST['pwd_2'];
	//si se desea cambiar la clave
	if(!empty($doc_cla1)&!empty($doc_cla2))
		{
		//las encriptamos
		$doc_cla_cryp = crypt($doc_cla1,'siestta');
		//hacemos el update
		$consulta_actualiza = mysql_query("update docentes set clave='$doc_cla_cryp',nombre='$doc_nom',apellidos='$doc_ape',email='$doc_ema',web='$doc_web',
especialidad='$doc_esp',telef1='$doc_te1',telef2='$doc_te2',rol='$doc_rol' where docente = '$usuario'");

		}
	else
		{
		$consulta_actualiza = mysql_query("update docentes set nombre='$doc_nom',apellidos='$doc_ape',email='$doc_ema',web='$doc_web',
especialidad='$doc_esp',telef1='$doc_te1',telef2='$doc_te2',rol='$doc_rol' where docente = '$usuario'");
		}
	if($consulta_actualiza)
		{
		echo '<br /><span class="texto_centrado">'.$id_datos_doc_edit.'</span>';
		if(!empty($doc_cla1)&!empty($doc_cla2))
			{
			echo '<br /><br /><span class="texto_centrado">'.$id_record_clave.'</span>';
			echo '<br /><br /><span class="texto_centrado">'.$id_doc.': '.$doc_nom.' '.$doc_ape.'. '.$id_nueva_cla.': '.$doc_cla1.'</span>';
			}
		}
	else
		{
		echo '<br /><br /><span class="negrita">'.$id_error_editar.'</span>';
		}
	break;

	//agregamos docente
	case 'agrega':
	//presentamos formulario
	echo '<br /><span class="negrita">'.$id_agregar.' '.$id_un.' '.$id_doc.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_ag_doc.'</p><br />';
	echo '<form name="guardadoc" id="guardadoc">';
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_doc.'</td>';
	echo '<td>'.$id_cla.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_ape.'</td>';
	echo '<td>'.$id_esp.'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="text" name="txt_doc" id="txt_doc" value="" maxlength="6" /></td>';
	echo '<td><input type="text" name="txt_cla" id="txt_cla" value="" maxlength="6" /></td>';
	echo '<td><input type="text" name="txt_nom" id="txt_nom" value="" maxlength="40" /></td>';
	echo '<td><input type="text" name="txt_ape" id="txt_ape" value="" maxlength="60" /></td>';
	echo '<td><input type="text" name="txt_esp" id="txt_esp" value="" maxlength="30" /></td>';
	echo '</tr>';
	echo '<tr class="encab">';
	echo '<td>'.$id_ema.'</td>';
	echo '<td>'.$id_web.'</td>';
	echo '<td>'.$id_te1.'</td>';
	echo '<td>'.$id_te2.'</td>';
	echo '<td>'.$id_rol.'</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input type="text" name="txt_ema" id="txt_ema" value="" maxlength="50" /></td>';	
	echo '<td><input type="text" name="txt_web" id="txt_web" value="" maxlength="50" /></td>';
	echo '<td><input type="text" name="txt_te1" id="txt_te1" value="" maxlength="9" /></td>';
	echo '<td><input type="text" name="txt_te2" id="txt_te2" value="" maxlength="9" /></td>';
	echo '<td>';
	echo '<select name="list_rol" id="list_rol">';
		echo '<option selected="selected" value="0">'.$id_doc.'</option>';
		echo '<option value="1">'.$id_admin.'</option>';
	echo '</select>';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
	echo '<p><a href="#" onclick="docGuarda()" title="'.$id_guardar.'">';
	echo '<img src="../imgs/guardar.png" alt="'.$id_guardar.'" />';
	echo '</a></p>';
	echo '</form>';
	break;

	//grabamos el docente
	case 'grabadoc':
	//cargamos variables pasadas
	$doc_nom=$_POST['txt_nom'];
	$doc_ape=$_POST['txt_ape'];
	$doc_esp=$_POST['txt_esp'];
	$doc_ema=$_POST['txt_ema'];
	$doc_web=$_POST['txt_web'];
	$doc_te1=$_POST['txt_te1'];
	$doc_te2=$_POST['txt_te2'];
	$doc_rol=$_POST['list_rol'];
	$doc_log=$_POST['txt_doc'];
	$doc_cla=$_POST['txt_cla'];
	//encriptamos clave y registramos
	$doc_cla_crip = crypt($doc_cla,'siestta');
	$inserta_doc = mysql_query("insert into docentes values('$doc_log','$doc_cla_crip','$doc_nom','$doc_ape','$doc_ema','$doc_web','$doc_esp','$doc_te1','$doc_te2','$doc_rol')");
	if ($inserta_doc)
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_ins.'</span>';
		}
	else
		{
		echo '<br /><br /><span class="negrita">'.$id_error_ins.'</span>';
		}
	break;

	//eliminamos todos los docentes
	case 'eliminatodo':
	$borratodos = mysql_query("delete from docentes where rol='0'");
	if($borratodos)
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_eli.'</span>';
		}
	else
		{
		echo '<br /><br /><span class="negrita">'.$id_borra_error.'</span>';
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
	list($n_doc,$n_cla,$n_nom,$n_ape,$n_ema,$n_web,$n_esp,$n_te1,$n_te2,$n_rol) =split( ",", $line);
	$line = fgets( $fp, 2024 );
	//encripto la clave
	$n_cla_crip = crypt($n_cla,'siestta');
	
	$inserta =mysql_query("insert into docentes values('$n_doc','$n_cla_crip','$n_nom','$n_ape','$n_ema','$n_web','$n_esp','$n_te1','$n_te2','$n_rol')");
	}
	//cerramos el archivo
	fclose($fp);

	//finalmente, eliminamos el archivo
	move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$_FILES['fileUpload']['name']);

	//elimino el registro de cabecera
	$borra_cab = mysql_query("delete from docentes where docente='col_d'");

	//si todo ha ido bien, presento mensaje
	if($inserta)echo'<script> alert("'.$id_reg_exito.'");</script>';
	

}
else echo '<script> alert("'.$id_error_formato.'");</script>';
}
else echo '<script> alert("'.$id_error_transf.'");</script>';
}//fin hay sesión
?>


