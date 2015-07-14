<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/10/2014
 * Last update:     01/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$group = elgg_extract('entity', $vars);
$activity = array_pop(ClipitActivity::get_by_id(array($group->activity)));
$tags = ClipitTrickyTopic::get_tags($activity->tricky_topic);
$tags = ClipitTag::get_by_id($tags, 0, 0, 'name');
$group_tags = ClipitTag::get_by_id($group->tag_array, 0, 0, 'name');
?>
<style>
    .selected{
        /*background: #C5C5C5 !important;*/
        color: #999;
        /*border: 0;*/
    }
</style>
<script>
    $(function(){
        $(document).on("click", ".assign-sb-group:not(.disabled)", function(){
            var list = $(this).closest(".tags-list").find(".assigned-list");
            var tag = $(this).data("tag");
            $(this).addClass("selected").appendTo(list);
            $(this).find("input[type=hidden]").remove();
            $(this).append('<input type="hidden" name="tag[]" value="'+tag+'" />');
        });
        $(document).on("click", ".assign-sb-group.selected", function(){
            var list = $(this).closest(".tags-list").find(".not-assigned-list");
            $(this).removeClass("selected").appendTo(list);
            $(this).find("input[type=hidden]").remove();
        });
    });
</script>
<?php
echo elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $group->id,
));
?>
<div class="row tags-list">
    <div class="col-md-6">
        <h3 class="title-block margin-top-0"><?php echo elgg_echo('unselected');?></h3>
        <ul class="not-assigned-list" style="min-height: 50px;">
        <?php
        foreach($tags as $tag):
            if(!in_array($tag->id, $group->tag_array)):
                ?>
                <li class="assign-sb-group list-item-5 blue cursor-pointer" data-tag="<?php echo $tag->id;?>" style="padding-left:5px;;">
                    <?php echo $tag->name;?>
                </li>
            <?php endif;?>
        <?php endforeach;?>
        </ul>
    </div>
    <div class="col-md-6">
        <h3 class="title-block margin-top-0"><?php echo elgg_echo('selected');?></h3>
        <ul class="assigned-list" style="min-height: 50px;">
            <?php foreach($group_tags as $tag):?>
                <li class="assign-sb-group list-item-5 selected blue" data-tag="<?php echo $tag->id;?>" style="padding-left:5px;;">
                    <?php echo $tag->name;?>
                    <?php echo elgg_view('input/hidden', array(
                        'name' => 'tag[]',
                        'value' => $tag->id
                    )); ?>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>