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

$agr_post=$_POST['agr'];
echo '<br/><span class="negrita">'.$id_inf_car.'</span>';

echo '<p class="centrado"><select id="agr" onchange="listaCartas()">';
if($agr_post){echo '<option selected="selected">'.$agr_post.'</option>';}
echo '<option>'.$id_elgagr.'</option>';
$sel_agr=mysql_query("select * from agrupamientos where docente='$docente'");
$num_agr=mysql_num_rows($sel_agr);
for($a=0;$a<$num_agr;$a++)
	{
	$reg_agr=mysql_fetch_array($sel_agr);
	$materia=$reg_agr['materia'];
	$agrupamiento=$reg_agr['agrupamiento'];
	echo '<option value="'.$agrupamiento.'">'.$agrupamiento.' ('.$materia.')</option>';
	}
echo '</select>';

if($agr_post)
	{
	$accion = $_POST['p1'];
	switch($accion)
	{
	case 'lista':
	if($_POST['texto'])
		{
		$fecha = date('Y-m-d');
		$texto = $_POST['texto'];
		$mensaje_pre = str_replace("[igual]","=",$texto);
		$mensaje = str_replace("~inte~","?",$mensaje_pre);
		$ins = mysql_query("insert into cartas values('','$docente','$mensaje','$agr_post','$fecha')");
		}
	if($_POST['id'])
		{
		$id_eli = $_POST['id'];
		$borra=mysql_query("delete from cartas where id='$id_eli'");
		}
	$sel_cartas = mysql_query("select * from cartas where docente='$docente' and destinatario='$agr_post' order by fecha desc");
	$num_cartas = mysql_num_rows($sel_cartas);
	if($num_cartas>0)
		{
		echo '<br /><br /><table class="tablacentrada">';
		echo '<tr class="encab">';
		echo '<td>'.$id_accion.'</td><td>'.$id_fecha_reg.'</td><td>'.$id_texto.'</td>';
		echo '</tr>';
		for($c=0;$c<$num_cartas;$c++)
			{
			$reg_cartas = mysql_fetch_array($sel_cartas);
			$id = $reg_cartas['id'];
			$carta = $reg_cartas['texto'];
			$carta_f = htmlspecialchars($carta);
			$subcarta=substr($carta,0,200);
			$fecha_reg = $reg_cartas['fecha'];
			$fecha_reg_esp = cambia_fecha_a_esp($fecha_reg);
			if($t%2==0){echo '<tr class="par">';}else{echo '<tr>';}
			echo '<td class="centrado">';
			echo '<a href="#" title="'.$id_eliminar.'" onclick="eliminaCarta(\''.$agr_post.'\',\''.$id.'\')"><img src="imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a>';
			echo '<br />';echo '<br />';
			echo '<a href="#" title="'.$id_con_ed.'" onclick="editaCarta(\''.$agr_post.'\',\''.$id.'\')"><img src="imgs/edita_peq.png" alt="'.$id_editar.'" /></a>';
			echo '<br />';echo '<br />';
			echo '<a href="#" title="'.$id_pdf.'" onclick="pdf1(\'cartas.php\',\''.$agr_post.'\',\''.$id.'\')"><img src="imgs/informe_peq.png" alt="'.$id_pdf.'" /></a>';
			echo '</td>';
			echo '<td class="centrado">';		
			echo $fecha_reg_esp;
			echo '</td>';
			echo '<td class="justificado">';
			echo ''.$subcarta.'...';
			echo '</td>';
			echo '</tr>';
			}
		echo '</table>';
		}
	else
		{
		echo '<br /><br /><p class="negrita">'.$id_no_cartas.'</p>';
		}
	echo '<br /><p class="negrita"><a href="#" onclick="redactaCarta(\''.$agr_post.'\')" title="'.$id_red_carta.'"><img src="imgs/mas.png" alt="'.$id_red_carta.'" /></a></p>';
	break;
 	case 'redacta':
	include("fckeditor/fckeditor.php") ;
	echo '<br /><form id="carta" name="carta" class="centrado">';
	echo '<br /><p class="texto_centrado"> '.$id_red_carta.'</p><br />'; 
	$oFCKeditor = new FCKeditor('area') ;
	$oFCKeditor->ToolbarSet = 'Carta';
	$oFCKeditor->BasePath = 'fckeditor/';
	$oFCKeditor->Value = 'Escribe aqu&iacute;';
	$oFCKeditor->Create() ;
	echo '<br /><p class="centrado">';
	echo '<a href="#" class="padding" onclick="grabaCarta(\''.$agr_post.'\')" title="'.$id_guardar.'"><img src="imgs/guardar.png" alt="'.$id_guardar.'"/></a>';
	echo '</p>';
	echo '</form>';

	break;
	case 'edita':
	$id=$_POST['id'];
	$sel_carta = mysql_query("select * from cartas where id='$id'");
	$reg_carta = mysql_fetch_array($sel_carta);
	$texto = $reg_carta['texto'];
	include("fckeditor/fckeditor.php") ;
	echo '<br /><form id="carta" name="carta" class="centrado">';
	echo '<br /><p class="texto_centrado"> '.$id_red_carta.'</p><br />'; 
	$oFCKeditor = new FCKeditor('area') ;
	$oFCKeditor->ToolbarSet = 'Carta';
	$oFCKeditor->BasePath = 'fckeditor/';
	$oFCKeditor->Value = $texto;
	$oFCKeditor->Create() ;
	echo '<br /><p class="centrado">';
	echo '<a href="#" class="padding" onclick="grabaCarta(\''.$agr_post.'\')" title="'.$id_guardar.'"><img src="imgs/guardar.png" alt="'.$id_guardar.'"/></a>';
	echo '</p>';
	echo '</form>';

	break;
	}//fin switch
	}




}//fin hay sesión

?>
