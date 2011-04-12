<?php

//////////////////////TRADUCCIÓN: VICENT LLOP///////////////////////////////////////////////////////////

/*///////////////////////////////////////////////////////////////////////////////////////////////////////////
///Este archivo es parte de SIESTTA 2.0 y forma parte del Ã©l. Por tanto, es aplicable////////////////////////
///su licencia GNU GPL///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///AplicaciÃ³n: SIESTTA 2.0 (SoluciÃ³n InformÃ¡tica Especializada en el Seguimiento TuTorial del Alumnado)//////
///Web del proyecto: http://siestta.org//////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Autor: RamÃ³n Castro PÃ©rez/////////////////////////////////////////////////////////////////////////////////
///Web: http://ramoncastro.es////////////////////////////////////////////////////////////////////////////////
///Mail: ramoncastroperez@gmail.com//////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Esta aplicaciÃ³n es software libre: puede redistribuirlo y/o modificarlo///////////////////////////////////
///bajo los tÃ©rminos de la GNU General Public License publicada por la///////////////////////////////////////
///Free Software Foundation, en su versiÃ³n 3 o posterior/////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Este programa es distribuido con la intenciÃ³n de que sea Ãºtil, pero sin///////////////////////////////////
///ninguna garantÃ­a. Vea los tÃ©rminos de la licencia GNU GPL para mÃ¡s detalles///////////////////////////////
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

//las variables de idioma se identifican con el prefijo id

$id_admin = 'Administrar';
$id_admin_sist = 'Administració del sistema';
$id_descon = 'Desconnexió';

$id_si = 'Sí­';
$id_no = 'No';
$id_av = 'De vegades';

$id_inicio = 'Inici';
$id_fin = 'Fi';
$id_docentes = 'Docents';
$id_grupos = 'Grups';
$id_agrup = 'Agrupaments';
$id_alumnos = 'Alumnes';
$id_alumno = 'alumne';
$id_Alumno = 'Alumne';
$id_evaluaciones = 'Avaluacions';
$id_evaluacion = 'Avaluació';
$id_matricula = 'Matrí­cula';
$id_con_ed = 'Consultar/Editar';
$id_periodos = 'Períodes';
$id_periodo = 'Període';

$id_contraer = 'Enrotllar';
$id_volver = 'Tornar';

$id_list_edi = 'Llistat/Edició';
$id_reg_eva = 'Registre i edició de Perí­odes d´Avaluació';
$id_reg_mas = 'Registre massiu';
$id_agregar = 'Afegir';
$id_eliminar = 'Eliminar';
$id_eliminados = 'Eliminats';
$id_cambiados = 'Canviats';
$id_edi_mas = 'Edició massiva';
$id_mat_mas = 'Matrícula massiva';
$id_mat_alu = 'Matricular alumn@';
$id_mat_edi = 'Canviar matrí­cula';
$id_camb_gru = 'Canviar al grup';

$id_de = 'de';
$id_para = 'per a';
$id_por = 'per';
$id_un = 'un';

$id_ayuda = 'Ajuda';
$id_texto_rm_doc = 'Utilitza esta funció per registrar tots els docents del
Centre mijançant la càrrega d´un arxiu CSV. Trobaràs
més informació pressionant la icona "Ajuda". Si desitges afegir un únic docent,
dirigix-te a "Afegir", en el menú lateral. Per canviar dades de docents o eliminar-los, clica en el menú lateral "Llistat/Edició"
';
$id_texto_rm_agr = 'Utilitza esta funció per registrar tots els agrupaments lectius del
Centre mijançant la càrrega d´un arxiu CSV. Trobaràs
més informació pressionant la icona "Ajuda". Si desitges afegir un único agrupament,
dirigix-te a "Afegir", en el menú lateral. Per canviar dades de l´agrupament o eliminar-los, clica en el menú lateral "Llistat/Edició"
';
$id_texto_rm_gru = 'Utilitza esta funció per registrar tots els grups del
Centre mijançant la càrrega d´un arxiu CSV. Trobaràs
més informació pressionant la icona "Ajuda". Si desitges afegir un únic grup,
dirigix-te a "Afegir", en el menú lateral. Per canviar dades de grups o eliminar-los, clica en el menú lateral "Llistat/Edició"
';
$id_texto_rm_alu = 'Utilitza esta funció per registrar tots els/les alumnes del
Centre mijançant la càrrega d´un arxiu CSV. Trobaràs
més informació pressionant la icona "Ajuda". Si desitges afegir un/a únic/a alumne-a,
dirigix-te a "Afegir", en el menú lateral. Per canviar dades de grups o eliminar-los, clica en el menú lateral "Llistat/Edició"
';
$id_texto_li_doc = 'Des d´ací­ podràs comprovar la llista de docents
(ordenats alfabèticament per cognoms) i canviar totes les seues dades excepte el nom d´usuari. També podràs suprimir-los. Tens més
informació pressionant la icona "Ajuda". Si desitges afegir un docent, fes clic en "Afegir", en el
menú lateral.';
$id_texto_li_agr = 'Des d´ací­ podràs comprovar la llista d´agrupaments
(ordenats alfabèticament per Departaments i Matèria) i canviar totes les seues dades excepte el nom de l´agrupament. També podràs suprimir-los. Tens més
informació pressionant la icona "Ajuda". Si desitges afegir un agrupament, fes clic en "Afegir", en el
menú lateral
.';
$id_texto_li_gru = 'Des d´ací­ podràs comprovar la llista de grups de referència
(ordenats alfabèticament per nivell i curs) i canviar totes les seues dades excepte el nom del grup. També podràs suprimir-los. Tens més
informació pressionant la icona "Ajuda". Si desitges afegir un grup, fes clic en "Afegir", en el
menú lateral

.';
$id_texto_li_alu = 'Des d´ací­ podràs comprovar la llista d´alumne
(ordenats alfabèticamente per grup, cognoms i nom) i canviar totes les seues dades, excepte el codi. També podàs suprimir-los. Tes més
informació polsant la icona "Ajuda". Si desitges afegir un/a alumne-a, fes clic en "Afegir", en el
menú lateral
.';
$id_texto_edi_doc = 'Ací pots canviar les dades del docent excepte el seu nom
d´usuari. Si no desitges canviar la clau, deixa en blanc els espais reservats
per a això. Trobaràs més informació polsant
la icona "Ajuda".
';
$id_texto_edi_agr = 'Ací pots canviar les dades de l´agrupament excepte el seu nom. Si no desitges canviar la clau, deixa en blanc els espais reservats
per a això. Trobaràs més informació polsant la icona "Ajuda".
';
$id_texto_edi_gru = 'Ací pots canviar les dades del grup excepte el seu nom. Si no desitges canviar la clau, deixa en blanc els espais reservats
per a això. Trobaràs més informació polsant la icona "Ajuda".
';
$id_texto_ag_doc = 'Des d´este formulari podràs afegir un docent a la base de
dades. Disposes de més informació polsant la
icona "Ajuda". Una vegada afegit fes clic en
"Llistat/Edició" per consultar el seu estat.
';
$id_texto_ag_agr = 'Des d´este formulari podràs afegir un agrupament a la base de
dades. Disposes de més informació polsant la
icona "Ajuda". Una vegada afegit fes clic en
"Llistat/Edició" per consultar el seu estat.
';
$id_texto_ag_gru = 'Des d´este formulari podràs afegir un grup a la base de
dades. Disposes de més informació polsant la
icona "Ajuda". Una vegada afegit fes clic en
"Llistat/Edició" per consultar el seu estat.
';
$id_texto_ag_alum = 'Des d´este formulari podràs afegir un alumne-a a la base de
dades. Disposes de més informació polsant la
icona "Ajuda". Una vegada afegit fes clic en
"Llistat/Edició" per consultar el seu estat
';
$id_texto_edi_mas_alum = 'Des d´este formulari podràs eliminar o canviar de grupo a diversos alumnes de manera simultània. Disposes de més informació polsant la
icona "Ajuda".';
$id_texto_reg_eva = 'Ací­ podràs registrar i editar les dates dels perí­odes en els que s´avaluarà l´alumnat. Disposes de més informació polsant la
icona "Ajuda".';
$id_texto_mat_mas = 'Ací­ podràs matricular tot l´alumnat del Centre. Disposes de més informació polsant la
icona "Ajuda".';
$id_texto_mat_con = 'Ací­ podràs consultar, canviar i eliminar la matrí­cula de l´alumnat del Centre. Disposes de més informació polsant la
icona "Ajuda".';
$id_texto_actividades = 'Ací­ podràs registrar, consultar, canviar i eliminar les activitats per les que avaluaràs i qualificaràs els teus alumnes. Disposes de més informació pulsando la
icona "Ajuda".';
$id_texto_horario = 'Ací­ podràs registrar, consultar, canviar i eliminar les franges horàries y el seu contingut. Disposes de méss informació polsant la icona "Ajuda".';

$id_csv = 'Arxiu CSV';
$id_reg = 'Registrar';
$id_error_upload = 'Error al pujar l´arxiu';
$id_error_formato = 'L´arxiu no té el format correcte. No s´ha pujat res.';
$id_error_transf = 'Transferencia interrumpida';
$id_transferido = 'transferit';

$id_reg_exito = 'Registre efectuat am èxit';

$id_doc = 'Docent';
$id_familia = 'Família';
$id_cla = 'Clau';
$id_nom = 'Nom';
$id_ape = 'Cognoms';
$id_ema = 'Email';
$id_esp = 'Especialitat';
$id_web = 'Web';
$id_te1 = 'Telèfon 1';
$id_te2 = 'Telèfon 2';
$id_rol = 'Rol';
$id_cod = 'Codi';
$id_fna = 'D. Naixement';
$id_fna_abrev = 'D.Naix.';
$id_mod = 'Modalitat';
$id_rep = 'Repetix';
$id_tu1 = 'Tutor/a 1';
$id_tu2 = 'Tutor/a 2';
$id_di1 = 'Adreça 1';
$id_di2 = 'Adreça 2';
$id_nac = 'Nacionalitat';

$id_gru = 'Grup';
$id_agr = 'Agrupament';
$id_dep = 'Departament';
$id_mat = 'Matèria';
$id_cur = 'Curs';
$id_niv = 'Nivell';

$id_editar = 'Editar';
$id_guardar = 'Guardar';
$id_cambio_cla = 'Canvi de clau';
$id_nueva_cla = 'Nova clau';
$id_intro_cla1 = 'Escriu la nova clau';
$id_intro_cla2 = 'Escriu la nova clau';
$id_rep_cla1 = 'Repetix la clau';

$id_datos = 'dades';

$id_admin = 'Administrador';

$id_doc_eliminado = 'Este docent ha sigut eliminat. Pots tornar a la llista fent
clic en "Llistat/Edició"
.';
$id_agr_eliminado = 'Este agrupament ha sigut eliminat. Pots tornar a la llista fent
clic en "Llistat/Edició"
.';
$id_datos_doc_edit = 'S´han actualitzat les dades d´este docent. Pots tornar a la llista fent
clic en "Llistat/Edició"
.';
$id_datos_agr_edit = 'S´han actualitzat les dades d´este agrupament. Pots tornar a la llista fent
clic en "Llistat/Edició"
.';
$id_datos_gru_edit = 'S´han actualitzat les dades d´este grup de referència. Pots tornar a la llista fent
clic en "Llistat/Edició"
.';
$id_error_editar = 'Error a l´actualitzar. No s´han canviat les dades';

$id_error_clave = 'Les claus no coincidixen. No s´ha actualitzat res';

$id_record_clave = 'Has canviat la clau d´este docent. Deus notificar-la el més prompte possible a l´interessat i indicar-li que la canvie des del Panel de Control';

$id_ins = 'Les dades han sigut registrades. Accedix a "Llistat/Edició" per consultar-les.';
$id_error_ins = 'Ha ocorregut un error. No s´ha pogut registrar res.';
$id_elim_todos = 'Eliminar tot';
$id_eli = 'S´ha eliminat tot';
$id_borra_error = 'Ha ocorregut un error. No s´ha pogut eliminar res.';

$id_elige_doc = 'Tria docent';
$id_elige_tut1 = 'Tria tutor/a 1';
$id_elige_tut2 = 'Tria tutor/a 2';

$id_foto = 'Foto';

$id_vergrupo = 'Llistar alumnat del grup';

$id_guardado = 'guardat';
$id_grabando = 'Carregant/Gravant Dades';
$id_cargando = 'Carregat';

$id_marcar_todos = 'Tots';
$id_todos_al = 'Tot l´alumnat';
$id_todas_act = 'Totes les activitats';
$id_todo_curso = 'Tot el curs';

$id_accion = 'Acció';

$id_siguiente = 'Següent';
$id_anterior = 'Anterior';

$id_fecha = 'Data';

$id_per_activo = 'Períodes donats d´alta';

$id_mat_mas='Matriculació';

$id_resultado = 'Resultat';

$id_mover_agr = 'Canviar l´agrupament';

$id_sel = 'Seleccionar';

$id_misdatos = 'Les meues dades';
$id_misactividades = 'Les meues activitats';
$id_mihorario = 'El meu horari';
$id_misinformes = 'Els meus informes';
$id_misagr = 'Els meus agrupaments';
$id_inf_asi = 'Assistència';
$id_inf_not = 'Qualificacions';
$id_inf_inc = 'Incidències';
$id_inf_tar = 'Deures';
$id_inf_ent = 'Entrevistes';
$id_inf_obs = 'Observacions';
$id_inf_nb = 'Nota Bene';
$id_inf_exa = 'Exàmens';
$id_inf_car = 'Cartes';
$id_inf_tut = 'Tutori­a';
$id_inf_bol = 'Butlletins';
$id_inf_Bol = 'Butlletí';
$id_inf_eva = 'Avaluació';
$id_mismensajes = 'Els meus missatges';
$id_centrotrab = 'Centre de treball';
$id_direccion = 'Adreça';
$id_telef = 'Telèfon';
$id_fax = 'Fax';
$id_nav = 'Navegar';
$id_nueva_foto = 'Canviar foto';
$id_mensaje_foto = 'Èxit. Polsa en Les meues dades de nou per vore la fotografia pujada';

$id_activ = 'Activitat';
$id_agrupamiento = 'Agrupamient';
$id_reg_activ = 'Registrar una nova activitat';
$id_nom_activ = 'Nom de l´activitat';
$id_agr_activ = 'Selecciona els agrupaments als qui assignes esta nova activitat i la seua ponderació';
$id_noagrup = 'No tens assignat ningun agrupament encara. Contacta amb l´administrador del sistema.';
$id_ponderacion = 'Ponderació (%)';
$id_ponderacion_txt = 'Ponderació en %. Utilitza el punt com separador decimal';
$id_periodo_txt = 'Tria període (per defecte, l´activitat és per a tot el curs)';
$id_noactiv = 'No has registrat ninguna activitat encara';
$id_activ_reg = 'Activitats registrades fins el moment';

$id_edita_act = 'Editar. Activitat (màx 15); Agrupament (màx 10); Ponderació (màx 2 decimales)';

$id_ver_horario = 'Vore horari';
$id_num_franjas = 'Nombre de franges horàries';
$id_franjas = 'Franges horàries';
$id_franja = 'Franja';

//atenció no editar despréss d´haver començat a usar SIESTTA
$id_cl = 'DL';
$id_cm = 'DM';
$id_cx = 'DX';
$id_cj = 'DJ';
$id_cv = 'DV';
$id_cs = 'DS';
$id_cd = 'DG';

$id_l = 'Dilluns';
$id_m = 'Dimarts';
$id_x = 'Dimecres';
$id_j = 'Dijous';
$id_v = 'Divendres';
$id_s = 'Dissabte';
$id_d = 'Diumenge';

$id_ene = 'Gen';
$id_feb = 'Feb';
$id_mar = 'Mar';
$id_abr = 'Abr';
$id_may = 'Mai';
$id_jun = 'Jun';
$id_jul = 'Jul';
$id_ago = 'Ago';
$id_sep = 'Set';
$id_oct = 'Oct';
$id_nov = 'Nov';
$id_dic = 'Des';

$id_enero = 'Gener';
$id_febrero = 'Febrer';
$id_marzo = 'Març';
$id_abril = 'Abril';
$id_mayo = 'Maig';
$id_junio = 'Juny';
$id_julio = 'Juliol';
$id_agosto = 'Agost';
$id_septiembre = 'Setembre';
$id_octubre = 'Octubre';
$id_noviembre = 'Novembre';
$id_diciembre = 'Desembre';
/////////////////////////////////////////////////////////////////

$id_recreo = 'PATI';
$id_fam_tut= 'AT.FAM.TUT.';
$id_fam= 'AT.FAM.';
$id_tsa='TUT.SENS.ALU.';
$id_rtut='R. TUTORS';
$id_rdep='R. DEPART.';
$id_pprac='PREP. PRACT.';
$id_ac='ACT.COMPLEM.';
$id_guardia='GUÀRDIA';
$id_guardia_recreo='GUÀRDIA REC';
$id_biblioteca='BIBLIOTECA';
$id_jd='J.D.';
$id_ed='E.D.';
$id_ccp='CCP';
$id_red_tic='RED.TIC.';
$id_red_lac='RED.LACT.';
$id_red_jub='RED.JUB.';
$id_ored='ALTRES RED.';
$id_chl='CHL';
$id_noper='NO.PERMAN.';


//////////////////////////////////////////////////////


$id_nueva_fila = 'Afegir fila';
$id_miagenda = 'La meua Agenda';
$id_horaini = 'Hora';
$id_sesion = 'Sessió';
$id_cita = 'Cita';
$id_citpub = 'Públic';
$id_citpri = 'Privat';
$id_hoy = 'hui';
$id_noclase = 'Hui no ni ha classe. Es cap de setmana. També pot ocórrer que no hages configurat el teu horari. Si ho acabes de fer, torna a entrar en el sistema';
$id_nocita = 'Afegir cita';
$id_elicita = 'Eliminar cita';
$id_edicita = 'Editar cita';
$id_seltipocita = 'Tipus de cita';
$id_saludo = 'Benvingut-da a SIESTTA 2.0';

//////////////////////////////////////////////////////////

$id_citaeli = 'Cita eliminada de la agenda';
$id_regcita = 'Registrar cita';
$id_regnotas = 'Registrar calificaciones';
$id_actcita = 'Actualizar cita';
$id_cancelar = 'Cancelar';

$id_tarea = 'Tarea';
$id_tareas = 'Tareas';
$id_examen = 'Examen';
$id_examen_pdtes = 'Próximos exÃ¡menes';
$id_obs = 'Observación';
$id_privado = 'Privado';

$id_abr_tarea = 'T';
$id_abr_examen = 'E';
$id_abr_privado = 'P';
$id_abr_obs = 'O';
$id_abr_nb = 'NB';
$id_verficha = 'Ver ficha';

$id_elgagr = 'Tria agrupament';
$id_elgalu = 'Tria alumne-a';
$id_elgact = 'Tria activitat';
$id_elgper = 'Tria perí­ode';
$id_final = 'Final';
$id_finalF = 'Final (*)';
$id_nodatos= 'Sense dades';
$id_total='Total';
$id_total_j='Justificades';
$id_pdf = 'Generar PDF';
$id_pdf_tut = 'Generar Informe en blanc';
$id_hasta_fecha = 'Fins la data';
$id_todos_agrup = 'Total agrupaments';
$id_descripcion = 'Descripció';

$id_coment = 'Comentari';
$id_ocultar = 'Amagar';

$id_recibidos='Rebuts';
$id_enviados='Enviats';
$id_borradores='Esborranys';
$id_redactar='Redactar';
$id_asunto='Assumpte';
$id_destinatario='Per a';
$id_enviar='Enviar';
$id_borrador = 'Guardar esborrany';
$id_mensaje_enviado = 'El missatge ha sigut enviat amb èxit';
$id_mensaje_no_enviado = 'No s´ha pogut enviar el missatge';
$id_borrador_guardado = 'Esborrany guardat';
$id_borrador_no_guardado = 'No s´ha pogut guardar l´esborrany';
$id_remitente='Remitent';
$id_mensaje='Missatge';
$id_leer='Llegir';
$id_nomensajes_borr='No existixen esborranys';
$id_nomensajes_env='No existixen missatges enviats';
$id_nomensajes_rec='No existixen missatges rebuts';
$id_mensaje_elim='Missatge eliminat';
$id_mensaje_no_elim='No s´ha pogut eliminar el missatge';
$id_todos_doc='Tots els docents';
$id_todos_doc_agr = 'Tots els seus docents';
$id_todos_fam='Totes les famílies';
$id_mensaje_nuevo = 'Missatge nou';
$id_mensajes_nuevos = 'Tens nous missatges';
$id_mensaje_leido = 'Missatge llegit';

$id_red_tarea = 'Registrar deure';
$id_red_obs = 'Registrar observació';
$id_red_carta = 'Redactar una carta';
$id_red_entrev = 'Registrar una entrevista';
$id_gen_bol = 'Generar un butlletí';

$id_nota = 'Nota';
$id_nota_media = 'Nota mitjana';
$id_nota_media_pond = 'Aporta a la nota';
$id_no_calif = 'No existixen qualificacions';
$id_no_coment = 'No hi ha comentaris';
$id_no_tareas = 'No existixen deures';
$id_fecha_reg = 'Data de registre';
$id_fecha_ent = 'Data d´entrega';
$id_no_obs = 'No existixen observacions';
$id_no_nb = 'No existix ninguna nota bene';
$id_texto = 'Text';
$id_no_cartas = 'No existixen cartes';
$id_no_entrev = 'No existixen entrevistes';
$id_no_activ = 'No existixen activitats';
$id_no_asi = 'No té faltes d´assistència';
$id_no_exam = 'No hi ha exàmens';


$id_datos_personales = 'Dades personals';
$id_datos_escolares = 'Dades escolars';
$id_datos_agrupamiento = 'Dades de l´Agrupament';
$id_exped = 'Expedient';
$id_ficha = 'Fitxa';

$id_faltas = 'Faltes';
$id_retrasos = 'Retrasos';
$id_justificadas = 'Justificades';

$id_todas_faltas = 'Consultar totes les faltes';
$id_todas_observaciones = 'Consultar totes les observacions';
$id_calificacion = 'Nota fins la data';
$id_hay_tarea = 'Ha d´entregar deures';
$id_no_tutoria = 'No existixen informes de tutori­a propis';

$id_red_tutoria = 'Redactar informe de tutori­a';
$id_mas_item = 'Afegir un ítem';
$id_item = 'Ítem';
$id_no_item = 'No existixen í­tems';
$id_valor = 'Valor';
$id_incluir = 'Incloure';

$id_ningun_doc = 'No utilitza SIESTTA';
$id_procede = 'Informe de';
$id_tutoria_recib = 'Informes de tutori­a rebuts';
$id_tutoria_prop = 'Informes de tutori­a propis';

$id_error_activ = 'ERROR. Ja tens una activitat amb eixe nom';

$id_texto_no_informecalif = 'No procedix este tipus d´informe';

$id_mes = 'Mes';
$id_anyo = 'Any';

$id_no_inf = 'No existixen informes';
$id_red_eval = 'Redactar informe d´avaluació';

$id_tarea_hoy = 'Hui hi ha que entregar deures. Revisa l´agenda';

$id_horario_lectivo = 'Horari lectiu';

$id_recupera = 'Recuperació';
$id_recu_elim = 'Nota eliminada';
$id_exam_pdtes = 'Nombre d´exàmens pendents';
$id_fecha_prim = 'Data del primer';

$id_firma_tut = 'Firma de la mare o el pare o el tutor legal';

$id_ultimas_not = 'Últimes qualificacions';
$mensaje_error = 'Les dades d´accés no són correctes';

$id_buscar_al = 'Buscar alumne-a';

$id_resumen = 'Quadre resum';
$id_hay_notas_hoy = 'Hi ha notes avui';
$id_todas_notas = 'Veure totes les notes';
$id_tareas_pendientes = 'Hi ha tasques per lliurar';
$id_todos_mensajes = 'Veure tots els missatges';
$id_todas_tareas = 'Veure totes les tasques';
$id_todos_exam = 'Veure tots els exàmens';
$id_tareas_grupo = "Tasques (per a tot l'alumnat)";
$id_tareas_ind = 'Tasques (només per a aquest/a alumne/a)';
$id_inf_cla = "Claus d'accés (famílies)";
$id_num_fam = 'Família';
$id_cla_fam = 'Clau de família';

$id_just_mas = 'Justificació massiva';
$id_faltajust = 'Falta';
$id_justificar = 'Justificar';
$id_ninguno = 'Cap';

$id_listado_clase = 'Todo el agrupamiento';

$id_max = 'Nota máxima';
$id_min = 'Nota mínima';
$id_avg = 'Nota media';

?>
