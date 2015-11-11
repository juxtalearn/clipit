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
$german = array(
    'message' => 'Nachricht',
    'messages' => 'Nachrichten',
    'messages:compose' => 'Nachricht erstellen',
    'messages:subject' => 'Betreff',

    'messages:inbox' => 'Posteingang',
    'messages:drafts' => 'Entwürfe',
    'messages:sent_email' => 'Gesendete Nachrichten',
    'messages:trash' => 'Papierkorb',
    'messages:contactmembersgroup' => 'Kontaktiere Gruppenmitglieder',
    // Message
    'message:from'  => "Von",
    'message:to'  => "An",
    'message:last_reply'  => "Letzte Antwort",
    'message:unread'  => "Ungelesen",
    'message:notfound' => "Nachricht nicht gefunden",
    'message:options'  => "Optionen",
    'message:created' => "Deine Nachricht wurde versendet.",
    'message:cantcreate' => "Nachricht konnte nicht versendet werden",
    'reply:created' => "Ihre Antwort wurde erfolgreich versendet.",
    'message:movetotrash' => "In Papierkorb verschieben",
    'message:movetoinbox' => "In Posteingang verschieben",
    'message:markasread' => "Als gelesen markieren",
    'message:markasunread' => "Als ungelesen markieren",
    'messages:read:marked' => "Nachrichten wurden als gelesen markiert",
    'messages:unread:marked' => "Nachrichten wurden als ungelesen markiert",
    'messages:removed' => "Nachrichten gelöscht",
    'messages:inbox:moved' => "Nachrichten in den Posteingang verschoben",
    'messages:error' => 'Es ist ein Problem aufgetreten. Bitten wiederholen Sie den Vorgang.',
    'messages:error:messages_not_selected' => 'Keine Nachrichten gewählt',
    'messages:unreads' => '%s ungelesene Nachrichten',

    // Error pages: empty folders
    'messages:inbox:none' => "Keine Nachrichten im Posteingang",
    'messages:sent:none' => "Es wurden keine Nachrichten versendet",
    'messages:trash:none' => "Es sind keine Nachrichten im Papierkorb.",


    // Search
    'messages:search' => 'Suche: %s',
    // Filter
    'messages:all' => 'Alle',
    'messages:private_msg' => 'Private Nachrichten',
    'messages:my_activities' => 'Meine Aktivitäten',
    // Reply
    'reply:edit' => "Editiere Antwort",
    'reply:create' => 'Antworten',
    'reply' => 'Antworten',
    'reply:total' => '%s Antworten insgesamt',
    'reply:unreads' => '%s ungelesene Antworten',
);

add_translation('de', $german);