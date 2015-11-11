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
$portuguese = array(
    'message' => 'Mensagem',
    'messages' => 'Mensagens',
    'messages:compose' => 'Compor mensagem',
    'messages:subject' => 'Assunto',
    'message:send' => 'Enviar uma mensagem',

    'messages:inbox' => 'Caixa de entrada',
    'messages:drafts' => 'Drafts',
    'messages:sent_email' => 'Mensagens enviadas',
    'messages:trash' => 'Lixo',
    'messages:contactmembersgroup' => 'Contactar com os membros do grupo',
    // Message
    'message:from'  => "De",
    'message:to'  => "Para",
    'message:last_reply'  => "Ultima resposta",
    'message:unread'  => "por ler",
    'message:notfound' => "Mensagem não encontrada",
    'message:options'  => "Opcoes",
    'message:created' => "A sua mensagem foi enviada.",
    'message:cantcreate' => "Não foi possible enviar a mensagem",
    'reply:deleted' => "Discussion reply has been deleted.",
    'reply:created' => "A sua resposta foi enviada.",
    'reply:cantdelete' => 'Não é possivel apagar a mensagem',
    'reply:cantedit' => 'Não é possivel editar a mensagem',
    'reply:edit' => 'Mensagem editada',
    'message:movetotrash' => "Mover para o lixo",
    'message:movetoinbox' => "Mover para a caixa de entrada",
    'message:markasread' => "Marcar como lida",
    'message:markasunread' => "Marcar como não lida",
    'messages:read:marked' => "Mensagens marcadas como lidas",
    'messages:unread:marked' => "Mensagens marcadas como não lidas",
    'messages:removed' => "Mensagens removidas",
    'messages:inbox:moved' => "Mensagens movidas para a caixa de entrada",
    'messages:error' => 'Ha um problema com a sua mensagem. Por favor, tente outra vez.',
    'messages:error:messages_not_selected' => 'Não há mensagens selecionadas',
    'messages:unreads' => '%s mensagens não lidas',

    // Error pages: empty folders
    'messages:inbox:none' => "Não há mensagens na caixa de entrada.",
    'messages:sent:none' => "Não há mensagens enviadas.",
    'messages:trash:none' => "Não há mensagens no lixo.",


    // Search
    'messages:search' => 'Pesquisar: %s',
    // Filter
    'messages:all' => 'Tudo',
    'messages:private_msg' => 'Mensagens privadas',
    'messages:my_activities' => 'As minhas atividades',
    // Reply
    'reply:edit' => "Editar resposta",
    'reply:create' => 'Criar resposta',
    'reply' => 'Responder',
    'reply:total' => '%s total de respostas',
    'reply:unreads' => '%s respostas por ler',
);

add_translation('pt', $portuguese);