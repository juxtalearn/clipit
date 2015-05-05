<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/05/14
 * Last update:     28/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rating = elgg_extract('entity', $vars);
$group_id = elgg_extract('group_id', $vars);

$class = 'pull-right rating-resume';
if($vars['class']){
    $class = $vars['class'];
}
echo elgg_view("page/components/modal_remote", array('id'=> "rating-average-{$rating->id}" ));
echo elgg_view('output/url', array(
    'href'  => "ajax/view/modal/publications/rating?id={$rating->id}&group_id={$group_id}",
    'class' => 'btn btn-default btn-xs pull-right btn-border-yellow hidden-xs',
    'text'  => '<i class="fa fa-star"></i> '.elgg_echo("publications:rating"),
    'data-toggle'   => 'modal',
    'data-target'   => '#rating-average-'.$rating->id
));
?>