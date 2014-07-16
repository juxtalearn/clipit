<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/07/14
 * Last update:     16/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$group = elgg_extract('entity', $vars);

echo elgg_view("page/components/modal_remote", array('id'=> "group-{$group->id}" ));
echo elgg_view('output/url', array(
    'href'  => "ajax/view/modal/group/view?id={$group->id}",
    'text'  => '<i class="fa fa-users"></i> '.$group->name,
    'title' => $group->name,
    'class' => 'label label-blue '.$vars['class'],
    'data-toggle'   => 'modal',
    'data-target'   => '#group-'.$group->id
));