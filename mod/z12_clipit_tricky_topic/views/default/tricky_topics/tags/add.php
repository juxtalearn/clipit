<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/10/2014
 * Last update:     13/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<div class="form-group">
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'title' => elgg_echo('remove'),
        'text' => '',
        'class' => 'fa fa-times red pull-right',
        'style' => 'margin-right: 10px;margin-top: 10px;',
        'onclick' => '$(this).parent(\'.form-group\').remove()',
        'aria-label' => elgg_echo('delete'),
    ));
    ?>
    <?php echo elgg_view("input/text", array(
        'name' => 'tag[]',
        'value' => $vars['value'],
        'style' => 'width: 90%;',
        'class' => 'form-control input-tag',
        'required' => isset($vars['required']) ? $vars['required'] : true,
        'placeholder' => elgg_echo('tag'),
        'aria-label' => elgg_echo('tag'),
    ));
    ?>
</div>