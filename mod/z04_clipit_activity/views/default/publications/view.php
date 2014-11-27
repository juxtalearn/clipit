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
$group = elgg_extract("group", $vars);
$comments = elgg_extract("comments", $vars);
$user_loggedin_id = elgg_get_logged_in_user_guid();
$user_logged = array_pop(ClipitUser::get_by_id(array($user_loggedin_id)));

$tags = $entity->tag_array;
$performance_average = ClipitPerformanceRating::get_average_target_rating($entity->id);
$total_evaluations = count(array_pop(ClipitRating::get_by_target(array($entity->id))));
?>
<!-- Multimedia info + details -->
<div class="multimedia-owner multimedia-pub">
    <div class="block">
        <?php if($vars['title'] !== false):?>
            <div class="header">
                <h3 class="title"><?php echo $entity->name; ?></h3>
            </div>
        <?php endif;?>
        <div class="multimedia-body">
            <?php echo elgg_view('multimedia/admin_options', array('entity' => $entity));?>
            <div class="multimedia-view">
                <?php echo $vars['body'];?>
            </div>
            <div class="row details">
                <div class="col-md-<?php echo ($vars['rating']!== false) ? 8 : 12; ?>">
                    <div class="description" data-shorten="true">
                        <div class="margin-bottom-10">
                            <?php if($group):?>
                                <div class="pull-right">
                                    <?php echo elgg_view("publications/owner_summary", array(
                                        'entity' => $entity,
                                    )); ?>
                                </div>
                            <?php endif;?>
                            <small class="show">
                                <strong>Published on</strong> <?php echo htmlspecialchars(date(elgg_echo('friendlytime:date_format'), $entity->time_created));?>
                                (<?php echo elgg_view('output/friendlytime', array('time' => $entity->time_created));?>)
                            </small>
                        </div>
                        <?php if($vars['description'] !== false):?>
                            <?php echo $entity->description; ?>
                        <?php endif;?>
                    </div>
                    <h4><strong><?php echo elgg_echo("tags"); ?></strong></h4>
                    <div class="tags">
                        <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tags)); ?>
                    </div>
                    <h4><strong><?php echo elgg_echo("labels"); ?></strong></h4>
                    <div class="margin-bottom-10">
                        <?php echo elgg_view('output/url', array(
                            'href'  => "javascript:;",
                            'text'  => '<i class="fa fa-plus"></i>',
                            'class' => 'image-block',
                            'id'    => 'labels_view',
                        ));
                        ?>
                        <small class="blue text-truncate content-block" id="label_list">
                            <?php echo elgg_view("publications/labels/view", array('labels' => $entity->label_array)); ?>
                        </small>
                    </div>
                    <?php echo elgg_view_form("publications/labels/add",
                        array(
                            'body' => elgg_view("publications/labels/add", array('entity_id' => $entity->id)),
                            'id' => 'add_labels',
                            'style' => 'display:none;background: #fafafa;padding: 10px;margin-top: 10px;',
                        )
                        );
                    ?>
                </div>
                <?php if($vars['rating']!== false): ?>
                <!-- Star rating -->
                <div class="col-md-4">
                    <div>
                        <div class="pull-right rating rating-resume readonly" data-score="<?php echo $performance_average;?>">
                            <?php echo star_rating_view($performance_average);?>
                        </div>
                        <h4 style=" display: inline-block; margin-top: 0;">
                            <strong><?php echo elgg_echo('publications:rating');?></strong>
                            <small style="margin-top: 5px;" class="show">
                                <?php echo $total_evaluations; ?>
                                <?php echo elgg_echo('publications:rating:votes');?>
                            </small>
                        </h4>
                        <?php
                        $performance_items = $entity->performance_item_array;
                        foreach($performance_items as $performance_item_id):
                            $performance_item = array_pop(ClipitPerformanceItem::get_by_id(array($performance_item_id)));
                            $average_for_item = ClipitPerformanceRating::get_average_item_rating_for_target($performance_item_id, $entity->id);
                        ?>
                            <div style="border-bottom: 1px solid #bae6f6;">
                                <div class="pull-right rating readonly" style="margin-right: 10px;margin-top: -3px;" data-score="<?php echo $average_for_item;?>">
                                    <?php echo star_rating_view($average_for_item); ?>
                                </div>
                                <h5 class="text-truncate blue" style="margin: 5px 0;">
                                    <?php echo elgg_view('output/url', array(
                                        'title' => $performance_item->name,
                                        'href'  => "explore/search?by=performance_item&id=".$performance_item->id,
                                        'text'  => $performance_item->name,
                                    ));
                                    ?>
                                </h5>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if($total_evaluations > 0): ?>
                    <ul class="evaluations">
                        <li class="list-item">
                            <?php
                            echo elgg_view("page/components/modal_remote", array('id'=> "rating-list-{$entity->id}" ));
                            echo elgg_view('output/url', array(
                                'href'  => "ajax/view/modal/publications/rating?by_target={$entity->id}&activiy_id={$activity->id}",
                                'text'  => elgg_echo("view"),
                                'class' => 'btn btn-xs btn-default pull-right btn-border-blue',
                                'data-toggle'   => 'modal',
                                'data-target'   => '#rating-list-'.$entity->id
                            ));
                            ?>
                            <h4><strong><?php echo elgg_echo('publications:rating:list');?></strong></h4>
                        </li>
                        <?php if($me_rating_entity = ClipitRating::get_from_user_for_target($user_loggedin_id, $entity->id)): ?>
                        <li class="list-item my-evaluation">
                            <div class="content-block">
                                <?php echo elgg_view("page/components/modal_remote", array('id'=> "rating-average-{$me_rating_entity->id}" ));?>
                                <?php echo elgg_view('output/url', array(
                                    'href'  => "ajax/view/modal/publications/rating?id={$me_rating_entity->id}",
                                    'text'  => elgg_echo("view"),
                                    'class' => 'btn btn-default btn-xs pull-right',
                                    'data-toggle'   => 'modal',
                                    'data-target'   => '#rating-average-'.$me_rating_entity->id
                                ));
                                ?>
                                <h4><strong><?php echo elgg_echo('publications:rating:my_evaluation');?></strong></h4>
                                <?php echo elgg_view("performance_items/summary", array('entity' => $me_rating_entity, 'user_rating' => true)); ?>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <?php endif;?>
                </div>
                <!-- Star rating end -->
                <?php endif; // rating = true ?>
            </div>
        </div>
    </div>
