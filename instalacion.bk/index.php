<?php

$licencia = '<strong>SIESTTA</strong> (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) es un software creado por docentes para docentes. Su objetivo consiste en incrementar la eficiencia a la hora de gestionar toda la información que se genera durante el proceso educativo, dentro y fuera del aula. De esta forma, la aplicación ofrece utilidad desde un punto de vista doble. Por un lado, el docente tendrá un acceso rápido y sencillo a todos sus datos y podrá visualizar y generar informes siempre actualizados. Por otro, las familias del alumnado estarán al día de los datos que les interesan, tanto por vía web como mediante documentos escritos.
<br /><br />
Con SIESTTA, <strong>el docente puede</strong>:
<ul>
	<li>Registrar datos sobre asistencia, calificaciones, tareas, observaciones, entrevistas.</li>
	<li>Disponer de una agenda personal donde estar al día de fechas de examen, citas privadas, mensajes, etcétera.</li>
	<li>Acceder a las fichas de su alumnado, disponiendo en segundos de la información requerida.</li>
	<li>Generar boletines actualizados al momento actual.</li>
	<li>Generar informes de asistencia, calificaciones, tareas, observaciones, tanto individuales como de agrupamiento.</li>
	<li>Comunicarse con las familias y resto de docentes del Centro.</li>
	<li>Generar y gestionar correspondencia.</li>
	<li>Generar informes de tutoría y de resultados de evaluación.</li>
</ul>
Con SIESTTA, <strong>las familias pueden</strong>:
<ul>
	<li>Acceder a los datos de asistencia, calificaciones, tareas y observaciones registrados por los docentes.</li>
	<li>Comunicarse con los docentes mediante mensajería interna.</li>
	<li>Recibir correspondencia y boletines con la frecuencia que deseen sin que ello suponga un esfuerzo adicional.</li>
	<li>En resumen, estar al día de la información que les interesa de manera personal y confidencial.</li>
</ul>
SIESTTA no es un software de gestión de centros; es un software de <strong>gestión de aula</strong>, de la información docente que se genera en los procesos de enseñanza-aprendizaje. Creemos que esta información es importante y por ello SIESTTA se centra en el objetivo de <strong>comunicar</strong> a las familias su información y de colaborar a la <strong>transparencia</strong> de la actividad docente, cualidad que consideramos fundamental en la dinámica educativa hoy en día.

<strong>SIESTTA es software libre bajo licencia <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">GNU General Public License</a></strong>, porque creemos que <strong>el conocimiento debe ser compartido</strong>; porque no hubiera sido posible generar este software si miles de personas no hubieran donado, cedido, compartido y comunicado sus datos, sus ideas, sus trucos, sus saberes. La máxima "<strong>Devuelve a la Comunidad</strong>" es el pilar fundamental del movimiento del software libre. Creemos que la Educación no debe quedar al margen de este concepto; es más, pensamos que debe dirigirse hacia este fin. Compartir genera conocimiento, expande ideas y beneficia a la Comunidad. <strong>Compartir es ser libre</strong>.
<br /><br />
<strong>SIESTTA usa:</strong><br>
<ul>
  <li><a href="http://php.net" target="_blank">PHP</a></li>
  <li><a href="http://www.fpdf.org/" target="_blank">FPDF</a></li>
  <li><a href="http://html2fpdf.sourceforge.net/" target="_blank">html2pdf</a></li>
  <li><a href="http://es.wikipedia.org/wiki/Ajax"
 target="_blank">Ajax</a></li>
  <li><a href="http://www.mysql.com/" target="_blank">MySQL</a></li>
  <li><a href="http://www.prototypejs.org/"
 target="_blank">Prototype</a></li>
  <li><a href="http://script.aculo.us/" target="_blank">Scriptaculous</a></li>
  <li><a href="http://www.ryanjlowe.com/?p=9" target="_blank">LitBox</a></li>
