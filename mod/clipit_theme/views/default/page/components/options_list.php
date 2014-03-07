<?php
/**
 * Created by PhpStorm.
 * User: equipo
 * Date: 3/03/14
 * Time: 15:31
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
// Config icon -> left position
/*$options = array(
    'style' => 'float:left;margin-right:10px;',
    'button' => '<button data-toggle="dropdown" class="btn-options btn btn-xs"><i class="fa fa-cog"></i> <b class="caret"></b></button>',
    'options' => $options_list,
);*/
$options = array(
    'style' => 'float:right;margin-right:10px;',
    'button' => '<button data-toggle="dropdown" class="btn-options btn btn-xs"><b>'.elgg_echo("options").'</b> <b class="caret"></b></button>',
    'options' => $options_list,
);

echo elgg_view("page/components/dropdown", $options);