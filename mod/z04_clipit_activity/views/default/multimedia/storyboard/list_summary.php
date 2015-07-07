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
$user_id = elgg_get_logged_in_user_guid();
$unlink = elgg_extract("unlink", $vars);
if($unlink){
    $user_groups = ClipitUser::get_groups($user_id);
}
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
?>
<?php echo elgg_view("storyboards/search");?>
<div class="clearfix"></div>
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
        $unlinked = false;
        if($unlink && in_array(ClipitStoryboard::get_group($storyboard->id), $user_groups)){
            $unlinked = true;
        }
        $published = false;
        ?>
        <?php
        if($vars['preview']):
            echo elgg_view("page/components/modal_remote", array('id'=> "viewer-id-{$storyboard->id}" ));
            $href_viewer = "ajax/view/multimedia/viewer?id=".$storyboard->id;
        endif;
        ?>
        <li class="row list-item">
            <div class="col-md-1 text-right">
                <a href="<?php echo elgg_get_site_url()."{$href}/view/{$storyboard->id}"; ?>">
                    <div class="multimedia-preview">
                        <?php if($vars['preview'] !== false):?>
                            <?php echo elgg_view('output/url', array(
                                'href'  => $href_viewer,
                                'title' => $storyboard->name,
                                'data-target' => '#viewer-id-'.$storyboard->id,
                                'data-toggle' => 'modal',
                                'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))
                            ));
                            ?>
                        <?php else:?>
                            <?php echo elgg_view('output/url', array(
                                'href'  => "{$href}/view/".$storyboard->id,
                                'title' => $storyboard->name,
                                'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))
                            ));
                            ?>
                        <?php endif;?>
                    </div>
                </a>
            </div>
            <div class="col-md-11">
                <?php
                $owner_options = '';
                if($storyboard->owner_id == $user_id || hasTeacherAccess($user->role) && $vars['actions']){
                    $options = array(
                        'entity' => $storyboard,
                        'edit' => array(
                            "data-target" => "#edit-storyboard-{$storyboard->id}",
                            "href" => elgg_get_site_url()."ajax/view/modal/multimedia/storyboard/edit?id={$storyboard->id}",
                            "data-toggle" => "modal"
                        ),
                        'remove' => array("href" => "action/multimedia/storyboards/remove?id={$storyboard->id}"),
                    );
                    if($storyboard->owner_id == $user_id){
                        $options['remove'] = array("href" => "action/multimedia/storyboards/remove?id={$storyboard->id}");
                    }
                    if($vars['actions']){
                        $owner_options = elgg_view("page/components/options_list", $options);
                        $select = '<input type="checkbox" name="check-file[]" value="'.$storyboard->id.'" class="select-simple">';
                    }
                    // Remote modal, form content
                    echo elgg_view("page/components/modal_remote", array('id'=> "edit-storyboard-{$storyboard->id}" ));
                }
                ?>
                <?php echo $owner_options;?>
                <div class="pull-right text-right">
                    <?php if($unlinked):?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => 'action/multimedia/storyboards/remove?id='.$storyboard->id.'&unlink=true',
                            'is_action' => true,
                            'class'  => 'btn btn-xs btn-border-red btn-primary margin-bottom-10',
                            'title' => elgg_echo('task:remove_storyboard'),
                            'text'  => '<i class="fa fa-trash-o"></i> '.elgg_echo('task:remove_storyboard')
                        ));
                        ?>
                    <?php endif; ?>
                    <?php if($rating):?>
                        <?php echo elgg_view("performance_items/summary", array(
                            'entity' => $storyboard,
                            'show_check' => true,
                        ));
                        ?>
                    <?php endif; ?>
                </div>
                <h4 class="text-truncate margin-0">
                    <strong>
                    <?php if($vars['preview']):?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => $href_viewer,
                            'title' => $storyboard->name,
                            'data-target' => '#viewer-id-'.$storyboard->id,
                            'data-toggle' => 'modal',
                            'text'  => $storyboard->name
                        ));
                        ?>
                    <?php else:?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "{$href}/view/".$storyboard->id,
                            'title' => $storyboard->name,
                            'text'  => $storyboard->name
                        ));
                        ?>
                    <?php endif;?>
                    </strong>
                </h4>
                <div class="overflow-hidden">
                    <div class="tags">
                        <?php echo elgg_view("tricky_topic/tags/view", array('tags' => $tags)); ?>
                    </div>
                    <p>
                        <?php echo $description;?>
                    </p>
                </div>
                <small class="show" style="margin: 0">
                    <?php
                    echo elgg_view("publications/owner_summary", array(
                        'entity' => $storyboard,
                        'entity_class' => 'ClipitStoryboard',
                        'msg' => elgg_echo('multimedia:uploaded_by')
                    ));
                    ?>
                    <?php if($vars['view_comments'] !== false):?>
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
                    <?php endif; ?>
                    <!-- Count total comments end-->
                    <i>
                        <?php echo elgg_view('output/friendlytime', array('time' => $storyboard->time_created));?>
                    </i>
                </small>
            </div>
        </li>
    <?php endforeach;?>
</ul>