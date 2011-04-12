/*Funciones propias de javascript*/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Autor: Ramón Castro Pérez	///////////////////////////////////////////////////////////////////////////////////
Web: http://ramoncastro.es	///////////////////////////////////////////////////////////////////////////////////
Licencia: GPL http://gnu.org	///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////*/


/*De: http://www.estadobeta.net/2006/10/10/prototype-ajax/*/
/* Javascript: se define un objeto con callbacks globales */
var globalCallbacks = {
                onCreate: function(){
                        $('cargando').show();
                },
                onComplete: function() {
                        if(Ajax.activeRequestCount == 0){
                                $('cargando').hide();
                        }
                }
        };
/* Se registran los callbacks en Ajax.Responders */
Ajax.Responders.register( globalCallbacks );
/*Fin Estado Beta//////////////////////////////////////////////////////////////////////////////////////////////////*/

function procesaRespuesta(resp){
	$("center").innerHTML = resp.responseText;
}
/////////////////////////////////////////CALENDARIO////////////////////////////////////////////////////////////////
function navegaMes(numero,anyo,variacion){
	var url = "panel_pda.php";
		if(variacion=="menos")
			{
			numeromes=parseFloat(numero);
			mes = numeromes - 1;
			if(mes<1)
				{
				mes = 12;
				anyo = anyo - 1;
				}
			}
		else
			{
			numeromes=parseFloat(numero);
			mes = numeromes + 1;
			if(mes>12)
				{
				mes = 1;
				anyo = (parseInt(anyo) + 1);
				}
			}
	var pars = "p2="+mes+"&p3="+anyo+"";
	var ajax = new Ajax.Request( url, {
			parameters: pars,
			method: "post",
			onComplete: procesaRespuesta
			});
}
function navegaAnyo(numero,mes,variacion){
	var url = "panel_pda.php";
		if(variacion=="menos")
			{
			anyo = (parseInt(numero) - 1);
			}
		else
			{
			anyo = (parseInt(numero) + 1);
			}
	var pars = "p3="+anyo+"&p2="+mes+"";
	var ajax = new Ajax.Request( url, {
			parameters: pars,
			method: "post",
			onComplete: procesaRespuesta
			});
}

function calendario(dia,mes,anyo){
	var url="panel_pda.php";
	var pars = "p1="+dia+"&p2="+mes+"&p3="+anyo+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}


