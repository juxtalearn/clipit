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
$title = elgg_echo("activity:stas");
elgg_push_breadcrumb($title);
$selected_tab = get_input('filter', 'files');
$href = "clipit_activity/{$activity->id}/resources";
$canCreate = false;
if($access == 'ACCESS_TEACHER' && $activity_status != 'closed'){
    $canCreate = true;
}
if(!$page[2]) {
    switch ($selected_tab) {
        case 'files':
            $files = ClipitActivity::get_files($activity->id);
            $params = array(
                'entity' => $activity,
                'create' => $canCreate,
                'entities' => $files,
                'href' => $href
            );
            $content = files_get_page_content_list($params);
            break;
        case 'videos':
            $videos = ClipitActivity::get_videos($activity->id);
            $params = array(
                'entity' => $activity,
                'create' => $canCreate,
                'actions' => true,
                'entities' => $videos,
                'href' => $href
            );
            $content = videos_get_page_content_list($params);
            break;

        default:
            return false;
            break;
    }
    $filter = elgg_view('multimedia/filter', array('tab_videos' => true, 'selected' => $selected_tab, 'entity' => $activity, 'href' => $href));
}
if($page[2] == 'download' && $page[3]){
    $file_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/file';
    set_input('id', $page[4]);
    include "$file_dir/download.php";
}
if($page[2] == 'view' && $page[3]){
    $entity_id = (int)$page[3];
    $multimedia_dir = elgg_get_plugins_path() . 'z04_clipit_activity/pages/multimedia';
    include "{$multimedia_dir}/view.php";
}
$params = array(
    'content'   => $content,
    'filter'    => $filter,
    'title'     => $title,
    'sub-title' => $activity->name,
    'title_style' => "background: #". $activity->color,
);