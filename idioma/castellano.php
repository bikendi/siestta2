<?php


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
$id_admin_sist = 'Administración del sistema';
$id_descon = 'Desconexión';

$id_si = 'Sí';
$id_no = 'No';
$id_av = 'A veces';

$id_inicio = 'Inicio';
$id_fin = 'Fin';
$id_docentes = 'Docentes';
$id_grupos = 'Grupos';
$id_agrup = 'Agrupamientos';
$id_alumnos = 'Alumn@s';
$id_alumno = 'alumn@';
$id_Alumno = 'Alumn@';
$id_evaluaciones = 'Evaluaciones';
$id_evaluacion = 'Evaluación';
$id_matricula = 'Matrícula';
$id_con_ed = 'Consultar/Editar';
$id_periodos = 'Períodos';
$id_periodo = 'Período';

$id_contraer = 'Enrollar';
$id_volver = 'Volver';

$id_list_edi = 'Listado/Edición';
$id_reg_eva = 'Registro y edición de Períodos de Evaluación';
$id_reg_mas = 'Registro masivo';
$id_agregar = 'Agregar';
$id_eliminar = 'Eliminar';
$id_eliminados = 'Eliminados';
$id_cambiados = 'Cambiados';
$id_edi_mas = 'Edición masiva';
$id_mat_mas = 'Matrícula masiva';
$id_mat_alu = 'Matricular alumn@';
$id_mat_edi = 'Cambiar matrícula';
$id_camb_gru = 'Cambiar al grupo';

$id_de = 'de';
$id_para = 'para';
$id_por = 'por';
$id_un = 'un';

