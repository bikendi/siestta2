<?php

//////////////////////TRADUCCIÓN: MANCOMUN.ORG http://www.mancomun.org///////////////////////////////////////

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


$id_admin = "Administrador";
$id_admin_sist = "Administración do sistema";
$id_descon = "Desconexión";
$id_si = "Sí";
$id_no = "Non";
$id_av = "Á veces";
$id_inicio = "Inicio";
$id_fin = "Fin";
$id_docentes = "Docentes";
$id_grupos = "Grupos";
$id_agrup = "Agrupamentos";
$id_alumnos = "Alumn@s";
$id_alumno = "alumn@";
$id_Alumno = "Alumn@";
$id_evaluaciones = "Avaliación";
$id_evaluacion = "Evaluación";
$id_matricula = "Matrícula";
$id_con_ed = "Consultar/Editar";
$id_periodos = "Períodos";
$id_periodo = "Período";
$id_contraer = "Enrolar";
$id_volver = "Volver";
$id_list_edi = "Listado/Edición";
$id_reg_eva = "Rexistro e edición de Períodos de Evaluación";
$id_reg_mas = "Rexistro masivo";
$id_agregar = "Agregar";
$id_eliminar = "Eliminar";
$id_eliminados = "Eliminados";
$id_cambiados = "Cambiados";
$id_edi_mas = "Edición masiva";
$id_mat_mas = "Matriculación";
$id_mat_alu = "Matricular alumn@";
$id_mat_edi = "Cambiar matrícula";
$id_camb_gru = "Cambiar ao grupo";
$id_de = "de";
$id_para = "para";
$id_por = "por";
$id_un = "un";
$id_ayuda = "Axuda";
$id_texto_rm_doc = "Utiliza esta función para rexistrar todos os docentes do Centro mediante a carga dun ficheiro CSV. Atoparás máis información presionando a icona \"Axuda\". Se desexas agregar un único docente, diríxete a \"Agregar\", no menú lateral. Para cambiar datos de docentes ou eliminalos, prema no menú lateral \"Listado/Edición\"";
$id_texto_rm_agr = "Utiliza esta función para rexistrar todos os agrupamentos lectivos do Centro mediante a carga dun ficheiro CSV. Atoparás máis información presionando a icona \"Axuda\". Se desexas agregar un único agrupamento, diríxete a \"Agregar\", no menú lateral. Para cambiar datos de agrupamentos ou eliminalos, prema no menú lateral \"Listado/Edición\"";
$id_texto_rm_gru = "Utiliza esta función para rexistrar todos os grupos de referencia do Centro mediante a carga dun ficheiro CSV. Atoparás máis información presionando a icona \"Axuda\". Se desexas agregar un único grupo de referencia,diríxete a \"Listado/Edición\", no menú lateral. Para cambiar datos de grupos ou eliminalos, prema no menú lateral \"Listado/Edición\"";
$id_texto_rm_alu = "Utiliza esta función para rexistrar todos @s alumn@s de referencia do Centro mediante a carga dun ficheiro CSV. Atoparás máis información presionando a icona \"Axuda\". Se desexas agregar un/unha únic@ alumn@, diríxete a \"Listado/Edición\", no menú lateral. Para cambiar datos de grupos ou eliminalos, prema no menú lateral \"Listado/Edición\"";
$id_texto_li_doc = "Desde aquí poderás comprobar a lista de docentes (ordenados alfabeticamente por apelidos) e cambiar todos os seus datos excepto o nome de usuari@. Tamén poderás suprimilos. Tes máis información pulsando a icona \"Axuda\". Se desexas agregar un docente, prema en \"Listado/Edición\", no menú lateral.";
$id_texto_li_agr = "Desde aquí poderás comprobar a lista de agrupamentos (ordenados alfabeticamente por Departamento e Materia) e cambiar todos os seus datos excepto o nome de agrupamento. Tamén poderás suprimilos. Tes máis información pulsando a icona \"Axuda\". Se desexas agregar un agrupamento, prema en \"Listado/Edición\", no menú lateral.";
$id_texto_li_gru = "Desde aquí poderás comprobar a lista de grupos de referencia (ordenados alfabeticamente por nivel e curso) e cambiar todos os seus datos excepto o nome de grupo. Tamén poderás suprimilos. Tes máis información pulsando a icona \"Axuda\". Se desexas agregar un grupo, prema en \"Listado/Edición\", no menú lateral.";
$id_texto_li_alu = "Desde aquí poderás comprobar a lista de alumn@s (ordenados alfabeticamente por grupo, apelidos e nome) e cambiar todos os seus datos excepto o código. Tamén poderás suprimilos. Tes máis información pulsando a icona \"Axuda\". Se desexas agregar un/unha alumn@, prema en \"Listado/Edición\", no menú lateral.";
$id_texto_edi_doc = "Aquí podes cambiar os datos do docente excepto o seu nome de usuario. Se non desexas cambiar a clave, deixa en branco os espazos reservados para iso. Atoparás máis información pulsando a icona \"Axuda\".";
$id_texto_edi_agr = "Aquí podes cambiar os datos do agrupamento excepto o seu nome. Atoparás máis información pulsando a icona \"Axuda\".";
$id_texto_edi_gru = "Aquí podes cambiar os datos do grupo de referencia excepto o seu nome. Atoparás máis información pulsando a icona \"Axuda\".";
$id_texto_ag_doc = "Desde este formulario poderás agregar un docente á base de datos. Dispós de máis información pulsando a icona \"Axuda\". Unha vez engadido prema en \"Listaxe/Edición\" para consultar o seu estado.";
$id_texto_ag_agr = "Desde este formulario poderás agregar un agrupamento á base de datos. Dispós de máis información pulsando a icona \"Axuda\". Unha vez engadido prema en \"Listaxe/Edición\" para consultar o seu estado.";
$id_texto_ag_gru = "Desde este formulario poderás agregar un grupo de referencia á base de datos. Dispós de máis información pulsando a icona \"Axuda\". Unha vez engadido prema en \"Listaxe/Edición\" para consultar o seu estado.";
$id_texto_ag_alum = "Desde este formulario poderás agregar un alumno á base de datos. Dispós de máis información pulsando a icona \"Axuda\". Unha vez engadido prema en \"Listaxe/Edición\" para consultar o seu estado.";
$id_texto_edi_mas_alum = "Desde este formulario poderás eliminar ou cambiar de grupo a varios alumnos de xeito simultáneo. Dispós de máis información pulsando a icona \"Axuda\".";
$id_texto_reg_eva = "Aquí poderás rexistrar e editar as datas dos períodos nos que se avaliará ao alumnado. Dispós de máis información pulsando a icona \"Axuda\".";
$id_texto_mat_mas = "Aquí poderás matricular a todo o alumnado do Centro. Dispós de máis información pulsando a icona \"Axuda\".";
$id_texto_mat_con = "Aquí poderás consultar, cambiar e eliminar a matrícula do alumnado do Centro. Dispós de máis información pulsando a icona \"Axuda\".";
$id_texto_actividades = "Aquí poderás rexistrar, consultar, cambiar e eliminar as actividades polas que avaliarás e cualificarás aos teus alumn@s. Dispós de máis información pulsando a icona \"Axuda\".";
$id_texto_horario = "Aquí poderás rexistrar, consultar, cambiar e eliminar as franxas horarias e o seu contido. Dispós de máis información pulsando a icona \"Axuda\".";
$id_csv = "ficheiro CSV";
$id_reg = "Rexistrar";
$id_error_upload = "Erro ao subir o ficheiro";
$id_error_formato = "O ficheiro non ten o formato correcto. Non se subiu nada.";
$id_error_transf = "Transferencia interrompida";
$id_transferido = "transferido";
$id_reg_exito = "Rexistro efectuado con éxito";
$id_doc = "Docente";
$id_familia = "Familia";
$id_cla = "Clave";
$id_nom = "Nome";
$id_ape = "Apelidos";
$id_ema = "Email";
$id_esp = "Especialidade";
$id_web = "Web";
$id_te1 = "Teléfono 1";
$id_te2 = "Teléfono 2";
$id_rol = "Rol";
$id_cod = "Código";
$id_fna = "D. Nacemento";
$id_fna_abrev = "D.Nac.";
$id_mod = "Modalidade";
$id_rep = "Repite";
$id_tu1 = "Titor/a 1";
$id_tu2 = "Titor/a 2";
$id_di1 = "Enderezo 1";
$id_di2 = "Enderezo 2";
$id_nac = "Nacionalidade";
$id_gru = "Grupo";
$id_agr = "Agrupamento";
$id_dep = "Departamento";
$id_mat = "Materia";
$id_cur = "Curso";
$id_niv = "Nivel";
$id_editar = "Editar";
$id_guardar = "Gardar";
$id_cambio_cla = "Cambio de clave";
$id_nueva_cla = "Nova clave";
$id_intro_cla1 = "Escribe a nova clave";
$id_intro_cla2 = "Escribe a nova clave";
$id_rep_cla1 = "Repite a clave";
$id_datos = "datos";
$id_doc_eliminado = "Este docente foi eliminado. Podes regresar á lista premendo en \"Listaxe/Edición\".";
$id_agr_eliminado = "Este agrupamento foi eliminado. Podes regresar á lista premendo en \"Listaxe/Edición\".";
$id_datos_doc_edit = "Actualízanse os datos deste docente. Podes regresar á lista premendo en \"Listaxe/Edición\".";
$id_datos_agr_edit = "Actualízanse os datos deste agrupamento. Podes regresar á lista premendo en \"Listaxe/Edición\".";
$id_datos_gru_edit = "Actualízanse os datos deste grupo de referencia. Podes regresar á lista premendo en \"Listaxe/Edición\".";
$id_error_editar = "Erro ao actualizar. Non se cambiaron os datos";
$id_error_clave = "As claves non coinciden. Non se actualizou nada";
$id_record_clave = "Cambiaches a clave deste docente. Debes notificala canto antes ao interesado e indicarlle que a cambie desde o Panel de Control";
$id_ins = "Os datos foron rexistrados. Accede a \"Listaxe/Edición\" para consultalos.";
$id_error_ins = "Ocorreu un erro. Non se puido rexistrar nada.";
$id_elim_todos = "Eliminar todo";
$id_eli = "Eliminouse todo";
$id_borra_error = "Ocorreu un erro. Non se puido eliminar nada.";
$id_elige_doc = "Elixe docente";
$id_elige_tut1 = "Elixe titor/a 1";
$id_elige_tut2 = "Elixe titor/a 2";
$id_foto = "Foto";
$id_vergrupo = "Listar alumnado do grupo";
$id_guardado = "Gardado";
$id_grabando = "Cargando/Gravando Datos";
$id_cargando = "Cargando";
$id_marcar_todos = "Todos";
$id_todos_al = "Todo o alumnado";
$id_todas_act = "Todas as actividades";
$id_todo_curso = "Todo o curso";
$id_accion = "Acción";
$id_siguiente = "Seguinte";
$id_anterior = "Anterior";
$id_fecha = "Data";
$id_per_activo = "Períodos dados de alta";
$id_resultado = "Resultado";
$id_mover_agr = "Cambiar ao agrupamento";
$id_sel = "Seleccionar";
$id_misdatos = "Os meus datos";
$id_misactividades = "As miñas actividades";
$id_mihorario = "O meu horario";
$id_misinformes = "Os meus informes";
$id_misagr = "Os meus agrupamentos";
$id_inf_asi = "Asistencia";
$id_inf_not = "Cualificación";
$id_inf_inc = "Incidencias";
$id_inf_tar = "Tarefas";
$id_inf_ent = "Entrevistas";
$id_inf_obs = "Observacións";
$id_inf_nb = "Nota Bene";
$id_inf_exa = "Exames";
$id_inf_car = "Cartas";
$id_inf_tut = "Titoría";
$id_inf_bol = "Boletíns";
$id_inf_Bol = "Boletín";
$id_inf_eva = "Evaluación";
$id_mismensajes = "As miñas mensaxes";
$id_centrotrab = "Centro de traballo";
$id_direccion = "Enderezo";
$id_telef = "Teléfono";
$id_fax = "Fax";
$id_nav = "Navegar";
$id_nueva_foto = "Cambiar foto";
$id_mensaje_foto = "Éxito. Pulsa nos meus datos de novo para ver a fotografía subida";
$id_activ = "Actividade";
$id_agrupamento = "agrupamento";
$id_reg_activ = "Rexistrar unha nova actividade";
$id_nom_activ = "Nome da actividade";
$id_agr_activ = "Selecciona os agrupamentos aos que asignas esta nova actividade e a súa ponderación";
$id_noagrup = "Aínda non tes asignado ningún agrupamento. Contacta co administrador do sistema.";
$id_ponderacion = "Ponderación (%)";
$id_ponderacion_txt = "Ponderación en %. Usa o punto como separador decimal";
$id_periodo_txt = "Elixe período (por defecto, a actividade é para todo o curso)";
$id_noactiv = "Aínda non rexistraches ningunha actividade";
$id_activ_reg = "Actividades rexistradas ata o momento";
$id_edita_act = "Editar. Actividade (máx 15); agrupamento (máx 10); Ponderación (máx 2 decimais)";
$id_ver_horario = "Ver horario";
$id_num_franjas = "Número de franxas horarias";
$id_franjas = "Franxas horarias";
$id_franja = "Franxa";
$id_cl = "LU";
$id_cm = "MA";
$id_cx = "ME";
$id_cj = "XO";
$id_cv = "VE";
$id_cs = "SA";
$id_cd = "DO";
$id_l = "Luns";
$id_m = "Martes";
$id_x = "Mércores";
$id_j = "Xoves";
$id_v = "Venres";
$id_s = "Sábado";
$id_d = "Domingo";
$id_ene = "Xan";
$id_feb = "Feb";
$id_mar = "Mar";
$id_abr = "Abr";
$id_may = "Mai";
$id_jun = "Xuñ";
$id_jul = "Xul";
$id_ago = "Ago";
$id_sep = "Sep";
$id_oct = "Out";
$id_nov = "Nov";
$id_dic = "Dec";
$id_enero = "Xaneiro";
$id_febrero = "Febreiro";
$id_marzo = "Marzo";
$id_abril = "Abril";
$id_mayo = "Maio";
$id_junio = "Xuño";
$id_julio = "Xullo";
$id_agosto = "Agosto";
$id_septiembre = "Setembro";
$id_octubre = "Outubro";
$id_noviembre = "Novembro";
$id_diciembre = "Decembro";
$id_recreo = "RECREO";
$id_fam_tut = "AT.FAM.TUT.";
$id_fam = "AT.FAM.";
$id_tsa = "TUT.SEN.ALU.";
$id_rtut = "R. TITORES";
$id_rdep = "R. DEPART.";
$id_pprac = "PREP. PRACT.";
$id_ac = "ACT.COMPLEM.";
$id_guardia = "GARDA";
$id_guardia_recreo = "GARDA REC";
$id_biblioteca = "BIBLIOTECA";
$id_jd = "J.D.";
$id_ed = "E.D.";
$id_ccp = "CCP";
$id_red_tic = "REDE.TIC.";
$id_red_lac = "REDE.LACT.";
$id_red_jub = "REDE.JUB.";
$id_ored = "OUTRAS REDE.";
$id_chl = "CHL";
$id_noper = "NON.PERMAN.";
$id_nueva_fila = "Engadir fila";
$id_miagenda = "A miña axenda";
$id_horaini = "Hora";
$id_sesion = "Sesión";
$id_cita = "Cita";
$id_citpub = "Público";
$id_citpri = "Privado";
$id_hoy = "hoxe";
$id_noclase = "Hoxe non hai clase. É fin de semana. Tamén pode ocorrer que non configures o teu horario. Se o acabas de facer, volve acceder á  SIESTTA";
$id_nocita = "Engadir cita";
$id_elicita = "Eliminar cita";
$id_edicita = "Editar cita";
$id_seltipocita = "Tipo de cita";
$id_saludo = "Benvid@ á SIESTTA 2.0";
$id_citaeli = "Cita eliminada da axenda";
$id_regcita = "Rexistrar cita";
$id_regnotas = "Rexistrar cualificación";
$id_actcita = "Actualizar cita";
$id_cancelar = "Cancelar";
$id_tarea = "Tarefa";
$id_tareas = "Tarefas";
$id_examen = "Exame";
$id_examen_pdtes = "Próximos Exames";
$id_obs = "Observación";
$id_privado = "Privado";
$id_abr_tarea = "T";
$id_abr_examen = "E";
$id_abr_privado = "P";
$id_abr_obs = "Ou";
$id_abr_nb = "NB";
$id_verficha = "Ver ficha";
$id_elgagr = "Elixe agrupamento";
$id_elgalu = "Elixe alumn@";
$id_elgact = "Elixe actividade";
$id_elgper = "Elixe período";
$id_final = "Final";
$id_finalF = "Final ()";
$id_nodatos = "Sen datos";
$id_total = "Total";
$id_total_j = "Xustificadas";
$id_pdf = "Xerar PDF";
$id_pdf_tut = "Xerar Informe en branco";
$id_hasta_fecha = "Ata a data";
$id_todos_agrup = "Total agrupamentos";
$id_descripcion = "Descrición";
$id_coment = "Comentario";
$id_ocultar = "Ocultar";
$id_recibidos = "Recibidos";
$id_enviados = "Enviados";
$id_borradores = "Borradores";
$id_redactar = "Redactar";
$id_asunto = "Asunto";
$id_destinatario = "Para";
$id_enviar = "Enviar";
$id_borrador = "Gardar borrador";
$id_mensaje_enviado = "A mensaxe foi enviada con éxito";
$id_mensaje_no_enviado = "Non se puido enviar a mensaxe";
$id_borrador_guardado = "Borrador gardado";
$id_borrador_no_guardado = "Non se puido gardar o borrador";
$id_remitente = "Remitente";
$id_mensaje = "Mensaxe";
$id_leer = "Ler";
$id_nomensajes_borr = "Non existen borradores";
$id_nomensajes_env = "Non existen mensaxes enviadas";
$id_nomensajes_rec = "Non existen mensaxes recibidas";
$id_mensaje_elim = "Mensaxe eliminada";
$id_mensaje_no_elim = "Non se puido eliminar a mensaxe";
$id_todos_doc = "Todos os docentes";
$id_todos_doc_agr = "Todos os seus docentes";
$id_todos_fam = "Todas as familias";
$id_mensaje_nuevo = "Mensaxe nova";
$id_mensajes_nuevos = "Tes novas mensaxes";
$id_mensaje_leido = "Mensaxe leído";
$id_red_tarea = "Rexistrar tarefa";
$id_red_obs = "Rexistrar observación";
$id_red_carta = "Redactar unha carta";
$id_red_entrev = "Rexistrar unha entrevista";
$id_gen_bol = "Xerar un boletín";
$id_nota = "Nota";
$id_nota_media = "Nota media";
$id_nota_media_pond = "Achega á nota";
$id_no_calif = "Non existen cualificacións";
$id_no_coment = "Non hai comentarios";
$id_no_tareas = "Non existen tarefas";
$id_fecha_reg = "Data de rexistro";
$id_fecha_ent = "Data de entrega";
$id_no_obs = "Non existen observacións";
$id_no_nb = "Non existe ningunha nota bene";
$id_texto = "Texto";
$id_no_cartas = "Non existen cartas";
$id_no_entrev = "Non existen entrevistas";
$id_no_activ = "Non existen actividades";
$id_no_asi = "Non ten faltas de asistencia";
$id_no_exam = "Non hai exames";
$id_datos_personales = "Datos persoais";
$id_datos_escolares = "Datos escolares";
$id_datos_agrupamento = "Datos do agrupamento";
$id_exped = "Expediente";
$id_ficha = "Ficha";
$id_faltas = "Faltas";
$id_retrasos = "Atrasos";
$id_justificadas = "Xustificadas";
$id_todas_faltas = "Consultar todas as faltas";
$id_todas_observaciones = "Consultar todas as observacións";
$id_calificacion = "Nota ata a data";
$id_hay_tarea = "Ten que entregar tarefa";
$id_no_tutoria = "Non existen informes de titoría propios";
$id_red_tutoria = "Redactar informe de titoría";
$id_mas_item = "Engadir un ítem";
$id_item = "Ítem";
$id_no_item = "Non existen ítems";
$id_valor = "Valor";
$id_incluir = "Incluír";
$id_ningun_doc = "Non usa SIESTTA";
$id_procede = "Informe de";
$id_tutoria_recib = "Informes de titoría recibidos";
$id_tutoria_prop = "Informes de titoría propios";
$id_error_activ = "ERRO. Xa tes unha actividade con este nome";
$id_texto_no_informecalif = "Non procede este tipo de informe";
$id_mes = "Mes";
$id_anyo = "Ano";
$id_no_inf = "Non existen informes";
$id_red_eval = "Redactar informe de evaluación";
$id_tarea_hoy = "Hoxe hai tarefas que entregar. Revisa a axenda";
$id_horario_lectivo = "Horario lectivo";
$id_recupera = "Recuperación";
$id_recu_elim = "Nota eliminada";
$id_exam_pdtes = "Número de Exames pendentes";
$id_fecha_prim = "Data do primeiro";
$id_firma_tut = "Firma da nai ou o pai ou o titor legal";
$id_ultimas_not = "Últimas cualificacións";
$id_buscar_al = "Buscar alumn@";
$id_resumen = "Cadro resumo";
$id_hay_notas_hoy = "Hai notas hoxe";
$id_todas_notas = "Ver todas as notas";
$id_tareas_pendientes = "Hai tarefas que entregar";
$id_todos_mensajes = "Ver todas as mensaxes";
$id_todas_tareas = "Ver todas as tarefas";
$id_todos_exam = "Ver todos os Exames";
$id_tareas_grupo = "Tarefas (para todo o alumnado)";
$id_tareas_ind = "Tarefas (só para este/a alumno/a)";
$id_inf_cla = "Claves de acceso (familias)";
$id_num_fam = "Número de familia";
$id_cla_fam = "Clave de familia";

$id_just_mas = 'Xustificación masiva';
$id_faltajust = 'Falta';
$id_justificar = 'Xustificar';
$id_ninguno = 'Ningún';

$id_listado_clase = 'Todo el agrupamiento';

$id_max = 'Nota máxima';
$id_min = 'Nota mínima';
$id_avg = 'Nota media';


?>
