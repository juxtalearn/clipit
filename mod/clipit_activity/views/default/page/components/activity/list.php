<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 14/02/14
 * Time: 10:29
 * To change this template use File | Settings | File Templates.
 */
$items = $vars['items'];
$offset = elgg_extract('offset', $vars);
$limit = elgg_extract('limit', $vars);
$count = elgg_extract('count', $vars);
$base_url = elgg_extract('base_url', $vars, '');
$pagination = elgg_extract('pagination', $vars, true);
$progress_html = elgg_extract('progress_bar', $vars);
$user = elgg_get_logged_in_user_entity();
$list_class = 'elgg-list';
if (isset($vars['list_class'])) {
    $list_class = "$list_class {$vars['list_class']}";
}

if (is_array($items) && count($items) > 0) {
    $html .= "<ul class=\"$list_class\">";
    foreach ($items as $item) {
        if($item){
            $group_id = ClipitGroup::get_from_user_activity($user->guid, $item->id);
            $group_array = ClipitGroup::get_by_id(array($group_id));
            $group =  array_pop($group_array); // ClipitGroup object
            $all_groups = ClipitActivity::get_groups($item->id);
            $activity_count = count($all_groups); // Activity count

            $title = elgg_get_friendly_title($item->name);
            $activity_link = elgg_view('output/url', array(
                'href' => "clipit_activity/{$item->id}",
                'text' => $item->name,
                'is_trusted' => true,
            ));
            if($progress_html){
                $progress_html = "<li>{$progress_html}</li>";
            }
            $html .= "  <li>
                            <ul class='pull-right'>
                                {$progress_html}
                                <li><small>{$activity_count} Groups</small></li>
                            </ul>
                            <h3>{$activity_link}</h3>
                            <!--<div>STA's | Groups | Activity publications | Calendar</div>-->
                            <div>
                                {$group->name}
                            </div>
                        </li>";
        }
    }
    $html .= "</ul>";
}

// HTML content
echo $html;