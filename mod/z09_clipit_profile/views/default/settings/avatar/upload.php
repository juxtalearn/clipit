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

if ($entity->avatar_file) {
    $remove_button = elgg_view('output/url', array(
        'text' => elgg_echo('remove'),
        'title' => elgg_echo('avatar:remove'),
        'href' => 'action/settings/avatar/remove?guid=' . elgg_get_page_owner_guid(),
        'is_action' => true,
        'aria-label' => elgg_echo('delete'),
        'class' => 'show btn btn-danger margin-top-10',
    ));
}

$form_params = array('enctype' => 'multipart/form-data', 'data-validate'=> "true");
?>
<div class="image-block text-center">
    <?php echo elgg_view('output/img', array(
            'src' => get_avatar($entity),
            'alt' => elgg_echo('avatar'),
        ));
    ?>
    <?php echo $remove_button;;?>
</div>
<div class="content-block">
    <?php echo elgg_view_form('settings/avatar/upload', $form_params, $vars);?>
</div>