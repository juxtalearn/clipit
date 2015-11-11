<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/06/14
 * Last update:     2/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activity = elgg_extract('activity', $vars);
$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($activity->tricky_topic)));

echo elgg_view("page/components/modal_remote", array('id'=> "tricky-topic-{$tricky_topic->id}" ));
echo elgg_view('output/url', array(
    'href'  => "ajax/view/modal/tricky_topic/view?id={$tricky_topic->id}",
    'text'  => $tricky_topic->name,
    'title' => $tricky_topic->name,
    'data-toggle'   => 'modal',
    'data-target'   => '#tricky-topic-'.$tricky_topic->id
));
