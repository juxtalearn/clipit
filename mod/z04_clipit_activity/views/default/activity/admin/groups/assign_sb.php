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
$group_tags = $group->tag_array;
?>
<style>
    .btn-border-blue.selected{
        background: #C5C5C5 !important;
        color: #fff;
        border: 0;
    }
    .assign-sb-group{
        margin: 5px;
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
<div class="tags-list">
    <h4>Selected</h4>
    <div class="assigned-list" style="min-height: 50px;">
        <?php
        foreach($group_tags as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
            ?>
            <a class="assign-sb-group btn btn-border-blue selected" data-tag="<?php echo $tag->id;?>">
                <?php echo $tag->name;?>
                <?php echo elgg_view('input/hidden', array(
                    'name' => 'tag[]',
                    'value' => $tag->id
                )); ?>
            </a>
        <?php endforeach;?>
    </div>
    <hr>
    <h4>Not Selected</h4>
    <div class="not-assigned-list" style="min-height: 50px;">
        <?php
        foreach($tags as $tag_id):
            if(!in_array($tag_id, $group_tags)):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
        ?>
            <a class="assign-sb-group btn btn-border-blue" data-tag="<?php echo $tag->id;?>">
                <?php echo $tag->name;?>
            </a>
            <?php endif;?>
        <?php endforeach;?>
    </div>
</div>