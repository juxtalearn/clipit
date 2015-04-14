<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rubric = elgg_extract('entity', $vars);
$language_index = ClipitPerformanceItem::get_language_index(get_current_language());
$user = array_pop(ClipitUser::get_by_id(array($quiz->owner_id)));
$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($quiz->tricky_topic)));
?>
<script>
$(function() {

});
</script>
<div class="pull-right">
    <div class="inline-block">
        <?php echo elgg_view('page/components/admin_options', array(
            'entity' => $rubric,
            'user' => $user,
        ));
        ?>
    </div>
    <span class="margin-left-10">
        <?php echo elgg_view("page/components/print_button");?>
    </span>
</div>
<div role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <?php foreach(performance_items_available_languages($rubric->item_name) as $i => $language):?>
            <li role="presentation" class="<?php echo $language_index == $i ? 'active':'';?>">
                <a href="#<?php echo $i;?>" aria-controls="<?php echo $i;?>" role="tab" data-toggle="tab"><?php echo $language;?></a>
            </li>
        <?php endforeach;?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <?php foreach(performance_items_available_languages($rubric->item_name) as $i => $language):?>
        <div role="tabpanel" class="row tab-pane <?php echo $language_index == $i ? 'active':'';?>" id="<?php echo $i;?>" style="padding: 20px;">
            <div class="col-md-7">
                <strong><?php echo $rubric->item_name[$i]; ?></strong>
                <?php if ($rubric->item_description[$i]): ?>
                    <p class="text-muted"><?php echo $rubric->item_description[$i]; ?></p>
                <?php endif; ?>
                <?php if ($rubric->example[$i]): ?>
                    <strong><?php echo elgg_echo('performance_item:example'); ?></strong>
                    <p class="text-muted"><?php echo $rubric->example[$i]; ?></p>
                <?php endif; ?>
            </div>
            <div class="col-md-5">
                <h4 class="margin-0 margin-bottom-15"><?php echo elgg_echo('category');?></h4>
                <strong><?php echo $rubric->category[$i]; ?></strong>
                <?php if ($rubric->category_description[$i]): ?>
                    <p class="text-muted"><?php echo $rubric->category_description[$i]; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach;?>
    </div>

</div>