///////////////////////////////////////FIN CALENDARIO//////////////////////////////////////////////////////////////
function abreListaTareas(fecha){
	var url="panel_pda.php";
	var pars = "lista_tareas=si&fecha_tarea="+fecha+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				}) 
}
function abreListaExamen(fecha){
	var url="panel_pda.php";
	var pars = "lista_examen=si&fecha_examen="+fecha+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				}) 
}
function abreAgrup(agrupamiento,hora,accion,fecha){
	var url="accion.php";
	var pars = "accion="+accion+"&agr="+agrupamiento+"&hini="+hora+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function abreAgrup1(agrupamiento,hora,fecha,tipo){
	var accion=$F("rd_accion_"+tipo+"");
	var url="accion.php";
	var pars = "accion="+accion+"&agr="+agrupamiento+"&hini="+hora+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function abreFichaPda(codigo,agrupamiento,hora,fecha){
	var url="accion.php";
	var pars = "codigo="+codigo+"&accion=ficha&agr="+agrupamiento+"&hini="+hora+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function regAsiPda(codigo,agrupamiento,hini,n,tipo,fecha,d){
	var dato = $F("rd_"+n+"_"+d+"");
	var url="accion.php";
	var pars = "registro=asi&codigo="+codigo+"&dato="+dato+"&accion="+tipo+"&agr="+agrupamiento+"&hini="+hini+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function eliAsiPda(codigo,agrupamiento,hini,tipo,fecha){
	var dato = "A";
	var url="accion.php";
	var pars = "registro=asi&codigo="+codigo+"&dato="+dato+"&accion="+tipo+"&agr="+agrupamiento+"&hini="+hini+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function abreNotasPda(codigo,agrupamiento,fecha_ini,fecha_fin,hini,fecha,nombre,apellidos){
	var url="accion.php";
	var pars = "codigo="+codigo+"&fecha_ini="+fecha_ini+"&fecha_fin="+fecha_fin+"&accion=lista_notas&agr="+agrupamiento+"&hini="+hini+"&fecha="+fecha+"&nombre="+nombre+"&apellidos="+apellidos+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function editaNota(nombre_input,campo,id){
	new Ajax.InPlaceEditor('' + nombre_input + '', '../edita.php?id='+id+'&campo='+campo+'&tabla=notas',{size:"15"});
}
function grabaNotaPda(agrupamiento,hini,n,fecha){
	var actividad = $F("list_act");
	var descripcion = $F("txt_descrip");
	if(actividad == '0')
		{
		alert("No se ha especificado la actividad. No se grabará nada");
		exit;
		}
	if(descripcion == '')
		{
		alert("No se ha especificado una descripción de la actividad. No se grabará nada");
		exit;
		}
	var url="accion.php";
	var params = Form.serialize($('notas'));
	var pars = "registro=not&agr="+agrupamiento+"&hini="+hini+"&actividad="+actividad+"&descripcion="+descripcion+"&numero="+n+"&fecha="+fecha+"";
	var parametros = ""+params+"&"+pars+"";
	var ajax = new Ajax.Request( url, {
				parameters: parametros,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function grabaObsPda(agrupamiento,hini,n,fecha){
	var url="accion.php";
	var params = Form.serialize($('obs'));
	var pars = "registro=obs&agr="+agrupamiento+"&hini="+hini+"&numero="+n+"&fecha="+fecha+"";
	var parametros = ""+params+"&"+pars+"";
	var ajax = new Ajax.Request( url, {
				parameters: parametros,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function grabaTareaPda(agrupamiento,hini,tipo,fecha){
	var tarea = $F('area_tarea');
	var destin = $F('list_tarea');
	if(destin == '0')
		{
		alert("No se ha especificado para quien es la tarea. No se grabará nada");
		exit;
		}
	if( ! confirm("Se grabará la tarea "+tarea+" para el día "+fecha+"") ) {
		return false;
	    }
	var url = "accion.php";
	var pars = "accion="+tipo+"&registro=tar&agr="+agrupamiento+"&hini="+hini+"&tarea="+tarea+"&destin="+destin+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function grabaExaPda(agrupamiento,hini,tipo,fecha){
	var examen = $F('area_examen');
	if( ! confirm("Se grabará el examen "+examen+" para el día "+fecha+"") ) {
		return false;
	    }
	var url = "accion.php";
	var pars = "accion="+tipo+"&registro=exa&agr="+agrupamiento+"&hini="+hini+"&examen="+examen+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function abreJustifPda(codigo,agrupamiento,hini,tipo,fecha){
	var url = "accion.php";
	var pars = "accion="+tipo+"&agr="+agrupamiento+"&hini="+hini+"&codigo="+codigo+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function abreJustifAnteriorPda(codigo,agrupamiento,hini,tipo,mes,fecha){
	if(mes=='1')
		{
		var nuevo_mes = '12';
		}
	else
		{
		nuevo_mes = (parseInt(mes) - 1);
		}
	var url = "accion.php";
	var pars = "accion="+tipo+"&agr="+agrupamiento+"&hini="+hini+"&codigo="+codigo+"&mes="+nuevo_mes+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function abreJustifSiguientePda(codigo,agrupamiento,hini,tipo,mes,fecha){
	if(mes=='12')
		{
		var nuevo_mes = '1';
		}
	else
		{
		nuevo_mes = (parseInt(mes) + 1);
		}
	var url = "accion.php";
	var pars = "accion="+tipo+"&agr="+agrupamiento+"&hini="+hini+"&codigo="+codigo+"&mes="+nuevo_mes+"&fecha="+fecha+"";
	var ajax = new Ajax.Request( url, {
				parameters: pars,
				method: "post",
				onComplete: procesaRespuesta
				})
}
function justiFicaPda(agrupamiento,hini,codigo,mes,fecha){
	var url="accion.php";
	var params = Form.serialize($('lista'));
	var pars = "agr="+agrupamiento+"&hini="+hini+"&codigo="+codigo+"&mes="+mes+"&accion=justif&j=si&fecha="+fecha+"";
	var parametros = ""+params+"&"+pars+"";
	var ajax = new Ajax.Request( url, {
				parameters: parametros,
				method: "post",
				onComplete: procesaRespuesta
				})

}
function marcaTodos(numero){
   for (i=0;i<numero;i++)
	{
	document.getElementById('just_'+i+'').checked=1;
        }
} 
function desmarcaTodos(numero){
   for (i=0;i<numero;i++)
	{
	document.getElementById('just_'+i+'').checked=0;
        }
} 
