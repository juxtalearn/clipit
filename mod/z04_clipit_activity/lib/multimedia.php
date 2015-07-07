<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/09/14
 * Last update:     8/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
function files_get_page_content_list($params = array()){
    $files = $params['files'];
    // Search items
    if($search_term = stripslashes(get_input("search"))){
        $items_search = array_keys(ClipitFile::get_from_search($search_term));
        $files = array_uintersect($items_search, $files, "strcasecmp");
    }
    elgg_extend_view("files/search", "search/search");
    $params['files'] = $files;

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
        $content .= elgg_view_form('multimedia/files/upload', array('id' => 'fileupload', 'enctype' => 'multipart/form-data'), array('entity' => $params['entity']));
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
function resources_get_page_content_list($params = array()){
    $resources = $params['entities'];
    // Search items
    if($search_term = stripslashes(get_input("search"))){
        $items_search = array_keys(ClipitResource::get_from_search($search_term));
        $resources = array_uintersect($items_search, $resources, "strcasecmp");
    }
    elgg_extend_view("resources/search", "search/search");
    $params['entities'] = $resources;

    $content = elgg_view('multimedia/resource/list', $params);
    if (!$resources) {
        $content .= elgg_view('output/empty', array('value' => elgg_echo('resources:none')));
    }
    return $content;
}
function storyboards_get_page_content_list($params = array()){
    $sbs = $params['entities'];
    // Search items
    if($search_term = stripslashes(get_input("search"))){
        $items_search = array_keys(ClipitStoryboard::get_from_search($search_term));
        $sbs = array_uintersect($items_search, $sbs, "strcasecmp");
    }
    elgg_extend_view("storyboards/search", "search/search");
    $params['entities'] = $sbs;

    $content = elgg_view('multimedia/storyboard/list', $params);
    if (!$sbs) {
        $content .= elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
    }
    return $content;
}
