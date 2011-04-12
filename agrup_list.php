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

//recogemos variables
$sesion = $_POST['p1'];
$fecha_ing = date('Y-m-d');

//extraigo nombre del día
$dia_ing=extrae_dia_mysql($fecha_ing);
$mes_ing=extrae_mes_ingles($fecha_ing);
$anyo_ing=substr($fecha_ing,0,4);
$nombre_dia_ing=date('D',mktime(0,0,0,$mes_ing,$dia_ing,$anyo_ing));
$numero_dia = nombre_dia_a_numero($nombre_dia_ing);
$nombre_dia=encuentra_dia($numero_dia-1);

$fecha_esp = cambia_fecha_a_esp($fecha_ing);

//si venimos de realizar algún registro
$registro=$_POST['registro'];
switch($registro)
	{
	//casos
	case 'not':
	$actividad=$_POST['actividad'];
	$descripcion=$_POST['descripcion'];
	echo '<br /><span class="texto_centrado"> '.$id_inf_not.' '.$actividad.' ('.$descripcion.')</span>';
	$numero=$_POST['numero'];
	echo '<ol class="negrita">';
	for($l=0;$l<$numero;$l++)
		{
		$nota[$l] = $_POST['nota_'.$l.''];
		$codigo[$l] = $_POST['cod_'.$l.''];
		$coment[$l] = $_POST['com_'.$l.''];
		$nom[$l] = $_POST['nom_'.$l.''];
		$ape[$l] = $_POST['ape_'.$l.''];
		if(isset($nota[$l]) && $nota[$l] != '')
			{
			$ins_not=mysql_query("insert into notas values('','$codigo[$l]','$sesion','$fecha_ing','$actividad','$nota[$l]','$descripcion','$coment[$l]')");
			echo '<li>'.$ape[$l].', '.$nom[$l].' '.$nota[$l].' '.$coment[$l].'</li>';
			}
		}
	echo '</ol>';
	echo '<br /><a href="#" onclick="pdf()" title="'.$id_pdf.'"><img src="imgs/informe.png" alt="'.$id_pdf.'" /></a>';
	break;
	
	case 'obs':
	echo '<br /><span class="texto_centrado"> '.$id_inf_obs.'</span>';
	$numero=$_POST['numero'];
	echo '<ol class="negrita">';
	for($l=0;$l<$numero;$l++)
		{
		$codigo[$l] = $_POST['cod_'.$l.''];
		$observ[$l] = $_POST['com_'.$l.''];
		$nom[$l] = $_POST['nom_'.$l.''];
		$ape[$l] = $_POST['ape_'.$l.''];
		if(isset($observ[$l]) && $observ[$l] != '')
			{
			$ins_observ=mysql_query("insert into observaciones values('','$codigo[$l]','$sesion','$observ[$l]','$fecha_ing')");
			echo '<li>'.$ape[$l].', '.$nom[$l].' '.$observ[$l].'</li>';
			}
		}
	echo '</ol>';
	break;
	}//fin switch registro

echo '<br/><span class="negrita">'.$id_agr.' '.$sesion.'. '.$id_fecha.': '.$nombre_dia.', '.$fecha_esp.'</span>';

echo '<p class="centrado">';
echo '<a href="#" onclick="miraAgrup(\''.$sesion.'\')">'.$id_inf_not.'</a>&nbsp;';
echo '<a href="#" onclick="abreAgrup1(\''.$sesion.'\')">'.$id_inf_obs.'</a>&nbsp;';
echo '</p><br />';

$accion = $_POST['p4'];

