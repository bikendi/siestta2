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
$alumno=$_POST['p2'];
$grupo=$_POST['p3'];
/*las acciones que se pueden llevar a cabo con los alumnos en el plano de la administración son:
	- Listado/Edición de alumnos ($accion='li')
	- Registro masivo de alumnos mediante carga de archivo CSV ($accion='rm')
	- Agregar un alumno ($accion='agrega')
	- Eliminar un alumno ($accion='edita')*/
//montamos un switch para llevar a cabo las acciones
switch($accion)
	{
	//registro masivo (presentamos formulario de entrada)
	case 'rm':

	echo '<br /><span class="negrita">'.$id_reg_mas.' '.$id_de.' '.$id_alumnos.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_rm_alu.'</p>';
	//mostramos formulario para subir el archivo csv a la carpeta temporal
	echo '
	<form method="post" enctype="multipart/form-data" action="alum.php" target="iframeUpload"></p>
	<p>'.$id_csv.': <input name="fileUpload" type="file" onchange="javascript: submit()" /></p>
	<iframe name="iframeUpload" style="display:none"></iframe>
	</form>
	';
	break;

	//listado-edición de alumnos cargados en el sistema
	case 'li':
        if($_POST['borratodos']=='si')
		{
		//eliminamos todos los alumnos del grupo
		$elimtodos=mysql_query("delete from alumnado where grupo = '$grupo'");
		}
	echo '<br /><p class="negrita">'.$id_list_edi.' '.$id_de.' '.$id_alumnos.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_li_alu.'</p>';
		
	//vamos a consultar y a listar en una tabla

	//listaré paginando por grupos de referencia
	$sel_gru = mysql_query("select distinct grupo from alumnado order by grupo");
	$numero_gru = mysql_num_rows($sel_gru);
		echo '<ul class="lista_grupos">';
		for($g=0;$g<$numero_gru;$g++)
		{
		$reg_gru = mysql_fetch_array($sel_gru);
		echo '<li><a href="#" onclick="paginaGrupo(\''.$reg_gru['grupo'].'\',\'pagina\')" title="'.$id_vergrupo.'">'.$reg_gru['grupo'].'</a></li>';
		}
		echo '</ul>';
		echo '<br />';
	
	echo '<table class="tablacentrada" id="tabla">';
	echo '<tr class="encab">';
	echo '<td>'.$id_cod.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_ape.'</td>';
	echo '<td>'.$id_fna.'</td>';
	echo '<td>'.$id_gru.'</td>';
	echo '<td>'.$id_mod.'</td>';
	echo '</tr>';
	$consulta_gru = mysql_query("select grupo from alumnado limit 1");
	$registro_gru = mysql_fetch_array($consulta_gru);
	$primero = $registro_gru['grupo'];
	$consulta_alu = mysql_query("select * from alumnado where grupo = '$primero' order by apellidos,nombre");
	//monto bucle y listo
	$n_alu = mysql_num_rows($consulta_alu);
	for($i=0;$i<$n_alu;$i++)
		{
		$registro_alu = mysql_fetch_array($consulta_alu);
		if($i%2==0){echo '<tr class="par">';}else{echo '<tr>';}		
		echo '<td>';
			echo '<a href="#" title="'.$id_editar.'" onclick="new LITBox(\'carga_fichaal.php?alu='.$registro_alu['codigo'].'\', {type:\'window\', overlay:true});">
			<img src="../imgs/edita.png" alt="'.$id_editar.'" />
			</a>
			';
			
			echo $registro_alu['codigo'];
			
		echo '</td>';
		echo '<td>'.$registro_alu['nombre'].'</td>';
		echo '<td>'.$registro_alu['apellidos'].'</td>';
		//cambio formato fecha
		$fecha_nac_esp = cambia_fecha_a_esp($registro_alu['f_nac']);
		echo '<td>'.$fecha_nac_esp.'</td>';
		echo '<td>'.$registro_alu['grupo'].'</td>';
		echo '<td>'.$registro_alu['modalidad'].'</td>';
		echo '</tr>';
		}
	echo '<tr class="encab">';
	echo '<td>'.$id_cod.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_ape.'</td>';
	echo '<td>'.$id_fna.'</td>';
	echo '<td>'.$id_gru.'</td>';
	echo '<td>'.$id_mod.'</td>';
	echo '</tr>';
	echo '</table>';
	echo '<p><a id="eliminar" href="#" onclick="aluBorraTodos(\''.$primero.'\')" title="'.$id_elim_todos.'">';
	echo '<img src="../imgs/eliminatodos.png" alt="'.$id_elim_todos.'" /></a></p><br />';
	break;

	case 'pagina':

	echo '<br /><span class="negrita">'.$id_list_edi.' '.$id_de.' '.$id_alumnos.'</span>';
	echo '<br /><p class="texto_centrado">'.$id_texto_li_alu.'</p>';
		
	//vamos a consultar y a listar en una tabla

	//listaré los grupos de referencia
	$sel_gru = mysql_query("select distinct grupo from alumnado order by grupo");
	$numero_gru = mysql_num_rows($sel_gru);
		echo '<ul class="lista_grupos">';
		for($g=0;$g<$numero_gru;$g++)
		{
		$reg_gru = mysql_fetch_array($sel_gru);
		echo '<li><a href="#" onclick="paginaGrupo(\''.$reg_gru['grupo'].'\',\'pagina\')" title="'.$id_vergrupo.'">'.$reg_gru['grupo'].'</a></li>';
		}
		echo '</ul>';
		echo '<br />';
	
	echo '<table class="tablacentrada" id="tabla">';
	echo '<tr class="encab">';
	echo '<td>'.$id_cod.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_ape.'</td>';
	echo '<td>'.$id_fna.'</td>';
	echo '<td>'.$id_gru.'</td>';
	echo '<td>'.$id_mod.'</td>';
	echo '</tr>';
	$consulta_alu = mysql_query("select * from alumnado where grupo = '$grupo' order by apellidos,nombre");
	//monto bucle y listo
	$n_alu = mysql_num_rows($consulta_alu);
	for($i=0;$i<$n_alu;$i++)
		{
		$registro_alu = mysql_fetch_array($consulta_alu);
		if($i%2==0){echo '<tr class="par">';}else{echo '<tr>';}		
		echo '<td>';
			echo '
<a href="#" title="'.$id_editar.'" onclick="new LITBox(\'carga_fichaal.php?alu='.$registro_alu['codigo'].'\', {type:\'window\', overlay:true});">
			<img src="../imgs/edita.png" alt="'.$id_editar.'" />
			</a>
			';
			echo $registro_alu['codigo'];
			echo '</a>';
		echo '</td>';
		echo '<td>'.$registro_alu['nombre'].'</td>';
		echo '<td>'.$registro_alu['apellidos'].'</td>';
		//cambio formato fecha
		$fecha_nac_esp = cambia_fecha_a_esp($registro_alu['f_nac']);
		echo '<td>'.$fecha_nac_esp.'</td>';
		echo '<td>'.$registro_alu['grupo'].'</td>';
		echo '<td>'.$registro_alu['modalidad'].'</td>';
		echo '</tr>';
		}
	echo '<tr class="encab">';
	echo '<td>'.$id_cod.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_ape.'</td>';
	echo '<td>'.$id_fna.'</td>';
	echo '<td>'.$id_gru.'</td>';
	echo '<td>'.$id_mod.'</td>';
	echo '</tr>';
	echo '</table>';
	echo '<p><a id="eliminar" href="#" onclick="aluBorraTodos(\''.$grupo.'\')" title="'.$id_elim_todos.'">';
	echo '<img src="../imgs/eliminatodos.png" alt="'.$id_elim_todos.'" /></a></p><br />';	

	break;

	case 'agrega':
	//presentamos formulario
	echo '<br /><span class="negrita">'.$id_agregar.' '.$id_un.' '.$id_alumno.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_ag_alum.'</p><br />';
	echo '<form name="guardaalu" id="guardaalu">';
	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_cod.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_ape.'</td>';
	echo '<td>'.$id_fna_abrev.'(dd-mm-aaaa)</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><input name="txt_cod" id="txt_cod" type="text" maxlength="6" value="" onblur="validaCampo(\'codigo\',\'txt_cod\')" /></td>';
	echo '<td><input name="txt_nom" id="txt_nom" type="text" maxlength="40" value=""/></td>';
	echo '<td><input name="txt_ape" id="txt_ape" type="text" maxlength="60" value="" /></td>';	
	echo '<td><input name="txt_fna" id="txt_nom" type="text" maxlength="40" value="" /></td>';
	echo '</tr>
	<tr class="encab">
	<td>'.$id_gru.'</td>
	<td>'.$id_mod.'</td>
	<td>'.$id_rep.'</td>
	<td>'.$id_nac.'</td>
    	</tr>
    	<tr>
	<td class="centrado">
	<select name="list_grupo" id="list_grupo">	
	';
//listamos grupos para componer el select
$sel_grupos = mysql_query("select cod_grupo from grupos");
$num_grupos = mysql_num_rows($sel_grupos);
for($n=0;$n<$num_grupos;$n++)
	{
	$reg_grupos = mysql_fetch_array($sel_grupos);
	$op_grupo = $reg_grupos['cod_grupo'];
	echo '<option>'.$op_grupo.'</option>';
	}
	echo '
	</select>
	</td>
	<td><input name="txt_modalidad" id="txt_modalidad" type="text" maxlength="8" value="" /></td>
	<td class="centrado">
	<select name="list_repite" id="list_repite">
	<option value="0">'.$id_no.'</option>
	<option value="1">'.$id_si.'</option>
	</select>
	</td>
	<td><input name="txt_nacionalidad" id="txt_nacionalidad" type="text" maxlength="20" value="" /></td>
    	</tr>
 	<tr class="encab">
      	<td>'.$id_tu1.'</td>
      	<td>'.$id_tu2.'</td>
      	<td>'.$id_di1.'</td>
      	<td>'.$id_di2.'</td>
    	</tr>
    	<tr>
	<td><input name="txt_tutor1" id="txt_tutor1" type="text" maxlength="100" value="" /></td>
	<td><input name="txt_tutor2" id="txt_tutor2" type="text" maxlength="100" value="" /></td>
	<td><input name="txt_direccion1" id="txt_direccion1" type="text" maxlength="160" value="" /></td>
	<td><input name="txt_direccion2" id="txt_direccion2" type="text" maxlength="160" value="ND" /></td>
    </tr>
    <tr class="encab">
	<td>'.$id_te1.'</td>
	<td>'.$id_te2.'</td>	
	<td>'.$id_ema.'</td>
	<td>'.$id_web.'</td>
    </tr>
    <tr>
	<td><input name="txt_telef1" id="txt_telef1" type="text" maxlength="9" value="" /></td>
      	<td><input name="txt_telef2" id="txt_telef2" type="text" maxlength="9" value="" /></td>	
      	<td><input name="txt_mail" id="txt_mail" type="text" maxlength="50" value="" /></td>
      	<td><input name="txt_web" id="txt_web" type="text" maxlength="50" value="" /></td>      
    </tr>';
	echo '</table>';
	echo '<p><a href="#" onclick="aluGuarda()" title="'.$id_guardar.'">';
	echo '<img src="../imgs/guardar.png" alt="'.$id_guardar.'" />';
	echo '</a></p>';
	echo '</form>';
	break;

	//grabamos el alumno
	case 'grabaalu':
	//cargamos variables pasadas
	$cod_alu=$_POST['txt_cod'];
	$nom_alu=$_POST['txt_nom'];
	$ape_alu=$_POST['txt_ape'];
	$fna_alu=$_POST['txt_fna'];
		$fna_alu_ing = cambia_fecha_a_ing($fna_alu);
	$gru_alu=$_POST['list_grupo'];
	$mod_alu=$_POST['txt_modalidad'];
	$rep_alu=$_POST['list_repite'];
	$nac_alu=$_POST['txt_nacionalidad'];
	$tu1_alu=$_POST['txt_tutor1'];
	$tu2_alu=$_POST['txt_tutor2'];
	$di1_alu=$_POST['txt_direccion1'];
	$di2_alu=$_POST['txt_direccion2'];
	if($di2_alu == 'ND')
		{
		$di2_alu_ins == '';
		}		
	$te1_alu=$_POST['txt_telef1'];
	$te2_alu=$_POST['txt_telef2'];
	$mai_alu=$_POST['txt_mail'];
	$web_alu=$_POST['txt_web'];
		
	$inserta_alu = mysql_query("insert into alumnado values('$cod_alu','$nom_alu','$ape_alu','$fna_alu_ing','$gru_alu','$mod_alu','$rep_alu','$tu1_alu','$tu2_alu','$di1_alu','$di2_alu_ins','$te1_alu','$te2_alu','$nac_alu','$mai_alu','$web_alu')");
	//genero la clave
	$clave_familia = rand(1000,9999);
	//la inserto
	$inserta_clave_familia = mysql_query("insert into familias values ('$cod_alu','$clave_familia')");	
	if ($inserta_alu && $inserta_clave_familia)
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_ins.'</span>';
		}
	else
		{
		echo '<br /><br /><span class="texto_centrado">'.$id_error_ins.'</span>';
		}
	break;

	case 'edita_masiva':
	
	echo '<br /><span class="negrita">'.$id_edi_mas.' '.$id_de.' '.$id_alumnos.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_edi_mas_alum.'</p>';
	
	//listaré los grupos de referencia
	$sel_gru = mysql_query("select distinct grupo from alumnado order by grupo");
	$numero_gru = mysql_num_rows($sel_gru);
		echo '<ul class="lista_grupos">';
		for($g=0;$g<$numero_gru;$g++)
		{
		$reg_gru = mysql_fetch_array($sel_gru);
		echo '<li><a href="#" onclick="paginaGrupo(\''.$reg_gru['grupo'].'\',\'edita_masiva\')" title="'.$id_vergrupo.'">'.$reg_gru['grupo'].'</a></li>';
		}
		echo '</ul>';
		echo '<br />';
	$consulta_gru = mysql_query("select grupo from alumnado limit 1");
	$registro_gru = mysql_fetch_array($consulta_gru);
	if($grupo) $primero = $grupo;
	else $primero = $registro_gru['grupo'];
	$consulta_alu = mysql_query("select * from alumnado where grupo = '$primero' order by apellidos,nombre");
	//monto bucle y listo
	$n_alu = mysql_num_rows($consulta_alu);	
	echo '<form id="checkboxes" name="checkboxes">';
	echo '<table class="tablacentrada" id="tabla">';
	echo '<tr class="encab">';
	echo '<td><a href="#" onclick="marcaTodos(\''.$n_alu.'\',\'checkboxes\')">'.$id_marcar_todos.'</a></td>';
	echo '<td>'.$id_cod.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_ape.'</td>';
	echo '<td>'.$id_gru.'</td>';
	echo '</tr>';
	
	for($i=0;$i<$n_alu;$i++)
		{
		$registro_alu = mysql_fetch_array($consulta_alu);
		if($i%2==0){echo '<tr class="par">';}else{echo '<tr>';}	
		echo '<td class="centrado"><input name="cb_'.$i.'" id="cb_'.$i.'" value="'.$registro_alu['codigo'].'" type="checkbox" /></td>';	
		echo '<td>';
			echo '<a href="#" title="'.$id_editar.'" onclick="new LITBox(\'carga_fichaal.php?alu='.$registro_alu['codigo'].'\', {type:\'window\', overlay:true});">';
			echo $registro_alu['codigo'];
			echo '</a>
			';			
			
		echo '</td>';
		echo '<td>'.$registro_alu['nombre'].'</td>';
		echo '<td>'.$registro_alu['apellidos'].'</td>';
		echo '<td class="centrado">'.$registro_alu['grupo'].'</td>';
		echo '</tr>';
		}
	echo '<tr class="encab">';
	echo '<td><a href="#" onclick="marcaTodos(\''.$n_alu.'\',\'checkboxes\')">'.$id_marcar_todos.'</a></td>';
	echo '<td>'.$id_cod.'</td>';
	echo '<td>'.$id_nom.'</td>';
	echo '<td>'.$id_ape.'</td>';
	echo '<td>'.$id_gru.'</td>';
	echo '</tr>';
	echo '</table>';
	echo '</form>';

	//echo '<div id="operacion">';
	echo '
        <br />
	<table class="tablacentrada">
	<tr class="encab">
	<td class="centrado">
	'.$id_accion.'
	</tr>
	<td class="centrado">
	<a href="#" onclick="aluEliminaSelec(\''.$n_alu.'\')">'.$id_eliminar.'</a>
	</td>
	</tr>
	<tr>
	<td class="centrado">
	<select name="list_grupo" id="list_grupo" onchange="aluCambiaGru(\''.$n_alu.'\')">
	<option>'.$id_camb_gru.'</option>
        ';
	$sel_grupos = mysql_query("select cod_grupo from grupos");
        $num_grupos = mysql_num_rows($sel_grupos);
	for($ng=0;$ng<$num_grupos;$ng++)
		{
		$reg_grupos = mysql_fetch_array($sel_grupos);
		$grup = $reg_grupos['cod_grupo'];
		echo '<option>'.$grup.'</option>';
		}
	echo '
	</select>
	</td>
	</tr>
	</table>
	';
	//echo '</div>';
	echo '<br />';
	break;

	//eliminamos alumnos seleccionados
	case 'elimina_sel':

	$numero = $_GET['numero'];
	//montamos bucle para ir eliminando
	for($i=0;$i<$numero;$i++)
		{
		$cb = $_POST['cb_'.$i.''];
		if($cb)
			{
			$borra_alu=mysql_query("delete from alumnado where codigo = '$cb'");
			if($borra_alu) $array[]=1;
			}
		}
	$registros_elim = array_sum($array);
	echo '<br /><br /><span class="texto_centrado">'.$id_eliminados.' '.$registros_elim.' '.$id_alumnos.' '.$id_de.' '.$numero.'</span>';
	
	break;	

	case 'cambia_sel':
	$numero = $_GET['numero'];
	$nuevo_grupo = $_GET['grupo'];
	//montamos bucle para ir actualizando
	for($i=0;$i<$numero;$i++)
		{
		$cb = $_POST['cb_'.$i.''];
		if($cb)
			{
			$cambia_alu=mysql_query("update alumnado set grupo = '$nuevo_grupo' where codigo = '$cb'");
			if($cambia_alu) $array[]=1;
			}
		}
	$registros_elim = array_sum($array);
	echo '<br /><br /><span class="texto_centrado">'.$id_cambiados.' '.$registros_elim.' '.$id_alumnos.' '.$id_de.' '.$numero.'</span>';
	

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
	list($n_cod,$n_nom,$n_ape,$n_fnac,$n_gru,$n_mod,$n_rep,$n_tu1,$n_tu2,$n_di1,$n_di2,$n_te1,$n_te2,$n_nac,$n_mai,$n_web) =split( ",", $line);
	$line = fgets( $fp, 2024 );
	//cambio formato de fecha
	$n_fnac_ing = cambia_fecha_a_ing($n_fnac);
	
	$inserta =mysql_query("insert into alumnado values('$n_cod','$n_nom','$n_ape','$n_fnac_ing','$n_gru','$n_mod','$n_rep','$n_tu1','$n_tu2','$n_di1','$n_di2','$n_te1','$n_te2','$n_nac','$n_mai','$n_web')");
	//genero la clave
	$clave_familia = rand(1000,9999);
	//la inserto
	$inserta_clave_familia = mysql_query("insert into familias values ('$n_cod','$clave_familia')");	
	}
	//cerramos el archivo
	fclose($fp);

	//finalmente, eliminamos el archivo
	move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$_FILES['fileUpload']['name']);

	//elimino el registro de cabecera
	$borra_cab = mysql_query("delete from alumnado where codigo='col_a'");

	//si todo ha ido bien, presento mensaje
	if($inserta && $inserta_clave_familia)echo'<script> alert("'.$id_reg_exito.'");</script>';
	

}
else echo '<script> alert("'.$id_error_formato.'");</script>';
}
else echo '<script> alert("'.$id_error_transf.'");</script>';
}//fin hay sesión
?>













