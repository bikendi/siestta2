<?php

session_start();
//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
$docente = $_SESSION['usuario_sesion'];
//conecto con MySQL
conecta();
//recibo variable
$valor = $_POST['value'];
//elimino espacios en blanco al principio y final
$cadena = trim($valor);
//consultamos los registros coincidentes
$select = mysql_query("select nombre,apellidos,codigo from alumnado where apellidos like '$cadena%'");
echo '<ul>';
//si no hay registros mostramos mensaje
if(mysql_num_rows($select) == 0)
{
echo '<li>'.$id_nodatos.'</li>';
}
else
{
//montamos bucle para presentar la lista
for($a=0;$a<(mysql_num_rows($select));$a++)
{
//extraemos registro actual
$reg = mysql_fetch_array($select);
$codigo = $reg['codigo'];
$sel_agr = mysql_query("select matricula.codigo,matricula.agrupamiento from matricula,agrupamientos where matricula.codigo= '$codigo' and matricula.agrupamiento = agrupamientos.agrupamiento and agrupamientos.docente = '$docente'");
if(mysql_num_rows($sel_agr)>0)
{
	//listamos
	$reg_agr = mysql_fetch_array($sel_agr);
	echo '<li>'.$reg['apellidos'].','.$reg['nombre'].','.$reg_agr['agrupamiento'].'</li>';
}
}
}
//cerramos lista
echo '</ul>';
}
?>
