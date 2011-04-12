<?php

/////////////////TRADUCCIÓN DEL FICHERO A CATALÁN: SANTI VILCHEZ///////////////////////////////////////////

/*///////////////////////////////////////////////////////////////////////////////////////////////////////////
///Aquest arxiu es part de SIESTTA 2.0 i en forma part. Per tant, és
aplicable ////////////////////////
///la seva llicència GNU GPL///////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Aplicació: SIESTTA 2.0 (Solución Informática Especializada en el Seguimiento TuTorial del Alumnado)//////
///Web del projecte: http://siestta.org//////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Autor: Ramón Castro Pérez/////////////////////////////////////////////////////////////////////////////////
///Web: http://ramoncastro.es////////////////////////////////////////////////////////////////////////////////
///Mail: ramoncastroperez@gmail.com//////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Aquesta aplicació és software lliure: es pot redistribuir i/o modificar///////////////////////////////////
///sota els termes de la GNU General Public License publicada per la///////////////////////////////////////
///Free Software Foundation, en la seva versió 3 o posterior/////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///Aquest programa és distribuït amb la intenció de que sigui útil, però sense///////////////////////////////////
///cap garantia. Vegi els termes de la llicència GNU GPL per més informació///////////////////////////////
///Pots trobar-la a  http://www.gnu.org/copyleft/gpl.es.html////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
///SIESTTA 2.0 utilitza://////////////////////////////////////////////////////////////////////////////////////////
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

//les variables d’idioma s’identifiquen amb el prefix id

$id_admin = 'Administrar';
$id_admin_sist = 'Administració del sistema';
$id_descon = 'Desconnexió';

$id_si = 'Sí';
$id_no = 'No';
$id_av = 'De vegades';

$id_inicio = 'Inici';
$id_fin = 'Fi';
$id_docentes = 'Docents';
$id_grupos = 'Grups';
$id_agrup = 'Agrupaments';
$id_alumnos = 'Alumn@s';
$id_alumno = 'alumn@';
$id_Alumno = 'Alumn@';
$id_evaluaciones = 'Avaluacions';
$id_evaluacion = 'Avaluació';
$id_matricula = 'Matrícula';
$id_con_ed = 'Consultar/Editar';
$id_periodos = 'Períodes';
$id_periodo = 'Període';

$id_contraer = 'Contraure';
$id_volver = 'Tornar';

$id_list_edi = 'Llistat/Edició';
$id_reg_eva = 'Registre i edició de Períodes d’Avaluació';
$id_reg_mas = 'Registre massiu';
$id_agregar = 'Afegir';
$id_eliminar = 'Eliminar';
$id_eliminados = 'Eliminats';
$id_cambiados = 'Canviats';
$id_edi_mas = 'Edició massiva';
$id_mat_mas = 'Matrícula massiva';
$id_mat_alu = 'Matricular alumn@';
$id_mat_edi = 'Canviar matrícula';
$id_camb_gru = 'Canviar al grup';

$id_de = 'de';
$id_para = 'para';
$id_por = 'per';
$id_un = 'un';

$id_ayuda = 'Ajuda';
$id_texto_rm_doc = 'Utilitza aquesta funció per registrar tots els docents del Centre mitjançant la càrrega d’un arxiu CSV. Trobaràs més informació clicant la icona "Ajuda". Si desitges afegir un únic docent, dirigeix-te a “Afegir”, al menú lateral. Per canviar dades de docents o eliminar-los, clica al menú lateral "Llistat/Edició"
';
$id_texto_rm_agr = 'Utilitza aquesta funció per registrar tots els agrupaments lectius del Centre mitjançant la càrrega d’un arxiu CSV. Trobaràs més informació clicant la icona "Ajuda". Si desitges afegir un únic agrupament , dirigeix-te a “Afegir”, al menú lateral. Per canviar dades d’agrupaments o eliminar-los, clica al menú lateral "Llistat/Edició"
';
$id_texto_rm_gru = 'Utilitza aquesta funció per registrar tots els grups de referència del Centre mitjançant la càrrega d’un arxiu CSV. Trobaràs més informació clicant la icona "Ajuda". Si desitges afegir un únic grup de referència, dirigeix-te a “Afegir”, al menú lateral. Per canviar dades de grups o eliminar-los, clica al menú lateral "Llistat/Edició"
';
$id_texto_rm_alu = 'Utilitza aquesta funció per registrar tots els alumn@s del Centre mitjançant la càrrega d’un arxiu CSV. Trobaràs més informació clicant la icona "Ajuda". Si desitges afegir un únic alumn@, dirigeix-te a “Afegir”, al menú lateral. Per canviar dades de grups o eliminar-los, clica al menú lateral "Llistat/Edició"
';
$id_texto_li_doc = 'Des d’aquí podràs comprovar la llista de docents(ordenats alfabèticament per cognoms) i canviar totes les seves dades excepte el nom d’usuari. També pots suprimir-los. Tens més informació clicant la icona “Ajuda”. Si desitges afegir un docent, clica a “Afegir”, al menú lateral.';
$id_texto_li_agr = 'Des d’aquí podràs comprovar la llista de agrupaments(ordenats alfabèticament per Departaments i matèries) i canviar totes les seves dades excepte el nom d’agrupament. També pots suprimir-los. Tens més informació clicant la icona “Ajuda”. Si desitges afegir un agrupament , clica a “Afegir”, al menú lateral
.';
$id_texto_li_gru = 'Des d’aquí podràs comprovar la llista de grups de referència(ordenats alfabèticament per nivell i cursos) i canviar totes les seves dades excepte el nom de grup. També pots suprimir-los. Tens més informació clicant la icona “Ajuda”. Si desitges afegir un grup, clica a “Afegir”, al menú lateral
.';
$id_texto_li_alu = 'Des d’aquí podràs comprovar la llista d’alumn@s(ordenats alfabèticament per grup, cognom i nom) i canviar totes les seves dades excepte el codi. També pots suprimir-los. Tens més informació clicant la icona “Ajuda”. Si desitges afegir un alumn@, clica a “Afegir”, al menú lateral
.';
$id_texto_edi_doc = 'Des d’aquí pots canviar les dades del docent excepte el seu nom d’usuari. Si no desitges canviar la clan, deixa en blanc els espais reservats per això. Trobaràs més informació clicant la icona “Ajuda”.
';
$id_texto_edi_agr = 'Des d’aquí pots canviar les dades del agrupament excepte el seu nom. Trobaràs més informació clicant la icona “Ajuda”.
';
$id_texto_edi_gru = 'Des d’aquí pots canviar les dades del grup de referència excepte el seu nom. Trobaràs més informació clicant la icona “Ajuda”.
';
$id_texto_ag_doc = 'Des d’aquest formulari podràs afegir un docent a la base de dades. Disposes de més informació clicant la icona “Ajuda”. Una vegada afegit clica a “Llistat/Edició” per controlar el seu estat.
';
$id_texto_ag_agr = 'Des d’aquest formulari podràs afegir un agrupament a la base de dades. Disposes de més informació clicant la icona “Ajuda”. Una vegada afegit clica a “Llistat/Edició” per controlar el seu estat.
';
$id_texto_ag_gru = 'Des d’aquest formulari podràs afegir un grup de referència a la base de dades. Disposes de més informació clicant la icona “Ajuda”. Una vegada afegit clica a “Llistat/Edició” per controlar el seu estat.
';
$id_texto_ag_alum = 'Des d’aquest formulari podràs afegir un alumn@ a la base de dades. Disposes de més informació clicant la icona “Ajuda”. Una vegada afegit clica a “Llistat/Edició” per controlar el seu estat.
';
$id_texto_edi_mas_alum = 'Des d’aquest formulari podràs eliminar o canviar de grup a més d’un alumn@s de manera simultània. Disposes de més informació clicant la icona “Ajuda”.';
$id_texto_reg_eva = 'Aquí podràs registrar i editar les dades dels períodes en els que s’avaluarà al alumnat. Disposes de més informació clicant la icona “Ajuda”.';
$id_texto_mat_mas = 'Aquí podràs matricular a tot l’alumnat del Centre. Disposes de més informació clicant la icona “Ajuda”.';
$id_texto_mat_con = 'Aquí podràs consultar, canviar i eliminar la matrícula de l’alumnat del Centre. Disposes de més informació clicant la icona “Ajuda”.';
$id_texto_actividades = 'Aquí podràs registrar, consultar, canviar i eliminar les activitats per les que avaluaràs i qualificaràs als teus alumn@s. Disposes de més informació clicant la icona “Ajuda”.';
$id_texto_horario = 'Aquí podràs registrar, consultar, canviar i eliminar les franges horàries i el seu contingut. Disposes de més informació clicant la icona “Ajuda”.';

$id_csv = 'Arxiu CSV';
$id_reg = 'Registrar';
$id_error_upload = 'Error al pujar l’arxiu';
$id_error_formato = 'L’arxiu no té el format correcte. No s’ha pujat res.';
$id_error_transf = 'Transferència interrompuda';
$id_transferido = 'transferit';

$id_reg_exito = 'Registre efectuat amb èxit';

$id_doc = 'Docent';
$id_familia = 'Família';
$id_cla = 'Clau';
$id_nom = 'Nom';
$id_ape = 'Cognom';
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
$id_rep = 'Repeteix';
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
$id_rep_cla1 = 'Repeteix la clau';

$id_datos = 'dades';

$id_admin = 'Administrador';

$id_doc_eliminado = 'Aquest document ha estat eliminat. Pots tornar a la llista fent clic a “Llisteta/Edició”
.';
$id_agr_eliminado = 'Aquest agrupament ha estat eliminat. Pots tornar a la llista fent clic a “Llistat/Edició”
.';
$id_datos_doc_edit = 'S’han actualitzat les dades d’aquest docent. Pots tornar a la llista fent clic a “Llistat/Edició” 
.';
$id_datos_agr_edit = 'S’han actualitzat les dades d’aquest agrupament. Pots tornar a la llista fent clic a “Llistat/Edició” 
.';
$id_datos_gru_edit = 'S’han actualitzar les dades d’aquest grup de referència. Pots tornar a la llista fent clic a “Llistat/Edició” 
.';
$id_error_editar = 'Error d’actualització. No s’han canviat les dades.';

$id_error_clave = 'Las claus no coincideixen. No s’ha actualitzat res.';

$id_record_clave = 'Has canviat les claus d’aquest docent. Has de notificar-la  ràpidament i indicar-li que la canvií des d’aquest panell de control';

$id_ins = 'Les dades han estat registrades. Accedeix  al  "Llistat/Edició" per consultar-les.';
$id_error_ins = 'Ha succeït una error. No s’ha pogut registrar res.';
$id_elim_todos = 'Eliminar tot';
$id_eli = 'S’ha eliminat tot';
$id_borra_error = 'Ha succeït una error. No s’ha eliminat res.';

$id_elige_doc = 'Escull docent';
$id_elige_tut1 = 'Escull tutor/a 1';
$id_elige_tut2 = 'Escull tutor/a 2';

$id_foto = 'Foto';

$id_vergrupo = 'Llistar alumnat del grup';

$id_guardado = 'guardat';
$id_grabando = 'Carregant/Gravant Dades';
$id_cargando = 'Carregant';

$id_marcar_todos = 'Tots';
$id_todos_al = 'Tot l’alumnat';
$id_todas_act = 'Totes les activitats';
$id_todo_curso = 'Tot el curs';

$id_accion = 'Acció';

$id_siguiente = 'Següent';
$id_anterior = 'Anterior';

$id_fecha = 'Data';

$id_per_activo = 'Períodes donats d’alta';

$id_mat_mas='Matriculació';

$id_resultado = 'Resultats';

$id_mover_agr = 'Canviar l’agrupament';

$id_sel = 'Seleccionar';

$id_misdatos = 'Les Meves dades';
$id_misactividades = 'Les Meves activitats';
$id_mihorario = 'El Meu horari';
$id_misinformes = 'Els Meus informes';
$id_misagr = 'Els Meus agrupaments';
$id_inf_asi = 'Assistència';
$id_inf_not = 'Qualificacions';
$id_inf_inc = 'Incidències';
$id_inf_tar = 'Tasques';
$id_inf_ent = 'Entrevistes';
$id_inf_obs = 'Observacions';
$id_inf_nb = 'Nota Bene';
$id_inf_exa = 'Exàmens';
$id_inf_car = 'Cartes';
$id_inf_tut = 'Tutoria';
$id_inf_bol = 'Butlletins';
$id_inf_Bol = 'Butlletí';
$id_inf_eva = 'Avaluació';
$id_mismensajes = 'Els Meus missatges';
$id_centrotrab = 'Centre de treball';
$id_direccion = 'Direcció';
$id_telef = 'Telèfon';
$id_fax = 'Fax';
$id_nav = 'Navegar';
$id_nueva_foto = 'Canviar foto';
$id_mensaje_foto = 'Èxit. Clica a les Meves dades de nou per veure la fotografia pujada';

$id_activ = 'Activitat';
$id_agrupamiento = 'Agrupament';
$id_reg_activ = 'Registrar una nova activitat';
$id_nom_activ = 'Nom de la activitat';
$id_agr_activ = 'Selecciona els agrupaments als que assignes aquesta nova activitat i la seva ponderació';
$id_noagrup = 'Encara no tens assignat cap agrupament. Contacta amb l’administrador del sistema.';
$id_ponderacion = 'Ponderació (%)';
$id_ponderacion_txt = 'Ponderació en %. Utilitza el punt com a separador decimal';
$id_periodo_txt = 'Escull període (per defecte, l’activitat és per tot el curs)';
$id_noactiv = 'No has registrat cap activitat encara';
$id_activ_reg = 'Activitats registrades fins al moment';

$id_edita_act = 'Editar. Activitat (màx. 15); Agrupament (màx. 10); Ponderació (màx. 2 decimals)';

$id_ver_horario = 'Veure horari';
$id_num_franjas = 'Número de franges horàries';
$id_franjas = 'Franges horàries';
$id_franja = 'Franja';

//Vigileu no editeu després d’haver començat a utilitzar SIESTTA
$id_cl = 'L';
$id_cm = 'M';
$id_cx = 'M';
$id_cj = 'J';
$id_cv = 'V';
$id_cs = 'S';
$id_cd = 'D';

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
$id_dic = 'Dec';

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
$id_tsa='TUT.SEN.ALU.';
$id_rtut='R. TUTORS';
$id_rdep='R. DEPART.';
$id_pprac='PREP. PRACT.';
$id_ac='ACT.COMPLEM.';
$id_guardia='GUÀRDIA';
$id_guardia_recreo='GUARDIA REC';
$id_biblioteca='BIBLIOTECA';
$id_jd='J.D.';
$id_ed='E.D.';
$id_ccp='CCP';
$id_red_tic='RED.TIC.';
$id_red_lac='RED.LACT.';
$id_red_jub='RED.JUB.';
$id_ored='OTRAS RED.';
$id_chl='CHL';
$id_noper='NO.PERMAN.';


//////////////////////////////////////////////////////


$id_nueva_fila = 'Afegir fila';
$id_miagenda = 'La Meva Agenda';
$id_horaini = 'Hora';
$id_sesion = 'Sessió';
$id_cita = 'Cita';
$id_citpub = 'Públic';
$id_citpri = 'Privat';
$id_hoy = 'Avui';
$id_noclase = 'Avui no hi ha classe. És cap de setmana. També pot succeir que no hagis configurat el teu horari. Si ho acabes de fer, torna a accedir a SIESTTA';
$id_nocita = 'Afegir cita';
$id_elicita = 'Eliminar cita';
$id_edicita = 'Editar cita';
$id_seltipocita = 'Tipus de cita';
$id_saludo = 'Benvingut/da a SIESTTA 2.0';

//////////////////////////////////////////////////////////

$id_citaeli = 'Cita eliminada de la agenda';
$id_regcita = 'Registrar cita';
$id_regnotas = 'Registrar qualificacions';
$id_actcita = 'Actualitzar cita';
$id_cancelar = 'Cancelar';

$id_tarea = 'Tasca';
$id_tareas = 'Tasques';
$id_examen = 'Examen';
$id_examen_pdtes = 'Pròxims exàmens';
$id_obs = 'Observació';
$id_privado = 'Privat';

$id_abr_tarea = 'T';
$id_abr_examen = 'E';
$id_abr_privado = 'P';
$id_abr_obs = 'O';
$id_abr_nb = 'NB';
$id_verficha = 'Veure fitxa';

$id_elgagr = 'Escull agrupament';
$id_elgalu = 'Escull alumn@';
$id_elgact = 'Escull activitat';
$id_elgper = 'Escull període';
$id_final = 'Final';
$id_finalF = 'Final (*)';
$id_nodatos= 'Sense dades';
$id_total='Total';
$id_total_j='Justificades';
$id_pdf = 'Generar PDF';
$id_pdf_tut = 'Generar Informe en blanc';
$id_hasta_fecha = 'Fins a al data';
$id_todos_agrup = 'Total agrupaments';
$id_descripcion = 'Descripció';

$id_coment = 'Comentari';
$id_ocultar = 'Ocultar';

$id_recibidos='Rebuts';
$id_enviats='Enviats';
$id_borradores='Esborranys';
$id_redactar='Redactar';
$id_asunto='Assumpte';
$id_destinatario='Per';
$id_enviar='Enviar';
$id_borrador = 'Guardar esborrany';
$id_mensaje_enviado = 'El missatge ha estat enviar amb èxit';
$id_mensaje_no_enviado = 'No s’ha pogut enviar el missatge';
$id_borrador_guardado = 'Esborrany guardat';
$id_borrador_no_guardado = 'No s’ha pogut guardar l’esborrany';
$id_remitente='Remitent';
$id_mensaje='Missatge';
$id_leer='Llegir';
$id_nomensajes_borr='No existeixen esborranys';
$id_nomensajes_env='No existeixen missatges enviats';
$id_nomensajes_rec='No existeixen missatges rebuts';
$id_mensaje_elim='Missatge eliminat';
$id_mensaje_no_elim='No s’ha pogut eliminar el missatge';
$id_todos_doc='Tots els docents';
$id_todos_doc_agr = 'Tots els seus docents';
$id_todos_fam='Totes les famílies';
$id_mensaje_nuevo = 'Missatge nou';
$id_mensajes_nuevos = 'Té nous missatges';
$id_mensaje_leido = 'Missatge llegit';

$id_red_tarea = 'Registrar tasca';
$id_red_obs = 'Registrar observació';
$id_red_carta = 'Redactar una carta';
$id_red_entrev = 'Registrar una entrevista';
$id_gen_bol = 'Generar un butlletí';

$id_nota = 'Nota';
$id_nota_media = 'Nota mitjana';
$id_nota_media_pond = 'Aporta a la nota';
$id_no_calif = 'No existeixen qualificacions';
$id_no_coment = 'No hi ha comentaris';
$id_no_tareas = 'No existeixen tasques';
$id_fecha_reg = 'Data d’enregistrament';
$id_fecha_ent = 'Data d’entrega';
$id_no_obs = 'No existeixen observacions';
$id_no_nb = 'No existeix cap nota bene';
$id_texto = 'Text';
$id_no_cartas = 'No existeixen cartes';
$id_no_entrev = 'No existeixen entrevistes';
$id_no_activ = 'No existeixen activitats';
$id_no_asi = 'No té faltes d’assistència';
$id_no_exam = 'No hi ha exàmens';


$id_datos_personales = 'Dades personals';
$id_datos_escolares = 'Dades escolars';
$id_datos_agrupamiento = 'Dades de l’Agrupament';
$id_exped = 'Expedient';
$id_ficha = 'Fitxa';

$id_faltas = 'Faltes';
$id_retrasos = 'Retards';
$id_justificadas = 'Justificades';

$id_todas_faltas = 'Consultar totes les faltes';
$id_todas_observaciones = 'Consultar totes les observacions';
$id_calificacion = 'Nota fins a la data';
$id_hay_tarea = 'Ha d’entregar una tasca';
$id_no_tutoria = 'No existeixen informes de tutoría propis';

$id_red_tutoria = 'Redactar informe de tutoria';
$id_mas_item = 'Afegir un ítem';
$id_item = 'Ítem';
$id_no_item = 'No existeixen ítems';
$id_valor = 'Valor';
$id_incluir = 'Incloure';

$id_ningun_doc = 'No utilitza SIESTTA';
$id_procede = 'Informe de';
$id_tutoria_recib = 'Informes de tutoría rebuts';
$id_tutoria_prop = 'Informes de tutoría propis';

$id_error_activ = 'ERROR. Ja tens una activitat amb aquest nom';

$id_texto_no_informecalif = 'No procedeix aquest tipus d’informe';

$id_mes = 'Mes';
$id_anyo = 'Any';

$id_no_inf = 'No existeixen informes';
$id_red_eval = 'Redactar informe d’avaluació';

$id_tarea_hoy = 'Avui hi ha tasques que entregar. Revisa la teva agenda';

$id_horario_lectivo = 'Horari lectiu';

$id_recupera = 'Recuperació';
$id_recu_elim = 'Nota eliminada';
$id_exam_pdtes = 'Número de exàmens pendents';
$id_fecha_prim = 'Data del primer';

$id_firma_tut = 'Firma de la mare o del pare o del tutor legal';

$id_ultimas_not = 'Últimes qualificacions';
$mensaje_error = 'Les dades d’accés no són correctes';

$id_buscar_al = 'Buscar alumn@';

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
$id_justificar = '﻿Justificar';
$id_ninguno = 'Cap';

$id_listado_clase = 'Todo el agrupamiento';

$id_max = 'Nota máxima';
$id_min = 'Nota mínima';
$id_avg = 'Nota media';


?>

