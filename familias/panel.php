<?php

session_start();

/*///////////////////////////////////////////////////////////////////////////////////////////////////////////
///Este archivo es parte de SIESTTA 2.0 y forma parte del él. Por tanto, es aplicable////////////////////////
///su licencia GNU GPL///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Aplicación: SIESTTA 2.0 (Solución Informática Especializada en el Seguimiento TuTorial del Alumnado)//////
///Web del proyecto: http://siestta.org//////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Autor: Ramón Castro Pérez/////////////////////////////////////////////////////////////////////////////////
///Web: http://ramoncastro.es////////////////////////////////////////////////////////////////////////////////
///Mail: ramoncastroperez@gmail.com//////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Esta aplicación es software libre: puede redistribuirlo y/o modificarlo///////////////////////////////////
///bajo los términos de la GNU General Public License publicada por la///////////////////////////////////////
///Free Software Foundation, en su versión 3 o posterior/////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Este programa es distribuido con la intención de que sea útil, pero sin///////////////////////////////////
///ninguna garantía. Vea los términos de la licencia GNU GPL para más detalles///////////////////////////////
///Puede encontrar la licencia en http://www.gnu.org/copyleft/gpl.es.html////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///SIESTTA 2.0 usa://////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///PHP -> http://php.net							/////////////////////////////
///MySQL -> http://www.mysql.com/						/////////////////////////////
///FPDF -> http://www.fpdf.org/						        /////////////////////////////      
///html2pdf -> http://html2fpdf.sourceforge.net/				/////////////////////////////
///AJAX -> http://es.wikipedia.org/wiki/Ajax 					/////////////////////////////
///Prototype -> http://www.prototypejs.org/					/////////////////////////////
///Scriptaculous -> http://script.aculo.us/					/////////////////////////////
///LitBox -> http://www.ryanjlowe.com/?p=9					/////////////////////////////
///FCK Editor -> http://www.fckeditor.net/					/////////////////////////////
///Dropline Neu -> http://www.silvestre.com.ar/					/////////////////////////////
///Tango Desktop Project -> http://tango.freedesktop.org/Tango_Desktop_Project	/////////////////////////////
///CSS Easy -> http://www.csseasy.com/						/////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////*/ 

//incluimos funciones,configuración e idioma
include('../funciones.php');
require('../config.php');
require('../idioma/'.$idioma.'');

//conectamos con MySQL
conecta();

//comprobamos usuario y clave
if (isset($_POST['numero']) && isset($_POST['clave']))
	{
	$familia = $_POST['numero'];
	$clave = $_POST['clave'];
	$sel_familia = mysql_query("select * from familias where codigo = '$familia' and clave = '$clave'");
	 
	 if(mysql_num_rows($sel_familia) > 0)
	 	{
	 	$sel_datos = mysql_query("select * from alumnado where codigo = '$familia'");
		$reg_datos = mysql_fetch_array($sel_datos);
	 	$nombre = $reg_datos['nombre'];
	 	$apellidos = $reg_datos['apellidos'];
	 	$grupo = $reg_datos['grupo']; 
		$f_nac = $reg_datos['f_nac'];
		$f_nac_esp = cambia_fecha_a_esp($f_nac);	 	
	 	$_SESSION['familia_sesion'] = $familia;
	 	$_SESSION['grupo_sesion'] = $grupo;
		$_SESSION['nombre_sesion']=$nombre;
		$_SESSION['apellidos_sesion']=$apellidos;
		$_SESSION['fnac_sesion']=$f_nac_esp;
		}
	else
		{
		echo '<p class="centradomedio">'.$mensaje_error.'</p>';
		}
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo 'SIESTTA 2.0: '.$nombre_centro.''; ?></title>
<link href="index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function faltasMes(){
var mes=document.meses.mes.value;
document.location.href="panel.php?accion=faltas_todas&mes="+mes+"";
}
function eliMen(accion,agrupamiento,id){
	if( ! confirm("¿Desea eliminar este mensaje?") ) {
                return false;
            }
	document.location.href="panel.php?accion="+accion+"&agrupamiento="+agrupamiento+"&id="+id+"";
}
function enviaMen(agrupamiento){
	var destinatario = document.mensaje.list_mat.value;
	if(destinatario == '0')
		{
		alert('Debes especificar un destinatario. El mensaje no se enviará');
		exit;
		}
	else
		{
		document.mensaje.action="panel.php?accion=mensajes&agrupamiento="+agrupamiento+"";
		document.mensaje.submit();
		}
}
</script>
</head>
<body>
<?php

$familia_activo = $_SESSION['familia_sesion'];

