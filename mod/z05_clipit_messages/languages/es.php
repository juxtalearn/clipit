<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$spanish = array(
    'message' => 'Mensaje',
    'messages' => 'Mensajes',
    'messages:compose' => 'Crear mensaje',
    'messages:subject' => 'Asunto',
    'message:send' => 'Enviar mensaje',

    'messages:inbox' => 'Bandeja de entrada',
    'messages:drafts' => 'Borradores',
    'messages:sent_email' => 'Mensajes enviados',
    'messages:trash' => 'Papelera',
    'messages:contactmembersgroup' => 'Contactar con miembros del grupo',
    // Message
    'message:from'  => "De",
    'message:to'  => "Para",
    'message:to_students' => 'Para estudiantes de mi actividad',
    'message:last_reply'  => "Última respuesta",
    'message:unread'  => "no leido",
    'message:notfound' => "Mensaje no encontrado",
    'message:options'  => "Opciones",
    'message:created' => "Tu mensaje ha sido enviado correctamente.",
    'message:cantcreate' => "No se pudo enviar el mensaje",
    'reply:deleted' => "Discussion reply has been deleted.",
    'reply:created' => "Su respuesta fue enviada correctamente.",
    'reply:cantdelete' => 'No se ha podido eliminar el mensaje',
    'reply:cantedit' => 'No se ha podido editar el mensaje',
    'reply:edit' => 'Mensaje editado',
    'message:movetotrash' => "Mover a la papelera",
    'message:movetoinbox' => "Mover a bandeja de entrada",
    'message:markasread' => "Marcar como leído",
    'message:markasunread' => "Marcar como no leído",
    'messages:read:marked' => "Mensaje(s) marcado(s) como leido(s)",
    'messages:unread:marked' => "Mensaje(s) marcado(s) como no leido(s)",
    'messages:removed' => "Mensajes borrados",
    'messages:inbox:moved' => "Mensajes movidos a la bandeja de entrada",
    'messages:error' => 'Hubo un problema con su mensaje, por favor inténtelo de nuevo.',
    'messages:error:messages_not_selected' => 'No se han seleccionado mensajes',
    'messages:unreads' => '%s mensajes no leídos',

    // Error pages: empty folders
    'messages:inbox:none' => "No hay mensajes en su bandeja de entrada.",
    'messages:sent:none' => "No hay mensajes enviados.",
    'messages:trash:none' => "No hay mensajes en su papelera.",


    // Search
    'messages:search' => 'Buscar: %s',
    // Filter
    'messages:all' => 'Todo',
    'messages:private_msg' => 'Mensajes privados',
    'messages:my_activities' => 'Mi actividades',
    // Reply
    'reply:edit' => "Editar respuesta",
    'reply:create' => 'Enviar respuesta',
    'reply:msg' => 'Responder',
    'reply:total' => '%s respuestas en total',
    'reply:unreads' => '%s respuesta no leídas',
);

add_translation('es', $spanish);