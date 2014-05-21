<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/05/14
 * Last update:     16/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract("entity", $vars);
$type = elgg_extract("type", $vars);

echo elgg_view("page/components/modal_remote", array('id'=> "publish-{$type}-{$entity->id}" ));
echo elgg_view('output/url', array(
    'href'  => "ajax/view/modal/multimedia/{$type}/publish?id={$entity->id}",
    'title' => elgg_echo('publish'),
    'data-target' => "#publish-{$type}-{$entity->id}",
    'data-toggle'=> 'modal',
    'style' => 'padding: 1px 5px;  background: #47a447;color: #fff;font-weight: bold;',
    'class' => 'btn-xs btn pull-right',
    'text'  => '<i class="fa fa-arrow-circle-up"></i> Publish'));