switch($accion)
{
//las calificaciones
case 'not':
echo '<form id="notas" name="notas">';
echo '<table class="tablacentrada"><tr><td>';
echo '<select id="act" onchange="miraAgrup0(\''.$sesion.'\')">';
if($_POST['act_post'])
	{
	echo '<option selected="selected">'.$_POST['act_post'].'</option>';
	}
echo '<option value="0">'.$id_elgact.'</option>';
$sel_per = mysql_query("select inicio,fin,periodo from periodos where inicio<'$fecha_ing' and fin>'$fecha_ing'");
$reg_per = mysql_fetch_array($sel_per);
$periodo = $reg_per['periodo'];
$ini_per = $reg_per['inicio'];
$fin_per = $reg_per['fin'];
$sel_act = mysql_query("select actividad from actividades where agrupamiento='$sesion' and periodo = '$periodo' or agrupamiento='$sesion' and periodo = '*'"); 
$num_act = mysql_num_rows($sel_act);
for($a=0;$a<$num_act;$a++)
	{
	$reg_act=mysql_fetch_array($sel_act);
	echo '<option>'.$reg_act['actividad'].'</option>';
	}
echo '</select>';
echo '&nbsp;';echo '&nbsp;';
echo '<img src="imgs/desc_peq.png" title="'.$id_descripcion.'" alt="'.$id_descripcion.'" /> <input id="desc" size="40" type="text" />';
echo '</td></tr></table>';
echo '<br />';
//selecciono el alumnado del agrupamiento
$sel_alum = mysql_query("select alumnado.codigo,alumnado.nombre,alumnado.apellidos,matricula.codigo,matricula.agrupamiento from alumnado,matricula where matricula.agrupamiento='$sesion' and matricula.codigo=alumnado.codigo order by apellidos, nombre");
$num_alum = mysql_num_rows($sel_alum);
//dividimos en tres bloques la lista
$div=($num_alum/3);
$div_red=round($div,0);
//con un bucle listamos
echo '<table class="tablacentrada">';
echo '<tr>';
echo '<td class="justificado">';
echo '<ul>';
for($n=0;$n<$div_red;$n++)
	{
	$reg_alum=mysql_fetch_array($sel_alum);
	$nom_alum=$reg_alum['nombre'];
	$ape_alum =$reg_alum['apellidos'];
	$cod_alum =$reg_alum['codigo'];

	//voy a contar las veces que se ha calificado la actividad si es que la hemos elegido del select ya
	if($_POST['act_post'])
		{
		$actividad_elegida = $_POST['act_post'];
		$sel_veces = mysql_query("select id from notas where agrupamiento='$sesion' and codigo='$cod_alum' and actividad='$actividad_elegida' and fecha between '$ini_per' and '$fin_per'");
		$num_veces = mysql_num_rows($sel_veces);
		}

	
		echo '<li><input type="text" id="nota_'.$n.'" name="nota_'.$n.'" size="3" maxlength="5" /><input type="hidden" id="cod_'.$n.'" name="cod_'.$n.'" value="'.$cod_alum.'" /><input type="hidden" id="nom_'.$n.'" name="nom_'.$n.'" value="'.$nom_alum.'" /><input type="hidden" id="ape_'.$n.'" name="ape_'.$n.'" value="'.$ape_alum.'" /> <a href="#" onclick="abreFicha(\''.$cod_alum.'\',\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$accion.'\')" title="'.$id_verficha.'"> '.$ape_alum.'</a>, <a href="#" title="'.$id_foto.'" onclick="new LITBox(\'carga_foto_al.php?usuario='.$cod_alum.'\', {type:\'window\', overlay:true, height:190, width:120, resizable:false});">'.$nom_alum.'</a>&nbsp;'.$num_veces.'&nbsp;<a href="#" onclick="muestraComent(\''.$n.'\')" title="'.$id_coment.'"  ><img src="imgs/obs_peq.png" alt="'.$id_coment.'" /></a></li>';

		echo '<li class="oculto" id="li_'.$n.'">';
		echo '<textarea id="com_'.$n.'" name="com_'.$n.'" columns="20" rows="3"></textarea>';
		echo '&nbsp;';
		echo '<a href="#" onclick="ocultaComent(\''.$n.'\')" title="'.$id_ocultar.'"><img src="imgs/cancelar_peq.png" alt="'.$id_ocultar.'" /></a>';
		echo '</li>';
		
	}
echo '</ul>';
echo '</td>';
echo '<td class="justificado">';
echo '<ul>';
for($n=$div_red;$n<(2*$div_red);$n++)
	{
	$reg_alum=mysql_fetch_array($sel_alum);
	$nom_alum=$reg_alum['nombre'];
	$ape_alum =$reg_alum['apellidos'];
	$cod_alum =$reg_alum['codigo'];

	//voy a contar las veces que se ha calificado la actividad si es que la hemos elegido del select ya
	if($_POST['act_post'])
		{
		$actividad_elegida = $_POST['act_post'];
		$sel_veces = mysql_query("select id from notas where agrupamiento='$sesion' and codigo='$cod_alum' and actividad='$actividad_elegida' and fecha between '$ini_per' and '$fin_per'");
		$num_veces = mysql_num_rows($sel_veces);
		}

	
		echo '<li><input type="text" id="nota_'.$n.'" name="nota_'.$n.'" size="3" maxlength="5" /><input type="hidden" id="cod_'.$n.'" name="cod_'.$n.'" value="'.$cod_alum.'" /><input type="hidden" id="nom_'.$n.'" name="nom_'.$n.'" value="'.$nom_alum.'" /><input type="hidden" id="ape_'.$n.'" name="ape_'.$n.'" value="'.$ape_alum.'" /> <a href="#" onclick="abreFicha(\''.$cod_alum.'\',\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$accion.'\')" title="'.$id_verficha.'"> '.$ape_alum.'</a>, <a href="#" title="'.$id_foto.'" onclick="new LITBox(\'carga_foto_al.php?usuario='.$cod_alum.'\', {type:\'window\', overlay:true, height:190, width:120, resizable:false});">'.$nom_alum.'</a>&nbsp;'.$num_veces.'&nbsp;<a href="#" onclick="muestraComent(\''.$n.'\')" title="'.$id_coment.'"  ><img src="imgs/obs_peq.png" alt="'.$id_coment.'" /></a></li>';
	
		echo '<li class="oculto" id="li_'.$n.'">';
		echo '<textarea id="com_'.$n.'" name="com_'.$n.'" columns="20" rows="3"></textarea>';
		echo '&nbsp;';
		echo '<a href="#" onclick="ocultaComent(\''.$n.'\')" title="'.$id_ocultar.'"><img src="imgs/cancelar_peq.png" alt="'.$id_ocultar.'" /></a>';
		echo '</li>';
		
	}
echo '</ul>';
echo '</td>';
echo '<td class="justificado">';
echo '<ul>';
for($n=(2*$div_red);$n<$num_alum;$n++)
	{
	$reg_alum=mysql_fetch_array($sel_alum);
	$nom_alum=$reg_alum['nombre'];
	$ape_alum =$reg_alum['apellidos'];
	$cod_alum =$reg_alum['codigo'];

	//voy a contar las veces que se ha calificado la actividad si es que la hemos elegido del select ya
	if($_POST['act_post'])
		{
		$actividad_elegida = $_POST['act_post'];
		$sel_veces = mysql_query("select id from notas where agrupamiento='$sesion' and codigo='$cod_alum' and actividad='$actividad_elegida' and fecha between '$ini_per' and '$fin_per'");
		$num_veces = mysql_num_rows($sel_veces);
		}

	
		echo '<li><input type="text" id="nota_'.$n.'" name="nota_'.$n.'" size="3" maxlength="5" /><input type="hidden" id="cod_'.$n.'" name="cod_'.$n.'" value="'.$cod_alum.'" /><input type="hidden" id="nom_'.$n.'" name="nom_'.$n.'" value="'.$nom_alum.'" /><input type="hidden" id="ape_'.$n.'" name="ape_'.$n.'" value="'.$ape_alum.'" /> <a href="#" onclick="abreFicha(\''.$cod_alum.'\',\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$accion.'\')" title="'.$id_verficha.'"> '.$ape_alum.'</a>, <a href="#" title="'.$id_foto.'" onclick="new LITBox(\'carga_foto_al.php?usuario='.$cod_alum.'\', {type:\'window\', overlay:true, height:190, width:120, resizable:false});">'.$nom_alum.'</a>&nbsp;'.$num_veces.'&nbsp;<a href="#" onclick="muestraComent(\''.$n.'\')" title="'.$id_coment.'"  ><img src="imgs/obs_peq.png" alt="'.$id_coment.'" /></a></li>';

		echo '<li class="oculto" id="li_'.$n.'">';
		echo '<textarea id="com_'.$n.'" name="com_'.$n.'" columns="20" rows="3"></textarea>';
		echo '&nbsp;';
		echo '<a href="#" onclick="ocultaComent(\''.$n.'\')" title="'.$id_ocultar.'"><img src="imgs/cancelar_peq.png" alt="'.$id_ocultar.'" /></a>';
		echo '</li>';
		
	}
echo '</ul>';
echo '</td>';
echo '</tr>';
echo '</table><br />';
echo '<p class="centrado"><a href="#" onclick="grabaNota1(\''.$sesion.'\',\''.$num_alum.'\')" title="'.$id_regnotas.'"><img src="imgs/guardar.png" alt="'.$id_regnotas.'" /></a></p>';
echo '</form>';
break;

case 'obs':
echo '<form id="obs" name="obs">';
//selecciono el alumnado del agrupamiento
$sel_alum = mysql_query("select alumnado.codigo,alumnado.nombre,alumnado.apellidos,matricula.codigo,matricula.agrupamiento from alumnado,matricula where matricula.agrupamiento='$sesion' and matricula.codigo=alumnado.codigo order by apellidos, nombre");
$num_alum = mysql_num_rows($sel_alum);
//dividimos en tres bloques la lista
$div=($num_alum/3);
$div_red=round($div,0);
//con un bucle listamos
echo '<table class="tablacentrada">';
echo '<tr>';
echo '<td class="justificado">';
echo '<ul>';
for($n=0;$n<$div_red;$n++)
	{
	$reg_alum=mysql_fetch_array($sel_alum);
	$nom_alum=$reg_alum['nombre'];
	$ape_alum =$reg_alum['apellidos'];
	$cod_alum =$reg_alum['codigo'];
	
		echo '<li><input type="hidden" id="cod_'.$n.'" name="cod_'.$n.'" value="'.$cod_alum.'" /><input type="hidden" id="nom_'.$n.'" name="nom_'.$n.'" value="'.$nom_alum.'" /><input type="hidden" id="ape_'.$n.'" name="ape_'.$n.'" value="'.$ape_alum.'" /> <a href="#" onclick="abreFicha(\''.$cod_alum.'\',\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$accion.'\')" title="'.$id_verficha.'"> '.$ape_alum.'</a>, <a href="#" title="'.$id_foto.'" onclick="new LITBox(\'carga_foto_al.php?usuario='.$cod_alum.'\', {type:\'window\', overlay:true, height:190, width:120, resizable:false});">'.$nom_alum.'</a>&nbsp;<a href="#" onclick="muestraComent(\''.$n.'\')" title="'.$id_coment.'"  ><img src="imgs/obs_peq.png" alt="'.$id_coment.'" /></a></li>';

		echo '<li class="oculto" id="li_'.$n.'">';
		echo '<textarea id="com_'.$n.'" name="com_'.$n.'" columns="20" rows="3"></textarea>';
		echo '&nbsp;';
		echo '<a href="#" onclick="ocultaComent(\''.$n.'\')" title="'.$id_ocultar.'"><img src="imgs/cancelar_peq.png" alt="'.$id_ocultar.'" /></a>';
		echo '</li>';
		
	}
echo '</ul>';
echo '</td>';
echo '<td class="justificado">';
echo '<ul>';
for($n=$div_red;$n<(2*$div_red);$n++)
	{
	$reg_alum=mysql_fetch_array($sel_alum);
	$nom_alum=$reg_alum['nombre'];
	$ape_alum =$reg_alum['apellidos'];
	$cod_alum =$reg_alum['codigo'];
	
		echo '<li><input type="hidden" id="cod_'.$n.'" name="cod_'.$n.'" value="'.$cod_alum.'" /><input type="hidden" id="nom_'.$n.'" name="nom_'.$n.'" value="'.$nom_alum.'" /><input type="hidden" id="ape_'.$n.'" name="ape_'.$n.'" value="'.$ape_alum.'" /> <a href="#" onclick="abreFicha(\''.$cod_alum.'\',\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$accion.'\')" title="'.$id_verficha.'"> '.$ape_alum.'</a>, <a href="#" title="'.$id_foto.'" onclick="new LITBox(\'carga_foto_al.php?usuario='.$cod_alum.'\', {type:\'window\', overlay:true, height:190, width:120, resizable:false});">'.$nom_alum.'</a>&nbsp;<a href="#" onclick="muestraComent(\''.$n.'\')" title="'.$id_coment.'"  ><img src="imgs/obs_peq.png" alt="'.$id_coment.'" /></a></li>';
	
		echo '<li class="oculto" id="li_'.$n.'">';
		echo '<textarea id="com_'.$n.'" name="com_'.$n.'" columns="20" rows="3"></textarea>';
		echo '&nbsp;';
		echo '<a href="#" onclick="ocultaComent(\''.$n.'\')" title="'.$id_ocultar.'"><img src="imgs/cancelar_peq.png" alt="'.$id_ocultar.'" /></a>';
		echo '</li>';
		
	}
echo '</ul>';
echo '</td>';
echo '<td class="justificado">';
echo '<ul>';
for($n=(2*$div_red);$n<$num_alum;$n++)
	{
	$reg_alum=mysql_fetch_array($sel_alum);
	$nom_alum=$reg_alum['nombre'];
	$ape_alum =$reg_alum['apellidos'];
	$cod_alum =$reg_alum['codigo'];
	
		echo '<li><input type="hidden" id="cod_'.$n.'" name="cod_'.$n.'" value="'.$cod_alum.'" /><input type="hidden" id="nom_'.$n.'" name="nom_'.$n.'" value="'.$nom_alum.'" /><input type="hidden" id="ape_'.$n.'" name="ape_'.$n.'" value="'.$ape_alum.'" /> <a href="#" onclick="abreFicha(\''.$cod_alum.'\',\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$accion.'\')" title="'.$id_verficha.'"> '.$ape_alum.'</a>, <a href="#" title="'.$id_foto.'" onclick="new LITBox(\'carga_foto_al.php?usuario='.$cod_alum.'\', {type:\'window\', overlay:true, height:190, width:120, resizable:false});">'.$nom_alum.'</a>&nbsp;<a href="#" onclick="muestraComent(\''.$n.'\')" title="'.$id_coment.'"  ><img src="imgs/obs_peq.png" alt="'.$id_coment.'" /></a></li>';

		echo '<li class="oculto" id="li_'.$n.'">';
		echo '<textarea id="com_'.$n.'" name="com_'.$n.'" columns="20" rows="3"></textarea>';
		echo '&nbsp;';
		echo '<a href="#" onclick="ocultaComent(\''.$n.'\')" title="'.$id_ocultar.'"><img src="imgs/cancelar_peq.png" alt="'.$id_ocultar.'" /></a>';
		echo '</li>';
		
	}
echo '</ul>';
echo '</td>';
echo '</tr>';
echo '</table><br />';
echo '<p class="centrado"><a href="#" onclick="grabaObs1(\''.$sesion.'\',\''.$fecha_ing.'\',\''.$hini.'\',\''.$num_alum.'\')" title="'.$id_regnotas.'"><img src="imgs/guardar.png" alt="'.$id_regnotas.'" /></a></p>';
echo '</form>';
break;

}//fin switch

}//fin hay sesión

?>
