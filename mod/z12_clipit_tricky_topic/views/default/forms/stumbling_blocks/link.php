<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/12/2014
 * Last update:     01/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$owner_tts = array_pop(ClipitTrickyTopic::get_by_owner(array(elgg_get_logged_in_user_guid())));
$options = array('' => elgg_echo('tricky_topic:select'));
if(is_array($owner_tts)) {
    foreach ($owner_tts as $tricky_topic) {
        $options[$tricky_topic->id] = $tricky_topic->name;
    }
}
echo elgg_view('input/hidden', array(
    'class' => 'input-entity-id',
    'name' => 'entity-id'
));
echo elgg_view("input/dropdown", array(
    'name' => 'tricky_topic',
    'aria-label' => 'tricky_topic',
    'style' => 'padding:5px;',
    'selected' => true,
    'class' => 'form-control margin-bottom-10',
    'options_values' => $options
));
echo '<div class="pull-right">';
echo elgg_view('output/url', array(
    'href'  => "javascript:;",
    'onclick' => '$(this).closest(\'td\').find(\'.link-tricky-topic\').click()',
    'class' => 'btn btn-xs btn-primary btn-border-blue margin-right-10',
    'text'  => elgg_echo('cancel'),
));
echo elgg_view('input/submit', array(
    'class' => 'btn btn-xs btn-primary',
    'value' => elgg_echo('send')
));
echo '</div>';