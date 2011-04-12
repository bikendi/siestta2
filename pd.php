<?php
//incluimos funciones,configuración e idioma
include('funciones.php');
require('config.php');
require('idioma/'.$idioma.'');
conecta();
$sel=mysql_query("select email from docentes where docente = '$administrador'");
$reg=mysql_fetch_array($sel);
$email=$reg['email'];
/*
This file is part of SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado).

SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) is developed by Ramón Castro Pérez. You can get more information at http://www.ramoncastro.es

SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) includes  the FPDF class (http://www.fpdf.org) in the “pdf” directory and some scripts use this class.

SIESTTA (Sistema Informático Especializado en el Seguimiento Tutorial del Alumnado) is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
	
You cand find a copy of the GNU General Public License in the "license" directory.

You should have received a copy of the GNU General Public License along with SIESTTA; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA.  
*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SIESTTA 2.0 - Protección de datos</title>
<link href="index.css" rel="stylesheet" type="text/css" />
</head>
<body>

<br>
<br>
<br>
<br>

<div style="text-align: center;"><big><big><big>Protección de datos en el sistema SIESTTA</big></big></big></div>

<br>

<div style="">
<table align="center" width="75%">

  <tbody>



    <tr>

      <td align="justify">
      <p>En conformidad con la Ley Orgánica 15/1999 de
13 de diciembre de
Protección de Datos de Carácter Personal (LOPD),
los datos
suministrados por el Usuario quedarán incorporados en un
fichero
automatizado, el cual será procesado exclusivamente para las siguientes
finalidades: información a familias y gestión docente. Los datos personales recogidos son los imprescindibles
para poder prestar el servicio requerido por el Usuario.</p>

      <p>Los datos de carácter personal
serán tratados con el grado de
protección adecuado, según el Real Decreto
994/1999 de 11 de junio,
tomándose las medidas de seguridad necesarias para evitar su
alteración, pérdida, tratamiento o acceso no
autorizado por parte de
terceros que lo puedan utilizar para finalidades distintas para las que
han sido solicitados al Usuario.</p>
      <p>El Usuario podrá ejercer sus derechos de
oposición, acceso, rectificación y cancelación, en
cumplimiento de lo establecido en la LOPD mediante comunicación
a <?php echo $email; ?>o a <?php echo $dir_centro; ?>.</p>
<p>El alumnado y/o sus tutores legales que utilicen este sistema informático estarán dando su conformidad para que los datos personales recabados sean utilizados exclusivamente para las siguientes
finalidades: información a familias y gestión docente.</p>

      </td>

    </tr>

  </tbody>
</table>

</div>

</body>
</html>
