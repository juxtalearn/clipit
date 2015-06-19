<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
elgg_load_js("jquery:raty");

$entity = elgg_extract("entity", $vars);
$rating = elgg_extract("rating", $vars);
$activity = elgg_extract("activity", $vars);
$tags = $entity->tag_array;
$rubrics = ClipitRubricItem::get_by_id($entity->rubric_item_array, 0, 0, 'time_created', false);
$tricky_topic_view = elgg_view("tricky_topic/preview", array('activity' => $activity));
if($rating){
    echo elgg_view("input/hidden", array(
        'name' => 'rating-id',
        'value' => $rating->id,
    ));
    $rating_tag = array();
    $rating_tags = ClipitTagRating::get_by_id($rating->tag_rating_array);
    foreach($rating_tags as $tag){
        $rating_tag[$tag->tag_id] = $tag;
    }
    $rating_rubric = array();
    $rating_rubrics = ClipitRubricRating::get_by_id($rating->rubric_rating_array);
    foreach($rating_rubrics as $rubric){
        $rating_rubric[$rubric->rubric_item] = $rubric;
    }
}
?>
<script>
$(function(){
    $(".enable-comment label").click(function(){
        var text = $(this).closest(".checking").find("textarea");
        if($(this).closest(".checking").find("iframe").length == 0){
            text.show().click();
        }
    });
    $('#evaluate a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        if(!$(this).closest("form").valid()){
            e.preventDefault();
        } else {
            return true;
        }
    });
    $(document).on('click', '.next_step', function(e){
        if(!$(this).closest("form").valid()){
            $( $(this).data('tabs') + '.nav-tabs a').unbind('click');
            return false;
        } else {
            $($(this).data('tabs') + '.nav-tabs > .active').next('li').find('a').trigger('click');
            return true;
        }
    });
    $(document).on('click', '.prev_step', function(e){
        $($(this).data('tabs') + '.nav-tabs > .active').prev('li').find('a').trigger('click');
    });
});
</script>
<!-- Evaluate -->
<?php if(!$rating):?>
    <h2 class="title-block"><?php echo elgg_echo('publications:evaluate');?></h2>
<?php endif;?>
<ul class="nav nav-tabs margin-bottom-20" role="tablist" id="evaluate">
    <li role="presentation" class="active">
        <a href="#stumbling_blocks" role="tab" data-toggle="tab"><?php echo elgg_echo('tags');?></a>
    </li>
    <?php if($rubrics):?>
        <li role="presentation">
            <a href="#rubrics" role="tab" data-toggle="tab"><?php echo elgg_echo('rubrics');?></a>
        </li>
    <?php endif;?>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="stumbling_blocks">
    <div class="col-md-12">
        <?php echo elgg_view('input/radio', array(
            'name' => 'overall',
            'options' => array(
                elgg_echo("input:yes") => 1,
                elgg_echo("input:no") => 0
            ),
            'value' => $rating ? ($rating->overall ? '1':'0'):'',
            'required'  => true,
            'class' => 'input-radios-horizontal blue pull-right',
        ));
        ?>
        <label for="overall content-block">
            <span class="text-muted">*</span> <?php echo elgg_echo('publications:question:tricky_topic',array($tricky_topic_view));?>
        </label>
        <?php echo elgg_view("input/hidden", array(
            'name' => 'entity-id',
            'value' => $entity->id,
        )); ?>
        <?php if($tags):?>
        <span class="show" style="margin-bottom: 10px;">
            <?php echo elgg_echo('publications:question:if_covered');?>
        </span>
    </div>
    <?php
    $i = 1;
    foreach($tags as $tag_id):
        $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
        if($rating) {
            echo elgg_view("input/hidden", array(
                'name' => "tag_rating[{$tag->id}][id]",
                'value' => $rating_tag[$tag->id]->id,
            ));
        }
        if($i%2 != 0){
            $view_tags_1 .= elgg_view('forms/publications/evaluate_stumbling_block', array(
                'tag' => $tag,
                'rating' => $rating,
                'rating_tag' => $rating_tag
            ));
        } else {
            $view_tags_2 .= elgg_view('forms/publications/evaluate_stumbling_block', array(
                'tag' => $tag,
                'rating' => $rating,
                'rating_tag' => $rating_tag
            ));
        }
    ?>
    <?php
        $i++;
    endforeach;
    ?>
    <div class="col-md-6"><?php echo $view_tags_1;?></div>
    <div class="col-md-6"><?php echo $view_tags_2;?></div>
    <?php endif;?>
    <div class="clearfix"></div>
    <span class="col-md-12 margin-top-15 text-muted">* <?php echo elgg_echo('field:required');?></span>
    <?php if(!$rating):?>
    <div class="clearfix"></div>
    <hr>
    <div class="col-md-12">
        <div class="text-right">
            <?php if($rubrics):?>
                <?php echo elgg_view('input/button',
                    array(
                        'value' => elgg_echo('next'),
                        'class' => "btn btn-primary next_step",
                        'data-tabs' => '#evaluate',
                        'style' => $rubrics ? '':'display:none'
                    ));
                ?>
            <?php else: ?>
                <?php echo elgg_view('input/submit',
                    array(
                        'value' => elgg_echo('submit'),
                        'class' => "btn btn-primary"
                    ));
                ?>
            <?php endif;?>
        </div>
    </div>
    <?php endif;?>
</div>
<?php if($rubrics):?>
<div id="rubrics" role="tabpanel" class="tab-pane">
    <div class="col-md-12">
        <?php echo elgg_view('rubric/items', array('entities' => $rubrics, 'rating' => true, 'rating_selected' => $rating_rubric));?>
    </div>
    <?php if(!$rating):?>
    <div class="clearfix"></div>
    <hr>
    <div class="col-md-12">
        <?php echo elgg_view('input/button',
            array(
                'value' => elgg_echo('prev'),
                'data-tabs' => '#evaluate',
                'class' => "btn btn-primary btn-border-blue prev_step"
            ));
        ?>
        <div class="pull-right">
            <?php echo elgg_view('input/submit',
                array(
                    'value' => elgg_echo('submit'),
                    'class' => "btn btn-primary"
                ));
            ?>
        </div>
    </div>
    <?php endif;?>
</div>
<?php endif;?>
</div>