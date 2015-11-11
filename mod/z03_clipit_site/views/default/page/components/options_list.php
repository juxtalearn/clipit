<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$options_list = array();
if(isset($vars['edit'])){
    $options_list[] = array(
        'attr' => $vars['edit'],
        'text' => elgg_echo('edit'),
        'icon' => 'pencil'
    );
}
if(isset($vars['remove'])){
    $vars['remove']['href'] =  elgg_add_action_tokens_to_url(elgg_normalize_url($vars['remove']['href']), true);
    $vars['remove']['class'] = "remove remove-object";
    $vars['id']['class'] = $entity->id;
    $options_list[] = array(
        'attr' => $vars['remove'],
        'text' => elgg_echo('remove'),
        'icon' => 'trash-o',
    );
}

$options = array(
    'style' => 'float:right;',
    'button' => '<button data-toggle="dropdown" class="btn-options btn btn-xs">
                    <span class="visible-xs visible-sm"><i class="fa fa-cog"></i> <b class="caret"></b></span>
                    <span class="hidden-xs hidden-sm"><b>'.elgg_echo("options").'</b> <b class="caret"></b></span>
                </button>',
    'options' => $options_list,
);

echo elgg_view("page/components/dropdown", $options);