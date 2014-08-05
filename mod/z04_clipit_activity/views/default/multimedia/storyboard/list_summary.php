<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   4/07/14
 * Last update:     4/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$storyboard_ids = elgg_extract('entities', $vars);
$href = elgg_extract("href", $vars);
$rating = elgg_extract("rating", $vars);
?>
<ul>
    <?php
    foreach($storyboard_ids as $storyboard_id):
        $storyboard = array_pop(ClipitStoryboard::get_by_id(array($storyboard_id)));
        $file = array_pop(ClipitFile::get_by_id(array($storyboard->file)));
        $tags = ClipitStoryboard::get_tags($storyboard->id);
        $description = trim(elgg_strip_tags($storyboard->description));
        // Description truncate max length 280
        if(mb_strlen($description)>280){
            $description = substr($description, 0, 280)."...";
        }
        $published = false;
        ?>
        <li class="row list-item">
            <div class="col-md-1 text-right">
                <a href="<?php echo elgg_get_site_url()."{$href}/view/{$storyboard->id}"; ?>">
                    <div class="multimedia-preview">
                        <?php echo elgg_view('output/url', array(
                            'href'  => "{$href}/view/".$storyboard->id,
                            'title' => $storyboard->name,
                            'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))));
                        ?>
                    </div>
                </a>
            </div>
            <div class="col-md-11">
                <?php echo elgg_view("publications/owner_summary", array(
                    'entity' => $storyboard,
                    'class' => 'pull-right',
                    'entity_class' => 'ClipitStoryboard',
                    'msg' => 'Uploaded by'
                )); ?>
                <h4 class="text-truncate margin-0">
                    <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/view/".$storyboard->id,
                        'title' => $storyboard->name,
                        'text'  => $storyboard->name));
                    ?>
                    </strong>
                </h4>
                <?php
                if($rating):
                    $rating_average = ClipitPerformanceRating::get_average_target_rating($storyboard->id);
                    ?>
                    <div class="pull-right rating ratings readonly" data-score="<?php echo $rating_average;?>">
                        <?php echo star_rating_view($rating_average);?>
                    </div>
                <?php endif; ?>
                <div class="tags">
                    <?php echo elgg_view("tricky_topic/tags/view", array('tags' => $tags)); ?>
                </div>
                <small class="show" style="margin: 0">
                    <?php
                    $total_comments = array_pop(ClipitComment::count_by_destination(array($storyboard->id), true));
                    ?>
                    <!-- Count total comments -->
                    <strong>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "{$href}/view/{$storyboard->id}#comments",
                            'title' => elgg_echo('comments'),
                            'class' => 'pull-right btn btn-xs btn-xs-5 btn-blue-lighter',
                            'text'  => $total_comments. ' <i class="fa fa-comments"></i>'))
                        ?>
                    </strong>
                    <!-- Count total comments end-->
                    <i>
                        <?php echo elgg_view('output/friendlytime', array('time' => $storyboard->time_created));?>
                    </i>
                </small>
            </div>
        </li>
    <?php endforeach;?>
</ul>