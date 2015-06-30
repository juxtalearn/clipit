<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/05/14
 * Last update:     21/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$user = array_pop(ClipitUser::get_by_id(array($entity->owner_id)));

$tag_ratings = $entity->tag_rating_array;
$rubric_ratings = ClipitRubricRating::get_by_id($entity->rubric_rating_array);
$overall_rating = elgg_echo("input:no");
if($entity->overall){
    $overall_rating = elgg_echo("input:yes");
}
?>
<div class="row">
    <div class="col-md-12">
        <div>
            <ul class="margin-top-10">
                <?php
                foreach($rubric_ratings as $rubric_rating):
                    $rubric_item = array_pop(ClipitRubricItem::get_by_id(array($rubric_rating->rubric_item)));
                    ?>
                    <li class="list-item-5">
                        <div data-toggle="popover"
                             data-trigger="hover"
                             data-placement="bottom"
                             data-content="<?php echo $rubric_item->level_array[ ($rubric_rating->level) - 1];?>">
                            <strong class="pull-right blue">
                                <?php echo $rubric_rating->score ? floor($rubric_rating->score * 100)/10 : '-';?>
                            </strong>
                        <span>
                            <?php echo $rubric_item->name;?>
                        </span>
                        </div>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <hr>
    </div>
    <div class="col-md-12">
        <label for="tricky-understand">
            <?php echo elgg_echo('publications:question:tricky_topic',array(''));?>
        </label>
        <p class="show blue">
            <strong><?php echo $overall_rating;?></strong>
        </p>
        <?php
        foreach($tag_ratings as $tag_rating_id):
            $tag_rating = array_pop(ClipitTagRating::get_by_id(array($tag_rating_id)));
            $tag = array_pop(ClipitTag::get_by_id(array($tag_rating->tag_id)));
            $is_used = "<i class='fa fa-times red'></i>";
            if($tag_rating->is_used){
                $is_used = "<i class='fa fa-check green'></i>";
            }
        ?>
            <div style="margin-top: 5px;">
                <label class="text-truncate">
                    <span class="blue">
                        <?php echo $is_used;?>
                    </span>
                    <?php echo $tag->name;?>
                </label>
                <div><?php echo $tag_rating->description;?></div>
            </div>
        <?php endforeach;?>
    </div>
</div>
