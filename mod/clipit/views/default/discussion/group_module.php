<?php
/**
 * Latest forum posts
 *
 * @uses $vars['entity']
 */

if ($vars['entity']->forum_enable == 'no') {
	return true;
}

$group = $vars['entity'];


$all_link = elgg_view('output/url', array(
	'href' => "discussion/owner/$group->guid",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$limit = 3;
$options = array(
	'type' => 'object',
	'subtype' => 'groupforumtopic',
	'container_guid' => $group->getGUID(),
	'limit' => $limit,
	'full_view' => false,
	'pagination' => false,
);
$content = elgg_list_entities($options);
elgg_pop_context();
$options_entity = array(
    'type' => 'object',
	'subtype' => 'groupforumtopic',
	'container_guid' => elgg_get_page_owner_guid(),
    'count' => true
);
$count_items = elgg_get_entities($options_entity);

if (!$content) {
	$content = '<p>' . elgg_echo('discussion:none') . '</p>';
}

$new_link = elgg_view('output/url', array(
	'href' => "discussion/add/" . $group->getGUID(),
	'text' => elgg_echo('groups:addtopic'),
	'is_trusted' => true,
));
if($count_items > $limit){
    $new_link .= elgg_view('output/url', array(
        'href' => "discussion/owner/$group->guid",
        'text' => elgg_echo('link:view:all'),
        'is_trusted' => true,
        'style'=>'float:right;'
    ));
}
echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('discussion:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));