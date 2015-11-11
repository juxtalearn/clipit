<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/09/14
 * Last update:     8/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
function files_get_page_content_list($params = array()){
    $files = $params['entities'];
    // Search items
    if($search_term = stripslashes(get_input("search"))){
        $items_search = array_keys(ClipitFile::get_from_search($search_term));
        $files = array_uintersect($items_search, $files, "strcasecmp");
    }
    elgg_extend_view("files/search", "search/search");
    $params['entities'] = $files;

    $content = elgg_view("files/search");
    $list_options = array();
    // File options
    if(!empty($files)) {
        $list_options['options_values'] = array(
            '' => elgg_echo('bulk_actions'),
            'remove' => elgg_echo('file:delete'),
        );
    }
    if($params['create']) {
        $content .= elgg_view_form('multimedia/files/upload', array(
            'action' => 'action/multimedia/files/save',
            'id' => 'fileupload',
            'enctype' => 'multipart/form-data',
            'data-validate' => 'true'
        ), array('entity' => $params['entity']));
    }
    $content .= elgg_view_form("multimedia/files/set_options",
        array('body' => elgg_view('multimedia/file/list', $params), 'class' => 'files-table'));
    if (!$files) {
        $content .= elgg_view('output/empty', array('value' => elgg_echo('file:none')));
    }
    return $content;
}

function videos_get_page_content_list($params = array()){
    $videos = $params['entities'];
    // Search items
    if($search_term = stripslashes(get_input("search"))){
        $items_search = array_keys(ClipitVideo::get_from_search($search_term));
        $videos = array_uintersect($items_search, $videos, "strcasecmp");
    }
    elgg_extend_view("videos/search", "search/search");
    $params['entities'] = $videos;

    $content = elgg_view('multimedia/video/list', $params);
    if (!$videos) {
        $content .= elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
    }
    return $content;
}

function texts_get_page_content_list($params = array()){
    $texts = $params['entities'];
    // Search items
    if($search_term = stripslashes(get_input("search"))){
        $items_search = array_keys(ClipitText::get_from_search($search_term));
        $texts = array_uintersect($items_search, $texts, "strcasecmp");
    }
    elgg_extend_view("texts/search", "search/search");
    $params['entities'] = $texts;

    $content = elgg_view('multimedia/text/list', $params);
    if (!$texts) {
        $content .= elgg_view('output/empty', array('value' => elgg_echo('texts:none')));
    }
    return $content;
}

