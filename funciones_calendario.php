<?php
function numero_mes_a_nombre($mes)

{

require('config.php');
require('idioma/'.$idioma.'');

if($mes == 1) return $id_ene;
if($mes == 2) return $id_feb;
if($mes == 3) return $id_mar;
if($mes == 4) return $id_abr;
if($mes == 5) return $id_may;
if($mes == 6) return $id_jun;
if($mes == 7) return $id_jul;
if($mes == 8) return $id_ago;
if($mes == 9) return $id_sep;
if($mes == 10) return $id_oct;
if($mes == 11) return $id_nov;
if($mes == 12) return $id_dic;

}

function dia_esp($day)
{

require('config.php');
require('idioma/'.$idioma.'');

if ($day=='Monday') return $id_l;
if ($day=='Tuesday') return $id_m;
if ($day=='Wednesday') return $id_x;
if ($day=='Thursday') return $id_j;
if ($day=='Friday') return $id_v;
if ($day=='Saturday') return $id_s;
if ($day=='Sunday') return $id_d;
}



//funcion que devuelve el último día de un mes y año dados
function ultimo_dia($mes,$anyo){ 
    $ultimo_dia=28; 
    while (checkdate($mes,$ultimo_dia + 1,$anyo)){ 
       $ultimo_dia++; 
    } 
    return $ultimo_dia; 
} 
?>
