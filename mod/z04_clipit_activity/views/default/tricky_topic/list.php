<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tricky_topic_id = get_input('tricky_topic');
$show_tags = get_input('show_tags');
$tags = get_input('tags');
$input_name = 'tags_checked[]';
if($from_view = elgg_extract('tricky_topic', $vars)){
    $tricky_topic_id = $from_view;
    $show_tags = elgg_extract('show_tags', $vars);
    $tags = elgg_extract('tags', $vars);
    $input_name = elgg_extract('input_name', $vars);
}

$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($tricky_topic_id)));
?>
<?php if($show_tags == 'checkbox'):?>
    <input type="checkbox" class="select-all-tags" >
    <small class="margin-left-5">Select Stumbling blocks</small>
    <hr class="margin-0 margin-bottom-10">
    <div class="tags-list" style="overflow-y: auto;max-height: 150px;">
        <?php
        foreach(ClipitTrickyTopic::get_tags($tricky_topic_id) as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
            $checked = false;
            if(array_search($tag_id, (array)$tags) !== false){
                $checked = 'checked';
            }
        ?>
            <label style="font-weight: normal;">
                <input type="checkbox" <?php echo $checked;?> name="<?php echo $input_name;?>" value="<?php echo $tag->id;?>" class="pull-left" style="margin-right: 10px;">
                <span class="overflow-hidden"><?php echo $tag->name;?></span>
            </label>
            <div class="clearfix"></div>
        <?php endforeach;?>
    </div>
<?php elseif($show_tags == 'list'):?>
<div class="col-md-12" style="padding:5px;">
    <h4>
        <?php echo elgg_view('output/url', array(
            'href'  => "explore/search?by=tricky_topic&id={$tricky_topic->id}",
            'target' => '_blank',
            'title' => $tricky_topic->name,
            'text'  => $tricky_topic->name,
        ));
        ?>
    </h4>
    <hr class="margin-0">
    <small class="show margin-top-5"><?php echo elgg_echo("tags");?></small>
    <div style="max-height: 150px;overflow-y: auto;">
        <?php
        foreach($tricky_topic->tag_array as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
            ?>
            <div class="col-md-6 text-truncate" style="padding:5px;">
                <?php echo elgg_view('output/url', array(
                    'href'  => "explore/search?by=tag&id={$tag->id}",
                    'target' => '_blank',
                    'title' => $tag->name,
                    'text'  => $tag->name,
                ));
                ?>
            </div>
        <?php endforeach;?>
    </div>
</div>
<?php endif;?>