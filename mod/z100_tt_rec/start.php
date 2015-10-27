<?php
/**
 * Learning Analytics - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 *
 * @author          RIAS JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */


elgg_register_event_handler('init', 'system', 'tt_rec_init');


function tt_rec_init()
{
    elgg_register_page_handler('tt_importer', 'tt_importer_pagehandler');
    elgg_register_page_handler('ttrec', 'tt_rec_pagehandler');
    elgg_register_ajax_view('recommendation/tricky_topic');
    #elgg_register_ajax_view('recommendation/input');
    elgg_register_ajax_view('recommendation/createOntologyEntry');
    elgg_register_ajax_view('navigation/menu/recommendation');

    elgg_extend_view('authoring_tools/sidebar/menu','navigation/menu/recommendation',300);

    elgg_register_css('recommendationscss', "/mod/z100_tt_rec/views/default/css/recommendations.css", 1000);
    elgg_load_css("recommendationscss");

    elgg_register_event_handler('create',ClipitTrickyTopic::SUBTYPE.'-'.ClipitTag::SUBTYPE,'tricky_topic_create_handler');
}


function tricky_topic_create_handler($event, $object_type, $object){
    error_log("Was anderes:<$event><$object_type> " .print_r($object,true));
    $trickytopic = array_pop(ClipitTrickyTopic::get_by_id(array($object->guid_one)));

    $sb = array_pop(ClipitTag::get_by_id(array($object->guid_two)));
    error_log("TT: ". print_r($trickytopic,true)); //immer leer??
    error_log("SB: ".print_r($sb,true));
}

function tt_importer_pagehandler($page) {
    include_once(elgg_get_plugins_path() . 'z100_tt_rec/views/default/recommendation/createOntologyEntry.php');
}


function tt_rec_pagehandler($page){

    gatekeeper();
    elgg_set_context('recommendation');
    $user_id = elgg_get_logged_in_user_guid();
    $user = array_pop(ClipitUser::get_by_id(array($user_id)));
    $title = elgg_echo('Tricky Topic Recommendation');
    $content = elgg_view('recommendation/tricky_topic',array('user'=>$user, 'user_id' =>$user_id));

    # include input
    elgg_extend_view('recommendation/tricky_topic', 'recommendation/input');


    $params = array(
        'content' => $content,
        'title' => $title,
       # 'sidebar' => $search_menu,
    );

    $body = elgg_view_layout('one_sidebar', $params);


    echo elgg_view_page($title, $body);
    return true;




}




