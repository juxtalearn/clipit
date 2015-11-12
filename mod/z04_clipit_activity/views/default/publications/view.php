<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract("entity", $vars);
$activity = elgg_extract("activity", $vars);
$group = elgg_extract("group", $vars);
$can_evaluate = elgg_extract("canEvaluate", $vars);
$feedback_task = elgg_extract("feedback_task", $vars);
$comments = elgg_extract("comments", $vars);
$user_loggedin_id = elgg_get_logged_in_user_guid();
$user_logged = array_pop(ClipitUser::get_by_id(array($user_loggedin_id)));

$tags = $entity->tag_array;
$total_evaluations = count(array_pop(ClipitRating::get_by_target(array($entity->id))));
$rubrics = get_rubric_items_from_resource($entity->id);
?>
<!-- Multimedia info + details -->
<div class="multimedia-owner multimedia-pub">
    <div class="block">
        <?php if($vars['title'] !== false):?>
            <div class="header">
                <?php if($vars['send_site']):?>
                    <div class="pull-right">
                    <?php if($entity::get_site($entity->id, true)):?>
                        <strong class="green">
                            <i class="fa fa-check "></i> <?php echo elgg_echo('published');?>
                        </strong>
                    <?php else:?>
                        <?php echo elgg_view("page/components/modal_remote", array('id'=> "publish-{$entity->id}" ));?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "ajax/view/modal/publications/publish?id={$entity->id}",
                            'class' => 'btn btn-xs btn-primary',
                            'text'  => '<i class="fa fa-globe"></i> '.elgg_echo('send:to_site'),
                            'data-toggle'   => 'modal',
                            'data-target' => '#publish-'.$entity->id,
                        ));
                        ?>
                    <?php endif;?>
                    </div>
                <?php endif;?>
                <h3 class="title"><?php echo $entity->name; ?></h3>
            </div>
        <?php endif;?>
        <div class="multimedia-body">
            <?php if($vars['admin_options'] !== false):?>
                <?php echo elgg_view('multimedia/admin_options', array('entity' => $entity));?>
            <?php endif;?>
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
                                <strong><?php echo elgg_echo('published:on');?></strong>
                                <?php echo htmlspecialchars(date(elgg_echo('friendlytime:date_format'), $entity->time_created));?>
                                (<?php echo elgg_view('output/friendlytime', array('time' => $entity->time_created));?>)
                            </small>
                        </div>
                        <?php if($vars['description'] !== false):?>
                            <?php echo $entity->description; ?>
                        <?php endif;?>
                    </div>
                    <h4><strong><?php echo elgg_echo("tags"); ?></strong></h4>
                    <?php
                    $i = 1;
                    $tag_average = ClipitTagRating::get_item_average_rating_for_target($entity->id);
                    $tags = ClipitTag::get_by_id($tags);
                    foreach($tags as $tag):
                        if($i%2 != 0){
                            $view_tags_1 .= elgg_view('tricky_topic/tags/rating', array(
                                'tag' => $tag,
                                'rating_tag' => $tag_average[$tag->id]
                            ));
                        } else {
                            $view_tags_2 .= elgg_view('tricky_topic/tags/rating', array(
                                'tag' => $tag,
                                'rating_tag' => $tag_average[$tag->id]
                            ));
                        }
                        $i++;
                    endforeach;
                    ?>
                    <div class="row">
                        <div class="col-md-6"><?php echo $view_tags_1;?></div>
                        <div class="col-md-6"><?php echo $view_tags_2;?></div>
                    </div>
                    <h4><strong><?php echo elgg_echo("labels"); ?></strong></h4>
                    <div class="margin-bottom-10">
                        <?php echo elgg_view('output/url', array(
                            'href'  => "javascript:;",
                            'title' => elgg_echo('add'),
                            'text'  => '<i class="fa fa-plus"></i>',
                            'class' => 'image-block',
                            'id'    => 'labels_view',
                        ));
                        ?>
                        <small class="blue content-block" id="label_list">
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
                            <?php if($rubrics):?>
                            <div class="pull-right readonly">
                                <div style="
