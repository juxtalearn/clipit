<?php
/**
 * Elgg send a message action page
 * Formal spanish version by LeonardoA
 * 
 * @package ElggMessages
*/

$spanish = array(
	/**
	* Menu items and titles
	*/

	'messages' => "Mensajes",
	'messages:unreadcount' => "%s no leidos",
	'messages:back' => "regresar a los mensajes",
	'messages:user' => "Bandeja de entrada de %s",
	'messages:posttitle' => "Mensajes de %s: %s",
	'messages:inbox' => "Bandeja de entrada",
	'messages:send' => "Enviar",
	'messages:sent' => "Enviado",
	'messages:message' => "Mensaje",
	'messages:title' => "Asunto",
	'messages:to' => "Para",
	'messages:from' => "De",
	'messages:fly' => "Enviar",
	'messages:replying' => "Respondiendo a",
	'messages:inbox' => "Bandeja de entrada",
	'messages:sendmessage' => "Enviar un mensaje",
	'messages:compose' => "Escribir un mensaje",
	'messages:add' => "Escribir un mensaje",
	'messages:sentmessages' => "Mensajes enviados",
	'messages:recent' => "Mensajes recientes",
	'messages:original' => "Mensaje original",
	'messages:yours' => "Su mensaje",
	'messages:answer' => "Responder",
	'messages:toggle' => 'Seleccionar/Deseleccionar todos',
	'messages:markread' => 'Marcar como leido',
	'messages:recipient' => 'Seleccione un destinatario...',
	'messages:to_user' => 'Para: %s',

	'messages:new' => 'Mensaje nuevo',

	'notification:method:site' => 'Sitio',

	'messages:error' => 'Ocurrió un problema al guardar su mensaje. Por favor intente nuevamente.',

	'item:object:messages' => 'Mensajes',

	/**
	* Status messages
	*/

	'messages:posted' => "Su mensaje ha sido enviado.",
	'messages:success:delete:single' => 'El mensaje fue eliminado',
	'messages:success:delete' => 'Mensajes eliminados',
	'messages:success:read' => 'Mensajes marcados como leidos',
	'messages:error:messages_not_selected' => 'No hay mensajes seleccionados',
	'messages:error:delete:single' => 'No se puede eliminar el mensaje',

	/**
	* Email messages
	*/

	'messages:email:subject' => 'Tiene un mensaje',
	'messages:email:body' => "Tiene un nuevo mensaje de %s.:

	
	%s

	
	Para ver sus mensajes, haga click a continuación:

	%s

	Para enviar un mensaje a %s, haga click aquí:

	%s

	No puede responder directamente a este correo.",

	/**
	* Error messages
	*/

	'messages:blank' => "Debes escribir algo en el cuerpo del mensaje antes de guardar.",
	'messages:notfound' => "No se pudo encontrar el mensaje especificado.",
	'messages:notdeleted' => "No se pudo eliminar este mensaje.",
	'messages:nopermission' => "No tiene permisos para modificar ese mensaje.",
	'messages:nomessages' => "No hay mensajes.",
	'messages:user:nonexist' => "No encontramos al destinatario entre los usuarios registrados.",
	'messages:user:blank' => "No ha seleccionado a nadie como destinatario.",

	'messages:deleted_sender' => 'Usuario borrado',

);
		
add_translation("es", $spanish);