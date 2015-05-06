<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rating = elgg_extract('rating', $vars);
$entity = elgg_extract('entity', $vars);
$entity_preview = elgg_extract('entity_preview', $vars);
$href = elgg_extract('href', $vars);
?>
<li class="row list-item">
    <div class="col-md-8">
        <small class="pull-right">
            <?php echo elgg_view('output/friendlytime', array('time' => $rating->time_created));?>
        </small>
        <label for="tricky-understand">
            <?php echo elgg_echo('publications:question:tricky_topic',array(''));?>
        </label>
        <p class="show blue">
            <strong>
                <?php
                if($rating->overall){
                    echo elgg_echo("input:yes");
                } else {
                    echo elgg_echo("input:no");
                }
                ?>
            </strong>
        </p>
        <?php
        $tag_ratings = $rating->tag_rating_array;
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
                    <span class="blue"><?php echo $is_used;?></span> <?php echo $tag->name;?>
                </label>
                <div><?php echo $tag_rating->description;?></div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="col-md-4">
        <div class="multimedia-preview image-block">
            <?php echo $entity_preview;?>
        </div>
        <div class="content-block">
            <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "{$href}/view/".$entity->id,
                    'title' => $entity->name,
                    'text'  => $entity->name));
                ?>
            </strong>
        </div>
        <div class="block-total">
            <hr class="margin-bottom-5 margin-top-10">
            <div>
                <ul>
                    <?php
                    $performance_ratings = $rating->performance_rating_array;
                    foreach($performance_ratings as $performance_rating_id):
                        $performance_rating = array_pop(ClipitPerformanceRating::get_by_id(array($performance_rating_id)));
                        $performance_item = array_pop(ClipitPerformanceItem::get_by_id(array($performance_rating->performance_item)));
                        ?>
                        <li class="list-item-5">
                            <div class="rating readonly pull-right" data-score="<?php echo $performance_rating->star_rating;?>" style="margin: 0 10px;">
                                <?php echo star_rating_view($performance_rating->star_rating);?>
                            </div>
                            <?php echo elgg_view('output/url', array(
                                'title' => $performance_item->name,
                                'href'  => "explore/search?by=performance_item&id=".$performance_item->id,
                                'text'  => $performance_item->name,
                            ));
                            ?>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>
</li>