<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/10/2014
 * Last update:     16/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
echo elgg_view("page/components/title_block", array(
    'title' => 'Performance items'
));
?>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?php echo elgg_view("input/text", array(
                'name' => 'activity-end',
                'class' => 'form-control',
                'required' => true,
            ));
            ?>
            <hr class="margin-0 margin-top-10 margin-bottom-10">
            <small class="show margin-top-5">Performance</small>
        </div>
        <?php for($i=0;$i<6;$i++):?>
        <div class="col-md-12 form-group">
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'title' => elgg_echo('remove'),
                'text' => '',
                'class' => 'fa fa-times red pull-left',
                'style' => 'margin-right: 10px;',
                'onclick' => '$(this).parent(\'.form-group\').remove()',
            ));
            ?>
            <div style="width: 90%;background: #fafafa;padding: 5px;" class="pull-left">
                <?php echo elgg_view("input/text", array(
                    'name' => 'tag[]',
                    'value' => $entity->name,
                    'class' => 'form-control input-tag margin-bottom-5',
                    'required' => true,
                    'placeholder' => elgg_echo('tag')
                ));
                ?>
                <strong>
                    <a>+ Description</a>
                </strong>
            </div>
        </div>
        <?php endfor;?>
    </div>
</div>
