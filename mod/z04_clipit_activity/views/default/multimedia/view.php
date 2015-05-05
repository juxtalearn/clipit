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

$tags = $entity->tag_array;
$labels = $entity->label_array;
$performance_items = $entity->performance_item_array;
?>
<!-- Multimedia info + details -->
<?php echo elgg_view("multimedia/owner_options", array('entity' => $entity, 'type' => $vars['type'])); ?>
<div class="clearfix"></div>
<div class="multimedia-owner">
    <div class="multimedia-preview hidden-xs">
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
            <div class="row">
                <div class="col-md-9">
                <?php if(!empty($tags)):?>
                    <small class="show"><?php echo elgg_echo('tags');?></small>
                    <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tags)); ?>
                <?php endif;?>
                <?php if(!empty($labels)):?>
                    <div class="margin-bottom-10">
                        <small class="show"><?php echo elgg_echo('labels');?></small>
                        <small class="blue text-truncate content-block" id="label_list">
                            <?php echo elgg_view("publications/labels/view", array('labels' => $labels)); ?>
                        </small>
                    </div>
                <?php endif;?>
                <?php if($vars['description'] !== false && $entity->description):?>
                    <div class="margin-bottom-10">
                        <small class="show"><?php echo elgg_echo('description');?></small>
                        <div class="description">
                            <?php echo $entity->description; ?>
                        </div>
                    </div>
                <?php endif;?>
                </div>
                <div class="col-md-3">
                    <?php if(!empty($performance_items)):?>
                        <small class="show"><?php echo elgg_echo('performance_items');?></small>
                        <?php echo elgg_view('performance_items/view', array('entities' => $performance_items)); ?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Multimedia info + details end -->