$id_ayuda = 'Ayuda';
$id_texto_rm_doc = 'Utiliza esta función para registrar todos los docentes del
Centro mediante la carga de un archivo CSV. Encontrarás
más información presionando el icono "Ayuda". Si deseas agregar un único docente,
dirígete a "Agregar", en el menú lateral. Para cambiar datos de docentes o eliminarlos, clica en el menú lateral "Listado/Edición"
';
$id_texto_rm_agr = 'Utiliza esta función para registrar todos los agrupamientos lectivos del
Centro mediante la carga de un archivo CSV. Encontrarás
más información presionando el icono "Ayuda". Si deseas agregar un único agrupamiento,
dirígete a "Agregar", en el menú lateral. Para cambiar datos de agrupamientos o eliminarlos, clica en el menú lateral "Listado/Edición"
';
$id_texto_rm_gru = 'Utiliza esta función para registrar todos los grupos de referencia del
Centro mediante la carga de un archivo CSV. Encontrarás
más información presionando el icono "Ayuda". Si deseas agregar un único grupo de referencia,
dirígete a "Agregar", en el menú lateral. Para cambiar datos de grupos o eliminarlos, clica en el menú lateral "Listado/Edición"
';
$id_texto_rm_alu = 'Utiliza esta función para registrar todos l@s alumn@s de referencia del
Centro mediante la carga de un archivo CSV. Encontrarás
más información presionando el icono "Ayuda". Si deseas agregar un/a únic@ alumn@,
dirígete a "Agregar", en el menú lateral. Para cambiar datos de grupos o eliminarlos, clica en el menú lateral "Listado/Edición"
';
$id_texto_li_doc = 'Desde aquí podrás comprobar la lista de docentes
(ordenados alfabéticamente por apellidos) y cambiar todos sus datos excepto el nombre de usuari@. También podrás suprimirlos. Tienes más
información pulsando el icono "Ayuda". Si deseas agregar un docente, haz clic en "Agregar", en el
menú lateral
.';
$id_texto_li_agr = 'Desde aquí podrás comprobar la lista de agrupamientos
(ordenados alfabéticamente por Departamento y Materia) y cambiar todos sus datos excepto el nombre de agrupamiento. También podrás suprimirlos. Tienes más
información pulsando el icono "Ayuda". Si deseas agregar un agrupamiento, haz clic en "Agregar", en el
menú lateral
.';
$id_texto_li_gru = 'Desde aquí podrás comprobar la lista de grupos de referencia
(ordenados alfabéticamente por nivel y curso) y cambiar todos sus datos excepto el nombre de grupo. También podrás suprimirlos. Tienes más
información pulsando el icono "Ayuda". Si deseas agregar un grupo, haz clic en "Agregar", en el
menú lateral
.';
$id_texto_li_alu = 'Desde aquí podrás comprobar la lista de alumn@s
(ordenados alfabéticamente por grupo,apellidos y nombre) y cambiar todos sus datos excepto el código. También podrás suprimirlos. Tienes más
información pulsando el icono "Ayuda". Si deseas agregar un/a alumn@, haz clic en "Agregar", en el
menú lateral
.';
$id_texto_edi_doc = 'Aquí puedes cambiar los datos del docente excepto su nombre
de usuario. Si no deseas cambiar la clave, deja en blanco los espacios reservados
para ello. Encontrarás más información pulsando
el icono "Ayuda".
';
$id_texto_edi_agr = 'Aquí puedes cambiar los datos del agrupamiento excepto su nombre. Encontrarás más información pulsando el icono "Ayuda".
';
$id_texto_edi_gru = 'Aquí puedes cambiar los datos del grupo de referencia excepto su nombre. Encontrarás más información pulsando el icono "Ayuda".
';
$id_texto_ag_doc = 'Desde este formulario podrás agregar un docente a la base de
datos. Dispones de más información pulsando el
icono "Ayuda". Una vez añadido haz clic en
"Listado/Edición" para consultar su estado.
';
$id_texto_ag_agr = 'Desde este formulario podrás agregar un agrupamiento a la base de
datos. Dispones de más información pulsando el
icono "Ayuda". Una vez añadido haz clic en
"Listado/Edición" para consultar su estado.
';
$id_texto_ag_gru = 'Desde este formulario podrás agregar un grupo de referencia a la base de
datos. Dispones de más información pulsando el
icono "Ayuda". Una vez añadido haz clic en
"Listado/Edición" para consultar su estado.
';
$id_texto_ag_alum = 'Desde este formulario podrás agregar un alumno a la base de
datos. Dispones de más información pulsando el
icono "Ayuda". Una vez añadido haz clic en
"Listado/Edición" para consultar su estado.
';
$id_texto_edi_mas_alum = 'Desde este formulario podrás eliminar o cambiar de grupo a varios alumnos de manera simultánea. Dispones de más información pulsando el
icono "Ayuda".';
$id_texto_reg_eva = 'Aquí podrás registrar y editar las fechas de los períodos en los que se evaluará al alumnado. Dispones de más información pulsando el
icono "Ayuda".';
$id_texto_mat_mas = 'Aquí podrás matricular a todo el alumnado del Centro. Dispones de más información pulsando el
icono "Ayuda".';
$id_texto_mat_con = 'Aquí podrás consultar, cambiar y eliminar la matrícula del alumnado del Centro. Dispones de más información pulsando el
icono "Ayuda".';
$id_texto_actividades = 'Aquí podrás registrar, consultar, cambiar y eliminar las actividades por las que evaluarás y calificarás a tus alumn@s. Dispones de más información pulsando el
icono "Ayuda".';
$id_texto_horario = 'Aquí podrás registrar, consultar, cambiar y eliminar las franjas horarias y su contenido. Dispones de más información pulsando el icono "Ayuda".';

$id_csv = 'Archivo CSV';
$id_reg = 'Registrar';
$id_error_upload = 'Error al subir el archivo';
$id_error_formato = 'El archivo no tiene el formato correcto. No se ha subido nada.';
$id_error_transf = 'Transferencia interrumpida';
$id_transferido = 'transferido';

$id_reg_exito = 'Registro efectuado con éxito';

