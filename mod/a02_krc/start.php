<?php


function krc_init()
{
    include_once(elgg_get_plugins_path() . "a02_krc/lib/KnowledgeRepresentationComponent.php");
    elgg_register_page_handler('krc', 'krc_page_handler');
    elgg_register_admin_menu_item('configure', 'krc', 'settings');
    elgg_register_action('krc/modify', elgg_get_plugins_path() . "a02_krc/actions/modify.php");
    elgg_register_action('krc/test', elgg_get_plugins_path() . "a02_krc/actions/test.php");
    elgg_register_event_handler('update', 'object', 'update_quiz_listener');
}

function krc_shutdown()
{
    global $sesame_store;
    unset($sesame_store);
}


function update_quiz_listener($event, $object_type, $object)
{
    if ($object instanceof ElggEntity && $object->getSubtype() == ClipitQuizResult::SUBTYPE) {
        $user_id = elgg_get_logged_in_user_guid();
        $quizquestion = array_pop(ClipitQuizQuestion::get_by_id(array($object->quiz_question)));
        update_quizresult($object, $user_id);
    }

}

function krc_page_handler($page)
{
    $title = "KnowledgeRepresentation Administration";
    $params = array(
        'content' => elgg_view("krc/krc"),
        'title' => $title,
        'filter' => "",
        'class' => 'default'
    );
    $body = elgg_view_layout('one-column', $params);
    echo elgg_view_page($title, $body);
}

//Function to add a submenu to the admin panel.
function krc_pagesetup()
{
    global $CONFIG;
    if (elgg_is_admin_logged_in() && elgg_get_context('krc')) {
        elgg_register_menu_item('page', array(
            'name' => 'KRC',
            'href' => $CONFIG->wwwroot . 'krc',
            'text' => 'Knowledge Representation Component',
            'context' => 'krc'));
    }
}


function update_quizresult(ElggObject $quizresult, $user_id)
{

    $qresult = array_pop(ClipitQuizResult::get_by_id(array($quizresult->guid)));
    $user_profile = new UserProfile($user_id);
    $user_profile->update_from_quizresult($qresult);
}


elgg_register_event_handler('init', 'system', 'krc_init');
elgg_register_event_handler('pagesetup', 'system', 'krc_pagesetup');


register_shutdown_function('krc_shutdown');
elgg_set_config("la_krc_class", "KnowledgeRepresentationComponent");