if (isset($_SESSION['familia_sesion']))
{
echo '<div id="header">';
//vamos a cargar la foto y algunos datos principales del alumno
if(file_exists('../admin/fotos_al/'.$familia_activo.'.jpg'))
	{
	$imagen = '../admin/fotos_al/'.$familia_activo.'.jpg';
	}
else
	{
	$imagen = '../admin/fotos_al/nofoto.jpg';
	}
echo '<table><tr><td><img id="foto" alt="Foto" src="'.$imagen.'" /></td>';
echo '<td>'.$nombre_centro.'<br />'.$dir_centro.'<br />';
echo '<br />'.$id_nom.': '.$_SESSION['nombre_sesion'].'';
echo '<br />'.$id_ape.': '.$_SESSION['apellidos_sesion'].'';
echo '<br />'.$id_fna.': '.$_SESSION['fnac_sesion'].'';
echo '<br />'.$id_gru.': '.$_SESSION['grupo_sesion'].'';
echo '<br /><a href="../salir.php" title="'.$id_descon.'"><img id="salir" src="../imgs/salir.png" alt="'.$id_descon.'" /></a>';
echo '</td></tr></table>';
//al otro lado, el textarea para enviar mensajes a los docentes

echo '</div>';
//echo '<div id="top">';
//aquí voy a poner los avisos
//echo '</div>';
echo '<div id="center">';
$accion = $_GET['accion'];
$agrup = $_GET['agrupamiento'];
//si acabo de llegar
if(!$accion)
	{
	echo '<br />';
	echo '<form name="meses"><p class="centrado">';
	echo ''.$id_inf_asi.' '.$id_mes.': ';
	echo '<select name="mes" onchange="javascript:faltasMes()"><option value="'.date('m').'">'.nombre_mes(date('M')).'</option>';
	for($m=1;$m<13;$m++)
		{
		echo '<option value="'.$m.'">'.nombre_mes2(date($m)).'</option>';
		}
	echo '</select>';
	echo '</p></form>';
	echo '<table style="margin:auto;"><tr class="encab">';
	echo '<td>'.$id_mat.'</td>';
	for($d=1;$d<32;$d++)
		{
		echo '<td>'.$d.'</td>';
		}
	echo '</tr>';
	$sel_materias = mysql_query("select agrupamientos.materia,agrupamientos.agrupamiento from agrupamientos,matricula where matricula.codigo = '$familia_activo' and matricula.agrupamiento = agrupamientos.agrupamiento");
	for($m=0;$m<(mysql_num_rows($sel_materias));$m++)
		{
		if($m%2==0){echo '<tr class="par">';}else{echo '<tr class="impar">';}
		$reg_materia = mysql_fetch_array($sel_materias);
		$agrupamiento = $reg_materia['agrupamiento'];
		echo '<td>'.$reg_materia['materia'].'</td>';
		for($d=1;$d<32;$d++)
			{
			//monto fecha del mes actual
			$fecha = ''.date('Y').'-'.date('m').'-'.$d.'';
			//veo si hay datos de asistencia
			$sel_dato = mysql_query("select hini,dato from asistencia where codigo = '$familia_activo' and fecha = '$fecha' and agrupamiento = '$agrupamiento'");
			echo '<td class="centrado2">';
			if(mysql_num_rows($sel_dato)>0)
				{
				for($da=0;$da<(mysql_num_rows($sel_dato));$da++)
					{
					$reg_dato = mysql_fetch_array($sel_dato);
					$dato = $reg_dato['dato'];
					$hini = $reg_dato['hini'];
					echo '<a href="#" title="'.$hini.'">'.$dato.'</a>';
					}
				}
			echo '</td>';
			}
		echo '</tr>';
		}
	echo '</table>';
	//ahora pongo aquí otra información relevante
	//una tabla: por filas, las materias; por columnas:
		//faltas
		//justificadas
		//retrasos
		//examenes 
		//nota hasta el momento
		//mensajes 
		//tareas 
		//incidencias 
	$hoy = date('Y-m-d');
	$sel_per = mysql_query("select * from periodos where '$hoy' between inicio and fin");
	if(mysql_num_rows($sel_per)>0)
		{
		$reg_per = mysql_fetch_array($sel_per);
		$per=$reg_per['periodo'];
		$fecha_ini = $reg_per['inicio'];
		$fecha_fin = $reg_per['fin'];
		$nombre_per = $reg_per['nombre'];
		}
	echo '<p class="centrado">'.$id_resumen.'</p>';
	echo '<table style="margin:auto;">';
	echo '<tr class="encab">';
	echo '<td>'.$id_inf_Bol.'</td>';
	echo '<td>'.$id_mat.'</td>';
	echo '<td>'.$id_calificacion.'<br />'.$nombre_per.'</td>';
	echo '<td>'.$id_inf_asi.'</td>';
	echo '<td>'.$id_mismensajes.'</td>';
	echo '<td>'.$id_tareas.'</td>';
	echo '<td>'.$id_inf_obs.'</td>';
	echo '<td>'.$id_inf_exa.'</td>';
	echo '</tr>';
	//vamos materia por materia
	$sel_materias = mysql_query("select agrupamientos.materia,agrupamientos.agrupamiento from agrupamientos,matricula where matricula.codigo = '$familia_activo' and matricula.agrupamiento = agrupamientos.agrupamiento");
	for($m=0;$m<(mysql_num_rows($sel_materias));$m++)
		{
		if($m%2==0){echo '<tr class="par">';}else{echo '<tr class="impar">';}
		$reg_materia = mysql_fetch_array($sel_materias);
		$agrupamiento = $reg_materia['agrupamiento'];
		echo '<td class="centrado">';
		echo '<a title="'.$id_gen_bol.'" href="../pdf/ficha_pdf.php?p1='.$familia_activo.'&p2='.$agrupamiento.'&p3=boletin&p4='.$_SESSION['nombre_sesion'].'&p5='.$_SESSION['apellidos_sesion'].'" target="_blank"><img src="../imgs/informe.png" alt="'.$id_gen_bol.'" /></a>';
		echo '</td>';
		echo '<td>'.$reg_materia['materia'].'</td>';
		echo '<td class="centrado">';//notas
		//colocamos el aviso por si hoy se ha registrado alguna nota
		$sel_not_hoy = mysql_query("select nota from notas where codigo='$familia_activo' and agrupamiento='$agrupamiento' and fecha='$hoy'");
		if(mysql_num_rows($sel_not_hoy)>0)
			{
			echo '<img src="../imgs/nuevo.gif" alt="'.$id_hay_notas_hoy.'" title="'.$id_hay_notas_hoy.'" />';
			echo '&nbsp;';
			echo '&nbsp;';
			}
		//fin aviso
		if(mysql_num_rows($sel_per)>0)
			{
			$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agrupamiento'");
			$num_activ = mysql_num_rows($sel_activ);
			for($a=0;$a<$num_activ;$a++)
				{
				$reg_activ = mysql_fetch_array($sel_activ);
				$activ = $reg_activ['actividad'];
				$pond = $reg_activ['ponderacion'];
				$sel_notas = mysql_query("select avg(nota) from notas where codigo='$familia_activo' and agrupamiento='$agrupamiento' and actividad='$activ' and fecha between '$fecha_ini' and '$fecha_fin'");
				$hay_nota=mysql_num_rows($sel_notas);
				if($hay_nota>0)
					{
					$reg_nota = mysql_fetch_array($sel_notas);
					$nota_media = $reg_nota['avg(nota)'];
					$nota_pond = ($nota_media*$pond)/100;
					$matriz_notas_pond[]=$nota_pond;
					}
				}
			if(count($matriz_notas_pond)>0)
				{
				$nota_media = array_sum($matriz_notas_pond);
				$nota_media_red = round($nota_media,2);
				echo '<a class="ver" href="panel.php?accion=notas&agrupamiento='.$agrupamiento.'" title="'.$id_todas_notas.'">'.$nota_media_red.'</a>';
				//si hay nota revisada
			$sel_notas_rev=mysql_query("select * from notas_rev where codigo='$familia_activo' and agrupamiento='$agrupamiento' and periodo='".$per."'");
			if(mysql_num_rows($sel_notas_rev)>0)
				{
				$reg_notas_rev=mysql_fetch_array($sel_notas_rev);
				echo '<br/>Calificación final: '.$nota_rev=$reg_notas_rev['nota'].'';
				}
				}
				
			unset($matriz_notas_pond);
			
			}//fin if periodo de evaluación
		echo '</td>';//fin notas
		echo '<td>';//asistencia
		//contamos las faltas
		$sel_faltas = mysql_query("select dato from asistencia where codigo='$familia_activo' and agrupamiento = '$agrupamiento' and dato='f'");
		$num_faltas = mysql_num_rows($sel_faltas);
		$sel_retrasos = mysql_query("select dato from asistencia where codigo='$familia_activo' and agrupamiento = '$agrupamiento' and dato='r'");
		$num_retrasos = mysql_num_rows($sel_retrasos);
		$sel_justif = mysql_query("select dato from asistencia where codigo='$familia_activo' and agrupamiento = '$agrupamiento' and dato='j'");
		$num_justif = mysql_num_rows($sel_justif);
		echo '<a class="ver" href="panel.php?accion=faltas&agrupamiento='.$agrupamiento.'" title="'.$id_todas_faltas.'">F: '.$num_faltas.' J: '.$num_justif.' R: '.$num_retrasos.'</a>';
		echo '</td>';//fin asistencia
		echo '<td class="centrado">';//mensajes
		//colocamos el aviso por si hay mensajes sin leer
		$sel_men_noleidos = mysql_query("select mensajes.id from mensajes,agrupamientos where mensajes.destinatario = '*f' and mensajes.remitente = agrupamientos.docente and agrupamientos.agrupamiento = '$agrupamiento' and ocultorec='0' and lectura='0' and borrador = '0' or mensajes.destinatario = '$agrupamiento' and mensajes.remitente = agrupamientos.docente and agrupamientos.agrupamiento = '$agrupamiento' and lectura='0' and ocultorec='0' and borrador = '0' or mensajes.destinatario = '$familia_activo' and mensajes.remitente = agrupamientos.docente and agrupamientos.agrupamiento = '$agrupamiento' and lectura='0' and borrador = '0' and ocultorec='0'");
		if(mysql_num_rows($sel_men_noleidos)>0)
			{
			echo '<img src="../imgs/nuevo.gif" alt="'.$id_mensajes_nuevos.'" title="'.$id_mensajes_nuevos.'" />';
			echo '&nbsp;';
			echo '&nbsp;';
			}
		//fin aviso
		//contamos los mensajes por remitente
		$sel_men = mysql_query("select mensajes.id from mensajes,agrupamientos where mensajes.destinatario = '*f' and mensajes.remitente = agrupamientos.docente and mensajes.ocultorec='0' and agrupamientos.agrupamiento = '$agrupamiento' or mensajes.destinatario = '$agrupamiento' and mensajes.remitente = agrupamientos.docente and mensajes.ocultorec='0' and agrupamientos.agrupamiento = '$agrupamiento' or mensajes.destinatario = '$familia_activo' and mensajes.remitente = agrupamientos.docente and mensajes.ocultorec='0' and agrupamientos.agrupamiento = '$agrupamiento'");
		echo '<a class="ver" href="panel.php?accion=mensajes&agrupamiento='.$agrupamiento.'" title="'.$id_todos_mensajes.'">'.mysql_num_rows($sel_men).'</a>';
		echo '</td>';//fin mensajes
		echo '<td class="centrado">';//tareas
		//colocamos el aviso por si hay tareas pendientes
		$sel_tar_pend = mysql_query("select id from tareas where codigo='$familia_activo' and agrupamiento='$agrupamiento' and fecha_ent > '$hoy'");
		$sel_tar_gen_pend = mysql_query("select distinct agenda.id from agenda,horario,agrupamientos where agrupamientos.agrupamiento = '$agrupamiento' and agrupamientos.docente = agenda.docente and horario.franja = agenda.franja and horario.dia = agenda.dia and agenda.tipo = 't' and horario.sesion = '$agrupamiento' and agenda.fecha > '$hoy'");
		if(mysql_num_rows($sel_tar_pend)>0 || mysql_num_rows($sel_tar_gen_pend)>0)
			{
			echo '<img src="../imgs/nuevo.gif" alt="'.$id_tareas_pendientes.'" title="'.$id_tareas_pendientes.'" />';
			echo '&nbsp;';
			echo '&nbsp;';
			}
		//fin aviso
		//veamos las individuales
		$sel_tar = mysql_query("select id from tareas where codigo='$familia_activo' and agrupamiento='$agrupamiento'");
		//ahora las generales
		//$sel_tar_gen = mysql_query("select agenda.id from agenda,horario where horario.sesion = '$agrupamiento' and horario.franja = agenda.franja and horario.dia = agenda.dia and agenda.tipo = 't'");
		$sel_tar_gen = mysql_query("select distinct agenda.id from agenda,horario,agrupamientos where agrupamientos.agrupamiento = '$agrupamiento' and agrupamientos.docente = agenda.docente and horario.franja = agenda.franja and horario.dia = agenda.dia and agenda.tipo = 't' and horario.sesion = '$agrupamiento'");
		echo '<a class="ver" href="panel.php?accion=tareas&agrupamiento='.$agrupamiento.'" title="'.$id_todas_tareas.'">'.(mysql_num_rows($sel_tar)+mysql_num_rows($sel_tar_gen)).'</a>';
		echo '</td>';//fin tareas
		echo '<td class="centrado">';//observaciones
		$sel_obs = mysql_query("select id from observaciones where codigo = '$familia_activo' and agrupamiento = '$agrupamiento'");
		echo '<a class="ver" href="panel.php?accion=observaciones&agrupamiento='.$agrupamiento.'" title="'.$id_todas_observaciones.'">'.mysql_num_rows($sel_obs).'</a>';
		echo '</td>';//fin observaciones
		echo '<td class="centrado">';//exámenes
		$sel_exam = mysql_query("select distinct agenda.id from agenda,horario,agrupamientos where agrupamientos.agrupamiento = '$agrupamiento' and agrupamientos.docente = agenda.docente and horario.franja = agenda.franja and horario.dia = agenda.dia and agenda.tipo = 'e' and horario.sesion = '$agrupamiento'");
		echo '<a class="ver" href="panel.php?accion=exam&agrupamiento='.$agrupamiento.'" title="'.$id_todos_exam.'">'.mysql_num_rows($sel_exam).'</a>';
		echo '</td>';//fin exámenes
		echo '</tr>';
		}
	echo '</table><br />';
	}//fin no hay accion
switch($accion)
	{
	case 'faltas_todas':
	$mes=$_GET['mes'];
	echo '<br />';
	echo '<form name="meses"><p class="centrado">';
	echo ''.$id_inf_asi.' '.$id_mes.': ';
	echo '<select name="mes" onchange="javascript:faltasMes()"><option value="'.date('m').'">'.nombre_mes2(date($mes)).'</option>';
	for($m=1;$m<13;$m++)
		{
		echo '<option value="'.$m.'">'.nombre_mes2(date($m)).'</option>';
		}
	echo '</select>';
	echo '</p></form>';
	echo '<table style="margin:auto;"><tr class="encab">';
	echo '<td>'.$id_mat.'</td>';
	for($d=1;$d<32;$d++)
		{
		echo '<td>'.$d.'</td>';
		}
	echo '</tr>';
	$sel_materias = mysql_query("select agrupamientos.materia,agrupamientos.agrupamiento from agrupamientos,matricula where matricula.codigo = '$familia_activo' and matricula.agrupamiento = agrupamientos.agrupamiento");
	for($m=0;$m<(mysql_num_rows($sel_materias));$m++)
		{
		if($m%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		$reg_materia = mysql_fetch_array($sel_materias);
		$agrupamiento = $reg_materia['agrupamiento'];
		echo '<td>'.$reg_materia['materia'].'</td>';
		for($d=1;$d<32;$d++)
			{
			//veo si hay datos de asistencia
			$sel_dato = mysql_query("select hini,dato from asistencia where codigo = '$familia_activo' and month(fecha) = '$mes' and day(fecha) = '$d' and agrupamiento = '$agrupamiento'");
			echo '<td class="centrado2">';
			if(mysql_num_rows($sel_dato)>0)
				{
				for($da=0;$da<(mysql_num_rows($sel_dato));$da++)
					{
					$reg_dato = mysql_fetch_array($sel_dato);
					$dato = $reg_dato['dato'];
					$hini = $reg_dato['hini'];
					echo '<a href="#" title="'.$hini.'">'.$dato.'</a>';
					}
				}
			echo '</td>';
			}
		echo '</tr>';
		}
	echo '</table>';
	//ahora pongo aquí otra información relevante
	//una tabla: por filas, las materias; por columnas:
		//faltas
		//justificadas
		//retrasos
		//examenes 
		//nota hasta el momento
		//mensajes 
		//tareas 
		//incidencias 
	$hoy = date('Y-m-d');
	$sel_per = mysql_query("select * from periodos where '$hoy' between inicio and fin");
	if(mysql_num_rows($sel_per)>0)
		{
		$reg_per = mysql_fetch_array($sel_per);
		$fecha_ini = $reg_per['inicio'];
		$fecha_fin = $reg_per['fin'];
		$nombre_per = $reg_per['nombre'];
		}
	echo '<p class="centrado">'.$id_resumen.'</p>';
	echo '<table style="margin:auto;">';
	echo '<tr class="encab">';
	echo '<td>'.$id_inf_Bol.'</td>';
	echo '<td>'.$id_mat.'</td>';
	echo '<td>'.$id_calificacion.'<br />'.$nombre_per.'</td>';
	echo '<td>'.$id_inf_asi.'</td>';
	echo '<td>'.$id_mismensajes.'</td>';
	echo '<td>'.$id_tareas.'</td>';
	echo '<td>'.$id_inf_obs.'</td>';
	echo '<td>'.$id_inf_exa.'</td>';
	echo '</tr>';
	//vamos materia por materia
	$sel_materias = mysql_query("select agrupamientos.materia,agrupamientos.agrupamiento from agrupamientos,matricula where matricula.codigo = '$familia_activo' and matricula.agrupamiento = agrupamientos.agrupamiento");
	for($m=0;$m<(mysql_num_rows($sel_materias));$m++)
		{
		if($m%2==0){echo '<tr class="par">';}else{echo '<tr class="impar">';}
		$reg_materia = mysql_fetch_array($sel_materias);
		$agrupamiento = $reg_materia['agrupamiento'];
		echo '<td class="centrado">';
		echo '<a title="'.$id_gen_bol.'" href="../pdf/ficha_pdf.php?p1='.$familia_activo.'&p2='.$agrupamiento.'&p3=boletin&p4='.$_SESSION['nombre_sesion'].'&p5='.$_SESSION['apellidos_sesion'].'" target="_blank"><img src="../imgs/informe.png" alt="'.$id_gen_bol.'" /></a>';
		echo '</td>';
		echo '<td>'.$reg_materia['materia'].'</td>';
		echo '<td class="centrado">';//notas
		//colocamos el aviso por si hoy se ha registrado alguna nota
		$sel_not_hoy = mysql_query("select nota from notas where codigo='$familia_activo' and agrupamiento='$agrupamiento' and fecha='$hoy'");
		if(mysql_num_rows($sel_not_hoy)>0)
			{
			echo '<img src="../imgs/nuevo.gif" alt="'.$id_hay_notas_hoy.'" title="'.$id_hay_notas_hoy.'" />';
			echo '&nbsp;';
			echo '&nbsp;';
			}
		//fin aviso
		if(mysql_num_rows($sel_per)>0)
			{
			$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agrupamiento'");
			$num_activ = mysql_num_rows($sel_activ);
			for($a=0;$a<$num_activ;$a++)
				{
				$reg_activ = mysql_fetch_array($sel_activ);
				$activ = $reg_activ['actividad'];
				$pond = $reg_activ['ponderacion'];
				$sel_notas = mysql_query("select avg(nota) from notas where codigo='$familia_activo' and agrupamiento='$agrupamiento' and actividad='$activ' and fecha between '$fecha_ini' and '$fecha_fin'");
				$hay_nota=mysql_num_rows($sel_notas);
				if($hay_nota>0)
					{
					$reg_nota = mysql_fetch_array($sel_notas);
					$nota_media = $reg_nota['avg(nota)'];
					$nota_pond = ($nota_media*$pond)/100;
					$matriz_notas_pond[]=$nota_pond;
					}
				}
			if(count($matriz_notas_pond)>0)
				{
				$nota_media = array_sum($matriz_notas_pond);
				$nota_media_red = round($nota_media,2);
				echo '<a class="ver" href="panel.php?accion=notas&agrupamiento='.$agrupamiento.'" title="'.$id_todas_notas.'">'.$nota_media_red.'</a>';
				}
			unset($matriz_notas_pond);
			}//fin if periodo de evaluación
		echo '</td>';//fin notas
		echo '<td>';//asistencia
		//contamos las faltas
		$sel_faltas = mysql_query("select dato from asistencia where codigo='$familia_activo' and agrupamiento = '$agrupamiento' and dato='f'");
		$num_faltas = mysql_num_rows($sel_faltas);
		$sel_retrasos = mysql_query("select dato from asistencia where codigo='$familia_activo' and agrupamiento = '$agrupamiento' and dato='r'");
		$num_retrasos = mysql_num_rows($sel_retrasos);
		$sel_justif = mysql_query("select dato from asistencia where codigo='$familia_activo' and agrupamiento = '$agrupamiento' and dato='j'");
		$num_justif = mysql_num_rows($sel_justif);
		echo '<a class="ver" href="panel.php?accion=faltas&agrupamiento='.$agrupamiento.'" title="'.$id_todas_faltas.'">F: '.$num_faltas.' J: '.$num_justif.' R: '.$num_retrasos.'</a>';
		echo '</td>';//fin asistencia
		echo '<td class="centrado">';//mensajes
		//colocamos el aviso por si hay mensajes sin leer
		$sel_men_noleidos = mysql_query("select mensajes.id from mensajes,agrupamientos where mensajes.destinatario = '*f' and mensajes.remitente = agrupamientos.docente and mensajes.ocultorec='0' and agrupamientos.agrupamiento = '$agrupamiento' and lectura='0' and borrador = '0' and ocultorec='0' or mensajes.destinatario = '$agrupamiento' and mensajes.remitente = agrupamientos.docente and mensajes.ocultorec='0' and agrupamientos.agrupamiento = '$agrupamiento' and lectura='0' and borrador = '0' and ocultorec='0' or mensajes.destinatario = '$familia_activo' and mensajes.remitente = agrupamientos.docente and mensajes.ocultorec='0' and agrupamientos.agrupamiento = '$agrupamiento' and lectura='0' and borrador = '0' and ocultorec='0'");
		if(mysql_num_rows($sel_men_noleidos)>0)
			{
			echo '<img src="../imgs/nuevo.gif" alt="'.$id_mensajes_nuevos.'" title="'.$id_mensajes_nuevos.'" />';
			echo '&nbsp;';
			echo '&nbsp;';
			}
		//fin aviso
		//contamos los mensajes por remitente
		$sel_men = mysql_query("select mensajes.id from mensajes,agrupamientos where mensajes.destinatario = '*f' and mensajes.remitente = agrupamientos.docente and agrupamientos.agrupamiento = '$agrupamiento' or mensajes.destinatario = '$agrupamiento' and mensajes.remitente = agrupamientos.docente and agrupamientos.agrupamiento = '$agrupamiento' or mensajes.destinatario = '$familia_activo' and mensajes.remitente = agrupamientos.docente and agrupamientos.agrupamiento = '$agrupamiento'");
		echo '<a class="ver" href="panel.php?accion=mensajes&agrupamiento='.$agrupamiento.'" title="'.$id_todos_mensajes.'">'.mysql_num_rows($sel_men).'</a>';
		echo '</td>';//fin mensajes
		echo '<td class="centrado">';//tareas
		//colocamos el aviso por si hay tareas pendientes
		$sel_tar_pend = mysql_query("select id from tareas where codigo='$familia_activo' and agrupamiento='$agrupamiento' and fecha_ent > '$hoy'");
		$sel_tar_gen_pend = mysql_query("select distinct agenda.id from agenda,horario,agrupamientos where agrupamientos.agrupamiento = '$agrupamiento' and agrupamientos.docente = agenda.docente and horario.franja = agenda.franja and horario.dia = agenda.dia and agenda.tipo = 't' and horario.sesion = '$agrupamiento' and agenda.fecha > '$hoy'");
		if(mysql_num_rows($sel_tar_pend)>0 || mysql_num_rows($sel_tar_gen_pend)>0)
			{
			echo '<img src="../imgs/nuevo.gif" alt="'.$id_tareas_pendientes.'" title="'.$id_tareas_pendientes.'" />';
			echo '&nbsp;';
			echo '&nbsp;';
			}
		//fin aviso
		//veamos las individuales
		$sel_tar = mysql_query("select id from tareas where codigo='$familia_activo' and agrupamiento='$agrupamiento'");
		//ahora las generales
		$sel_tar_gen = mysql_query("select distinct agenda.id from agenda,horario,agrupamientos where agrupamientos.agrupamiento = '$agrupamiento' and agrupamientos.docente = agenda.docente and horario.franja = agenda.franja and horario.dia = agenda.dia and agenda.tipo = 't' and horario.sesion = '$agrupamiento'");
		echo '<a class="ver" href="panel.php?accion=tareas&agrupamiento='.$agrupamiento.'" title="'.$id_todas_tareas.'">'.(mysql_num_rows($sel_tar)+mysql_num_rows($sel_tar_gen)).'</a>';
		echo '</td>';//fin tareas
		echo '<td class="centrado">';//observaciones
		$sel_obs = mysql_query("select id from observaciones where codigo = '$familia_activo' and agrupamiento = '$agrupamiento'");
		echo '<a class="ver" href="panel.php?accion=observaciones&agrupamiento='.$agrupamiento.'" title="'.$id_todas_observaciones.'">'.mysql_num_rows($sel_obs).'</a>';
		echo '</td>';//fin observaciones
		echo '<td class="centrado">';//exámenes
		$sel_exam = mysql_query("select distinct agenda.id from agenda,horario,agrupamientos where agrupamientos.agrupamiento = '$agrupamiento' and agrupamientos.docente = agenda.docente and horario.franja = agenda.franja and horario.dia = agenda.dia and agenda.tipo = 'e' and horario.sesion = '$agrupamiento'");
		echo '<a class="ver" href="panel.php?accion=exam&agrupamiento='.$agrupamiento.'" title="'.$id_todos_exam.'">'.mysql_num_rows($sel_exam).'</a>';
		echo '</td>';//fin exámenes
		echo '</tr>';
		}
	echo '</table><br />';
	break;
	
	//las notas
	case 'notas':
	$sel_materia = mysql_query("select materia from agrupamientos where agrupamiento='$agrup'");
	$reg_materia = mysql_fetch_array($sel_materia);
	echo '<br /><p class="centrado">'.$id_inf_not.' ('.$reg_materia['materia'].')</p>';
	//resumen de evaluaciones
	echo '<table style="margin:auto;">';
	echo '<tr class="encab">';
	echo '<td>'.$id_periodo.'</td><td>'.$id_calificacion.'</td><td>'.$id_recupera.'</td>';
	$sel_per = mysql_query("select * from periodos");
	$num_per = mysql_num_rows($sel_per);
	for($p=0;$p<$num_per;$p++)
		{
		$reg_per = mysql_fetch_array($sel_per);
		if($p%2==0){echo '<tr class="par">';}else{echo '<tr class="impar">';}
		echo '<td>'.$reg_per['nombre'].'</td>';
		$fecha_ini = $reg_per['inicio'];
		$fecha_fin = $reg_per['fin'];
		$sel_activ = mysql_query("select * from actividades where agrupamiento = '$agrup'");
		$num_activ = mysql_num_rows($sel_activ);
		for($a=0;$a<$num_activ;$a++)
			{
			$reg_activ = mysql_fetch_array($sel_activ);
			$activ = $reg_activ['actividad'];
			$pond = $reg_activ['ponderacion'];
			$sel_notas = mysql_query("select avg(nota) from notas where codigo='$familia_activo' and agrupamiento='$agrup' and actividad='$activ' and fecha between '$fecha_ini' and '$fecha_fin'");
			$hay_nota=mysql_num_rows($sel_notas);
			if($hay_nota>0)
				{
				$reg_nota = mysql_fetch_array($sel_notas);
				$nota_media = $reg_nota['avg(nota)'];
				$nota_pond = ($nota_media*$pond)/100;
				$matriz_notas_pond[]=$nota_pond;
				}
			}
			if(count($matriz_notas_pond)>0)
				{
				$nota_media = array_sum($matriz_notas_pond);
				$nota_media_red = round($nota_media,2);
				echo '<td class="centrado">'.$nota_media_red.'';
                                //si hay nota revisada
			$sel_notas_rev=mysql_query("select * from notas_rev where codigo='$familia_activo' and agrupamiento='$agrup' and periodo='".$reg_per['periodo']."'");
			if(mysql_num_rows($sel_notas_rev)>0)
				{
				$reg_notas_rev=mysql_fetch_array($sel_notas_rev);
				echo '<br/>Calificación final: '.$nota_rev=$reg_notas_rev['nota'].'';
				}
                                echo '</td>';
				$sel_rec=mysql_query("select * from recuperaciones where codigo='$familia_activo' and agrupamiento='$agrup' and periodo='".$reg_per['periodo']."'");
				echo '<td class="centrado">';

				if(mysql_num_rows($sel_rec)>0)
					{
					$reg_rec=mysql_fetch_array($sel_rec);
					$nota_rec=$reg_rec['nota'];
					echo $nota_rec;
					echo '</td>';
					}
				else
					{
					echo '</td>';
					}
				}
		echo '</tr>';
		unset($matriz_notas_pond);
		}//fin for resumen de evaluaciones
	echo '</table>';

	$sel_notas = mysql_query("select * from notas where codigo='$familia_activo' and agrupamiento='$agrup' order by fecha desc, actividad");
	$num_notas = mysql_num_rows($sel_notas);
	if($num_notas>0)
		{
		echo '<br /><table style="margin:auto;">';
		echo '<tr class="encab">';
		echo '<td>'.$id_fecha.'</td><td>'.$id_descripcion.'</td><td>'.$id_nota.'</td><td>'.$id_activ.'</td><td>'.$id_coment.'</td>';
		echo '</tr>';
		for($n=0;$n<$num_notas;$n++)
			{
			if($n%2==0){echo '<tr class="par">';}else{echo '<tr class="impar">';}
			$reg_notas = mysql_fetch_array($sel_notas);
			$id = $reg_notas['id'];
			$fecha = $reg_notas['fecha'];
			$fecha_esp = cambia_fecha_a_esp($fecha);
			$descripcion = $reg_notas['descripcion'];
			$nota = $reg_notas['nota'];
			$actividad = $reg_notas['actividad'];
			$comentario = $reg_notas['comentario'];
			if($comentario == ''){$comentario = $id_no_coment;}
			echo '<td>';
			echo $fecha_esp;
			echo '</td>';
			echo '<td>';
			echo $descripcion;
			echo '</td>';
			echo '<td>';
			echo $nota;
			echo '</td>';
			echo '<td>';
			echo $actividad;
			echo '</td>';
			echo '<td>';
			echo $comentario;
			echo '</td>';
			echo '</tr>';
			}
		echo '</table>';
		echo '<br /><p class="centrado"><a title="'.$id_pdf.'" href="../pdf/ficha_pdf.php?p1='.$familia_activo.'&p2='.$agrup.'&p3='.$accion.'&p4='.$_SESSION['nombre_sesion'].'&p5='.$_SESSION['apellidos_sesion'].'" target="_blank"><img src="../imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
		echo '<p class="centrado"><a href="panel.php">'.$id_volver.'</a></p>';
		}
	else
		{
		echo '<br /><p class="centrado">'.$id_no_calif.'</p>';
		echo '<p class="centrado"><a href="panel.php">'.$id_volver.'</a></p>';
		}
	break;//fin de notas
	
	case 'faltas'://las faltas
	$sel_mes_faltas = mysql_query("select distinct month(fecha),year(fecha) from asistencia where agrupamiento = '$agrup' and codigo = '$familia_activo' and dato <> 'a' order by fecha asc");
	$num_mes_faltas = mysql_num_rows($sel_mes_faltas);
	if($num_mes_faltas>0)
		{
		$sel_materia = mysql_query("select materia from agrupamientos where agrupamiento='$agrup'");
		$reg_materia = mysql_fetch_array($sel_materia);
		echo '<br/><p class="centrado">'.$id_inf_asi.' ('.$reg_materia['materia'].')</p>';
		echo '<br /><table style="margin:auto;">';
		echo '<tr>';
		echo '<td>'.$id_mes.'</td>';
		for($d=0;$d<31;$d++)
			{
			$dia = $d + 1;
			echo '<td class="centrado">'.$dia.'</td>';
			}
		echo '</tr>';	
		for($fa=0;$fa<$num_mes_faltas;$fa++)
			{
			$reg_mes_faltas=mysql_fetch_array($sel_mes_faltas);
			$mes_faltas=$reg_mes_faltas['month(fecha)'];
			$anyo_faltas=$reg_mes_faltas['year(fecha)'];
			$name_mes = date('M',mktime(0,0,0,$mes_faltas+1,0,0));
			$nombre_mes = nombre_mes($name_mes);			
			if($fa%2==0)echo '<tr class="par">';else echo '<tr class="impar">';
			echo '<td>'.$nombre_mes.'</td>';
			for($d=0;$d<31;$d++)
				{
				$dia = $d + 1;
				$nombre_dia_ing = date('D', mktime(0, 0, 0, $mes_faltas, $dia, $anyo_faltas));
				$numero_dia = nombre_dia_a_numero($nombre_dia_ing);
				if($numero_dia == '6' || $numero_dia == '7')
					{
					echo '<td class="naranja"></td>';
					}
				else
					{
					$fecha_consulta = ''.$anyo_faltas.'-'.$mes_faltas.'-'.$dia.'';
					$sel_falta = mysql_query("select dato,hini from asistencia where agrupamiento='$agrup' and codigo = '$familia_activo' and fecha = '$fecha_consulta' and dato <> 'a'");
					if(mysql_num_rows($sel_falta)>0)
						{
						echo '<td class="centrado">';
						for($f=0;$f<(mysql_num_rows($sel_falta));$f++)
							{
							$reg_falta = mysql_fetch_array($sel_falta);
							$horafalta=$reg_falta['hini'];
							echo '<a href="#" title="'.$horafalta.'">'.$reg_falta['dato'].'</a>';
							}
						echo '</td>';
						}
					else
						{
						echo '<td></td>';
						}
					}
				}
				echo '</tr>';		
			}//fin de for
		echo '</table>';
		echo '<br /><p class="centrado"><a title="'.$id_pdf.'" href="../pdf/ficha_pdf.php?p1='.$familia_activo.'&p2='.$agrup.'&p3='.$accion.'&p4='.$_SESSION['nombre_sesion'].'&p5='.$_SESSION['apellidos_sesion'].'" target="_blank"><img src="../imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
		echo '<p class="centrado"><a href="panel.php">'.$id_volver.'</a></p>';
		}
	else
		{
		$sel_materia = mysql_query("select materia from agrupamientos where agrupamiento='$agrup'");
		$reg_materia = mysql_fetch_array($sel_materia);
		echo '<br /><p class="centrado">'.$id_no_asi.' ('.$reg_materia['materia'].')</p>';
		echo '<p class="centrado"><a href="panel.php">'.$id_volver.'</a></p>';
		}
	break;//fin de faltas

	case 'tareas'://tareas
	$sel_materia = mysql_query("select materia from agrupamientos where agrupamiento='$agrup'");
	$reg_materia = mysql_fetch_array($sel_materia);
	echo '<br/><p class="centrado">'.$id_tareas_grupo.' ('.$reg_materia['materia'].')</p>';
	$sel_tareas_gen = mysql_query("select distinct agenda.cita,agenda.fecha from agenda,horario,agrupamientos where agrupamientos.agrupamiento = '$agrup' and agrupamientos.docente = agenda.docente and horario.franja = agenda.franja and horario.dia = agenda.dia and agenda.tipo = 't' and horario.sesion = '$agrup' order by agenda.fecha desc");
	$num_tareas_gen = mysql_num_rows($sel_tareas_gen);
	echo '<br /><table style="margin:auto;">';
	echo '<tr class="encab">';
	echo '<td>'.$id_tarea.'</td><td>'.$id_fecha_ent.'</td>';
	echo '</tr>';
	for($tg=0;$tg<$num_tareas_gen;$tg++)
		{
		$reg_tareas_gen = mysql_fetch_array($sel_tareas_gen);
		$tarea_gen = $reg_tareas_gen['cita'];
		$fecha_gen = $reg_tareas_gen['fecha'];
		$fecha_gen_esp = cambia_fecha_a_esp($fecha_gen);
		if($tg%2==0){echo '<tr class="par">';}else{echo '<tr class="impar">';}
		echo '<td>';
		echo $tarea_gen;
		echo '</td>';
		echo '<td class="centrado">';		
		echo $fecha_gen_esp;
		echo '</td>';
		echo '</tr>';
		}
	echo '</table>';
	$sel_tareas = mysql_query("select * from tareas where codigo='$familia_activo' and agrupamiento='$agrup' order by fecha_reg desc");
	$num_tareas = mysql_num_rows($sel_tareas);
	echo '<br/><p class="centrado">'.$id_tareas_ind.' ('.$reg_materia['materia'].')</p>';
	echo '<br /><table style="margin:auto;">';
	echo '<tr class="encab">';
	echo '<td>'.$id_tarea.'</td><td>'.$id_fecha_reg.'</td><td>'.$id_fecha_ent.'</td>';
	echo '</tr>';
	for($t=0;$t<$num_tareas;$t++)
		{
		$reg_tareas = mysql_fetch_array($sel_tareas);
		$id = $reg_tareas['id'];
		$tarea = $reg_tareas['tarea'];
		$fecha_reg = $reg_tareas['fecha_reg'];
		$fecha_ent = $reg_tareas['fecha_ent'];
		$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
		$fecha_ent_esp = cambia_fecha_a_esp($fecha_ent);
		if($t%2==0){echo '<tr class="par">';}else{echo '<tr class="impar">';}
		echo '<td>';
		echo $tarea;
		echo '</td>';
		echo '<td class="centrado">';		
		echo $fecha_reg_esp;
		echo '</td>';
		echo '<td class="centrado">';
		echo $fecha_ent_esp;
		echo '</td>';
		echo '</tr>';
		}
	echo '</table>';
	echo '<br /><p class="centrado"><a href="panel.php">'.$id_volver.'</a></p>';
	break;//fin de tareas

	case 'observaciones'://observaciones
	$sel_obs = mysql_query("select * from observaciones where codigo='$familia_activo' and agrupamiento='$agrup' order by fecha desc");
	$num_obs = mysql_num_rows($sel_obs);
	if($num_obs>0)
		{
		$sel_materia = mysql_query("select materia from agrupamientos where agrupamiento='$agrup'");
		$reg_materia = mysql_fetch_array($sel_materia);
		echo '<br/><p class="centrado">'.$id_inf_obs.' ('.$reg_materia['materia'].')</p>';
		echo '<br /><table style="margin:auto;">';
		echo '<tr class="encab">';
		echo '<td>'.$id_obs.'</td><td>'.$id_fecha_reg.'</td>';
		echo '</tr>';
		for($o=0;$o<$num_obs;$o++)
			{
			$reg_obs = mysql_fetch_array($sel_obs);
			$id = $reg_obs['id'];
			$observacion = $reg_obs['observacion'];
			$fecha_reg = $reg_obs['fecha'];
			$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
			if($o%2==0){echo '<tr class="par">';}else{echo '<tr class="impar">';}
			echo '<td>';
			echo $observacion;
			echo '</td>';
			echo '<td class="centrado">';		
			echo $fecha_reg_esp;
			echo '</td>';
			echo '</tr>';
			}
		echo '</table>';
		echo '<br /><p class="centrado"><a title="'.$id_pdf.'" href="../pdf/ficha_pdf.php?p1='.$familia_activo.'&p2='.$agrup.'&p3=obs&p4='.$_SESSION['nombre_sesion'].'&p5='.$_SESSION['apellidos_sesion'].'" target="_blank"><img src="../imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';
		echo '<p class="centrado"><a href="panel.php">'.$id_volver.'</a></p>';
		}
	else
		{
		$sel_materia = mysql_query("select materia from agrupamientos where agrupamiento='$agrup'");
		$reg_materia = mysql_fetch_array($sel_materia);
		echo '<br /><p class="centrado">'.$id_no_obs.' ('.$reg_materia['materia'].')</p>';
		echo '<p class="centrado"><a href="panel.php">'.$id_volver.'</a></p>';
		}
	break;//fin de observaciones

	case 'exam'://exámenes
	$sel_exam = mysql_query("select distinct agenda.cita,agenda.fecha from agenda,horario,agrupamientos where agrupamientos.agrupamiento = '$agrup' and agrupamientos.docente = agenda.docente and horario.franja = agenda.franja and horario.dia = agenda.dia and agenda.tipo = 'e' and horario.sesion = '$agrup'");
	$num_exam = mysql_num_rows($sel_exam);
	if($num_exam>0)
		{
		$sel_materia = mysql_query("select materia from agrupamientos where agrupamiento='$agrup'");
		$reg_materia = mysql_fetch_array($sel_materia);
		echo '<br/><p class="centrado">'.$id_inf_exa.' ('.$reg_materia['materia'].')</p>';
		echo '<br /><table style="margin:auto;">';
		echo '<tr class="encab">';
		echo '<td>'.$id_examen.'</td><td>'.$id_fecha.'</td>';
		echo '</tr>';
		for($e=0;$e<$num_exam;$e++)
			{
			$reg_exam = mysql_fetch_array($sel_exam);
			$examen = $reg_exam['cita'];
			$fecha_exam = $reg_exam['fecha'];
			$fecha_exam_esp = cambia_fecha_a_esp($fecha_exam);
			if($e%2==0){echo '<tr class="par">';}else{echo '<tr class="impar">';}
			echo '<td>';
			echo $examen;
			echo '</td>';
			echo '<td class="centrado">';		
			echo $fecha_exam_esp;
			echo '</td>';
			echo '</tr>';
			}
		echo '</table>';
		echo '<p class="centrado"><a href="panel.php">'.$id_volver.'</a></p>';
		}
	else
		{
		$sel_materia = mysql_query("select materia from agrupamientos where agrupamiento='$agrup'");
		$reg_materia = mysql_fetch_array($sel_materia);
		echo '<br /><p class="centrado">'.$id_no_exam.' ('.$reg_materia['materia'].')</p>';
		echo '<p class="centrado"><a href="panel.php">'.$id_volver.'</a></p>';
		}
	break;//fin de exámenes

	case 'mensajes'://mensajes
	//si vengo de pulsar eliminar
	/*$id_elimen = $_GET['id'];
	if($id_elimen)
		{
		mysql_query("update mensajes set ocultorec = '1' where id='$id_elimen'");
		}*/
	//fin eliminar
	$sel_materia = mysql_query("select materia from agrupamientos where agrupamiento='$agrup'");
	$reg_materia = mysql_fetch_array($sel_materia);
	echo '<br /><p class="centrado">'.$id_recibidos.' ('.$reg_materia['materia'].')</p>';
	//selecciono los mensajes
	$sel_men = mysql_query("select mensajes.id,mensajes.fecha,mensajes.mensaje from mensajes,agrupamientos where mensajes.destinatario = '*f' and mensajes.remitente = agrupamientos.docente and mensajes.ocultorec='0' and agrupamientos.agrupamiento = '$agrup' or mensajes.destinatario = '$agrup' and mensajes.remitente = agrupamientos.docente and mensajes.ocultorec='0' and agrupamientos.agrupamiento = '$agrup' or mensajes.destinatario = '$familia_activo' and mensajes.remitente = agrupamientos.docente and mensajes.ocultorec='0' and agrupamientos.agrupamiento = '$agrup'");
	if(mysql_num_rows($sel_men)>0)
		{
		echo '<table style="margin:auto;">';
		echo '<tr class="encab">';
		//echo '<td class="centrado">'.$id_accion.'</td>';
		echo '<td>'.$id_fecha.'</td>';
		echo '<td>'.$id_texto.'</td>';
		echo '</tr>';
		$num_men = mysql_num_rows($sel_men);
		for($m=0;$m<$num_men;$m++)
			{
			$reg_men = mysql_fetch_array($sel_men);
			$id_men = $reg_men['id'];
			$fecha_men = $reg_men['fecha'];
			$fecha_men_esp = cambia_fecha_a_esp($fecha_men);
			$men = $reg_men['mensaje'];
			if($m%2==0){echo '<tr class="par">';}else{echo '<tr class="impar">';}
			//echo '<td class="centrado"><a href="#" onclick="javascript:eliMen(\'mensajes\',\''.$agrup.'\',\''.$id_men.'\')" title="'.$id_eliminar.'"><img src="../imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a></td>';
			echo '<td class="centrado">'.$fecha_men_esp.'</td>';
			echo '<td>'.$men.'</td>';
			echo '</tr>';
			}//fin for mensajes
		echo '</table><br />';
		}//fin hay mensajes
	else
		{
		echo '<br /><p class="centrado">'.$id_nomensajes_rec.'</p><br />';
		}
	//veamos si hay que enviar un mensaje
	$texto_men = $_POST['cajatexto'];
	$destin_men = $_POST['list_mat'];
	if($texto_men && $destin_men)
		{
		$asunto=''.$_SESSION['nombre_sesion'].' '.$_SESSION['apellidos_sesion'].' ('.$_SESSION['grupo_sesion'].')';
		$hoy = date('Y-m-d');
		if($destin_men != '*')
			{	
			
			$env_men = mysql_query("insert into mensajes values('','$familia_activo','$destin_men','$asunto','$texto_men','0','0','$hoy','f','0','0')");
			if($env_men) {echo '<p class="centrado">'.$id_mensaje_enviado.'</p>';} else {echo '<p class="centrado">'.$id_mensaje_no_enviado.'</p>';}
			}//fin mensaje para un docente
		else
			{
			$sel_materias = mysql_query("select agrupamientos.materia,agrupamientos.agrupamiento from agrupamientos,matricula where matricula.codigo = '$familia_activo' and matricula.agrupamiento = agrupamientos.agrupamiento");
			for($m=0;$m<(mysql_num_rows($sel_materias));$m++)
				{
				$reg_materias=mysql_fetch_array($sel_materias);
				$materia_men=$reg_materias['materia'];
				$agrupamiento_men=$reg_materias['agrupamiento'];
				$sel_doc=mysql_query("select docente from agrupamientos where agrupamiento='$agrupamiento_men'");
				$reg_doc=mysql_fetch_array($sel_doc);
				$doc_men=$reg_doc['docente'];
				$env_men = mysql_query("insert into mensajes values('','$familia_activo','$doc_men','$asunto','$texto_men','0','0','$hoy','f','0','0')");
				if($env_men) {echo '<p class="centrado">'.$id_mensaje_enviado.' ('.$materia_men.')</p>';} else {echo '<p class="centrado">'.$id_mensaje_no_enviado.' ('.$materia_men.')</p>';}
				}//fin for materias
			}//fin mensaje para todos
		}//fin de envío del mensaje

	//ahora el espacio para enviar un mensaje
	echo '<p class="centrado">'.$id_redactar.'</p>';
	echo '<form name="mensaje" method="post">';
	echo '<p class="centrado">';
	echo ''.$id_destinatario.': ';
	echo '<select name="list_mat">';
	echo '<option value="0">'.$id_elige_doc.'</option>';
	echo '<option value="*">'.$id_todos_doc.'</option>';
	$sel_materias = mysql_query("select agrupamientos.materia,agrupamientos.agrupamiento from agrupamientos,matricula where matricula.codigo = '$familia_activo' and matricula.agrupamiento = agrupamientos.agrupamiento");
	for($m=0;$m<(mysql_num_rows($sel_materias));$m++)
		{
		$reg_materias=mysql_fetch_array($sel_materias);
		$materia_men=$reg_materias['materia'];
		$agrupamiento_men=$reg_materias['agrupamiento'];
		$sel_doc=mysql_query("select docente from agrupamientos where agrupamiento='$agrupamiento_men'");
		$reg_doc=mysql_fetch_array($sel_doc);
		$doc_men=$reg_doc['docente'];
		echo '<option value="'.$doc_men.'">'.$materia_men.'</option>';
		}//fin for materias
	echo '</select>';
	echo '<br /><br />';
	echo '<textarea rows="5" cols="40" name="cajatexto"></textarea>';
	echo '<br /><br />';
	echo '<a href="#" onclick="enviaMen(\''.$agrup.'\')" title="'.$id_enviar.'"><img src="../imgs/envia_mail.png" alt="'.$id_enviar.'" /></a>';
	echo '</p>';		
	echo '</form>';
	echo '<br /><p class="centrado"><a href="panel.php">'.$id_volver.'</a></p>';
	break;//fin de mensajes

	}//fin de switch
echo '</div>';
echo '<div id="footer">'; 
echo '<br/>';
echo '<a href="http://siestta.org" target="_blank">SIESTTA 2.0</a> es software libre bajo licencia <a id="gnu" href="http://www.gnu.org/copyleft/gpl.html" target="_blank">GNU General Public License</a>';
echo '<br />';
echo '<a href="http://ramoncastro.es" target="_blank">Ram&oacute;n Castro P&eacute;rez</a> 2007';
echo '</div>';
}

?>

</body>
</html>