<li><a href="http://www.fckeditor.net/" target="_blank">FCK Editor</a></li>
  <li><a href="http://www.silvestre.com.ar/"
 target="_blank">Dropline Neu</a></li>
  <li><a
 href="http://tango.freedesktop.org/Tango_Desktop_Project"
 target="_blank">Tango</a></li>
  <li><a href="http://www.csseasy.com/" target="_blank">CSS Easy</a></li>
</ul>
<br />
SIESTTA <u>no hubiera sido posible sin</u>:
<ul>
	<li>El incondicional apoyo de <a href="http://estherpedroche.blogspot.com" target="_blank">Esther.</a></li>
	<li>El tesón en su uso por parte de <a href="http://montsepedroche.wordpress.com" target="_blank">Montse</a> y sus apreciadas observaciones.</li>
	<li>El apoyo logístico de Montse Senior.</li>
	<li>Las ideas y el ímpetu de <a href="http://andujar.tv" target="_blank">José Luis</a> que me enseñaron el camino.</li>
	<li>La enorme cantidad de personas que se dedican a colgar sus trucos e ideas en la web.</li>
	<li>Los ánimos y palabras de aliento recibidas por mail de tantas y tantas personas de tantos y tantos lugares distintos del mundo.</li>
	</ul>
SIESTTA es software experimental. Se distribuye con la intención de que sea útil, declinando toda responsabilidad sobre su uso y aplicación. SIESTTA es software libre distribuido bajo licencia GNU General Public License y su uso y modificación debe respetar los términos de dicha licencia así como las propias de las librerías empleadas y mencionadas anteriormente. Puedes encontrar una copia de la licencia GNU General Public License <a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">aquí</a>.

<br /><br />SIESTTA ha sido desarrollado por <a href="http://ramoncastro.es" target="_blank">Ramón Castro Pérez</a>.';

