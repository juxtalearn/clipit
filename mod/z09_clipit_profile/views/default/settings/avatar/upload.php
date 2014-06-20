<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/06/14
 * Last update:     20/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);

$current_label = elgg_echo('avatar:current');

$remove_button = '';
if ($vars['entity']->icontime) {
    $remove_button = elgg_view('output/url', array(
        'text' => elgg_echo('remove'),
        'title' => elgg_echo('avatar:remove'),
        'href' => 'action/avatar/remove?guid=' . elgg_get_page_owner_guid(),
        'is_action' => true,
        'class' => 'elgg-button elgg-button-cancel mll',
    ));
}

$form_params = array('enctype' => 'multipart/form-data');
?>
<div class="image-block">
    <?php echo elgg_view('output/img', array(
            'src' => $entity->getIconUrl('medium'),
            'alt' => elgg_echo('avatar'),
        ));
    ?>
</div>
<div class="content-block">
    <?php echo elgg_view_form('settings/upload', $form_params, $vars);?>
</div>