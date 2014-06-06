<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/04/14
 * Last update:     28/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract("entity", $vars);
$user_loggedin = elgg_get_logged_in_user_guid();
$user_loggedin = new ElggUser($user_loggedin_id);
$owner_user = new ElggUser($entity->owner_id);
?>
<!-- Multimedia info + details -->
<div class="multimedia-owner">
    <?php echo elgg_view("multimedia/owner_options", array('entity' => $entity, 'type' => $vars['type'])); ?>
    <div class="multimedia-preview">
        <?php echo $vars['preview'];?>
    </div>
    <div class="block">
        <div class="header">
            <h3 class="title"><?php echo $entity->name; ?></h3>
            <small class="show sub-title">
                <img class="user-avatar" src="<?php echo $owner_user->getIconURL("tiny");?>">
                <i>
                    Uploaded by
                    <?php echo elgg_view('output/url', array(
                        'href'  => "profile/".$owner_user->login,
                        'title' => $owner_user->name,
                        'text'  => $owner_user->name));
                    ?>
                    <?php echo elgg_view('output/friendlytime', array('time' => $entity->time_created));?>
                </i>
            </small>
        </div>
        <div class="multimedia-body">
            <div class="multimedia-view">
                <?php echo $vars['body'];?>
            </div>
            <div>
                <?php echo $entity->description; ?>
            </div>
        </div>
    </div>
</div>
<!-- Multimedia info + details end -->


<a name="replies"></a>
<?php
$auto_id = 1;
foreach(array_pop(ClipitPost::get_by_destination(array($entity->id))) as $reply_msg){
    echo elgg_view("discussion/reply",
        array(
            'entity' => $reply_msg,
            'auto_id' => $auto_id,
        ));
    $auto_id++;
}
?>


<!-- Reply form -->
<a name="create_reply"></a>
<h3 class="activity-module-title"><?php echo elgg_echo("reply:create"); ?></h3>
<div class="discussion discussion-reply-msg">
    <div class="user-reply">
        <img class="user-avatar" src="<?php echo $user_loggedin->getIconURL('small'); ?>"/>
    </div>
    <div class="block">
        <?php echo elgg_view_form("discussion/reply/create", array('data-validate'=> "true", 'class'=>'fileupload' ), array('entity'  => $entity)); ?>
    </div>
</div>
<!-- Reply form end-->
