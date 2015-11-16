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
$disabled = elgg_extract('disabled', $vars);
$options_list = array();

if(isset($vars['edit'])){
    $params = array('icon' => 'pencil');
    if(in_array('edit', $disabled)){
        $params = array(
            'icon' => 'ban',
            'item_class' => 'disabled',
            'attr' => array_merge($vars['edit'], array('href' => false, 'data-target' => false))
        );
    }
    $options_list[] = array_merge(array(
        'attr' => $vars['edit'],
        'text' => elgg_echo('edit'),
    ), $params);
}

if(isset($vars['remove'])){
    $vars['remove']['href'] =  elgg_add_action_tokens_to_url(elgg_normalize_url($vars['remove']['href']), true);
    $vars['remove']['class'] = "remove remove-object";
    $vars['id']['class'] = $entity->id;
    $params = array('icon' => 'trash-o');
    if(in_array('remove', $disabled)){
        $params = array(
            'icon' => 'ban',
            'item_class' => 'disabled',
            'attr' => array_merge($vars['remove'], array('href' => false, 'class' => 'remove'))
        );
    }
    $options_list[] = array_merge(array(
        'attr' => $vars['remove'],
        'text' => elgg_echo('remove'),
    ), $params);
}

if(isset($vars['clone'])){
    $vars['clone']['href'] =  elgg_add_action_tokens_to_url(elgg_normalize_url($vars['clone']['href']), true);
    $vars['id']['class'] = $entity->id;
    $options_list[] = array(
        'attr' => $vars['clone'],
        'text' => elgg_echo('duplicate'),
        'icon' => 'copy'
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