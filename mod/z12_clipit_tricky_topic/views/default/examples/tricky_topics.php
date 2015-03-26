<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/12/2014
 * Last update:     18/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$selected = elgg_extract('selected', $vars);
$tags = elgg_extract('tags', $vars);

$tricky_topics = ClipitTrickyTopic::get_all();
$owner_tt = array();
foreach($tricky_topics as $tricky_topic){
    $tt[$tricky_topic->id] = $tricky_topic->name;
    if($tricky_topic->owner_id == elgg_get_logged_in_user_guid()){
        $owner_tt[$tricky_topic->id] = $tricky_topic->name;
    }
}
$tt = array_diff($tt, $owner_tt);
?>
<script>
$(function(){
    $(document).on('click', '.select-all-tags', function(){
        var container = $(this).parent('div');
        var isChecked = $(this).prop('checked');
        container.find('input[type=checkbox]').prop('checked', isChecked);
    });
    $('.trick-topic-tags-check').on('change', '#tricky-topic', function(){
        var container = $(this).closest('.trick-topic-tags-check'),
            content = container.find('.tags-list'),
            tags = container.data('tags'),
            more_tags = $(this).closest('.trick-topic-tags-check').find('.add-more-tags');

        if($(this).val() == 0){
            content.hide();
            more_tags.hide();
            return false;
        }
        more_tags.show();
        content.show().html('<i class="fa fa-spinner fa-spin blue"></i>');
        elgg.post("ajax/view/tricky_topic/list",{
            data: {
                'tricky_topic' : $(this).val(),
                'show_tags': 'checkbox',
                'tag_label' : '<?php echo elgg_echo('tags');?>',
                'tags': tags
            },
            success: function(html){
                content.html(html);
            }
        });
    });
});
</script>
<div style="background: #fafafa;padding: 10px;" class="trick-topic-tags-check" data-tags="<?php echo json_encode($tags);?>">
    <div class="form-group">
        <label for="tricky-topic"><?php echo elgg_echo("activity:select:tricky_topic");?></label>
        <select <?php echo $vars['required']!==false ?'required':'';?> id="tricky-topic" class="form-control" name="tricky-topic" style="padding-top: 5px;padding-bottom: 5px;">
            <option value="">
                <?php echo elgg_echo('tricky_topic:select');?>
            </option>
            <?php if(count($owner_tt)>0):?>
                <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_me');?>">
                    <?php foreach($owner_tt as $value => $name):?>
                        <option <?php echo $selected == $value ? 'selected' : '';?> value="<?php echo $value;?>">
                            <?php echo $name;?>
                        </option>
                    <?php endforeach;?>
                </optgroup>
            <?php endif;?>
            <?php if(count($tt)>0):?>
                <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_others');?>">
                    <?php foreach($tt as $value => $name):?>
                        <option <?php echo $selected == $value ? 'selected' : '';?> value="<?php echo $value;?>">
                            <?php echo $name;?>
                        </option>
                    <?php endforeach;?>
                </optgroup>
            <?php endif;?>
        </select>
    </div>
    <div style="display: <?php echo $selected ? 'block' : 'none'?>;" class="tags-list">
        <?php if($selected):?>
            <?php echo elgg_view('tricky_topic/list', array(
                'tricky_topic' => $selected,
                'tags' => $tags,
                'tag_label' => elgg_echo('tags'),
                'show_tags' => 'checkbox',
            ));
            ?>
        <?php endif;?>
    </div>
    <div class="form-group margin-top-10 add-more-tags" style="display: <?php echo $selected ? 'block' : 'none'?>;">
        <small class="show">
            <?php echo elgg_echo('add:more');?>
        </small>
        <div class="form-add-tags form-group margin-top-10">
            <?php if($tags_diff):?>
                <?php foreach(ClipitTag::get_by_id($tags_diff) as $tag):?>
                    <?php echo elgg_view("tricky_topics/tags/add", array('value' => $tag->name));?>
                <?php endforeach;?>
            <?php else: ?>
                <?php echo elgg_view("tricky_topics/tags/add", array('required' => false));?>
            <?php endif;?>
        </div>
        <?php echo elgg_view('output/url', array(
            'href'  => "javascript:;",
            'class' => 'btn btn-xs btn-primary',
            'title' => elgg_echo('add'),
            'text'  => '<i class="fa fa-plus"></i> ' . elgg_echo('add'),
            'id'    => 'add-tag',
        ));
        ?>
    </div>
</div>