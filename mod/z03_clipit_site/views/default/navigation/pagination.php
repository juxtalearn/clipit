<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/09/2014
 * Last update:     19/09/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$offset = abs((int) elgg_extract('offset', $vars, 0));
// because you can say $vars['limit'] = 0
$limit = (int)elgg_extract('limit', $vars, 10);
$count = (int) elgg_extract('count', $vars, 0);

$offset_key = elgg_extract('offset_key', $vars, 'offset');
// some views pass an empty string for base_url
if (isset($vars['base_url']) && $vars['base_url']) {
    $base_url = $vars['base_url'];
} else if (isset($vars['baseurl']) && $vars['baseurl']) {
    elgg_deprecated_notice("Use 'base_url' instead of 'baseurl' for the navigation/pagination view", 1.8);
    $base_url = $vars['baseurl'];
} else {
    $base_url = current_page_url();
}

$num_pages = elgg_extract('num_pages', $vars, 10);
$delta = ceil($num_pages / 2);

if ($count <= $limit && $offset == 0) {
    // no need for pagination
    return true;
}

$total_pages = ceil($count / $limit);
$current_page = ceil($offset / $limit) + 1;

$pages = new stdClass();
$pages->prev = array(
    'text' => elgg_echo('previous'),
    'href' => '',
    'is_trusted' => true,
);
$pages->next = array(
    'text' => elgg_echo('next'),
    'href' => '',
    'is_trusted' => true,
);
$pages->items = array();

// Add pages before the current page
if ($current_page > 1) {
    $prev_offset = $offset - $limit;
    if ($prev_offset < 0) {
        $prev_offset = 0;
    }

    $pages->prev['href'] = elgg_http_add_url_query_elements($base_url, array($offset_key => $prev_offset));

    $first_page = $current_page - $delta;
    if ($first_page < 1) {
        $first_page = 1;
    }

    $pages->items = range($first_page, $current_page - 1);
}


$pages->items[] = $current_page;


// add pages after the current one
if ($current_page < $total_pages) {
    $next_offset = $offset + $limit;
    if ($next_offset >= $count) {
        $next_offset--;
    }

    $pages->next['href'] = elgg_http_add_url_query_elements($base_url, array($offset_key => $next_offset));

    $last_page = $current_page + $delta;
    if ($last_page > $total_pages) {
        $last_page = $total_pages;
    }

    $pages->items = array_merge($pages->items, range($current_page + 1, $last_page));
}

echo '<div class="text-center">';
echo '<ul class="pagination">';
$start = false;
if($current_page > 1 && $total_pages > 1){
    $start = array(
        'text' => '<i class="fa fa-angle-double-left"></i>',
        'href' => elgg_http_add_url_query_elements($base_url, array($offset_key => 0)),
        'is_trusted' => true,
    );
    $link = elgg_view('output/url', $start);
    echo "<li>$link</li>";
}

if ($pages->prev['href']) {
    $link = elgg_view('output/url', $pages->prev);
    echo "<li class='hidden-xs'>$link</li>";
} else {
    echo "<li class=\"hidden-xs disabled\"><span>{$pages->prev['text']}</span></li>";
}

foreach ($pages->items as $page) {
    if ($page == $current_page) {
        echo "<li class=\"active\"><span>$page</span></li>";
    } else {
        $page_offset = (($page - 1) * $limit);
        $url = elgg_http_add_url_query_elements($base_url, array($offset_key => $page_offset));
        $link = elgg_view('output/url', array(
            'href' => $url,
            'text' => $page,
            'is_trusted' => true,
        ));
        echo "<li>$link</li>";
    }
}

if ($pages->next['href']) {
    $link = elgg_view('output/url', $pages->next);
    echo "<li class='hidden-xs'>$link</li>";
} else {
    echo "<li class=\"hidden-xs disabled\"><span>{$pages->next['text']}</span></li>";
}
$end = false;
if($current_page < $total_pages && $total_pages > 1){
    $end = array(
        'text' => '<i class="fa fa-angle-double-right"></i>',
        'href' => elgg_http_add_url_query_elements($base_url, array($offset_key => ($total_pages-1)*$limit)),
        'is_trusted' => true,
    );
    $link = elgg_view('output/url', $end);
    echo "<li>$link</li>";
}
echo '</ul>';
echo '</div>';