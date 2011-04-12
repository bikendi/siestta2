<?php

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

/*el menú lateral es un trozo de código que carga en el panel de administración. Desde él se pueden realizar todas las acciones. Es una lista de enlaces desplegables con las funciones de script.aculo.us que nos mostrarán el contenido solicitado*/

echo '
<div id="menu">
<p>&nbsp;<a href="../panel.php" title="'.$id_volver.'"><img src="../imgs/volver.png" alt="'.$id_volver.'" /></a></p>
<ul>
	<li>
	<a href="#" title="'.$id_contraer.'" onclick="new Effect.Fade(\'docentes\'),new Effect.Fade(\'img_doc\')">
	<img style="display:none" id="img_doc" src="../imgs/menos.png"/>
	</a>
	<a href="#" onclick="new Effect.Appear(\'docentes\'),new Effect.Appear(\'img_doc\')"> '.$id_docentes.'</a>
	</li>
		<ul style="display:none" id="docentes">
		<li><a href="#" onclick="docLista()">'.$id_list_edi.'</a></li>
		<li><a href="#" onclick="docMasivo()">'.$id_reg_mas.'</a></li>
		<li><a href="#" onclick="docAgrega()">'.$id_agregar.'</a></li>
		</ul>

	<li>
	<a href="#" title="'.$id_contraer.'" onclick="new Effect.Fade(\'agrupamientos\'),new Effect.Fade(\'img_agr\')">
	<img style="display:none" id="img_agr" src="../imgs/menos.png"/>
	</a>
	<a href="#" onclick="new Effect.Appear(\'agrupamientos\'),new Effect.Appear(\'img_agr\')"> '.$id_agrup.'</a>
	</li>
		<ul style="display:none" id="agrupamientos">
		<li><a href="#" onclick="agrLista()">'.$id_list_edi.'</a></li>
		<li><a href="#" onclick="agrMasivo()">'.$id_reg_mas.'</a></li>
		<li><a href="#" onclick="agrAgrega()">'.$id_agregar.'</a></li>
		</ul>


	<li>
	<a href="#" title="'.$id_contraer.'" onclick="new Effect.Fade(\'grupos\'),new Effect.Fade(\'img_gru\')">
	<img style="display:none" id="img_gru" src="../imgs/menos.png"/>
	</a>
	<a href="#" onclick="new Effect.Appear(\'grupos\'),new Effect.Appear(\'img_gru\')"> '.$id_grupos.'</a>
	</li>
		<ul style="display:none" id="grupos">
		<li><a href="#" onclick="gruLista()">'.$id_list_edi.'</a></li>
		<li><a href="#" onclick="gruMasivo()">'.$id_reg_mas.'</a></li>
		<li><a href="#" onclick="gruAgrega()">'.$id_agregar.'</a></li>
		</ul>

	<li>
	<a href="#" title="'.$id_contraer.'" onclick="new Effect.Fade(\'alumnos\'),new Effect.Fade(\'img_alu\')">
	<img style="display:none" id="img_alu" src="../imgs/menos.png"/>
	</a>
	<a href="#" onclick="new Effect.Appear(\'alumnos\'),new Effect.Appear(\'img_alu\')"> '.$id_alumnos.'</a>
	</li>
		<ul style="display:none" id="alumnos">
		<li><a href="#" onclick="aluLista()">'.$id_list_edi.'</a></li>
		<li><a href="#" onclick="aluMasivo()">'.$id_reg_mas.'</a></li>
		<li><a href="#" onclick="aluAgrega()">'.$id_agregar.'</a></li>
		<li><a href="#" onclick="ediAluMasiva()">'.$id_edi_mas.'</a></li>
		</ul>

	<li>
	<a href="#" onclick="evaLista()">'.$id_evaluaciones.'</a>	
	</li>	

	
	<li>
	<a href="#" title="'.$id_contraer.'" onclick="new Effect.Fade(\'matricula\'),new Effect.Fade(\'img_mat\')">
	<img style="display:none" id="img_mat" src="../imgs/menos.png"/>
	</a>
	<a href="#" onclick="new Effect.Appear(\'matricula\'),new Effect.Appear(\'img_mat\')"> '.$id_matricula.'</a>
	</li>
		<ul style="display:none" id="matricula">
		<li><a href="#" onclick="matriculaConsulta()">'.$id_con_ed.'</a></li>
		<li><a href="#" onclick="matriculaMasiva()">'.$id_mat_mas.'</a></li>
		</ul>	
	
</ul>
<br /><p class="centrado"><a href="ayuda/index.html" title="'.$id_ayuda.'" target="_blank"><img src="../imgs/ayuda.png" alt="'.$id_ayuda.'" /></a>
</div>
';

?>
