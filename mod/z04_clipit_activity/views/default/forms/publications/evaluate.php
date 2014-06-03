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

$entity = elgg_extract("entity", $vars);
$activity = elgg_extract("activity", $vars);
$tags = $entity->tag_array;
$tricky_topic_view = elgg_view("tricky_topic/preview", array('activity' => $activity));
?>
<script>
$(function(){
    $('#my-rating .rating').raty({
        width: "",
        scoreName: function(){
            var performance_id = $(this).data("performance-id");
            var input = $(this).find("input");
            input.prop({"required": true, "type": "text"});
            return "performance_rating["+performance_id+"]";
        },
        starOff : 'fa-star fa empty',
        starOn  : 'fa-star fa',
        click: function(score, evt) {
            var input = $(this).find("input");
            input.removeClass("error");
            $("label[for='"+input.attr("name")+"'] > span").remove();
        }
    });
});
</script>
<div class="row">
    <div class="col-md-8">
        <label for="overall">
            <?php echo elgg_echo('publications:question:tricky_topic',array($tricky_topic_view));?>
        </label>
        <?php echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $entity->id,
        )); ?>
        <?php echo elgg_view('input/radio', array(
            'name' => 'overall',
            'options' => array(
                elgg_echo("input:yes") => 1,
                elgg_echo("input:no") => 0
            ),
            'required'  => true,
            'class' => 'input-radios-horizontal blue',
        )); ?>
        <span class="show" style="margin-bottom: 10px;">
            <?php echo elgg_echo('publications:question:if_covered');?>
        </span>
        <?php
        foreach($tags as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
        ?>
            <div style="margin-top: 5px;">
                <?php echo elgg_view('input/radio', array(
                    'name' => "tag_rating[{$tag->id}][is_used]",
                    'options' => array(
                        elgg_echo("input:yes") => 1,
                        elgg_echo("input:no") => 0
                    ),
                    'required'  => true,
                    'class' => 'input-radios-horizontal blue pull-right',
                )); ?>
                <label for="tag_rating[<?php echo $tag->id; ?>][is_used]">
                    <?php echo $tag->name; ?>
                </label>
                <?php echo elgg_view("input/plaintext", array(
                    'name'  => "tag_rating[{$tag->id}][comment]",
                    'class' => 'form-control',
                    'placeholder' => elgg_echo('publications:question:sb'),
                    'onclick'   => '$(this).addClass(\'mceEditor\');
                                    tinymce_setup();
                                    tinymce.execCommand(\'mceFocus\',false,this.id);',
                    'rows'  => 1,
                ));
                ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-md-4">
        <div id="my-rating">
            <h4>
                <strong><?php echo elgg_echo('publications:my_rating');?></strong>
            </h4>
            <ul>
                <?php
                $performance_items = $entity->performance_item_array;
                foreach($performance_items as $performance_item_id):
                    $performance_item = array_pop(ClipitPerformanceItem::get_by_id(array($performance_item_id)));
                ?>
                    <li class="list-item">
                        <div class="rating" data-performance-id="<?php echo $performance_item->id;?>" style="color: #e7d333;float: right;font-size: 18px;margin: 0 10px;"></div>
                        <label class="blue" for="performance_rating[<?php echo $performance_item->id;?>]" style="font-weight: normal;padding-top: 2px;margin: 0;"><?php echo $performance_item->name;?></label>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<div style="margin-top: 20px;">
<?php echo elgg_view('input/submit',
    array(
        'value' => elgg_echo('submit'),
        'class' => "btn btn-primary pull-right"
    ));
?>
</div>