<?php

session_start();
//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']))
{
//conecto con MySQL
conecta();
//recogemos la información cargando la variable
$docente=$_POST['p1'];
$franja_post=$_POST['p2'];
$hini_post=$_POST['p5'];
$hfin_post=$_POST['p6'];
$franja_h_post = $_POST['p7'];
$franja_pasada = $_POST['p8'];

if(isset($franja_post))
	{
	$dia_post=$_POST['p3'];
	$sesion_post=$_POST['p4'];
	//si el registro está, lo actualizamos
	$sel_sesion = mysql_query("select sesion from horario where docente = '$docente' and franja = '$franja_post' and dia = '$dia_post'");
	if(mysql_num_rows($sel_sesion)>0)
		{
		$act_sesion = mysql_query("update horario set sesion='$sesion_post' where docente = '$docente' and franja = '$franja_post' and dia = '$dia_post'");
		}
	else
		{
		//inserto en base de datos
		$inserta_sesion=mysql_query("insert into horario values('$docente','$franja_post','$dia_post','$sesion_post')");
		}
	}
if(isset($franja_h_post))
	{
	//si el registro está, lo actualizamos
	$sel_franja = mysql_query("select franja from franjas where docente='$docente' and franja='$franja_h_post'");
	if(mysql_num_rows($sel_franja)>0)
		{
		$act_franja = mysql_query("update franjas set hini='$hini_post',hfin='$hfin_post' where franja='$franja_h_post' and docente='$docente'");
		}
	else
		{
		//inserto en base de datos
		$inserta_franja=mysql_query("insert into franjas values('$docente','$franja_h_post','$hini_post','$hfin_post')");
		}
	}
echo '<br/><span class="negrita">'.$id_mihorario.'</span>';
echo '<p>'.$id_texto_horario.'</p>';

//presento formulario para registrar horario
echo '<form id="reg_hor" name="reg_hor">';

	echo '<table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td>'.$id_inicio.'</td><td>'.$id_fin.'</td><td>'.$id_l.'</td><td>'.$id_m.'</td><td>'.$id_x.'</td><td>'.$id_j.'</td><td>'.$id_v.'</td>';
	echo '</tr>';
	if($franja_pasada)
		{
		$sel_franjas = mysql_query("select franja from franjas where docente='$docente' order by hini desc limit 1");
		}
	else
		{
		$sel_franjas = mysql_query("select franja from franjas where docente='$docente' order by franja desc limit 1");
		}
	if(mysql_num_rows($sel_franjas)>0)
	{
	$reg_franjas = mysql_fetch_array($sel_franjas);
	
	if($franja_pasada)
		{
		$ultima_franja = $franja_pasada;
		}
	else
		{
		$ultima_franja = $reg_franjas['franja'];
		}
	//montamos bucle para presentar horario
	for($h=0;$h<$ultima_franja;$h++)
		{
		$f = $h+1;
		$sel_hor = mysql_query("select hini,hfin from franjas where docente='$docente' and franja='$f'");
		$reg_hor = mysql_fetch_array($sel_hor);
		if($h%2==0){echo '<tr class="par">';}else{echo '<tr>';}
		echo '<td>';
		echo '<input type="text" id="ini_'.$f.'" value="'.$reg_hor['hini'].'" size="5" maxlength="5" />';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" id="fin_'.$f.'" value="'.$reg_hor['hfin'].'" size="5" maxlength="5" onblur="guardaFranja(\''.$docente.'\',\''.$f.'\')" />';
		echo '</td>';
		for($d=1;$d<6;$d++)
		{
		$sel_dia = mysql_query("select sesion from horario where docente='$docente' and franja='$f' and dia='$d'");
		$reg_dia = mysql_fetch_array($sel_dia);
		echo '<td>';
		echo '<select id="agr_'.$f.'_'.$d.'" onchange="guardaSesion(\''.$docente.'\',\''.$f.'\',\''.$d.'\')">';
		echo '<option selected="selected">'.$reg_dia['sesion'].'</option>';
		$sel_agr = mysql_query("select agrupamiento from agrupamientos where docente = '$docente'");
		$num_agr = mysql_num_rows($sel_agr);
		for($nagr=0;$nagr<$num_agr;$nagr++)
			{
			$reg_agr = mysql_fetch_array($sel_agr);
			echo '<option style="font-weight:bold">'.$reg_agr['agrupamiento'].'</option>';
			}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////resto de horas lectivas y complementarias////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<option>'.$id_recreo.'</option>';
		echo '<option>'.$id_fam.'</option>';
		echo '<option>'.$id_fam_tut.'</option>';
		echo '<option>'.$id_tsa.'</option>';
                echo '<option>'.$id_rtut.'</option>';
		echo '<option>'.$id_rdep.'</option>';
		echo '<option>'.$id_pprac.'</option>';
		echo '<option>'.$id_ac.'</option>';
		echo '<option>'.$id_guardia.'</option>';
		echo '<option>'.$id_guardia_recreo.'</option>';
		echo '<option>'.$id_biblioteca.'</option>';
		echo '<option>'.$id_jd.'</option>';
		echo '<option>'.$id_ed.'</option>';
		echo '<option>'.$id_ccp.'</option>';
		echo '<option>'.$id_red_tic.'</option>';
		echo '<option>'.$id_red_lac.'</option>';
		echo '<option>'.$id_red_jub.'</option>';
		echo '<option>'.$id_ored.'</option>';
		echo '<option>'.$id_chl.'</option>';
		echo '<option>'.$id_noper.'</option>';
		echo '<option>LTESF</option>';
		echo '<option>AFC</option>';
		echo '<option>CDAC</option>';
		echo '<option>PLAB</option>';
		echo '<option>PAR</option>';
		echo '<option>ACN</option>';
		echo '<option>DIV</option>';
		echo '<option>LCR</option>';
		echo '<option>OTRA</option>';
		echo '</select>';
		echo '</td>';
		}
		echo '</tr>';
		}

	//presento enlace para añadir fila nueva
	$proxima_franja = $ultima_franja+1;
	echo '<a href="#" onclick="nuevaFila(\''.$docente.'\',\''.$proxima_franja.'\')" title="'.$id_nueva_fila.'"><img src="imgs/mas.png" alt="'.$id_nueva_fila.'" /></a>';
	}//fin había franjas ya registradas
	else//no hay nada registrado
	{
	echo '<tr class="par">';
	echo '<td>';
		echo '<input type="text" id="ini_1" value="'.$reg_hor['hini'].'" size="5" maxlength="5" />';
		echo '</td>';
		echo '<td>';
		echo '<input type="text" id="fin_1" value="'.$reg_hor['hfin'].'" size="5" maxlength="5" onblur="guardaFranja(\''.$docente.'\',\'1\')" />';
		echo '</td>';
		for($d=1;$d<6;$d++)
		{
		//$sel_dia = mysql_query("select sesion from horario where docente='$docente' and franja='$f' and dia='$d'");
		//$reg_dia = mysql_fetch_array($sel_dia);
		echo '<td>';
		echo '<select id="agr_1_'.$d.'" onchange="guardaSesion(\''.$docente.'\',\'1\',\''.$d.'\')">';
		echo '<option selected="selected">'.$reg_dia['sesion'].'</option>';
		$sel_agr = mysql_query("select agrupamiento from agrupamientos where docente = '$docente'");
		$num_agr = mysql_num_rows($sel_agr);
		for($nagr=0;$nagr<$num_agr;$nagr++)
			{
			$reg_agr = mysql_fetch_array($sel_agr);
			echo '<option style="font-weight:bold">'.$reg_agr['agrupamiento'].'</option>';
			}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////resto de horas lectivas y complementarias////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		echo '<option>'.$id_recreo.'</option>';
		echo '<option>'.$id_fam.'</option>';
		echo '<option>'.$id_fam_tut.'</option>';
		echo '<option>'.$id_tsa.'</option>';
                echo '<option>'.$id_rtut.'</option>';
		echo '<option>'.$id_rdep.'</option>';
		echo '<option>'.$id_pprac.'</option>';
		echo '<option>'.$id_ac.'</option>';
		echo '<option>'.$id_guardia.'</option>';
		echo '<option>'.$id_guardia_recreo.'</option>';
		echo '<option>'.$id_biblioteca.'</option>';
		echo '<option>'.$id_jd.'</option>';
		echo '<option>'.$id_ed.'</option>';
		echo '<option>'.$id_ccp.'</option>';
		echo '<option>'.$id_red_tic.'</option>';
		echo '<option>'.$id_red_lac.'</option>';
		echo '<option>'.$id_red_jub.'</option>';
		echo '<option>'.$id_ored.'</option>';
		echo '<option>'.$id_chl.'</option>';
		echo '<option>'.$id_noper.'</option>';
                echo '<option>LTESF</option>';
		echo '<option>AFC</option>';
		echo '<option>CDAC</option>';
		echo '<option>PLAB</option>';
		echo '<option>PAR</option>';
		echo '<option>ACN</option>';
		echo '<option>DIV</option>';
		echo '<option>LCR</option>';
		echo '<option>OTRA</option>';
		echo '</select>';
		echo '</td>';
		}
		echo '</tr>';
		
	}//fin de else (no había nada registrado)

echo '</table>';
echo '<br />';
echo '<p class="centrado"><a href="#" onclick="abrePdf(\'horario_pdf.php\')" title="'.$id_pdf.'"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a></p>';

}//fin if hay sesion

?>