$id_doc = 'Docente';
$id_familia = 'Familia';
$id_cla = 'Clave';
$id_nom = 'Nombre';
$id_ape = 'Apellidos';
$id_ema = 'Email';
$id_esp = 'Especialidad';
$id_web = 'Web';
$id_te1 = 'Teléfono 1';
$id_te2 = 'Teléfono 2';
$id_rol = 'Rol';
$id_cod = 'Código';
$id_fna = 'F. Nacimiento';
$id_fna_abrev = 'F.Nac.';
$id_mod = 'Modalidad';
$id_rep = 'Repite';
$id_tu1 = 'Tutor/a 1';
$id_tu2 = 'Tutor/a 2';
$id_di1 = 'Dirección 1';
$id_di2 = 'Dirección 2';
$id_nac = 'Nacionalidad';

$id_gru = 'Grupo';
$id_agr = 'Agrupamiento';
$id_dep = 'Departamento';
$id_mat = 'Materia';
$id_cur = 'Curso';
$id_niv = 'Nivel';

$id_editar = 'Editar';
$id_guardar = 'Guardar';
$id_cambio_cla = 'Cambio de clave';
$id_nueva_cla = 'Nueva clave';
$id_intro_cla1 = 'Escribe la nueva clave';
$id_intro_cla2 = 'Escribe la nueva clave';
$id_rep_cla1 = 'Repite la clave';

$id_datos = 'datos';

$id_admin = 'Administrador';

$id_doc_eliminado = 'Este docente ha sido eliminado. Puedes regresar a la lista haciendo
clic en "Listado/Edición"
.';
$id_agr_eliminado = 'Este agrupamiento ha sido eliminado. Puedes regresar a la lista haciendo
clic en "Listado/Edición"
.';
$id_datos_doc_edit = 'Se han actualizado los datos de este docente. Puedes regresar a la lista haciendo
clic en "Listado/Edición"
.';
$id_datos_agr_edit = 'Se han actualizado los datos de este agrupamiento. Puedes regresar a la lista haciendo
clic en "Listado/Edición"
.';
$id_datos_gru_edit = 'Se han actualizado los datos de este grupo de referencia. Puedes regresar a la lista haciendo
clic en "Listado/Edición"
.';
$id_error_editar = 'Error al actualizar. No se han cambiado los datos';

$id_error_clave = 'Las claves no coinciden. No se ha actualizado nada';

$id_record_clave = 'Has cambiado la clave de este docente. Debes notificarla lo antes posible al interesado e indicarle que la cambie desde el Panel de Control';

$id_ins = 'Los datos han sido registrados. Accede a "Listado/Edición" para consultarlos.';
$id_error_ins = 'Ha ocurrido un error. No se ha podido registrar nada.';
$id_elim_todos = 'Eliminar todo';
$id_eli = 'Se ha eliminado todo';
$id_borra_error = 'Ha ocurrido un error. No se ha podido eliminar nada.';

$id_elige_doc = 'Elige docente';
$id_elige_tut1 = 'Elige tutor/a 1';
$id_elige_tut2 = 'Elige tutor/a 2';

$id_foto = 'Foto';

$id_vergrupo = 'Listar alumnado del grupo';

$id_guardado = 'guardado';
$id_grabando = 'Cargando/Grabando Datos';
$id_cargando = 'Cargando';

$id_marcar_todos = 'Todos';
$id_todos_al = 'Todo el alumnado';
$id_todas_act = 'Todas las actividades';
$id_todo_curso = 'Todo el curso';

$id_accion = 'Acción';

$id_siguiente = 'Siguiente';
$id_anterior = 'Anterior';

$id_fecha = 'Fecha';

$id_per_activo = 'Períodos dados de alta';

$id_mat_mas='Matriculación';

$id_resultado = 'Resultado';

$id_mover_agr = 'Cambiar al agrupamiento';

$id_sel = 'Seleccionar';

