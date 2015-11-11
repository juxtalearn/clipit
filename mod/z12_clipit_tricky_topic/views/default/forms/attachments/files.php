<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/02/2015
 * Last update:     18/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity_id = elgg_extract('entity_id', $vars);
if($entity_id){
    echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $entity_id
    ));
}
?>
<!-- Add files -->
<div class="group-input margin-top-10">
    <div class="margin-bottom-20 clone-input">
        <a href="javascript:;" class="fa fa-trash-o red margin-right-10 remove-input" style="visibility: hidden;"></a>
        <?php echo elgg_view("input/file", array(
            'name' => 'file[]',
            'style' => 'display: inline-block;'
        ));
        ?>
        <i class="fa fa-check green correct" style="display: none;"></i>
    </div>
</div>
<div class="margin-left-20">
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'class' => 'btn btn-sm btn-border-blue add-input btn-primary',
        'title' => elgg_echo('add'),
        'text'  => '<i class="fa fa-plus"></i> ' . elgg_echo('add'),
    ));
    ?>
    <?php if($vars['submit']):?>
        <?php echo elgg_view('input/submit', array(
            'href'  => "javascript:;",
            'class' => 'btn-primary btn btn-sm margin-left-20',
            'title' => elgg_echo('send'),
            'text'  => elgg_echo('send'),
        ));
        ?>
    <?php endif;?>
</div>
<!-- Add files end -->