<?php
/**
 * View a list of items
 *
 * @package Elgg
 *
 * @uses $vars['items']       Array of ElggEntity or ElggAnnotation objects
 * @uses $vars['offset']      Index of the first list item in complete list
 * @uses $vars['limit']       Number of items per page. Only used as input to pagination.
 * @uses $vars['count']       Number of items in the complete list
 * @uses $vars['base_url']    Base URL of list (optional)
 * @uses $vars['pagination']  Show pagination? (default: true)
 * @uses $vars['position']    Position of the pagination: before, after, or both
 * @uses $vars['full_view']   Show the full view of the items (default: false)
 * @uses $vars['list_class']  Additional CSS class for the <ul> element
 * @uses $vars['item_class']  Additional CSS class for the <li> elements
 */

$items = $vars['items'];
$offset = elgg_extract('offset', $vars);
$limit = elgg_extract('limit', $vars);
$count = elgg_extract('count', $vars);
$base_url = elgg_extract('base_url', $vars, '');
$pagination = elgg_extract('pagination', $vars, true);
$offset_key = elgg_extract('offset_key', $vars, 'offset');
$position = elgg_extract('position', $vars, 'after');

$list_class = 'elgg-list';
if (isset($vars['list_class'])) {
    $list_class = "$list_class {$vars['list_class']}";
}

$item_class = 'elgg-item';
if (isset($vars['item_class'])) {
    $item_class = "$item_class {$vars['item_class']}";
}

$html = "";
$nav = "";

if ($pagination && $count) {
    $nav .= elgg_view('navigation/pagination', array(
        'base_url' => $base_url,
        'offset' => $offset,
        'count' => $count,
        'limit' => $limit,
        'offset_key' => $offset_key,
    ));
}

if (is_array($items) && count($items) > 0) {
    $html .= '
    <div class="margin-bar"></div>
    <ul class="events">';
    foreach ($items as $item) {
        print_r($item);
        $li = elgg_view_list_item($item, $vars);
        if ($li) {
            if (elgg_instanceof($item)) {
                $id = "elgg-{$item->getType()}-{$item->getGUID()}";
            } else {
                $id = "item-{$item->getType()}-{$item->id}";
            }
            $html .= '
                <li class="event">
                    <div class="circle-activity" style="background: #f7931e;"></div>
                    <div class="event-details">
                        <a><i class="fa fa-comment" style="color: #f7931e;"></i> Your video has been commented</a>
                        <div class="recommended" style="overflow:hidden;border-radius: 3px; padding: 8px; margin-top: 10px;background: #f1f2f7;">
                            <div style="overflow:hidden;">
                                <img class="thumb-video" style="height: 55px;width: 70px;float: left;margin-right: 10px;" src="http://img.youtube.com/vi/bQVoAWSP7k4/2.jpg">
                                <div class="info_" style="overflow: hidden;  text-overflow: ellipsis;  white-space: nowrap;">
                                    <span class="title" style="color: #119BCD;font-size: 14px;">Lorem ipsum dolor sit amet consectetur</span>
                                    <span style="color: #119BCD;font-size: 11px;display:block;">Biology</span>
                                    <div style="font-size: 14px;color: #e7d333;">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-o"></i>
                                        <i class="fa fa-star-o"></i>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 5px;background: #FFF;padding: 5px;">
                                <div style="font-size: 14px;float:right;color: #e7d333;">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                                <span style="color: #119BCD;font-size: 11px;display:block;">Pepe Martinez Gonzalez</span>
                                <div style="font-size: 12px;margin-top: 5px;">Duis et ante turpis. Praesent risusligula, porta vitae hendrerit quis</div>
                            </div>
                        </div>
                        <small class="text-right event-date">12:00h, NOV 18, 2013</small>
                    </div>
                </li>';
            //$html .= "<li id=\"$id\" class=\"$item_class>$li</li>";
        }
    }
    $html .= '</div></ul>';
}

if ($position == 'before' || $position == 'both') {
    $html = $nav . $html;
}

if ($position == 'after' || $position == 'both') {
    $html .= $nav;
}

echo $html;