$id_misdatos = 'Mis datos';
$id_misactividades = 'Mis actividades';
$id_mihorario = 'Mi horario';
$id_misinformes = 'Mis informes';
$id_misagr = 'Mis agrupamientos';
$id_inf_asi = 'Asistencia';
$id_inf_not = 'Calificaciones';
$id_inf_inc = 'Incidencias';
$id_inf_tar = 'Tareas';
$id_inf_ent = 'Entrevistas';
$id_inf_obs = 'Observaciones';
$id_inf_nb = 'Nota Bene';
$id_inf_exa = 'Exámenes';
$id_inf_car = 'Cartas';
$id_inf_tut = 'Tutoría';
$id_inf_bol = 'Boletines';
$id_inf_Bol = 'Boletín';
$id_inf_eva = 'Evaluación';
$id_mismensajes = 'Mis mensajes';
$id_centrotrab = 'Centro de trabajo';
$id_direccion = 'Dirección';
$id_telef = 'Teléfono';
$id_fax = 'Fax';
$id_nav = 'Navegar';
$id_nueva_foto = 'Cambiar foto';
$id_mensaje_foto = 'Éxito. Pulsa en Mis datos de nuevo para ver la fotografía subida';

$id_activ = 'Actividad';
$id_agrupamiento = 'Agrupamiento';
$id_reg_activ = 'Registrar una nueva actividad';
$id_nom_activ = 'Nombre de la actividad';
$id_agr_activ = 'Selecciona los agrupamientos a los que asignas esta nueva actividad y su ponderación';
$id_noagrup = 'No tienes asignado ningún agrupamiento aún. Contacta con el administrador del sistema.';
$id_ponderacion = 'Ponderación (%)';
$id_ponderacion_txt = 'Ponderación en %. Usa el punto como separador decimal';
$id_periodo_txt = 'Elige período (por defecto, la actividad es para todo el curso)';
$id_noactiv = 'No has registrado ninguna actividad aún';
$id_activ_reg = 'Actividades registradas hasta el momento';

$id_edita_act = 'Editar. Actividad (max 15); Agrupamiento (max 10); Ponderación (max 2 decimales)';

$id_ver_horario = 'Ver horario';
$id_num_franjas = 'Número de franjas horarias';
$id_franjas = 'Franjas horarias';
$id_franja = 'Franja';

//ojo no editar después de haber comenzado a usar SIESTTA
$id_cl = 'L';
$id_cm = 'M';
$id_cx = 'M';
$id_cj = 'J';
$id_cv = 'V';
$id_cs = 'S';
$id_cd = 'D';

$id_l = 'Lunes';
$id_m = 'Martes';
$id_x = 'Miércoles';
$id_j = 'Jueves';
$id_v = 'Viernes';
$id_s = 'Sábado';
$id_d = 'Domingo';

$id_ene = 'Ene';
$id_feb = 'Feb';
$id_mar = 'Mar';
$id_abr = 'Abr';
$id_may = 'May';
$id_jun = 'Jun';
$id_jul = 'Jul';
$id_ago = 'Ago';
$id_sep = 'Sep';
$id_oct = 'Oct';
$id_nov = 'Nov';
$id_dic = 'Dic';

$id_enero = 'Enero';
$id_febrero = 'Febrero';
$id_marzo = 'Marzo';
$id_abril = 'Abril';
$id_mayo = 'Mayo';
$id_junio = 'Junio';
$id_julio = 'Julio';
$id_agosto = 'Agosto';
$id_septiembre = 'Septiembre';
$id_octubre = 'Octubre';
$id_noviembre = 'Noviembre';
$id_diciembre = 'Diciembre';
/////////////////////////////////////////////////////////////////

$id_recreo = 'RECREO';
$id_fam_tut= 'AT.FAM.TUT.';
$id_fam= 'AT.FAM.';
$id_tsa='TUT.SIN.ALU.';
$id_rtut='R. TUTORES';
$id_rdep='R. DEPART.';
$id_pprac='PREP. PRACT.';
$id_ac='ACT.COMPLEM.';
$id_guardia='GUARDIA';
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


