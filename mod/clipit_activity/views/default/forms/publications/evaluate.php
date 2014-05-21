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
$tags = $entity->tag_array;

$new_tag_rating_id = ClipitRating::create(array(
    'target'    => $entity->id,
    'overall_rating'    => 1, // Yes
));
// Tag rating create
//$tags_rating[] = ClipitTagRating::create(array(
//    'tag_id'    => 1003,
//    'is_used'   => 0,
//    'comment'   => '<p>&iquest;Qu&eacute; es esto?</p>'
//));
//$tags_rating[] = ClipitTagRating::create(array(
//    'tag_id'    => 1002,
//    'is_used'   => 0,
//    'comment'   => '<p>Est&aacute; muy mal explicado, joder que mal</p>'
//));
//$tags_rating[] = ClipitTagRating::create(array(
//    'tag_id'    => 1001,
//    'is_used'   => 1,
//    'comment'   => ''
//));
////ClipitRating::add_tag_ratings($new_tag_rating_id, $tags_rating);
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

//ClipitRating::add_performance_ratings($new_tag_rating_id, $performance_ratings);
//
print_r(ClipitRating::get_all());
?>
<style>
.input-radios-horizontal{
    margin-bottom: 0;
}
.fa-star.empty{
    color: #bae6f6;
}
#my-rating .rating .fa-star{
    cursor: pointer;
}
#my-rating .rating{
    width: auto !important;
}
</style>
<script>
$(function(){
    $('#my-rating .rating').raty({
        width: "",
        scoreName: "rating[]",
        starOff : 'fa-star fa empty',
        starOn  : 'fa-star fa',
        click: function(score, evt) {
            $(this).find("input").prop("required", true);
        }
    });
});
</script>
<div class="row">
    <div class="col-md-8">
        <label for="tricky-understand">
            Does this video help you to understand Tricky Topic?
        </label>
        <?php echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $entity->id,
        )); ?>
        <?php echo elgg_view('input/radio', array(
            'name' => 'tricky-understand',
            'options' => array(
                elgg_echo("input:yes") => 1,
                elgg_echo("input:no") => 0
            ),
            'required'  => true,
            'class' => 'input-radios-horizontal blue',
        )); ?>
        <span class="show" style="margin-bottom: 10px;">
            Check topics covered in this video, and explain why:
        </span>
        <?php
        foreach($tags as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
        ?>
            <div style="margin-top: 5px;">
                <?php echo elgg_view('input/radio', array(
                    'name' => "tag[{$tag->id}][check]",
                    'options' => array(
                        elgg_echo("input:yes") => 1,
                        elgg_echo("input:no") => 0
                    ),
                    'class' => 'input-radios-horizontal blue pull-right',
                )); ?>
                <label class="text-truncate" for="tag[<?php echo $tag->id; ?>][explain]">
                    <?php echo $tag->name; ?>
                </label>
                <?php echo elgg_view("input/plaintext", array(
                    'name'  => "tag[{$tag->id}][explain]",
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
        <div class="pull-right" id="my-rating">
            <h4>
                <strong>My rating</strong>
            </h4>
            <div style="margin: 10px 0;">
                <div class="rating" style="color: #e7d333;float: right;font-size: 18px;margin: 0 10px;"></div>
                <span class="text-truncate" style="padding-top: 2px;">Innovation</span>
            </div>
            <div style="margin: 10px 0;">
                <div class="rating" style="color: #e7d333;float: right;font-size: 18px;margin: 0 10px;"></div>
                <span class="text-truncate" style="padding-top: 2px;">Design</span>
            </div>
            <div style="margin: 10px 0;">
                <div class="rating" style="color: #e7d333;float: right;font-size: 18px;margin: 0 10px;"></div>
                <span class="text-truncate" style="padding-top: 2px;">Learning</span>
            </div>
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