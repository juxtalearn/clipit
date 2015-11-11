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
$swedish = array(
    'message' => 'Meddelande',
    'messages' => 'Meddelanden',
    'messages:compose' => 'Skriv ett meddelande',
    'messages:subject' => 'Ärende',
    'message:send' => 'Skicka ett meddelande',

    'messages:inbox' => 'Inkorg',
    'messages:drafts' => 'Utkast',
    'messages:sent_email' => 'Skickade meddelanden',
    'messages:trash' => 'Papperskorg',
    'messages:contactmembersgroup' => 'Kontakta gruppmedlemmar',
    // Message
    'message:from'  => "Från",
    'message:to'  => "Till",
    'message:to_students' => 'Till studenter från min aktivitet',
    'message:last_reply'  => "Senaste svar",
    'message:unread'  => "oläst",
    'message:notfound' => "Meddelandet kunde inte hittas",
    'message:options'  => "Alternativ",
    'message:created' => "Ditt meddelande har skickats.",
    'message:cantcreate' => "Ditt meddelande kunde inte skickas.",
    'reply:deleted' => "Diskussionssvaret har tagits bort.",
    'reply:created' => "Ditt svar har skickats.",
    'reply:cantdelete' => 'Kan inte ta bort meddelandet',
    'reply:cantedit' => 'Kan inte redigera meddelandet',
    'reply:edited' => 'Meddelande redigerat',
    'message:movetotrash' => "Flytta till papperskorg",
    'message:movetoinbox' => "Flytta till inkorgen",
    'message:markasread' => "Markera som läst",
    'message:markasunread' => "Markera som oläst",
    'messages:read:marked' => "Meddelanden markerade som lästa",
    'messages:unread:marked' => "Meddelanden markerade som olästa",
    'messages:removed' => "Meddelanden flyttades",
    'messages:inbox:moved' => "Meddelanden flyttade till inkorg",
    'messages:error' => 'Det uppstod ett problem med ditt meddelande. Försök igen.',
    'messages:error:messages_not_selected' => 'Inget meddelande är valt',
    'messages:unreads' => '%s olästa meddelanden',

    // Error pages: empty folders
    'messages:inbox:none' => "Det finns inga meddelanden i din inkorg.",
    'messages:sent:none' => "Det finns inga skickade meddelanden.",
    'messages:trash:none' => "Det finns inga meddelanden i din skräpkorg.",


    // Search
    'messages:search' => 'Sök: %s',
    // Filter
    'messages:all' => 'Alla',
    'messages:private_msg' => 'Privata meddelanden',
    'messages:my_activities' => 'Mina aktiviteter',
    // Reply
    'reply:edit' => "Redigera svar",
    'reply:create' => 'Skapa svar',
    'reply' => 'Reply',
    'reply:total' => '%s totalt antal svar',
    'reply:unreads' => '%s olästa svar',
);

add_translation('sv', $english);