$id_nueva_fila = 'Añadir fila';
$id_miagenda = 'Mi Agenda';
$id_horaini = 'Hora';
$id_sesion = 'Sesión';
$id_cita = 'Cita';
$id_citpub = 'Público';
$id_citpri = 'Privado';
$id_hoy = 'hoy';
$id_noclase = 'Hoy no hay clase. Es fin de semana. También puede ocurrir que no hayas configurado tu horario. Si lo acabas de hacer, vuelve a acceder a SIESTTA';
$id_nocita = 'Añadir cita';
$id_elicita = 'Eliminar cita';
$id_edicita = 'Editar cita';
$id_seltipocita = 'Tipo de cita';
$id_saludo = 'Bienvenid@ a SIESTTA 2.0';

//////////////////////////////////////////////////////////

$id_citaeli = 'Cita eliminada de la agenda';
$id_regcita = 'Registrar cita';
$id_regnotas = 'Registrar calificaciones';
$id_actcita = 'Actualizar cita';
$id_cancelar = 'Cancelar';

$id_tarea = 'Tarea';
$id_tareas = 'Tareas';
$id_examen = 'Examen';
$id_examen_pdtes = 'Próximos exámenes';
$id_obs = 'Observación';
$id_privado = 'Privado';

$id_abr_tarea = 'T';
$id_abr_examen = 'E';
$id_abr_privado = 'P';
$id_abr_obs = 'O';
$id_abr_nb = 'NB';
$id_verficha = 'Ver ficha';

$id_elgagr = 'Elige agrupamiento';
$id_elgalu = 'Elige alumn@';
$id_elgact = 'Elige actividad';
$id_elgper = 'Elige período';
$id_final = 'Final';
$id_finalF = 'Final (*)';
$id_nodatos= 'Sin datos';
$id_total='Total';
$id_total_j='Justificadas';
$id_pdf = 'Generar PDF';
$id_pdf_tut = 'Generar Informe en blanco';
$id_hasta_fecha = 'Hasta la fecha';
$id_todos_agrup = 'Total agrupamientos';
$id_descripcion = 'Descripción';

$id_coment = 'Comentario';
$id_ocultar = 'Ocultar';

$id_recibidos='Recibidos';
$id_enviados='Enviados';
$id_borradores='Borradores';
$id_redactar='Redactar';
$id_asunto='Asunto';
$id_destinatario='Para';
$id_enviar='Enviar';
$id_borrador = 'Guardar borrador';
$id_mensaje_enviado = 'El mensaje ha sido enviado con éxito';
$id_mensaje_no_enviado = 'No se ha podido enviar el mensaje';
$id_borrador_guardado = 'Borrador guardado';
$id_borrador_no_guardado = 'No se ha podido guardar el borrador';
$id_remitente='Remitente';
$id_mensaje='Mensaje';
$id_leer='Leer';
$id_nomensajes_borr='No existen borradores';
$id_nomensajes_env='No existen mensajes enviados';
$id_nomensajes_rec='No existen mensajes recibidos';
$id_mensaje_elim='Mensaje eliminado';
$id_mensaje_no_elim='No se ha podido eliminar el mensaje';
$id_todos_doc='Todos los docentes';
$id_todos_doc_agr = 'Todos sus docentes';
$id_todos_fam='Todas las familias';
$id_mensaje_nuevo = 'Mensaje nuevo';
$id_mensajes_nuevos = 'Tienes nuevos mensajes';
$id_mensaje_leido = 'Mensaje leído';

$id_red_tarea = 'Registrar tarea';
$id_red_obs = 'Registrar observación';
$id_red_carta = 'Redactar una carta';
$id_red_entrev = 'Registrar una entrevista';
$id_gen_bol = 'Generar un boletín';

