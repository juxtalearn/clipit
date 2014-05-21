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
$user_loggedin = elgg_get_logged_in_user_guid();
$user_loggedin_elgg = new ElggUser($user_loggedin);
$tags = ClipitVideo::get_tags($entity->id);
?>

<!-- Multimedia info + details -->
<div class="multimedia-owner multimedia-pub">
    <div class="block">
        <div class="header">
            <h2 class="title"><?php echo $entity->name; ?></h2>
        </div>
        <div class="multimedia-body">
            <div class="multimedia-view">
                <?php echo $vars['body'];?>
            </div>
            <div class="row details">
                <div class="col-md-8">
                    <h4><strong>Tags</strong></h4>
                    <div class="tags">
                        <?php echo elgg_view("page/elements/tags", array('tags' => $tags)); ?>
                    </div>
                    <h4><strong>Description</strong></h4>
                    <div class="description">
                        <?php echo $entity->description; ?>
                    </div>
                </div>
                <!-- Star rating -->
                <div class="col-md-4">
                    <div>
                        <div class="rating" style="
    color: #e7d333;
    float: right;
    border-radius: 3px;
    background: #fafafa;
    padding: 5px 10px;
    font-size: 18px;
">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <h4 style=" display: inline-block; margin-top: 0;">
                            <strong>Rating</strong>
                            <small style="margin-top: 5px;" class="show">3/5 (4 VOTES)</small>
                        </h4>
                        <div>
                            <div class="rating" style="color: #e7d333;float: right;font-size: 18px;margin-right: 10px;">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                                <i class="fa fa-star" style="
    color: #bae6f6;
"></i>
                            </div>
                            <h4 class="text-truncate">Innovation</h4>
                        </div>
                        <div>
                            <div class="rating" style="color: #e7d333;float: right;font-size: 18px;margin-right: 10px;">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </div>
                            <h4 class="text-truncate">Design</h4>
                        </div>
                        <div>
                            <div class="rating" style="color: #e7d333;float: right;font-size: 18px;margin-right: 10px;">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h4 class="text-truncate">Learning</h4>
                        </div>
                    </div>
                </div>
                <!-- Star rating end -->
            </div>
        </div>
    </div>
</div>
<!-- Multimedia info + details end -->
<h2 class="title-block">Evaluate</h2>
<?php echo elgg_view_form("publications/evaluate", array(
    'style' => 'background: #f1f2f7;padding: 20px;margin: 10px 0;',
    'data-validate' => 'true'),
    array('entity' => $entity));
?>

<?php if($comments = array_pop(ClipitComment::get_by_destination(array($entity->id)))):?>
<a name="comments"></a>
<h3 class="activity-module-title"><?php echo elgg_echo("comments"); ?> <span class="blue-lighter">(<?php echo count($comments);?>)</span></h3>
<?php
    foreach($comments as $comment){
        echo elgg_view("comments/comment",
            array(
                'entity' => $comment,
            ));
    }
endif;
?>
<!-- Comment form -->
<a name="create_reply"></a>
<h3 class="activity-module-title"><?php echo elgg_echo("comment:create"); ?></h3>
<div class="discussion discussion-reply-msg">
    <div class="user-reply">
        <img class="user-avatar" src="<?php echo $user_loggedin_elgg->getIconURL('small'); ?>"/>
    </div>
    <div class="block">
        <?php echo elgg_view_form("comments/create", array('data-validate'=> "true", 'class'=>'fileupload' ), array('entity'  => $entity)); ?>
    </div>
</div>
<!-- Comment form end-->