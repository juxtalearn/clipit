<?php
/**
 * Elgg groups plugin spanish language pack
 * Formal spanish version by LeonardoA
 *
 * @package ElggGroups
 */

$spanish = array(

	/**
	 * Menu items and titles
	 */
	'groups' => "Grupos",
	'groups:owned' => "Grupos que administro",
	'groups:owned:user' => 'Grupos que administra %s',
	'groups:yours' => "Mis grupos",
	'groups:user' => "Grupos de %s",
	'groups:all' => "Grupos",
	'groups:add' => "Crear grupo",
	'groups:edit' => "Editar grupo",
	'groups:delete' => 'Borrar grupo',
	'groups:membershiprequests' => 'Manejar solicitudes de unión a grupos',
	'groups:invitations' => 'Invitaciones a grupos',

	'groups:icon' => 'Icono de grupo (opcional)',
	'groups:name' => 'Nombre del Grupo',
	'groups:username' => 'Nombre corto del Grupo (mostrado en la URL, sólo caracteres alfanuméricos)',
	'groups:description' => 'Descripción completa',
	'groups:briefdescription' => 'Descripción breve',
	'groups:interests' => 'Etiquetas',
	'groups:website' => 'Sitio Web',
	'groups:members' => 'Miembros del grupo',
	'groups:members:title' => 'Miembros de %s',
	'groups:members:more' => "Ver todos los miembros",
	'groups:membership' => "Ver los permisos de los miembros",
	'groups:access' => "Permisos de acceso",
	'groups:owner' => "Propietario",
	'groups:owner:warning' => "Atención: si cambia este valor, ya no será administrador de este grupo.",
	'groups:widget:num_display' => 'Número de grupos a mostrar',
	'groups:widget:membership' => 'Sus Grupos',
	'groups:widgets:description' => 'Muestra en su perfil los grupos a los que pertenece',
	'groups:noaccess' => 'No hay acceso al grupo',
	'groups:permissions:error' => 'No tiene permisos para realizar esta acción',
	'groups:ingroup' => 'en el grupo',
	'groups:cantcreate' => 'Solo administradores pueden crear grupos.',
	'groups:cantedit' => 'No puede editar este grupo',
	'groups:saved' => 'Grupo guardado',
	'groups:featured' => 'Grupos destacados',
	'groups:makeunfeatured' => 'No destacar',
	'groups:makefeatured' => 'Destacar',
	'groups:featuredon' => '%s es miembro de un grupo destacado.',
	'groups:unfeatured' => '%s ha sido retirado de los grupos destacados.',
	'groups:featured_error' => 'Grupo inválido.',
	'groups:joinrequest' => 'Solicitar unirse',
	'groups:join' => 'Unirse al grupo',
	'groups:leave' => 'Abandonar el grupo',
	'groups:invite' => 'Invitar amigos',
	'groups:invite:title' => 'Invitar amigos a este grupo',
	'groups:inviteto' => "Invitar amigos a '%s'",
	'groups:nofriends' => "No tiene amigos que no hayan sido invitados al grupo.",
	'groups:nofriendsatall' => 'No hay amigos para invitar',
	'groups:viagroups' => "a traves de los grupos",
	'groups:group' => "Grupo",
	'groups:search:tags' => "etiqueta",
	'groups:search:title' => "Buscar grupos marcados con '%s'",
	'groups:search:none' => "No se encontraron grupos que cumplieran con la búsqueda",
	'groups:search_in_group' => "Buscar en este grupo",
	'groups:acl' => "Grupo: %s",

	'discussion:notification:topic:subject' => 'Nuevo tema de discusión para el grupo',
	'groups:notification' =>
'%s ha agregado un nuevo tema a %s:

%s
%s

Ver y responder:
%s
',

	'discussion:notification:reply:body' =>
'%s ha respondido al tema %s en el grupo %s:

%s

Ver y comentar:
%s
',

	'groups:activity' => "Actividad del grupo",
	'groups:enableactivity' => 'Permitir actividades del grupo',
	'groups:activity:none' => "El grupo no ha tenido actividad aún",

	'groups:notfound' => "No se encontró el grupo",
	'groups:notfound:details' => "El grupo solicitado no existe o no tiene permiso para verlo",

	'groups:requests:none' => 'No hay solicitudes de membresía.',

	'groups:invitations:none' => 'Actualmente no tiene invitaciones.',

	'item:object:groupforumtopic' => "Temas de discusión",

	'groupforumtopic:new' => "Añadir un tema de discusión",

	'groups:count' => "grupos creados",
	'groups:open' => "grupo abierto",
	'groups:closed' => "grupo privado",
	'groups:member' => "miembros",
	'groups:searchtag' => "Buscar grupos por etiquetas",

	'groups:more' => 'Ver todos',
	'groups:none' => 'No hay grupos',


	/*
	 * Access
	 */
	'groups:access:private' => 'Cerrado - los miembros deben ser invitados',
	'groups:access:public' => 'Abierto - cualquiera puede unirse',
	'groups:access:group' => 'Sólo miembros del grupo',
	'groups:closedgroup' => 'Este grupo es sólo por invitación',
	'groups:closedgroup:request' => 'Para solicitar unirse, haga click en "Solicitar unirse".',
	'groups:visibility' => '¿Quienes pueden ver este grupo?',

	/*
	Group tools
	*/
	'groups:enableforum' => 'Habilitar discusión en los grupos',
	'groups:yes' => 'sí',
	'groups:no' => 'no',
	'groups:lastupdated' => 'Última actualizacion de %s por %s',
	'groups:lastcomment' => 'Último comentario de %s por %s',

	/*
	Group discussion
	*/
	'discussion' => 'Discusión',
	'discussion:add' => 'Añadir tema de discusión',
	'discussion:latest' => 'Último tema de discusion',
	'discussion:group' => 'Discusiones de grupo',
	'discussion:none' => 'No hay discusiones',
	'discussion:reply:title' => 'Respuesta por %s',

	'discussion:topic:created' => 'El tema de discusión ha sido creado.',
	'discussion:topic:updated' => 'El tema de discusión ha sido actualizado.',
	'discussion:topic:deleted' => 'El tema de discusión ha sido borrado.',

	'discussion:topic:notfound' => 'No se ha encontrado el tema de discusión.',
	'discussion:error:notsaved' => 'No se puede guardar el tema de discusión',
	'discussion:error:missing' => 'El título y el contenido son obligatorios',
	'discussion:error:permissions' => 'No tiene permiso para hacer eso',
	'discussion:error:notdeleted' => 'No se pudo borrar el tema de discusión',

	'discussion:reply:deleted' => 'La respuesta ha sido borrada.',
	'discussion:reply:error:notdeleted' => 'No se pudo borrar la respuesta',

	'reply:this' => 'Responder a esto',

	'group:replies' => 'Respuestas',
	'groups:forum:created' => 'Creó %s con %d comentarios',
	'groups:forum:created:single' => 'creado %s con %d respuestas',
	'groups:forum' => 'Discusión',
	'groups:addtopic' => 'Agregar un tema',
	'groups:forumlatest' => 'Última discusión',
	'groups:latestdiscussion' => 'Actividad reciente',
	'groups:newest' => 'Nuevo',
	'groupspost:success' => 'Tu respuesta ha sido publicada',
	'groups:alldiscussion' => 'Última discusión',
	'groups:edittopic' => 'Editar tema',
	'groups:topicmessage' => 'Mensaje del tema',
	'groups:topicstatus' => 'Estado del tema',
	'groups:reply' => 'Responder',
	'groups:topic' => 'Tema',
	'groups:posts' => 'Publicaciones',
	'groups:lastperson' => 'Último usuario',
	'groups:when' => 'Cuando',
	'grouptopic:notcreated' => 'No hay temas creados.',
	'groups:topicopen' => 'Abierto',
	'groups:topicclosed' => 'Cerrado',
	'groups:topicresolved' => 'Resuelto',
	'grouptopic:created' => 'Tu tema ha sido creado.',
	'groupstopic:deleted' => 'El tema ha sido eliminado.',
	'groups:topicsticky' => 'Permanente',
	'groups:topicisclosed' => 'Esta discusión está cerrada.',
	'groups:topiccloseddesc' => 'Este tema está cerrado y no acepta nuevos comentarios.',
	'grouptopic:error' => 'El grupo no pudo ser creado. Por favor intenta de nuevo o contacta con el administrador.',
	'groups:forumpost:edited' => "Has editado la entrada exitosamente.",
	'groups:forumpost:error' => "Hubo un problema al editar la entrada.",


	'groups:privategroup' => 'Este es un grupo privado. Debe solicitar membresía.',
	'groups:notitle' => 'El grupo debe tener un título',
	'groups:cantjoin' => 'No se puedo unir al grupo',
	'groups:cantleave' => 'No se pudo abandonar el grupo',
	'groups:removeuser' => 'Remover del grupo',
	'groups:cantremove' => 'No se puede remover este usuario del grupo',
	'groups:removed' => 'El usuario %s ha sido removido del grupo',
	'groups:addedtogroup' => 'El usuario ha sido agregado con éxito',
	'groups:joinrequestnotmade' => 'No se pudo enviar la solicitud de membresía del grupo',
	'groups:joinrequestmade' => 'Ha solicitado unirse al grupo',
	'groups:joined' => 'Se ha unido al grupo',
	'groups:left' => 'Ha abandonado el grupo',
	'groups:notowner' => 'No es el propietario del grupo.',
	'groups:notmember' => 'No es miembro de este grupo.',
	'groups:alreadymember' => 'Ya es miembro de este grupo',
	'groups:userinvited' => 'El usuario ha sido invitado.',
	'groups:usernotinvited' => 'El usuario no pudo ser invitado.',
	'groups:useralreadyinvited' => 'El usuario ya ha sido invitado',
	'groups:invite:subject' => "%s le ha invitado al grupo %s",
	'groups:updated' => "Última respuesta por %s %s",
	'groups:started' => "Iniciado por %s",
	'groups:joinrequest:remove:check' => '¿Seguro que desea cancelar esta solicitud de membresía?',
	'groups:invite:remove:check' => '¿Seguro que desea anular esta invitación?',
	'groups:invite:body' => "Hola %s,

%s le ha invitado para que se una al grupo '%s'. Haga click en el siguiente enlace para aceptar la invitación:

%s",

	'groups:welcome:subject' => "Bienvenido al grupo %s",
	'groups:welcome:body' => "¡Hola %s!

Ahora es miembro del grupo '%s'. Haga click en el siguiente enlace para comenzar a participar:

%s",

	'groups:request:subject' => "%s ha solicitado unirse al grupo %s",
	'groups:request:body' => "Hola %s,

%s ha solicitado unirse al grupo '%s'. Haga click en el siguiente enlace para ver su perfil:

%s

O click a continuación para ver todas las solicitudes de membresía del grupo:

%s",

	/*
		Forum river items
	*/

	'river:create:group:default' => '%s ha creado el grupo %s',
	'river:join:group:default' => '%s se ha unido al grupo %s',
	'river:create:object:groupforumtopic' => '%s abrió el tema %s',
	'river:reply:object:groupforumtopic' => '%s ha respondido en el tema %s',
	
	'groups:nowidgets' => 'No se han definido widgets para el grupo.',


	'groups:widgets:members:title' => 'Miembros del grupo',
	'groups:widgets:members:description' => 'Despliega los miembros del grupo.',
	'groups:widgets:members:label:displaynum' => 'Despliega los miembros de un grupo.',
	'groups:widgets:members:label:pleaseedit' => 'Por favor configure este widget.',

	'groups:widgets:entities:title' => "Objetos en el grupo",
	'groups:widgets:entities:description' => "Despliega los objetos guardados en este grupo",
	'groups:widgets:entities:label:displaynum' => 'Despliega los objetos de este grupo.',
	'groups:widgets:entities:label:pleaseedit' => 'Por favor configure este widget.',

	'groups:forumtopic:edited' => 'Tema de discusión editado con éxito.',

	'groups:allowhiddengroups' => '¿Desea habilitar los grupos privados (invisibles)?',
	'groups:whocancreate' => '¿Quién puede crear nuevos grupos?',

	/**
	 * Action messages
	 */
	'group:deleted' => 'Grupo y contenidos borrados',
	'group:notdeleted' => 'El grupo no pudo ser borrado',

	'group:notfound' => 'No se pudo encontrar el grupo',
	'grouppost:deleted' => 'Publicación del grupo borrada con éxito',
	'grouppost:notdeleted' => 'La publicación del grupo no se pudo borrar',
	'groupstopic:deleted' => 'Tema borrado',
	'groupstopic:notdeleted' => 'No se pudo borrar el tema',
	'grouptopic:blank' => 'No hay temas',
	'grouptopic:notfound' => 'No se pude encontrar el tema solicitado',
	'grouppost:nopost' => 'Publicación vacía',
	'groups:deletewarning' => "¿Seguro que desea borrar este grupo? Esta acción no se puede deshacer",

	'groups:invitekilled' => 'La invitación ha sido eliminada.',
	'groups:joinrequestkilled' => 'La solicitud ha sido eliminada.',

	// ecml
	'groups:ecml:discussion' => 'Discusiónes de grupos',
	'groups:ecml:groupprofile' => 'Perfiles de grupos',

);

add_translation("es", $spanish);
