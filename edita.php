<?php

session_start();
//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
$docente1=$_SESSION['usuario_sesion'];
//conecto con MySQL
conecta();
//recogemos la información cargando la variable
$value=$_POST['value'];
$docente = $_GET['docente'];
$campo = $_GET['campo'];
$accion = $_POST['p1'];

$activ_ant = $_GET['activ_ant'];
$agrup_ant = $_GET['agrup_ant'];
$per_ant = $_GET['per_ant'];

$citafranja = $_GET['citafranja'];
$citadia = $_GET['citadia'];
$citacaracter = $_GET['citacaracter'];
$citafecha = $_GET['citafecha'];

$id = $_GET['id'];
$tabla = $_GET['tabla'];

if($id && $tabla == 'recuperaciones')
	{
	$agrupamiento = $_GET['agrupamiento'];
	$sel_agr = mysql_query("select agrupamiento from agrupamientos where agrupamiento = '$agrupamiento' and docente = '$docente1'");
	if(mysql_num_rows($sel_agr)>0)
		{
		$codigo = $_GET['codigo'];
		$tipo = $_GET['tipo'];
		switch ($tipo)
			{
			case 'edita':
			if($value=='')
				{
				$del = mysql_query("delete from recuperaciones where periodo='$id' and agrupamiento='$agrupamiento' and codigo='$codigo'");
				echo $id_recu_elim; 
				}
			else
				{
				$act = mysql_query("update recuperaciones set ".$campo."='$value' where periodo='$id' and agrupamiento='$agrupamiento' and codigo='$codigo'");
				echo $value;
				}
			break;
			case 'inserta':
			$ins = mysql_query("insert into recuperaciones values ('$id','$agrupamiento','$codigo','$value')");
			echo $value;
			break;
			}
		}
	}
	
if($id && $tabla == 'notas_rev')
	{
	$agrupamiento = $_GET['agrupamiento'];
	$sel_agr = mysql_query("select agrupamiento from agrupamientos where agrupamiento = '$agrupamiento' and docente = '$docente1'");
	if(mysql_num_rows($sel_agr)>0)
		{
		$codigo = $_GET['codigo'];
		$tipo = $_GET['tipo'];
		switch ($tipo)
			{
			case 'edita':
			if($value=='')
				{
				$del = mysql_query("delete from notas_rev where periodo='$id' and agrupamiento='$agrupamiento' and codigo='$codigo'");
				//echo $id_recu_elim; 
				}
			else
				{
				$act = mysql_query("update notas_rev set ".$campo."='$value' where periodo='$id' and agrupamiento='$agrupamiento' and codigo='$codigo'");
				echo $value;
				}
			break;
			case 'inserta':
			$ins = mysql_query("insert into notas_rev values ('','$agrupamiento','$codigo','$id','$value')");
			echo $value;
			break;
			}
		}
	}

if($id && $tabla == 'evaluacion')
	{
	$act = mysql_query("update evaluacion set ".$campo."='$value' where id='$id'");
	echo $value;
	}

if($id && $tabla == 'notas')
	{
	if($_GET['tipo']=='fecha')
		{
		$fecha_esp = cambia_fecha_a_ing($value);
		$act=mysql_query("update notas set fecha='$fecha_esp' where id='$id'");
		}
	else
		{
		$act=mysql_query("update notas set ".$campo."='$value' where id='$id'");
		}
	echo $value;
	}
if($id && $tabla == 'tareas')
	{
	if($_GET['tipo']=='fecha')
		{
		$fecha_esp = cambia_fecha_a_ing($value);
		$act=mysql_query("update tareas set ".$campo."='$fecha_esp' where id='$id'");
		}
	else
		{
		$act=mysql_query("update tareas set ".$campo."='$value' where id='$id'");
		}
	echo $value;
	}
if($id && $tabla == 'observaciones')
	{
	if($_GET['tipo']=='fecha')
		{
		$fecha_esp = cambia_fecha_a_ing($value);
		$act=mysql_query("update observaciones set ".$campo."='$fecha_esp' where id='$id'");
		}
	else
		{
		$act=mysql_query("update observaciones set ".$campo."='$value' where id='$id'");
		}
	echo $value;
	}


if($docente && $value && $campo &&!$citafranja)
	{
	$act=mysql_query("update docentes set ".$campo."='$value' where docente='$docente'");
	echo $value;
	}//fin $docente y demás

if($docente && $citafranja && $citadia && $citacaracter)
	{
	$sel=mysql_query("select * from agenda where docente='$docente' and franja='$citafranja' and dia='$citadia' and fecha='$citafecha'");
	if(mysql_num_rows($sel)>0)
		{
		if(!$value)
			{
			$eli=mysql_query("delete from agenda where docente='$docente' and franja='$citafranja' and dia='$citadia' and fecha='$citafecha'");
			echo $id_citaeli;
			}
		else
			{
			$act=mysql_query("update agenda set ".$citacaracter."='$value' where docente='$docente' and franja='$citafranja' and dia='$citadia' and fecha='$citafecha'");
			echo $value;
			}
		}
	else
		{
		if($citacaracter=='publico')
			{
			$ins=mysql_query("insert into agenda values('$docente','$citafranja','$citadia','$citafecha','$value','')");
			echo $value;
			}
		else
			{
			$ins=mysql_query("insert into agenda values('','$docente','$citafranja','$citadia','$citafecha','$value','$id_abr_privado')");
			echo $value;
			}
		}
	}

if($activ_ant && $agrup_ant & $value)
	{
	$act=mysql_query("update actividades set ".$campo."='$value' where actividad='$activ_ant' and agrupamiento='$agrup_ant'");
	if($act)
		{
		echo $value;
		}
	else
		{
		echo $id_error_activ;
		}
	}//fin $actividades y demás

switch($accion)
	{
	case 'clave':
	$clave = $_POST['clave'];
	$docente = $_POST['docente'];
	$clave_cript = crypt($clave,'siestta');
	$actualiza_clave = mysql_query("update docentes set clave='$clave_cript' where docente='$docente'");
	if($actualiza_clave)
		{
		echo '<p class="texto">'.$id_reg_exito.'</p>';
		}
		else
		{
		echo '<p class="texto">'.$id_error_ins.'</p>';
		}
	break;
	}//fin switch

}//fin if sesión

?>