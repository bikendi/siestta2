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

$asunto=$_GET['asunto'];
$tipo=$_GET['tipo'];
$destinatario=$_GET['destinatario'];
$mensaje=$_GET['mensaje'];
$id=$_GET['id'];

echo '<form id="formulario" name="formulario" class="centrado">';
echo '<span class="negrita_cursiva">'.$id_asunto.':</span> <input type="text" id="asunto" name="asunto" value="'.$asunto.'" size="40" /><br /><br />';
echo '<span class="negrita_cursiva">'.$id_destinatario.':</span> ';
$sel_doc=mysql_query("select docente,nombre,apellidos,especialidad from docentes order by especialidad,apellidos,nombre");
$num_doc=mysql_num_rows($sel_doc);
echo '<select onclick="muestraDest(\'d\')" id="sel_doc" name="destin_doc">';
echo '<option value="0">'.$id_doc.'</option>';
if($tipo=='td' && $destinatario='*')
	{
	echo '<option selected="selected" class="negrita_cursiva" value="*">'.$id_todos_doc.'</option>';
	}
else
	{
	echo '<option class="negrita_cursiva" value="*">'.$id_todos_doc.'</option>';
	}
for($d=0;$d<$num_doc;$d++)
	{
	$reg_doc=mysql_fetch_array($sel_doc);
	if($destinatario == $reg_doc['docente'])
		{
		echo '<option selected="selected" value="'.$reg_doc['docente'].'">['.$reg_doc['especialidad'].'] '.$reg_doc['nombre'].' '.$reg_doc['apellidos'].'</option>';
		}
	else
		{
		echo '<option value="'.$reg_doc['docente'].'">['.$reg_doc['especialidad'].'] '.$reg_doc['nombre'].' '.$reg_doc['apellidos'].'</option>';
		}
	}
echo '</select>';
$sel_agr=mysql_query("select agrupamiento from agrupamientos where docente='$docente'");
$num_agr=mysql_num_rows($sel_agr);
echo '<select onclick="muestraDest(\'f\')" id="sel_fam" name="destin_fam">';
echo '<option value="0">'.$id_familia.'</option>';
if($tipo=='tf' && $destinatario == '*')
	{
	echo '<option selected="selected" class="negrita_cursiva" value="*">'.$id_todos_fam.'</option>';
	}
else
	{
	echo '<option class="negrita_cursiva" value="*">'.$id_todos_fam.'</option>';
	}
for($a=0;$a<$num_agr;$a++)
	{
	$reg_agr=mysql_fetch_array($sel_agr);
	$agr=$reg_agr['agrupamiento'];
	if($destinatario==$agr)
		{
		echo '<option selected="selected" class="negrita_cursiva">'.$agr.'</option>';
		}
	else
		{
		echo '<option class="negrita_cursiva">'.$agr.'</option>';
		}
	$sel_alu=mysql_query("select matricula.codigo,matricula.agrupamiento,alumnado.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agr' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alu=mysql_num_rows($sel_alu);
	for($b=0;$b<$num_alu;$b++)
		{
		$reg_alu=mysql_fetch_array($sel_alu);
		if($destinatario==$reg_alu['codigo'])
			{
			echo '<option selected="selected" value="'.$reg_alu['codigo'].'">'.$reg_alu['apellidos'].', '.$reg_alu['nombre'].'</option>';
			}
		else
			{
			echo '<option value="'.$reg_alu['codigo'].'">'.$reg_alu['apellidos'].', '.$reg_alu['nombre'].'</option>';
			}
		}
	}
echo '</select>';
echo '<br/>';echo '<br/>';
$oFCKeditor = new FCKeditor('area') ;
$oFCKeditor->ToolbarSet = 'mensaje';
$oFCKeditor->BasePath = 'fckeditor/';
$oFCKeditor->Value = $mensaje;
$oFCKeditor->Create() ;

echo '<br/>';
echo '<p class="centrado">';
echo '<a href="#" class="padding" onclick="enviaMensajeBorrador(\'e\',\''.$id.'\')" title="'.$id_enviar.'"><img src="imgs/enviados.png" alt="'.$id_enviar.'"/></a>';
echo '<a href="#" class="padding" onclick="enviaMensajeBorrador(\'b\',\''.$id.'\')" title="'.$id_borrador.'"><img src="imgs/borrador.png" alt="'.$id_borrador.'"/></a>';
echo '</p>';

echo '</form>';










}//fin sesión

?>
