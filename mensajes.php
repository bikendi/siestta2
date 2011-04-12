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

echo '<br /><span class="negrita"> '.$id_mismensajes.'</span>';

echo '<p class="centrado">';
echo '<span><a href="#" onclick="redactaMensaje()" title="'.$id_redactar.'"><img src="imgs/redactar.png" alt="'.$id_redactar.'"/></span>';echo '&nbsp;';
echo '<span><a href="#" onclick="recibidosMensaje()" title="'.$id_recibidos.'"><img src="imgs/recibidos.png" alt="'.$id_recibidos.'"/></span>';echo '&nbsp;';
echo '<span><a href="#" onclick="enviadosMensaje()" title="'.$id_enviados.'"><img src="imgs/enviados.png" alt="'.$id_enviados.'"/></span>';echo '&nbsp;';
echo '<span><a href="#" onclick="borradorMensaje()" title="'.$id_borradores.'"><img src="imgs/borrador.png" alt="'.$id_borradores.'"/></a></span>';
echo '</p>';

$accion=$_POST['accion'];
switch($accion)
{
case 'redacta':

echo '<form id="formulario" name="formulario" class="centrado">';
echo '<span class="negrita_cursiva">'.$id_asunto.':</span> <input type="text" id="asunto" name="asunto" size="40" /><br /><br />';
echo '<span class="negrita_cursiva">'.$id_destinatario.':</span> ';
$sel_doc=mysql_query("select docente,nombre,apellidos,especialidad from docentes order by especialidad,apellidos,nombre");
$num_doc=mysql_num_rows($sel_doc);
echo '<select onclick="muestraDest(\'d\')" id="sel_doc" name="destin_doc">';
echo '<option value="0">'.$id_doc.'</option>';
echo '<option class="negrita_cursiva" value="*">'.$id_todos_doc.'</option>';
for($d=0;$d<$num_doc;$d++)
	{
	$reg_doc=mysql_fetch_array($sel_doc);
	echo '<option value="'.$reg_doc['docente'].'">['.$reg_doc['especialidad'].'] '.$reg_doc['nombre'].' '.$reg_doc['apellidos'].'</option>';
	}
echo '</select>';
$sel_agr=mysql_query("select agrupamiento from agrupamientos where docente='$docente'");
$num_agr=mysql_num_rows($sel_agr);
echo '<select onclick="muestraDest(\'f\')" id="sel_fam" name="destin_fam">';
echo '<option value="0">'.$id_familia.'</option>';
echo '<option class="negrita_cursiva" value="*f">'.$id_todos_fam.'</option>';
for($a=0;$a<$num_agr;$a++)
	{
	$reg_agr=mysql_fetch_array($sel_agr);
	$agr=$reg_agr['agrupamiento'];
	echo '<option class="negrita_cursiva">'.$agr.'</option>';
	$sel_alu=mysql_query("select matricula.codigo,matricula.agrupamiento,alumnado.codigo,alumnado.nombre,alumnado.apellidos from alumnado,matricula where matricula.agrupamiento='$agr' and matricula.codigo=alumnado.codigo order by alumnado.apellidos,alumnado.nombre");
	$num_alu=mysql_num_rows($sel_alu);
	for($b=0;$b<$num_alu;$b++)
		{
		$reg_alu=mysql_fetch_array($sel_alu);
		echo '<option value="'.$reg_alu['codigo'].'">'.$reg_alu['apellidos'].', '.$reg_alu['nombre'].'</option>';
		}
	}
echo '</select>';
echo '<br/>';echo '<br/>';
$oFCKeditor = new FCKeditor('area') ;
$oFCKeditor->ToolbarSet = 'mensaje';
$oFCKeditor->BasePath = 'fckeditor/';
$oFCKeditor->Value = 'Escribe aqu&iacute;';
$oFCKeditor->Create() ;

echo '<br/>';
echo '<p class="centrado">';
echo '<a href="#" class="padding" onclick="enviaMensaje(\'e\')" title="'.$id_enviar.'"><img src="imgs/enviados.png" alt="'.$id_enviar.'"/></a>';
echo '<a href="#" class="padding" onclick="enviaMensaje(\'c\')" title="'.$id_cancelar.'"><img src="imgs/cancelar.png" alt="'.$id_cancelar.'"/></a>';
echo '<a href="#" class="padding" onclick="enviaMensaje(\'b\')" title="'.$id_borrador.'"><img src="imgs/borrador.png" alt="'.$id_borrador.'"/></a>';
echo '</p>';

echo '</form>';

break;

case 'envia':
$asunto = $_POST['asunto'];
$destin_doc = $_POST['destin_doc'];
$destin_fam = $_POST['destin_fam'];
if($destin_doc == '0' && $destin_fam != '*'){$destino = $destin_fam;$tipo='f';}
if($destin_doc == '0' && $destin_fam == '*'){$destino = $destin_fam;$tipo='tf';}
if($destin_fam == '0' && $destin_doc != '*'){$destino = $destin_doc;$tipo='d';}
if($destin_fam == '0' && $destin_doc == '*'){$destino = $destin_doc;$tipo='td';}
$texto = $_POST['texto'];
$mensaje_pre = str_replace("[igual]","=",$texto);
$mensaje = str_replace("~inte~","?",$mensaje_pre);

$datetime = date('Y-m-d H:i:s');

$ins = mysql_query("insert into mensajes values('','$docente','$destino','$asunto','$mensaje','0','0','$datetime','$tipo','0','0')");
if($_POST['idb'])
	{
	$id_borr=$_POST['idb'];
	$eli_borr=mysql_query("delete from mensajes where id='$id_borr'");
	}
if($ins)
	{
	echo '<p class="centrado">'.$id_mensaje_enviado.'</p>';
	}
else
	{
	echo '<p class="centrado">'.$id_mensaje_no_enviado.'</p>';
	}
break;

case 'borrador':
$asunto = $_POST['asunto'];
$destin_doc = $_POST['destin_doc'];
$destin_fam = $_POST['destin_fam'];
if($destin_doc == '0' && $destin_fam != '*'){$destino = $destin_fam;$tipo='f';}
if($destin_doc == '0' && $destin_fam == '*'){$destino = $destin_fam;$tipo='tf';}
if($destin_fam == '0' && $destin_doc != '*'){$destino = $destin_doc;$tipo='d';}
if($destin_fam == '0' && $destin_doc == '*'){$destino = $destin_doc;$tipo='td';}
$texto = $_POST['texto'];
$mensaje_pre = str_replace("[igual]","=",$texto);
$mensaje = str_replace("~inte~","?",$mensaje_pre);
$datetime = date('Y-m-d H:i:s');
if($_POST['idb'])
	{
	$id_borr=$_POST['idb'];
	$act_borr=mysql_query("update mensajes set destinatario='$destino',asunto='$asunto',mensaje='$mensaje',tipo='$tipo',fecha='$datetime' where id='$id_borr'");
	}
else
	{
	$ins = mysql_query("insert into mensajes values('','$docente','$destino','$asunto','$mensaje','0','1','$datetime','$tipo','0','0')");
	}
if($ins)
	{
	echo '<p class="centrado">'.$id_borrador_guardado.'</p>';
	}
else
	{
	echo '<p class="centrado">'.$id_borrador_no_guardado.'</p>';
	}
break;

case 'recibidos':
$sel_recib = mysql_query("select * from mensajes where destinatario='$docente' and borrador='0' and ocultorec='0' or destinatario='*' and remitente != '$docente' and borrador='0' and tipo = 'td' and ocultorec='0' order by fecha desc");
$num_recib = mysql_num_rows($sel_recib);
if($num_recib>0)
{
echo '<p class="texto_centrado"> '.$id_recibidos.'</p><br />'; 
echo '<table class="tablacentrada">';
echo '<tr class="encab">';
echo '<td>'.$id_accion.'</td><td>'.$id_remitente.'</td><td>'.$id_asunto.'</td><td>'.$id_fecha.'</td>';
echo '<tr>';
for($m=0;$m<$num_recib;$m++)
	{
        $reg_recib=mysql_fetch_array($sel_recib);
        $id=$reg_recib['id'];
	//veo si lo tengo "eliminado" en la tabla mensajes
	$sel_TM = mysql_query("select * from todosmensajes where id='$id' and destinatario='$docente'");
	if(mysql_num_rows($sel_TM)==0)
	{
       	if($m%2==0)echo '<tr class="par">';else echo '<tr>';
	$remitente=$reg_recib['remitente'];
	$tipo=$reg_recib['tipo'];
	
		$sel_doc=mysql_query("select nombre,apellidos from docentes where docente='$remitente'");
		if(mysql_num_rows($sel_doc)>0)
			{
			$reg_doc=mysql_fetch_array($sel_doc);
			$nombre_remit=$reg_doc['nombre'];
			$apellidos_remit=$reg_doc['apellidos'];
			}
		else
			{
			$sel_alu=mysql_query("select nombre,apellidos from alumnado where codigo='$remitente'");
			$reg_alu=mysql_fetch_array($sel_alu);
			$nombre_remit=$reg_alu['nombre'];
			$apellidos_remit=$reg_alu['apellidos'];
			}
	$asunto=$reg_recib['asunto'];
	$mensaje=$reg_recib['mensaje'];
	$lectura=$reg_recib['lectura'];
	$fecha=$reg_recib['fecha'];
	$oculto=$reg_recib['ocultorec'];
	$fecha_string=strtotime($fecha);
	$fecha_esp=date('d-m-Y H:i:s',$fecha_string);
	echo '<td class="centrado">';
	echo '<a href="#" onclick="eliminaRec(\''.$id.'\')" title="'.$id_eliminar.'"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'"/></a></td>';
	echo '<td class="justificado">'.$nombre_remit.' '.$apellidos_remit.'</td>';
	echo '<td class="justificado"><a href="#" onclick="new LITBox(\'mensaje_lee.php?id='.$id.'\', {type:\'window\', overlay:true, height:300, width:500, resizable:true});" title="'.$id_leer.'">';
	if($lectura == '0')
		{
		echo ' <img src="imgs/nuevo.png" title="'.$id_mensaje_nuevo.'" alt="'.$id_mensaje_nuevo.'" class="alin_bajo" /> ';
		}
	else
		{
		echo ' <img src="imgs/leido.png" title="'.$id_mensaje_leido.'" alt="'.$id_mensaje_leido.'" class="alin_bajo" /> ';
		}
	echo $asunto;
	echo '</a></td>';
	echo '<td>'.$fecha_esp.'</td>';
	echo '</tr>';
        }//fin if TM
	}
echo '</table>';
}
else
{
echo '<p class="texto_centrado">'.$id_nomensajes_rec.'</p>';
}
break;

case 'eliminarec':
$id=$_POST['id'];
//veo si es para todos
$sel_todos=mysql_query("select destinatario from mensajes where id='$id' and destinatario='*'");
if(mysql_num_rows($sel_todos)>0)
	{
	$ins_mentodos=mysql_query("insert into todosmensajes values('$id','$docente')");
	}
else
	{
	$act=mysql_query("update mensajes set ocultorec='1' where id='$id'");
	}
if($act || $ins_mentodos)
	{
	echo '<p class="centrado">'.$id_mensaje_elim.'</p>';
	}
else
	{
	echo '<p class="centrado">'.$id_mensaje_no_elim.'</p>';
	}
break;

case 'eliminaenv':
$id=$_POST['id'];
$act=mysql_query("update mensajes set ocultoenv='1' where id='$id'");
if($act)
	{
	echo '<p class="centrado">'.$id_mensaje_elim.'</p>';
	}
else
	{
	echo '<p class="centrado">'.$id_mensaje_no_elim.'</p>';
	}
break;

case 'eliminatotal':
$id=$_POST['id'];
$act=mysql_query("delete from mensajes where id='$id'");
if($act)
	{
	echo '<p class="centrado">'.$id_mensaje_elim.'</p>';
	}
else
	{
	echo '<p class="centrado">'.$id_mensaje_no_elim.'</p>';
	}
break;

case 'enviados':
$sel_env = mysql_query("select * from mensajes where remitente='$docente' and ocultoenv= '0' order by fecha desc");
$num_env = mysql_num_rows($sel_env);
if($num_env>0)
{
echo '<p class="texto_centrado">'.$id_enviados.'</p><br />';
echo '<table class="tablacentrada">';
echo '<tr class="encab">';
echo '<td>'.$id_accion.'</td><td>'.$id_destinatario.'</td><td>'.$id_asunto.'</td><td>'.$id_fecha.'</td>';
for($m=0;$m<$num_env;$m++)
	{
	if($m%2==0)echo '<tr class="par">';else echo '<tr>';
	$reg_env=mysql_fetch_array($sel_env);
	$id=$reg_env['id'];
	$destinatario=$reg_env['destinatario'];
	$tipo=$reg_env['tipo'];
	switch($tipo)
		{
		case 'd':	
		$sel_doc=mysql_query("select nombre,apellidos from docentes where docente='$destinatario'");
		$reg_doc=mysql_fetch_array($sel_doc);
		$nombre_dest=$reg_doc['nombre'];
		$apellidos_dest=$reg_doc['apellidos'];
		break;
		case 'td':
		$nombre_dest=$id_todos_doc;
                $apellidos_dest='';
		break;
		case 'f':
		$sel_alu=mysql_query("select nombre,apellidos from alumnado where codigo='$destinatario'");
		if(mysql_num_rows($sel_alu)>0)
			{
			$reg_alu=mysql_fetch_array($sel_alu);
			$nombre_dest=$reg_doc['nombre'];
			$apellidos_dest=$reg_doc['apellidos'];
			}
		else
			{
			$nombre_dest=''.$id_todos_fam.' ('.$destinatario.')';
			}
		break;
		case 'tf':
		$nombre_dest=$id_todos_fam;
		break;
		}
	$asunto=$reg_env['asunto'];
	$mensaje=$reg_env['mensaje'];
	$oculto=$reg_env['ocultoenv'];
	$fecha=$reg_env['fecha'];
	$fecha_string=strtotime($fecha);
	$fecha_esp=date('d-m-Y H:i:s',$fecha_string);
	echo '<td class="centrado">';
	echo '<a href="#" onclick="eliminaEnv(\''.$id.'\')" title="'.$id_eliminar.'"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'"/></a></td>';
	echo '<td class="justificado">'.$nombre_dest.' '.$apellidos_dest.'</td>';
	echo '<td class="justificado"><a href="#" onclick="new LITBox(\'mensaje_lee.php?id='.$id.'\', {type:\'window\', overlay:true, height:300, width:500, resizable:true});" title="'.$id_leer.'">'.$asunto.'</a></td>';
	echo '<td>'.$fecha_esp.'</td>';
	echo '</tr>';
	}
echo '</table>';
}
else
{
echo '<p class="texto_centrado">'.$id_nomensajes_env.'</p>';
}
break;

case 'listaborrador':
$sel_borr = mysql_query("select * from mensajes where remitente='$docente' and borrador='1' order by fecha desc");
$num_borr = mysql_num_rows($sel_borr);
if($num_borr>0)
{
echo '<p class="texto_centrado">'.$id_borradores.'</p><br />';
echo '<table class="tablacentrada">';
echo '<tr class="encab">';
echo '<td>'.$id_accion.'</td><td>'.$id_destinatario.'</td><td>'.$id_asunto.'</td><td>'.$id_fecha.'</td>';
for($m=0;$m<$num_borr;$m++)
	{
	if($m%2==0)echo '<tr class="par">';else echo '<tr>';
	$reg_borr=mysql_fetch_array($sel_borr);
	$id=$reg_borr['id'];
	$destinatario=$reg_borr['destinatario'];
	$tipo=$reg_borr['tipo'];
		switch($tipo)
		{
		case 'd':	
		$sel_doc=mysql_query("select nombre,apellidos from docentes where docente='$destinatario'");
		$reg_doc=mysql_fetch_array($sel_doc);
		$nombre_dest=$reg_doc['nombre'];
		$apellidos_dest=$reg_doc['apellidos'];
		break;
		case 'td':
		$nombre_dest=$id_todos_doc;
		break;
		case 'f':
		$sel_alu=mysql_query("select nombre,apellidos from alumnado where codigo='$destinatario'");
		if(mysql_num_rows($sel_alu)>0)
			{
			$reg_alu=mysql_fetch_array($sel_alu);
			$nombre_dest=$reg_doc['nombre'];
			$apellidos_dest=$reg_doc['apellidos'];
			}
		else
			{
			$nombre_dest=''.$id_todos_fam.' ('.$destinatario.')';
			}
		break;
		case 'tf':
		$nombre_dest=$id_todos_fam;
		break;
		}
	$asunto=$reg_borr['asunto'];
	$mensaje=$reg_borr['mensaje'];
	$mensaje_f=htmlspecialchars($mensaje);
	$fecha=$reg_borr['fecha'];
	$fecha_string=strtotime($fecha);
	$fecha_esp=date('d-m-Y H:i:s',$fecha_string);
	echo '<td class="centrado"><a href="#" onclick="eliminaMensajeTotal(\''.$id.'\')" title="'.$id_eliminar.'"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'"/></a></td>';
	echo '<td class="justificado">'.$nombre_dest.' '.$apellidos_dest.'</td>';
	echo '<td class="justificado"><a href="#" onclick="new LITBox(\'mensaje_borr.php?asunto='.$asunto.'&tipo='.$tipo.'&destinatario='.$destinatario.'&mensaje='.$mensaje_f.'&id='.$id.'\', {type:\'window\', overlay:true, height:400, width:700, resizable:true});" title="'.$id_leer.'">'.$asunto.'</a></td>';
	echo '<td>'.$fecha_esp.'</td>';
	echo '</tr>';
	}
echo '</table>';
}
else
{
echo '<p class="texto_centrado">'.$id_nomensajes_borr.'</p>';
}
break;

}//fin switch($accion)


}//fin if hay sesión