background-color: #fafafa;
padding: 5px;
border-radius: 100px;
width: 70px;
height: 70px;
line-height: 60px;
text-align: center;
margin-top: -10px;
">
                                    <span style="color: rgb(50, 180, 229); font-weight: bold; font-size: 27px; font-family: FuturaBoldRegular, Impact, 'Impact Bold', Helvetica, Arial, sans, sans-serif; display: inline;">
                                        <?php echo rubric_rating_value($entity->rubric_rating_average);?>
                                    </span>

                                </div>
                            </div>
                            <?php endif;?>
                            <h4 class="inline-block">
                                <strong><?php echo elgg_echo('publications:rating');?></strong>
                                <small style="margin-top: 5px;" class="show">
                                    <?php echo $total_evaluations; ?>
                                    <?php echo elgg_echo('publications:rating:votes');?>
                                </small>
                            </h4>
                            <div class="clearfix"></div>
                            <ul>
                            <?php
                            if($rubrics):
                            $rubric_items_average = ClipitRubricRating::get_item_average_rating_for_target($entity->id);
                            foreach($rubrics as $rubric):
                            ?>
                                <li class="list-item-5">
                                    <strong class="pull-right blue">
                                        <?php echo $rubric_items_average[$rubric->id]? floor($rubric_items_average[$rubric->id]*100)/10: '-';?>
                                    </strong>
                                    <span>
                                        <?php echo $rubric->name;?>
                                    </span>
                                </li>
                            <?php
                            endforeach;
                                endif;
                            ?>
                            </ul>
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
                                <?php
                                if($me_rating_entity = ClipitRating::get_user_rating_for_target($user_loggedin_id, $entity->id)):
                                    $can_evaluate_edit = ($feedback_task && ClipitTask::get_status($feedback_task) == ClipitTask::STATUS_ACTIVE) ? true:false;
                                    ?>
                                    <li class="list-item my-evaluation">
                                        <?php if($can_evaluate_edit):?>
                                            <?php
                                            $modal = elgg_view("page/components/modal",
                                                array(
                                                    "dialog_class"     => "modal-lg",
                                                    "target"    => "edit-feedback",
                                                    "title"     => elgg_echo("publications:rating:edit"),
                                                    "form"      => true,
                                                    "body"      => elgg_view("forms/publications/evaluate",
                                                        array(
                                                            'entity' => $entity,
                                                            'activity' => $activity,
                                                            'rating' => $me_rating_entity
                                                        )),
                                                    "cancel_button" => true,
                                                    "ok_button" => elgg_view('input/submit',
                                                        array(
                                                            'value' => elgg_echo('save'),
                                                            'class' => "btn btn-primary"
                                                        ))
                                                ));

                                            ?>
                                            <?php echo elgg_view_form('', array(
                                                    'action' => 'action/publications/evaluate',
                                                    'data-validate'=> "true",
                                                    'body' => $modal,
                                                    'enctype' => 'multipart/form-data'
                                                )
                                            );
                                            ?>
                                        <?php endif;?>
                                        <div class="content-block">
                                            <div class="pull-right">
                                                <?php if($can_evaluate_edit):?>
                                                    <?php echo elgg_view('output/url', array(
                                                        'text'  => elgg_echo("edit"),
                                                        'class' => 'btn btn-default btn-xs',
                                                        'data-toggle'   => 'modal',
                                                        'data-target'   => '#edit-feedback'
                                                    ));
                                                    ?>
                                                <?php endif;?>
                                                <?php echo elgg_view("page/components/modal_remote", array('id'=> "rating-average-{$me_rating_entity->id}" ));?>
                                                <?php echo elgg_view('output/url', array(
                                                    'href'  => "ajax/view/modal/publications/rating?id={$me_rating_entity->id}",
                                                    'text'  => elgg_echo("view"),
                                                    'class' => 'btn btn-default btn-xs btn-border-blue',
                                                    'data-toggle'   => 'modal',
                                                    'data-target'   => '#rating-average-'.$me_rating_entity->id
                                                ));
                                                ?>
                                            </div>
                                            <h4><strong><?php echo elgg_echo('publications:rating:my_evaluation');?></strong></h4>
<!--                                                --><?php //echo elgg_view("performance_items/summary", array('entity' => $me_rating_entity, 'user_rating' => true)); ?>
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
<?php if($can_evaluate):?>
    <a name="evaluate"></a>
    <?php echo elgg_view_form("publications/evaluate",
        array('data-validate' => 'true', 'style' => 'margin-bottom: 80px'),
        array('entity' => $entity, 'activity' => $activity));
    ?>
<?php endif; ?>

<?php
if($comments):
    $total_comments = array_pop(ClipitComment::count_by_destination(array($entity->id), false));
    ?>
    <a name="comments"></a>
    <h3 class="activity-module-title"><?php echo elgg_echo("comments"); ?> <span class="blue-lighter">(<?php echo $total_comments;?>)</span></h3>
    <?php
    foreach($comments as $comment){
        echo elgg_view("comments/comment",
            array(
                'user' => $user_logged,
                'entity' => $comment,
                'target_id' => $entity->id,
                'activity_id' => $activity->id
            ));
    }
endif;
?>
<?php echo clipit_get_pagination(array('count' => $total_comments)); ?>
<?php if($activity->status != ClipitActivity::STATUS_CLOSED && !$can_evaluate):?>
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
<?php endif;?>