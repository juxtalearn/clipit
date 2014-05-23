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
$tags = $entity->tag_array;
//$t =  array(
//    '1003' => array('is_used' => 0, 'comment' => 'blabla'),
//    '1005' => array('is_used' => 1, 'comment' => 'mmmm')
//);
//$ts = array('tag_rating'=> $t);
//print_r($ts);
//foreach($ts['tag_rating'] as $id => $tvalue){
//    echo $id." = ".$tvalue['comment']." \n";
//}
//$new_tag_rating_id = ClipitRating::create(array(
//    'target'    => $entity->id,
//    'overall_rating'    => 1, // Yes
//));
//// Tag rating create
//$tags_rating[] = ClipitTagRating::create(array(
//    'tag_id'    => 1003,
//    'is_used'   => 0,
//    'description'   => '<p>&iquest;Qu&eacute; es esto?</p>'
//));
//$tags_rating[] = ClipitTagRating::create(array(
//    'tag_id'    => 1002,
//    'is_used'   => 0,
//    'description'   => '<p>Est&aacute; muy mal explicado, joder que mal</p>'
//));
//$tags_rating[] = ClipitTagRating::create(array(
//    'tag_id'    => 1001,
//    'is_used'   => 1,
//    'description'   => ''
//));
//ClipitRating::add_tag_ratings($new_tag_rating_id, $tags_rating);
//
//$performance_ratings[] = ClipitPerformanceRating::create(array(
//    'performance_item' => 1036,
//    'star_rating'   => 1
//));
//$performance_ratings[] = ClipitPerformanceRating::create(array(
//    'performance_item' => 1037,
//    'star_rating'   => 3
//));
//$performance_ratings[] = ClipitPerformanceRating::create(array(
//    'performance_item' => 1038,
//    'star_rating'   => 5
//));
//
//ClipitRating::add_performance_ratings($new_tag_rating_id, $performance_ratings);
//
//print_r(ClipitRating::get_all());
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
            Does this video help you to understand Tricky Topic?
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
            Check if each topic was covered in this video, and explain why:
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
                    'placeholder' => 'Why is/isn\'t this SB correctly covered?',
                    'onclick'   => '$(this).addClass(\'mceEditor\');tinymce_setup();',
                    'rows'  => 1,
                ));
                ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="col-md-4">
        <div id="my-rating">
            <h4>
                <strong>My rating</strong>
            </h4>
            <ul>
            <?php
            $performance_items = $entity->performance_array;
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
        'class' => "btn btn-primary"
    ));
?>
</div>