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
$owner_user = array_pop(ClipitUser::get_by_id(array($entity->owner_id)));
?>
<!-- Multimedia info + details -->
<?php echo elgg_view("multimedia/owner_options", array('entity' => $entity, 'type' => $vars['type'])); ?>
<div class="clearfix"></div>
<div class="multimedia-owner">
    <div class="multimedia-preview">
        <?php echo $vars['preview'];?>
    </div>
    <div class="block">
        <div class="header">
            <h3 class="title"><?php echo $entity->name; ?></h3>
            <small class="show sub-title">
                <?php echo elgg_view('output/img', array(
                    'src' => get_avatar($owner_user, 'small'),
                    'class' => 'user-avatar avatar-tiny'
                ));?>
                <i>
                    <?php echo elgg_echo('multimedia:uploaded_by');?>
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
            <?php echo elgg_view('multimedia/admin_options', array('entity' => $entity));?>
            <div class="multimedia-view">
                <?php echo $vars['body'];?>
            </div>
            <div class="description">
                <?php echo $entity->description; ?>
            </div>
        </div>
    </div>
</div>
<!-- Multimedia info + details end -->