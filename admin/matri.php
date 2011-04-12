<?php

session_start();
//incluimos funciones,configuración e idioma
include('../funciones.php');
require('../config.php');
require('../idioma/'.$idioma.'');
//si hay sesión cargamos código
if (isset($_SESSION['usuario_sesion']) && $_SESSION['rol_sesion'] == 'admin')
{
//conecto con MySQL
conecta();
//recogemos la información cargando la variable
$accion=$_POST['p1'];
$grupo=$_POST['p2'];
$graba=$_POST['p3'];

switch($accion)
	{
	case 'masiva':

	echo '<br /><span class="negrita">'.$id_mat_mas.' '.$id_de.' '.$id_alumnos.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_mat_mas.'</p>';
	
	//listaré paginando por grupos de referencia
	$sel_gru = mysql_query("select cod_grupo from grupos");
	$numero_gru = mysql_num_rows($sel_gru);
		echo '<ul class="lista_grupos">';
		for($g=0;$g<$numero_gru;$g++)
		{
		$reg_gru = mysql_fetch_array($sel_gru);
		echo '<li><a href="#" onclick="listaGrupoMatricula(\''.$reg_gru['cod_grupo'].'\')" title="'.$id_vergrupo.'">'.$reg_gru['cod_grupo'].'</a></li>';
		}
		echo '</ul><br />';
		
	if($grupo)
	{
	//selecciono y listo
	$sel_alumnos = mysql_query("select codigo,nombre,apellidos from alumnado where grupo = '$grupo' order by apellidos,nombre");
	$num_alumnos = mysql_num_rows($sel_alumnos);
	echo '<p class="negrita">'.$id_gru.' '.$grupo.'</p>';
	echo '<form id="alumnado_a_matricular" name="alumnado_a_matricular">'; 
	echo '<select multiple class="floatleft" name="codigo[]" id="codigo" ondblclick="abreFicha()">';
	for($n=0;$n<$num_alumnos;$n++)
		{
		$reg_alumnos = mysql_fetch_array($sel_alumnos);
		echo '
		<option value="'.$reg_alumnos['codigo'].'">
		'.$reg_alumnos['nombre'].' '.$reg_alumnos['apellidos'].'
		</option>';
	}
	echo '</select>';
	echo '</form>';
	//selecciono agrupamientos
	$sel_agrup = mysql_query("select * from agrupamientos");
	$num_agrup = mysql_num_rows($sel_agrup);
	echo '<select class="floatleft" name="agrupamiento" id="agrupamiento" onchange="matriculaAlumnos()">';
	echo '<option>'.$id_agr.'</option>';
	for($i=0;$i<$num_agrup;$i++)
		{
		$reg_agrup = mysql_fetch_array($sel_agrup);
		echo '<option value="'.$reg_agrup['agrupamiento'].'">'.$reg_agrup['agrupamiento'].'('.$reg_agrup['materia'].' '.$reg_agrup['docente'].')</option>';
		}
	echo '</select>';
	}//fin if($grupo)
	
	if($graba)
	{
	$agrupamiento = $_POST['agrupamiento'];
	$alum_matri = $_POST['codigo'];
	//recogemos alumnos
	for ($i=0;$i<count($alum_matri);$i++)
		{ 
		//matriculamos
		$codigo_matri = $alum_matri[$i];
		$inserta_matri = mysql_query("insert into matricula values ('$codigo_matri','$agrupamiento')");
		}
	//listo los matriculados
	$sel_alum = mysql_query("select alumnado.nombre,alumnado.apellidos,alumnado.codigo,matricula.codigo,matricula.agrupamiento from alumnado,matricula where alumnado.codigo=matricula.codigo and matricula.agrupamiento='$agrupamiento' order by alumnado.apellidos,alumnado.nombre");
	$num_alum = mysql_num_rows($sel_alum);
	echo '<p class="negrita_cursiva">'.$id_resultado.' '.$id_de.' '.$id_mat_mas.'</p>';
	echo '<table>';
	echo '<tr class="encab">';
	echo '<td>'.$id_agr.' '.$agrupamiento.'</td>';
	echo '</tr>';
	for($j=0;$j<$num_alum;$j++)
		{
		$n=$j+1;
		$reg_alum = mysql_fetch_array($sel_alum);
		echo '<tr>';
		echo '<td>'.$n.' '.$reg_alum['nombre'].' '.$reg_alum['apellidos'].'</td>';
		echo '</tr>';
		}
	echo '</table>';
	}//fin if($graba)
	break;

	case 'consulta':

	echo '<br /><span class="negrita">'.$id_con_ed.' '.$id_de.' '.$id_matricula.'</span><br />';
	echo '<br /><p class="texto_centrado">'.$id_texto_mat_con.'</p>';
	
	//monto un select para listar los alumnos matriculados en el agrupamiento
	echo '<select name="agrupamiento" id="agrupamiento" onchange="listaAlumMat()">';
        echo '<option>'.$id_agr.'</p>';
	$sel_agr = mysql_query("select agrupamiento from agrupamientos");
	$num_agr = mysql_num_rows($sel_agr);
	for($a=0;$a<$num_agr;$a++)
		{
		$reg_agr = mysql_fetch_array($sel_agr);
		echo '<option>'.$reg_agr['agrupamiento'].'</option>';
		}
	echo '</select>';
	$actualiza_agrupa = $_POST['p7'];
	$numero_act_agrupa = $_POST['p8'];
	$agrupa_antiguo = $_POST['p9'];
	if($actualiza_agrupa && $numero_act_agrupa)
	{
	for($act=0;$act<$numero_act_agrupa;$act++)
		{
		$check = $_POST['cb_'.$act.''];
		if($check)
			{
			$actualiza_agr = mysql_query("update matricula set agrupamiento = '$actualiza_agrupa' where codigo = '$check' and agrupamiento = '$agrupa_antiguo'");
			}
		}
	}
	$borra_codigo = $_POST['p5'];
	$borra_agrupa = $_POST['p6'];
	if($borra_codigo && $borra_agrupa)
	{
	$elim_mat = mysql_query("delete from matricula where codigo = '$borra_codigo' and agrupamiento = '$borra_agrupa'");
	}
	$agrupamiento = $_POST['p4'];
	$sel_alum = mysql_query("select alumnado.nombre,alumnado.apellidos,alumnado.codigo,matricula.codigo,matricula.agrupamiento from alumnado,matricula where alumnado.codigo=matricula.codigo and matricula.agrupamiento='$agrupamiento' order by alumnado.apellidos,alumnado.nombre");
	$num_alum = mysql_num_rows($sel_alum);
	if($num_alum>0)
	{
	echo '<form id="checkboxes" name="checkboxes">';
	echo '<br /><table class="tablacentrada">';
	echo '<tr class="encab">';
	echo '<td><a href="#" onclick="marcaTodos(\''.$num_alum.'\',\'checkboxes\')">'.$id_sel.'</a></td>';
	echo '<td>'.$id_agr.' '.$agrupamiento.'</td>';
	echo '</tr>';
	for($j=0;$j<$num_alum;$j++)
		{
		$reg_alum = mysql_fetch_array($sel_alum);
		$n=$j+1;
		if($j%2==0)echo '<tr class="par">'; else echo '<tr>';
		echo '<td class="centrado"><input name="cb_'.$j.'" id="cb_'.$j.'" value="'.$reg_alum['codigo'].'" type="checkbox" /></td>';
		echo '<td class="justificado"><a href="#" title="'.$id_eliminar.'" onclick="matBorra(\''.$reg_alum['codigo'].'\',\''.$agrupamiento.'\')"><img src="../imgs/borra_peq.png" alt="'.$id_eliminar.'" /></a> '.$n.' <a href="#" title="'.$id_editar.'" onclick="new LITBox(\'carga_fichaal.php?alu='.$reg_alum['codigo'].'\', {type:\'window\', overlay:true});">'.$reg_alum['apellidos'].', '.$reg_alum['nombre'].'</a></td>';
		echo '</tr>';
		}
	echo '</table><br />';
	//selecciono agrupamientos
	$sel_agrup = mysql_query("select * from agrupamientos");
	$num_agrup = mysql_num_rows($sel_agrup);
	echo '<select name="list_agrupamiento" id="list_agrupamiento" onchange="cambiaAlumnosAgrup(\''.$num_alum.'\',\''.$agrupamiento.'\')">';
	echo '<option>'.$id_mover_agr.'</option>';
	for($i=0;$i<$num_agrup;$i++)
		{
		$reg_agrup = mysql_fetch_array($sel_agrup);
		echo '<option value="'.$reg_agrup['agrupamiento'].'">'.$reg_agrup['agrupamiento'].'('.$reg_agrup['materia'].' '.$reg_agrup['docente'].')</option>';
		}
	echo '</select>';
	echo '</form>';
	}
	break;

	}//fin switch

}//fin hay sesión
?>

