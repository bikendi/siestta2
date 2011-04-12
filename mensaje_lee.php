<?php

session_start();
//incluimos funciones,configuración e idioma (también fckeditor)
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
include("fckeditor/fckeditor.php") ;
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
$docente = $_SESSION['usuario_sesion'];
//conecto con MySQL
conecta();

$id=$_GET['id'];
$act=mysql_query("update mensajes set lectura='1' where id='$id'");
$sel=mysql_query("select mensaje from mensajes where id='$id'");
$reg=mysql_fetch_array($sel);
$mensaje=$reg['mensaje'];
echo $mensaje;

}//fin sesión

?>