</div>
<!-- Multimedia info + details end -->
<?php if($vars['canEvaluate']):?>
    <?php echo elgg_view_form("publications/evaluate", array('data-validate' => 'true', 'style' => 'margin-bottom: 80px'),
        array('entity' => $entity, 'activity' => $activity));
    ?>
<?php endif; ?>

<?php
if($comments):
    $total_comments = array_pop(ClipitComment::count_by_destination(array($entity->id), true));
?>
    <a name="comments"></a>
    <h3 class="activity-module-title"><?php echo elgg_echo("comments"); ?> <span class="blue-lighter">(<?php echo $total_comments;?>)</span></h3>
    <?php
    foreach($comments as $comment){
        echo elgg_view("comments/comment",
            array(
                'entity' => $comment,
                'target_id' => $entity->id,
                'activity_id' => $activity->id
            ));
    }
endif;
?>
<?php echo clipit_get_pagination(array('count' => $total_comments)); ?>
<!-- Comment form -->
<a name="create_reply"></a>
<h3 class="activity-module-title"><?php echo elgg_echo("comment:create"); ?></h3>
<div class="discussion discussion-reply-msg">
    <div class="user-reply">
        <?php echo elgg_view('output/img', array(
            'src' => get_avatar($user_logged, 'small'),
            'class' => 'user-avatar avatar-small'
        ));?>
    </div>
    <div class="block">
        <?php echo elgg_view_form("comments/create", array('data-validate'=> "true", 'class'=>'fileupload' ), array('entity'  => $entity)); ?>
    </div>
</div>
<!-- Comment form end-->