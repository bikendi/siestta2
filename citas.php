<?php

session_start();
//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
include("fckeditor/fckeditor.php") ;
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
//conecto con MySQL
conecta();
$id = $_GET['id'];
$dia = $_GET['dia'];
$mes = $_GET['mes'];
$anyo = $_GET['anyo'];
$franja = $_GET['franja'];
$numero_dia = $_GET['numero_dia'];
echo '<div class="centrado">';
$idcita = $_GET['idcita'];
if($idcita)
{
$sel_cita = mysql_query("select * from agenda where id='$idcita'"); 
$reg_cita = mysql_fetch_array($sel_cita);
$oFCKeditor = new FCKeditor('area') ;
$oFCKeditor->ToolbarSet = 'mensaje';
$oFCKeditor->BasePath = 'fckeditor/';
$oFCKeditor->Value = $reg_cita['cita'];;
$oFCKeditor->Create();
$tipo = $reg_cita['tipo'];
	switch($tipo)
		{
		case $id_abr_tarea:
		$tipo_c=$id_tarea;
		break;
		case $id_abr_examen:
		$tipo_c=$id_examen;
		break;
		case $id_abr_obs:
		$tipo_c=$id_inf_nb;
		break;
		case $id_abr_privado:
		$tipo_c=$id_privado;
		break;
		}
echo '<br/>';
echo '<select id="select" onchange="actualizaCita(\''.$idcita.'\',\''.$dia.'\',\''.$mes.'\',\''.$anyo.'\',\''.$franja.'\',\''.$numero_dia.'\')">';
echo '<option selected="selected">'.$tipo_c.'</option>';
echo '<option>'.$id_seltipocita.'</option>';
echo '<option value='.$id_abr_tarea.'>'.$id_tarea.'</option>';
echo '<option value='.$id_abr_examen.'>'.$id_examen.'</option>';
echo '<option value='.$id_abr_obs.'>'.$id_inf_nb.'</option>';
echo '<option class="negrita_cursiva" value='.$id_abr_privado.'>'.$id_privado.'</option>';
echo '</select>';
}
else
{
$oFCKeditor = new FCKeditor('area') ;
$oFCKeditor->ToolbarSet = 'mensaje';
$oFCKeditor->BasePath = 'fckeditor/';
$oFCKeditor->Value = 'Escribe aqu&iacute;';
$oFCKeditor->Create() ;

echo '<br/>';
echo '<select id="select'.$ns.'" onchange="grabaCita(\''.$ns.'\',\''.$dia.'\',\''.$mes.'\',\''.$anyo.'\',\''.$franja.'\',\''.$numero_dia.'\')">';
echo '<option>'.$id_seltipocita.'</option>';
echo '<option value='.$id_abr_tarea.'>'.$id_tarea.'</option>';
echo '<option value='.$id_abr_examen.'>'.$id_examen.'</option>';
echo '<option value='.$id_abr_obs.'>'.$id_inf_nb.'</option>';
echo '<option class="negrita_cursiva" value='.$id_abr_privado.'>'.$id_privado.'</option>';
echo '</select>';
}
echo '</div>';
}

?>