$id_nota = 'Nota';
$id_nota_media = 'Nota media';
$id_nota_media_pond = 'Aporta a la nota';
$id_no_calif = 'No existen calificaciones';
$id_no_coment = 'No hay comentarios';
$id_no_tareas = 'No existen tareas';
$id_fecha_reg = 'Fecha de registro';
$id_fecha_ent = 'Fecha de entrega';
$id_no_obs = 'No existen observaciones';
$id_no_nb = 'No existe ninguna nota bene';
$id_texto = 'Texto';
$id_no_cartas = 'No existen cartas';
$id_no_entrev = 'No existen entrevistas';
$id_no_activ = 'No existen actividades';
$id_no_asi = 'No tiene faltas de asistencia';
$id_no_exam = 'No hay exámenes';


$id_datos_personales = 'Datos personales';
$id_datos_escolares = 'Datos escolares';
$id_datos_agrupamiento = 'Datos del Agrupamiento';
$id_exped = 'Expediente';
$id_ficha = 'Ficha';

$id_faltas = 'Faltas';
$id_retrasos = 'Retrasos';
$id_justificadas = 'Justificadas';

$id_todas_faltas = 'Consultar todas las faltas';
$id_todas_observaciones = 'Consultar todas las observaciones';
$id_calificacion = 'Nota hasta la fecha';
$id_hay_tarea = 'Tiene que entregar tarea';
$id_no_tutoria = 'No existen informes de tutoría propios';

$id_red_tutoria = 'Redactar informe de tutoría';
$id_mas_item = 'Añadir un ítem';
$id_item = 'Ítem';
$id_no_item = 'No existen ítems';
$id_valor = 'Valor';
$id_incluir = 'Incluir';

$id_ningun_doc = 'No usa SIESTTA';
$id_procede = 'Informe de';
$id_tutoria_recib = 'Informes de tutoría recibidos';
$id_tutoria_prop = 'Informes de tutoría propios';

$id_error_activ = 'ERROR. Ya tienes una actividad con este nombre';

$id_texto_no_informecalif = 'No procede este tipo de informe';

$id_mes = 'Mes';
$id_anyo = 'Año';

$id_no_inf = 'No existen informes';
$id_red_eval = 'Redactar informe de evaluación';

$id_tarea_hoy = 'Hoy hay tareas que entregar. Revisa la agenda';

$id_horario_lectivo = 'Horario lectivo';

$id_recupera = 'Recuperación';
$id_recu_elim = 'Nota eliminada';
$id_exam_pdtes = 'Número de exámenes pendientes';
$id_fecha_prim = 'Fecha del primero';

$id_firma_tut = 'Firma de la madre o el padre o el tutor legal';

$id_ultimas_not = 'Últimas calificaciones';
$mensaje_error = 'Los datos de acceso no son correctos o no existe el usuario en esta base de datos';

$id_buscar_al = 'Buscar alumn@';


$id_resumen = 'Cuadro resumen';
$id_hay_notas_hoy = 'Hay notas hoy';
$id_todas_notas = 'Ver todas las notas';
$id_tareas_pendientes = 'Hay tareas que entregar';
$id_todos_mensajes = 'Ver todos los mensajes';
$id_todas_tareas = 'Ver todas las tareas';
$id_todos_exam = 'Ver todos los exámenes';
$id_tareas_grupo = 'Tareas (para todo el alumnado)';
$id_tareas_ind = 'Tareas (sólo para éste/a alumno/a)';
$id_inf_cla = 'Claves de acceso (familias)';
$id_num_fam = 'Número de familia';
$id_cla_fam = 'Clave de familia';

$id_just_mas = 'Justificación masiva';
$id_faltajust = 'Falta';
$id_justificar = 'Justificar';
$id_ninguno = 'Ninguno';

$id_listado_clase = 'Todo el agrupamiento';

$id_max = 'Nota máxima';
$id_min = 'Nota mínima';
$id_avg = 'Nota media';

?>
