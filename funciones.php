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

function conecta()
	{
	require('config.php');
 	$con_mysql=mysql_connect($servidor,$usuario_mysql,$clave_mysql)or die('ERROR:'.mysql_error());
	mysql_select_db($bd)or die('ERROR:'.mysql_error());
	}

function cambia_fecha_a_esp($fecha){
    ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;

}

function cambia_fecha_a_ing($fecha){
    ereg( "([0-9]{1,2})-([0-9]{1,2})-([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}
function cambia_fecha_a_ing_esp($fecha){
    ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
}

function encuentra_dia($dia){

require('config.php');
require('idioma/'.$idioma.'');

switch ($dia)
	{
	case '0':
	$nombredia=$id_l;
	break;
	case '1':
	$nombredia=$id_m;
	break;
	case '2':
	$nombredia=$id_x;
	break;
	case '3':
	$nombredia=$id_j;
	break;
	case '4':
	$nombredia=$id_v;
	break;
	case '5':
	$nombredia=$id_s;
	break;
	case '6':
	$nombredia=$id_d;
	break;
	}
return $nombredia;
}


function encuentra_dia_abr($dia){

require('config.php');
require('idioma/'.$idioma.'');

switch ($dia)
	{
	case '0':
	$nombredia=$id_cl;
	break;
	case '1':
	$nombredia=$id_cm;
	break;
	case '2':
	$nombredia=$id_cx;
	break;
	case '3':
	$nombredia=$id_cj;
	break;
	case '4':
	$nombredia=$id_cv;
	break;
	case '5':
	$nombredia=$id_cs;
	break;
	case '6':
	$nombredia=$id_cd;
	break;
	}
return $nombredia;
}


function extrae_dia_mysql($fecha)

{

return substr($fecha,8,10);

}

function extrae_mes_ingles($fecha)

	{

	$primero=substr($fecha,5,8);
	return substr($primero,0,2);

}


function calcula_edad($fecha_nac)

{

$anio_nac = substr($fecha_nac,0,4);
$mes_nac = extrae_mes_ingles($fecha_nac);
$dia_nac = extrae_dia_mysql($fecha_nac);

$anio_hoy = date('Y');
$mes_hoy = date('m');
$dia_hoy = date('d');

$edad = $anio_hoy - $anio_nac;

if($mes_hoy < $mes_nac || ($mes_hoy == $mes_nac) && ($dia_hoy < $dia_nac))

$edad = $anio_hoy - $anio_nac - 1;

return $edad;

}

function siguiente_letra($letra)
{
$abc = "abcdefghijklmnopqrstuvwyz";
$posicion = strpos($abc,$letra);
$loquebusco = substr($abc,$posicion+1,1);
return $loquebusco;
}

function nombre_mes($mes)
{
require('config.php');
require('idioma/'.$idioma.'');
switch ($mes)
	{
	case 'Jan':
	$nombremes=$id_enero;
	break;
	case 'Feb':
	$nombremes=$id_febrero;
	break;
	case 'Mar':
	$nombremes=$id_marzo;
	break;
	case 'Apr':
	$nombremes=$id_abril;
	break;
	case 'May':
	$nombremes=$id_mayo;
	break;
	case 'Jun':
	$nombremes=$id_junio;
	break;
	case 'Jul':
	$nombremes=$id_julio;
	break;
	case 'Aug':
	$nombremes=$id_agosto;
	break;
	case 'Sep':
	$nombremes=$id_septiembre;
	break;
	case 'Oct':
	$nombremes=$id_octubre;
	break;
	case 'Nov':
	$nombremes=$id_noviembre;
	break;
	case 'Dec':
	$nombremes=$id_diciembre;
	break;
	}
return $nombremes;
}
function nombre_mes2($mes)
{
require('config.php');
require('idioma/'.$idioma.'');
switch ($mes)
	{
	case '1':
	$nombremes=$id_enero;
	break;
	case '2':
	$nombremes=$id_febrero;
	break;
	case '3':
	$nombremes=$id_marzo;
	break;
	case '4':
	$nombremes=$id_abril;
	break;
	case '5':
	$nombremes=$id_mayo;
	break;
	case '6':
	$nombremes=$id_junio;
	break;
	case '7':
	$nombremes=$id_julio;
	break;
	case '8':
	$nombremes=$id_agosto;
	break;
	case '9':
	$nombremes=$id_septiembre;
	break;
	case '10':
	$nombremes=$id_octubre;
	break;
	case '11':
	$nombremes=$id_noviembre;
	break;
	case '12':
	$nombremes=$id_diciembre;
	break;
	}
return $nombremes;
}
function nombre_dia_a_numero($nombre_dia_ing)
{
switch($nombre_dia_ing)
	{
	case 'Mon':
	$numero='1';
	break;
	case 'Tue':
	$numero='2';
	break;
	case 'Wed':
	$numero='3';
	break;
	case 'Thu':
	$numero='4';
	break;
	case 'Fri':
	$numero='5';
	break;
	case 'Sat':
	$numero='6';
	break;
	case 'Sun':
	$numero='7';
	break;
	}
return $numero;
}
function decode($var)
	{
	return utf8_decode($var);
	}
?>
