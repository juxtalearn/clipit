<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$spanish = array(
    'message' => 'mensaje',
    'messages' => 'mensajes',
    'messages:compose' => 'crea un mensaje',
    'messages:subject' => 'tema',

    'messages:inbox' => 'entrada',
    'messages:drafts' => 'Borradores',
    'messages:sent_email' => 'enviar correo',
    'messages:trash' => 'papelera',
    'messages:contactmembersgroup' => 'contactar con miembros del grupo',
    // Message
    'message:from'  => "de",
    'message:to'  => "para",
    'message:last_reply'  => "última respuesta",
    'message:unread'  => "no leido",
    'message:notfound' => "mensaje no encontrado",
    'message:options'  => "opciones",
    'message:created' => "su mensaje ha sido enviado correctamente.",
    'message:cantcreate' => "No se pudo enviar el mensaje",
    'reply:created' => "Su respuesta fue enviada correctamente.",
    'message:movetotrash' => "mover a la papelera",
    'message:movetoinbox' => "mover a bandeja de entrada",
    'message:markasread' => "marcar como leído",
    'message:markasunread' => "marcar como no leído",
    'messages:read:marked' => "mensajes marcados como leidos",
    'messages:unread:marked' => "mensajes marcados como no leidos",
    'messages:removed' => "mensajes borrados",
    'messages:inbox:moved' => "mensajes movidos a la bandeja de entrada",
    'messages:error' => 'hubo un problema con su mensaje, por favor inténtelo de nuevo.',
    'messages:error:messages_not_selected' => 'no se han seleccionado mensajes',
    'messages:unreads' => '%s mensajes no leídos',

    // Error pages: empty folders
    'messages:inbox:none' => "no hay mensajes en su bandeja de entrada.",
    'messages:sent:none' => "no hay mensajes enviados.",
    'messages:trash:none' => "no hay mensajes en su papelera.",


    // Search
    'messages:search' => 'buscar: %s',
    // Filter
    'messages:all' => 'todo',
    'messages:private_msg' => 'mensajes privados',
    'messages:my_activities' => 'mi actividad',
    // Reply
    'reply:edit' => "editar respuesta",
    'reply:create' => 'crear respuesta',
    'reply' => 'contestar',
    'reply:total' => '%s numero de respuesta',
    'reply:unreads' => '%s respuesta no leídas',
);

add_translation('es', $spanish);