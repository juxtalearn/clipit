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
$performance_items = $entity->performance_item_array;
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
    $rating_performance = array();
    $rating_performances = ClipitPerformanceRating::get_by_id($rating->performance_rating_array);
    foreach($rating_performances as $performance_item){
        $rating_performance[$performance_item->performance_item] = $performance_item;
    }
}
?>
<script>
    $(function(){
        $('#my-rating .rating').raty({
            width: "",
            scoreName: function(){
                var performance_id = $(this).data("performance-id");
                return "performance_rating["+performance_id+"][star]";
            },
            score: function() {
                return $(this).data('score');
            },
            starOff : 'fa-star fa empty',
            starOn  : 'fa-star fa',
            click: function(score, evt) {
                var input = $(this).find("input");
                input.removeClass("error");
                $("label[for='"+input.attr("name")+"'] > span").remove();
            }
        });
        $(".enable-comment label").click(function(){
            var text = $(this).closest(".checking").find("textarea");
            if($(this).closest(".checking").find("iframe").length == 0){
                text.show().click();
            }
        });
        $('#my-rating .rating').each(function(){
            var input = $(this).find("input");
            input.attr({"required": true, 'data-msg-required': '*'}).addClass('hidden-validate');
        });
    });
</script>
<!-- Evaluate -->
<?php if(!$rating):?>
    <h2 class="title-block"><?php echo elgg_echo('publications:evaluate');?></h2>
<?php endif;?>
<div class="row" <?php echo !$rating ? 'style="background: #f1f2f7;padding: 20px;margin: 10px 0;"':'';?>>
    <div class="col-md-8">
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
        <?php
        foreach($tags as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
            if($rating) {
                echo elgg_view("input/hidden", array(
                    'name' => "tag_rating[{$tag->id}][id]",
                    'value' => $rating_tag[$tag->id]->id,
                ));
            }
        ?>
            <div style="margin-top: 5px;" class="checking">
                <?php echo elgg_view('input/radio', array(
                    'name' => "tag_rating[{$tag->id}][is_used]",
                    'options' => array(
                        elgg_echo("input:yes") => 1,
                        elgg_echo("input:no") => 0
                    ),
                    'required' => true,
                    'value' => $rating ? ($rating_tag[$tag->id]->is_used ? '1':'0'):'',
                    'class' => 'input-radios-horizontal enable-comment blue pull-right',
                )); ?>
                <label for="tag_rating[<?php echo $tag->id; ?>][is_used]">
                    <?php echo $tag->name; ?>
                </label>
                <?php echo elgg_view("input/plaintext", array(
                    'name'  => "tag_rating[{$tag->id}][comment]",
                    'class' => 'form-control '.($rating ? 'mceEditor':''),
                    'style' => $rating?'':'display:none;',
                    'placeholder' => elgg_echo('publications:question:sb'),
                    'onclick'   => !$rating ? '$(this).addClass(\'mceEditor\');
                                    clipit.tinymce();
                                    tinymce.execCommand(\'mceFocus\',false,this.id);': '',
                    'value' => $rating_tag[$tag->id]->description,
                    'rows'  => 1,
                ));
                ?>
            </div>
        <?php endforeach; ?>
        <?php endif;?>
    </div>
    <div class="col-md-4">
        <?php if($performance_items):?>
        <div id="my-rating">
            <h4 class="margin-0">
                <span class="text-muted">*</span> <strong><?php echo elgg_echo('publications:my_rating');?></strong>
            </h4>
            <div class="margin-bottom-5 margin-top-5">
                <small><?php echo elgg_echo('publications:rating:stars');?>:</small>
            </div>
            <ul>
                <?php
                foreach($performance_items as $performance_item_id):
                    $performance_item = array_pop(ClipitPerformanceItem::get_by_id(array($performance_item_id)));
                    if($rating) {
                        echo elgg_view("input/hidden", array(
                            'name' => "performance_rating[{$performance_item->id}][id]",
                            'value' => $rating_performance[$performance_item_id]->id,
                        ));
                    }
                    ?>
                    <li class="list-item-5">
                        <div class="rating"
                             <?php echo $rating ? 'data-score="'.$rating_performance[$performance_item_id]->star_rating.'"':'';?>
                             data-performance-id="<?php echo $performance_item->id;?>"
                             style="color: #e7d333;float: right;font-size: 18px;margin: 0 10px;">
                             </div>
                        <label class="blue" for="performance_rating[<?php echo $performance_item->id;?>][star]" style="font-weight: normal;padding-top: 2px;margin: 0;">
                            <?php echo $performance_item->name; ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif;?>
    </div>
    <div class="clearfix"></div>
    <div class="margin-top-20 col-md-12 text-right">
        <span class="pull-left margin-top-5 text-muted">* <?php echo elgg_echo('field:required');?></span>
        <?php if(!$rating):?>
            <?php echo elgg_view('input/submit',
                array(
                    'value' => elgg_echo('submit'),
                    'class' => "btn btn-primary pull-right"
                ));
            ?>
        <?php endif;?>
    </div>
</div>
