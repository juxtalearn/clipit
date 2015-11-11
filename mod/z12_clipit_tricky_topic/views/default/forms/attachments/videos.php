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
<ul class="group-input margin-top-10">
    <li class="margin-bottom-20 clone-input list-item">
        <div id="panel_1" class="panel-group">
            <a href="javascript:;" class="fa fa-trash-o red margin-right-10 remove-input image-block"  style="visibility: hidden;"></a>
            <div class="content-block panel" style="box-shadow: none;background: none;">
                <div class="form-group margin-top-5">
                    <?php echo elgg_view("input/text", array(
                        'name' => 'video_title[]',
                        'class' => 'form-control',
                        'placeholder' => elgg_echo('video:title'),
                        'required' => true
                    ));
                    ?>
                </div>
                <a data-parent="#panel_1" class="btn-sm btn btn-primary btn-border-blue margin-right-10" data-toggle="collapse" href="#collapse_1" aria-expanded="false">
                    <?php echo elgg_echo('video:add:to_youtube');?>
                </a>
                <a data-parent="#panel_1" class="btn-sm btn btn-primary btn-border-blue margin-right-10" data-toggle="collapse" href="#collapse_2" aria-expanded="false">
                    <?php echo elgg_echo('video:add:paste_url');?>
                </a>
                <div class="collapse margin-top-10" id="collapse_1" style="padding: 10px 0;">
                    <?php echo elgg_view("input/file", array(
                        'name' => 'video[]',
                        'style' => 'display: inline-block;'
                    ));
                    ?>
                    <i class="fa fa-check green correct" style="display: none;"></i>
                </div>
                <div class="collapse margin-top-10" id="collapse_2" style="padding: 10px 0;">
                    <?php echo elgg_view("input/text", array(
                        'name' => 'video_url[]',
                        'class' => 'form-control',
                        'placeholder' => elgg_echo('video:link:youtube_vimeo'),
                    ));
                    ?>
                </div>
            </div>
        </div>
    </li>
</ul>
<div class="margin-left-20">
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'class' => 'btn btn-sm btn-border-blue add-input collapse-type btn-primary',
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
