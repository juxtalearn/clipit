<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/10/2014
 * Last update:     13/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
<div class="form-group">
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'title' => elgg_echo('remove'),
        'text' => '',
        'id'    => 'add-tricky-topic',
        'class' => 'fa fa-times red pull-left',
        'style' => 'margin-right: 10px;',
        'onclick' => '$(this).parent(\'.form-group\').remove()',
    ));
    ?>
    <?php echo elgg_view("input/text", array(
        'name' => 'tag[]',
        'value' => $vars['value'],
        'style' => 'width: 90%;',
        'class' => 'form-control input-tag',
        'required' => isset($vars['required']) ? $vars['required'] : true,
        'placeholder' => elgg_echo('tag')
    ));
    ?>
</div>