include('../funciones.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIESTTA 2.0</title>
<link href="index.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="header">

</div>

<?php

$paso = $_POST['hid_paso'];

if(!$paso)

	{

	echo '
	<div id="center">
	<form method="post" action="index.php">
	<ul>
	<li>Licencia de SIESTTA 2.0</li>
	</ul>
	<table style="margin:auto;width:80%;border:1px solid #dc8;"><tr><td class="justificado">'.$licencia.'</td></tr></table><br />
	<input type="submit" value="Acepto" />
	<input type=hidden value="1" name="hid_paso" />
	</form>
	<br />
	</div>
	';

	}

switch($paso)

	{

	case '1':	

	echo '
	<div id="center">
	<form method="post" id="form1" action="index.php">
	<br /><br />
	<span class="centrado"><a href="../LEEME/leeme.txt" target="_blank">Lee primero las instrucciones de pre-instalación</a></span>
	<br /><br />
	<table class="tablacentrada">
	<tr class="encab">
	<td class="centrado">Configuración de conexión</td>
	<td class="centrado">Administración del sitio</td>
	<td class="centrado">Centro educativo</td>
	</tr>
	<tr>
	<td class="derecha">Servidor: <input type="text" name="txt_servidor" /></td>
	<td class="derecha">Administrador (6 máximo): <input type="text" name="txt_admin" maxlength="6"/></td>
	<td class="derecha">Nombre del centro: <input type="text" name="txt_centro" />
	</tr>
	<tr>
	<td class="derecha">Base de datos: <input type="text" name="txt_bd" /></td>
	<td class="derecha">Clave (6 máximo): <input type="text" name="txt_clave" maxlength="6"/></td>
	<td class="derecha">Dirección del centro: <input type="text" name="dir_centro" />	
	</tr>
	<tr>
	<td class="derecha">Usuario MySQL: <input type="text" name="txt_usuario" /></td>
	<td class="derecha">Idioma: <select name="list_idioma">
	<option value="castellano.php">castellano</option>
	<option value="catalan.php">catal&aacute;n</option>
	<option value="valenciano.php">valenciano</option>
	<option value="gallego.php">gallego</option>
	</select>
	</td>
	<td class="derecha">Teléfono: <input type="text" name="tel_centro" /><br />Fax: <input type="text" name="fax_centro" /></td>
	</tr>
	<tr>
	<td class="derecha">Clave MySQL: <input type="text" name="txt_clave_mysql" /></td>
	<td></td>
	<td class="derecha">Web: <input type="text" name="web_centro" /><br />Mail: <input type="text" name="mail_centro" /></td>
	</tr>
	</table>
	<br />	
	
	<p class="centrado"
	<input class=boton type="submit" value="Acepto" />
	<input type=hidden value="2" name="hid_paso" />
	</p>
	</form>
	</div>
	';	

	break;

	case '2':

	$servidor = $_POST['txt_servidor'];
	$bd = $_POST['txt_bd'];
	$usuario_mysql = $_POST['txt_usuario'];
	$clave_mysql = $_POST['txt_clave_mysql'];
	$administrador = $_POST['txt_admin'];
	$clave = $_POST['txt_clave'];
	$nombre_centro = $_POST['txt_centro'];
	$idioma = $_POST['list_idioma'];
	$dir_centro = $_POST['dir_centro'];
	$telefono_centro = $_POST['tel_centro'];
	$fax_centro = $_POST['fax_centro'];
	$mail_centro = $_POST['mail_centro'];
	$web_centro = $_POST['web_centro'];
	
	if(!$servidor || !$bd || !$usuario_mysql || !$clave_mysql || !$administrador || !$clave || !$nombre_centro || !$dir_centro || !$telefono_centro || !$fax_centro || !$mail_centro || !$web_centro)

	{

	echo '
	<div id="error">
	<br /><br /><br /><br /><br /><br /><br /><br /><br />
	<a href="javascript:history.go(-1)">Debes cumplimentar todos los campos</a>
	</div>
	';

	}

	else

	{

	$abro_fichero = fopen('../config.php','w');

	if(!$abro_fichero)
	{
	echo '
	<div id="error">
	<br /><br /><br /><br /><br /><br /><br /><br /><br />
	<a href="javascript:history.go(-1)">El fichero config.php no tiene permisos de escritura. Cambia los permisos y vuelve al paso anterior</a>
	</div>
	';
	}
	else
	{

	$salto = "\n";
		
	$linea_1 = '<?php'; 
	fputs($abro_fichero,$linea_1); 
	fputs($abro_fichero,$salto);

	$linea_2 = '$servidor = \''.$servidor.'\';'; 
	fputs($abro_fichero,$linea_2); 
	fputs($abro_fichero,$salto);

	$linea_3 = '$bd = \''.$bd.'\';'; 
	fputs($abro_fichero,$linea_3);
	fputs($abro_fichero,$salto);

	$linea_4 = '$usuario_mysql = \''.$usuario_mysql.'\';'; 
	fputs($abro_fichero,$linea_4);
	fputs($abro_fichero,$salto);

	$linea_4a = '$clave_mysql = \''.$clave_mysql.'\';'; 
	fputs($abro_fichero,$linea_4a);
	fputs($abro_fichero,$salto);

	$linea_5 = '$administrador = \''.$administrador.'\';'; 
	fputs($abro_fichero,$linea_5);
	fputs($abro_fichero,$salto);

	$linea_6 = '$nombre_centro = \''.$nombre_centro.'\';'; 
	fputs($abro_fichero,$linea_6);
	fputs($abro_fichero,$salto);

	$linea_7 = '$dir_centro = \''.$dir_centro.'\';'; 
	fputs($abro_fichero,$linea_7);
	fputs($abro_fichero,$salto);

	$linea_8 = '$telefono_centro = \''.$telefono_centro.'\';'; 
	fputs($abro_fichero,$linea_8);
	fputs($abro_fichero,$salto);

	$linea_9 = '$fax_centro = \''.$fax_centro.'\';'; 
	fputs($abro_fichero,$linea_9);
	fputs($abro_fichero,$salto);

	$linea_10 = '$mail_centro = \''.$mail_centro.'\';'; 
	fputs($abro_fichero,$linea_10);
	fputs($abro_fichero,$salto);

	$linea_11 = '$web_centro = \''.$web_centro.'\';'; 
	fputs($abro_fichero,$linea_11);
	fputs($abro_fichero,$salto);

	$linea_12 = '$idioma = \''.$idioma.'\';'; 
	fputs($abro_fichero,$linea_12);
	fputs($abro_fichero,$salto);

	$linea_13 = '?>'; 
	fputs($abro_fichero,$linea_13); 
	
	fclose($abro_fichero);

	conecta();
	
	//creo las tablas

	$crea_tabla=mysql_query("CREATE TABLE `actividades` (
  `actividad` varchar(20) NOT NULL,
  `agrupamiento` varchar(10) NOT NULL,
  `ponderacion` decimal(4,2) NOT NULL,
  `periodo` varchar(2) NOT NULL,
  PRIMARY KEY  (`actividad`,`agrupamiento`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Actividades';

	$crea_tabla=mysql_query("CREATE TABLE `agenda` (
  `id` int(11) NOT NULL auto_increment,
  `docente` varchar(6) NOT NULL,
  `franja` varchar(2) NOT NULL,
  `dia` tinyint(1) NOT NULL,
  `fecha` date NOT NULL,
  `cita` longtext NOT NULL,
  `tipo` char(1) NOT NULL,
  PRIMARY KEY  (`id`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Agenda';

	$crea_tabla=mysql_query("CREATE TABLE `agrupamientos` (
  `agrupamiento` varchar(10) NOT NULL default '',
  `departamento` varchar(30) NOT NULL default '',
  `materia` varchar(50) NOT NULL default '',
  `docente` varchar(6) NOT NULL default '',
  `curso` char(1) NOT NULL default '',
  `nivel` varchar(6) NOT NULL default '',
  PRIMARY KEY  (`agrupamiento`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Agrupamientos';


	$crea_tabla=mysql_query("CREATE TABLE `alumnado` (
  `codigo` varchar(6) NOT NULL default '',
  `nombre` varchar(40) NOT NULL default '',
  `apellidos` varchar(60) NOT NULL default '',
  `f_nac` date NOT NULL default '0000-00-00',
  `grupo` varchar(8) NOT NULL default '',
  `modalidad` varchar(8) NOT NULL default '',
  `repite` set('0','1') NOT NULL default '',
  `tutor1` varchar(100) NOT NULL default '',
  `tutor2` varchar(100) NOT NULL default '',
  `direccion1` varchar(160) NOT NULL default '',
  `direccion2` varchar(160) NOT NULL default '',
  `telef1` varchar(9) NOT NULL default '',
  `telef2` varchar(9) NOT NULL default '',
  `nacionalidad` varchar(20) NOT NULL default '',
  `mail` varchar(50) NOT NULL default '',
  `weblog` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`codigo`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Alumnado';


	$crea_tabla=mysql_query("CREATE TABLE `asistencia` (
  `codigo` varchar(6) NOT NULL,
  `agrupamiento` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `hini` varchar(5) NOT NULL,
  `dato` char(1) NOT NULL,
  PRIMARY KEY  (`codigo`,`agrupamiento`,`fecha`,`hini`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Asistencia';


	$crea_tabla=mysql_query("CREATE TABLE `cartas` (
  `id` int(11) NOT NULL auto_increment,
  `docente` varchar(6) NOT NULL,
  `texto` longtext NOT NULL,
  `destinatario` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY  (`id`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Cartas';


	$crea_tabla=mysql_query("CREATE TABLE `docentes` (
  `docente` varchar(6) NOT NULL default '',
  `clave` varchar(30) default NULL,
  `nombre` varchar(40) default NULL,
  `apellidos` varchar(60) default NULL,
  `email` varchar(50) default NULL,
  `web` varchar(50) default NULL,
  `especialidad` varchar(30) default NULL,
  `telef1` varchar(9) NOT NULL default '',
  `telef2` varchar(9) NOT NULL default '',
  `rol` char(1) NOT NULL default '',
  PRIMARY KEY  (`docente`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Docentes';



	$crea_tabla=mysql_query("CREATE TABLE `entrevistas` (
  `id` int(11) NOT NULL auto_increment,
  `docente` varchar(6) NOT NULL,
  `texto` longtext NOT NULL,
  `codigo` varchar(6) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY  (`id`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Entrevistas';

	$crea_tabla=mysql_query("CREATE TABLE `evaluacion` (
  `id` int(11) NOT NULL auto_increment,
  `codigo` varchar(6) NOT NULL,
  `agrupamiento` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `materia` varchar(50) NOT NULL,
  `observaciones` longtext NOT NULL,
  `nota` decimal(4,2) NOT NULL,
  PRIMARY KEY  (`id`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Evaluación';

	$crea_tabla=mysql_query("CREATE TABLE `familias` (
  `codigo` varchar(6) collate utf8_unicode_ci NOT NULL default '',
  `clave` varchar(4) collate utf8_unicode_ci NOT NULL default '',
  PRIMARY KEY  (`codigo`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Familias';

	$crea_tabla=mysql_query("CREATE TABLE `franjas` (
  `docente` varchar(6) NOT NULL,
  `franja` varchar(2) NOT NULL,
  `hini` varchar(5) NOT NULL,
  `hfin` varchar(5) NOT NULL,
  PRIMARY KEY  (`docente`,`franja`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Franjas';

	$crea_tabla=mysql_query("CREATE TABLE `grupos` (
  `cod_grupo` varchar(8) NOT NULL default '',
  `tut1_grupo` varchar(6) NOT NULL default '-',
  `tut2_grupo` varchar(6) NOT NULL default '-',
  `niv_grupo` varchar(6) NOT NULL default '-',
  `cur_grupo` char(1) NOT NULL default '-',
  PRIMARY KEY  (`cod_grupo`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Grupos';


	$crea_tabla=mysql_query("CREATE TABLE `horario` (
  `docente` varchar(6) NOT NULL,
  `franja` varchar(2) NOT NULL,
  `dia` tinyint(1) NOT NULL,
  `sesion` varchar(15) NOT NULL,
  PRIMARY KEY  (`docente`,`franja`,`dia`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Horario';


	$crea_tabla=mysql_query("CREATE TABLE `items` (
  `id` int(11) NOT NULL auto_increment,
  `informe` int(11) NOT NULL,
  `item` longtext NOT NULL,
  `valor` set('s','n','v') NOT NULL,
  PRIMARY KEY  (`id`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Ítems';


	$crea_tabla=mysql_query("CREATE TABLE `matricula` (
  `codigo` varchar(6) NOT NULL,
  `agrupamiento` varchar(10) NOT NULL,
  PRIMARY KEY  (`codigo`,`agrupamiento`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Matrícula';


	$crea_tabla=mysql_query("CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL auto_increment,
  `remitente` varchar(8) NOT NULL,
  `destinatario` varchar(8) NOT NULL,
  `asunto` varchar(250) NOT NULL,
  `mensaje` longtext NOT NULL,
  `lectura` set('0','1') NOT NULL,
  `borrador` set('0','1') NOT NULL,
  `fecha` datetime NOT NULL,
  `tipo` set('d','f','td','tf') NOT NULL,
  `ocultorec` set('0','1') NOT NULL,
  `ocultoenv` set('0','1') NOT NULL,
  PRIMARY KEY  (`id`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Mensajes';


	$crea_tabla=mysql_query("CREATE TABLE `notas` (
  `id` int(11) NOT NULL auto_increment,
  `codigo` varchar(6) NOT NULL,
  `agrupamiento` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `actividad` varchar(20) NOT NULL,
  `nota` decimal(4,2) NOT NULL,
  `descripcion` longtext NOT NULL,
  `comentario` longtext NOT NULL,
  PRIMARY KEY  (`id`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Notas';

	$crea_tabla=mysql_query("CREATE TABLE `observaciones` (
  `id` int(11) NOT NULL auto_increment,
  `codigo` varchar(6) NOT NULL,
  `agrupamiento` varchar(10) NOT NULL,
  `observacion` longtext NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY  (`id`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Observaciones';


	$crea_tabla=mysql_query("CREATE TABLE `periodos` (
  `periodo` varchar(2) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  PRIMARY KEY  (`periodo`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Períodos';

	$crea_tabla=mysql_query("CREATE TABLE `recuperaciones` (
  `periodo` varchar(2) NOT NULL,
  `agrupamiento` varchar(10) NOT NULL,
  `codigo` varchar(6) NOT NULL,
  `nota` decimal(4,2) NOT NULL,
  PRIMARY KEY  (`periodo`,`agrupamiento`,`codigo`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Recuperaciones';


	$crea_tabla=mysql_query("CREATE TABLE `tareas` (
  `id` int(11) NOT NULL auto_increment,
  `codigo` varchar(6) NOT NULL,
  `agrupamiento` varchar(10) NOT NULL,
  `tarea` longtext NOT NULL,
  `fecha_reg` date NOT NULL,
  `fecha_ent` date NOT NULL,
  PRIMARY KEY  (`id`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Tareas';

	$crea_tabla=mysql_query("CREATE TABLE `todosmensajes` (
  `id` int(11) NOT NULL default '0',
  `destinatario` varchar(6) NOT NULL,
  PRIMARY KEY  (`id`,`destinatario`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Todosmensajes';


	$crea_tabla=mysql_query("CREATE TABLE `tutoria` (
  `id` int(11) NOT NULL auto_increment,
  `codigo` varchar(6) NOT NULL,
  `agrupamiento` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `texto` longtext NOT NULL,
  `destin` varchar(6) NOT NULL,
  `estado_recibido` set('0','1') NOT NULL,
  `estado_envio` set('0','1') NOT NULL,
  PRIMARY KEY  (`id`)
)");
	if(!$crea_tabla) echo 'Error al crear tabla Tutoría';

	
	

	$clave_crypt=crypt($clave,'siestta');
	$inserta = mysql_query("insert into docentes values('$administrador','$clave_crypt','','','','','','','','1')");

	echo '
	<div id="center">
	<br />
	<span>Debes ELIMINAR ahora el directorio "instalacion"</span><br />
	<span>Vuelve a modificar los permisos del archivo config.php a SÓLO LECTURA (444)</span><br />
	<span>Una vez realizados los pasos anteriores, pulsa <a href="../index.php">aquí</a> para acceder</span>
	<br /><br />
	<table class="tablacentrada"><tr class="encab"><td class="centrado">SIESTTA instalado y configurado</td></tr>
	<tr>
	<td>Servidor MySQL: '.$servidor.'	
	<br />Base de datos MySQL: '.$bd.'	
	<br />Usuario MySQL: '.$usuario_mysql.'	
	<br />Clave MySQL: '.$clave_mysql.'	
	<br />Administrador del sitio: '.$administrador.'	
	<br />Centro educativo: '.$nombre_centro.'
	<br />Dirección: '.$dir_centro.'
	<br />Teléfono: '.$telefono_centro.' Fax: '.$fax_centro.'
	<br />Email: '.$mail_centro.' Web: '.$web_centro.'
	<br />Idioma: '.$idioma.'
	</td>
	</table>	
	</div>
	';	
	}
	}

	break;

	}

?>

</body>
</html>


