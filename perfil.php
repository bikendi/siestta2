<?php

session_start();
//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
$docente=$_SESSION['usuario_sesion'];
//////////////////////////cambio_foto//////////////////////////////////////
//copiamos el archivo a la carpeta temporal
  //    Script Que copia el archivo temporal subido al servidor en un directorio.
$tipo = $_FILES['fileUpload']['type'];

//    Definimos Directorio donde se guarda el archivo
$dir = 'admin/fotos_doc/';
//eliminamos la foto antigua
if ($tipo && file_exists('admin/fotos_doc/'.$docente.'.jpg')){unlink('admin/fotos_doc/'.$docente.'.jpg'); }
//    Intentamos Subir Archivo
//    (1) Comprobamos que existe el nombre temporal del archivo
if (isset($_FILES['fileUpload']['tmp_name']))
	{
	//    (2) - Comprobamos que se trata de un archivo de imágen
	if ($tipo == 'image/jpeg')
		{
		//    (3) Por ultimo se intenta copiar el archivo al servidor.
		if (!copy($_FILES['fileUpload']['tmp_name'], $dir.$_FILES['fileUpload']['name']))
			{
			echo '<script> alert("'.$id_error_upload.'");</script>';
			}
		else
			{
			echo '<script>alert("'.$id_mensaje_foto.'");</script>';
			}
		}
	else echo '<script> alert("'.$id_error_formato.'");</script>';
	}
else echo '<script> alert("'.$id_error_transf.'");</script>';

/////////////////////////fin_cambio_foto///////////////////////////////////

//conecto con MySQL
conecta();
//recogemos la información cargando la variable
$docente=$_POST['p1'];
//consultamos y listamos
$sel_datos = mysql_query("select * from docentes where docente = '$docente'");
echo '<br /><span class="negrita">'.$id_misdatos.'</span>';
echo '<ul>';
echo '<li>'.$id_centrotrab.': <a href="'.$web_centro.'" target="_blank">'.$nombre_centro.'</a></li>';
echo '<li>'.$id_direccion.': '.$dir_centro.'</li>';
echo '<li>'.$id_ema.': <a href="mailto:'.$mail_centro.'">'.$mail_centro.'</a> '.$id_telef.': '.$telefono_centro.' '.$id_fax.': '.$fax_centro.'</li>';
if (file_exists('admin/fotos_doc/'.$docente.'.jpg'))
	{ 
	echo '<p><a href="#" onclick="presenta(\'fileUpload\')" title="'.$id_nueva_foto.'"><img class="foto" src="admin/fotos_doc/'.$docente.'.jpg" alt="'.$docente.'" /></a></p>';
	}
else
	{
	echo '<p><a href="#" onclick="presenta(\'fileUpload\')" title="'.$id_nueva_foto.'"><img class="foto" src="admin/fotos_doc/nofoto.jpg" alt="'.$docente.'" /></a></p>';
	}
$reg_datos = mysql_fetch_array($sel_datos);
$telef1 = $reg_datos['telef1'];
$telef2 = $reg_datos['telef2'];
$nombre = $reg_datos['nombre'];
$apellidos = $reg_datos['apellidos'];
$especialidad = $reg_datos['especialidad'];
$web = $reg_datos['web'];
$email = $reg_datos['email'];
	
echo '<li>
	<form method="post" enctype="multipart/form-data" action="perfil.php" target="iframeUpload">
	<input class="oculto_centrado" name="fileUpload" id="fileUpload" type="file" onchange="javascript: submit()" />
	<input type="hidden" name="p1" id="p1" value="'.$docente.'"/>
	<iframe name="iframeUpload" style="display:none"></iframe>
	</form>
</li>';

echo '<li>'.$id_nom.': <a href="#" id="nombre" onclick="editaDocente(\'nombre\',\''.$docente.'\',\''.$nombre.'\')">'.$nombre.'</a></li>';

echo '<li>'.$id_ape.': <a href="#" id="apellidos" onclick="editaDocente(\'apellidos\',\''.$docente.'\',\''.$apellidos.'\')">'.$apellidos.'</a></li>';

echo '<li>'.$id_esp.': <a href="#" id="especialidad" onclick="editaDocente(\'especialidad\',\''.$docente.'\',\''.$especialidad.'\')">'.$especialidad.'</a></li>';

echo '<li>'.$id_web.': <a href="#" id="miweb" onclick="editaDocente(\'miweb\',\''.$docente.'\',\''.$web.'\')">'.$web.'</a><a href="'.$web.'" title="'.$id_nav.'" target="_blank"><img class="alin_medio" src="imgs/navegar.png"/></a></li>';

echo '<li>'.$id_ema.': <a href="#" id="email" onclick="editaDocente(\'email\',\''.$docente.'\',\''.$email.'\')">'.$email.'</a><a href="mailto:'.$email.'" title="'.$id_ema.'"><img class="alin_medio" src="imgs/envia_mail.png"/></a></li>';

echo '<li>'.$id_te1.': <a href="#" id="telef1" onclick="editaDocente(\'telef1\',\''.$docente.'\',\''.$telef1.'\')">'.$telef1.'</a></li>';

echo '<li>'.$id_te2.': <a href="#" id="telef2" onclick="editaDocente(\'telef2\',\''.$docente.'\',\''.$telef2.'\')">'.$telef2.'</a></li>';

echo '<li><br/><a href="#" onclick="presenta(\'cambio_cla\')" title="'.$id_cambio_cla.'"><img src="imgs/clave.png" alt="'.$id_cambio_cla.'" /></a></li>';
echo '<li><p id="cambio_cla" class="oculto">'.$id_intro_cla1.':<input type="password" size="6" maxlength="6" id="clave"/> '.$id_rep_cla1.':<input type="password" size="6" maxlength="6" id="claverep"/><a href="#" onclick="cambiaClave(\''.$docente.'\')">'.$id_cambio_cla.'</a></p></li>';
}//fin hay sesión

?>
