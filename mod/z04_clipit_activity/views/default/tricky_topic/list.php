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
$tag_label = get_input('tag_label');
$tags = get_input('tags');
$input_name = 'tags_checked[]';
if($from_view = elgg_extract('tricky_topic', $vars)){
    $tricky_topic_id = $from_view;
    $show_tags = elgg_extract('show_tags', $vars);
    $tags = elgg_extract('tags', $vars);
    $tag_label = elgg_extract('tag_label', $vars);
    if(elgg_extract('input_name', $vars)){
        $input_name = elgg_extract('input_name', $vars);
    }
}

$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($tricky_topic_id)));
$multimedia = array_merge(
    $tricky_topic->video_array,
    $tricky_topic->file_array
);
$examples = ClipitExample::get_from_tricky_topic($tricky_topic->id);
$quizzes = ClipitQuiz::get_from_tricky_topic($tricky_topic->id);
?>
<?php if($show_tags == 'checkbox'):?>
    <?php if($tag_label):?>
        <label><?php echo $tag_label;?></label>
    <?php endif;?>
    <input type="checkbox" class="select-all-tags" >
    <small class="margin-left-5"><?php echo elgg_echo('check:all_none');?></small>
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
            'href'  => "tricky_topics/view/{$tricky_topic->id}",
            'target' => '_blank',
            'title' => $tricky_topic->name,
            'text'  => $tricky_topic->name,
        ));
        ?>
    </h4>
    <hr class="margin-0">
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
    <div class="row margin-top-10">
        <div class="col-md-6">
            <small class="show"><?php echo elgg_echo('education_level');?></small>
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input('tricky_topics', array('education_level'=>$tricky_topic->education_level)),
                'target' => '_blank',
                'title' => elgg_echo('education_level:'.$tricky_topic->education_level),
                'text'  => elgg_echo('education_level:'.$tricky_topic->education_level),
            ));
            ?>
        </div>
        <div class="col-md-6">
            <small class="show"><?php echo elgg_echo('tricky_topic:subject');?></small>
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input('tricky_topics', array('subject'=>$tricky_topic->subject)),
                'target' => '_blank',
                'title' => $tricky_topic->subject,
                'text'  => $tricky_topic->subject,
            ));
            ?>
        </div>
    </div>
    <hr>
    <div class="margin-top-20 row">
        <div class="col-md-6">
        <?php echo elgg_view('output/url', array(
            'href'  => "tricky_topics/view/{$tricky_topic->id}#examples",
            'target' => '_blank',
            'class' => 'margin-right-15',
            'title' => elgg_echo('examples'),
            'text'  =>  '<i class="fa fa-th-list"></i> '.elgg_echo('examples').' <strong>('.count($examples).')</strong>',
        ));
        ?>
        <?php
        $total_quizzes = 0;
            foreach($quizzes as $quiz){
                if($quiz->cloned_from == 0) {
                    $total_quizzes++;
                }
            }
        ?>
        <p class="margin-top-10">
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input('quizzes', array('tricky_topic'=>$tricky_topic->name)),
                'target' => '_blank',
                'title' => elgg_echo('quizzes'),
                'text'  =>  '<i class="fa fa-pencil-square-o"></i> '.elgg_echo('quizzes').' <strong>('.$total_quizzes.')</strong>',
            ));
            ?>
        </p>
        </div>
        <div class="col-md-6">
        <?php echo elgg_view('output/url', array(
            'href'  => "tricky_topics/view/{$tricky_topic->id}#resources",
            'target' => '_blank',
            'title' => elgg_echo('activity:stas'),
            'text'  =>  '<i class="fa fa-image"></i> '.elgg_echo('activity:stas').' <strong>('.count($multimedia).')</strong>',
        ));
        ?>
        </div>
    </div>
</div>
<?php endif;?>