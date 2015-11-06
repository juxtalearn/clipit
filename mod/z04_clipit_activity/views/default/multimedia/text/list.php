<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$entities_ids = elgg_extract('entities', $vars);
$texts = ClipitText::get_by_id($entities_ids);

$href = elgg_extract("href", $vars);
$rating = elgg_extract("rating", $vars);
$task_id = elgg_extract("task_id", $vars);
$unlink = elgg_extract("unlink", $vars);
$user_id = elgg_get_logged_in_user_guid();
if($unlink){
    $user_groups = ClipitUser::get_groups($user_id);
}
?>
<?php echo elgg_view("texts/search"); ?>
<?php if($vars['create']):?>
    <?php
    $modal = elgg_view("page/components/modal",
        array(
            "dialog_class"     => "modal-md",
            "target"    => "add-text",
            "title"     => elgg_echo("text:add"),
            "form"      => true,
            "body"      => elgg_view('forms/multimedia/texts/save', array('scope_entity'  => $entity)),
            "cancel_button" => true,
            "ok_button" => elgg_view('input/submit',
                array(
                    'value' => elgg_echo('add'),
                    'class' => "btn btn-primary"
                ))
        ));
    // if create var contains additional data
    $modal .= $vars['create_form'];
    ?>
    <?php echo elgg_view_form('', array(
            'action' => 'action/multimedia/texts/save',
            'data-validate'=> "true",
            'body' => $modal,
            'enctype' => 'multipart/form-data'
        ),
        array('entity'  => $entity)
    );
    ?>
    <div class="block" style="margin-bottom: 20px;">
        <button type="button" data-toggle="modal" data-target="#add-text" class="btn btn-default">
            <?php echo elgg_echo("text:add");?>
        </button>
    </div>
<?php endif; ?>
<div class="clearfix"></div>
<ul class="text-list">
    <?php
    foreach($texts as $text):
        $tags = ClipitText::get_tags($text->id);
        $description = trim(elgg_strip_tags($text->description));
        $description = elgg_get_excerpt($description, 400);
        $published = false;
        $unlinked = false;
        if($unlink && in_array(ClipitText::get_group($text->id), $user_groups)){
            $unlinked = true;
        }
        $href_text = $href."/view/".$text->id . ($task_id ? "?task_id=".$task_id: "");
    ?>
        <li class="text-item row list-item">
            <?php if($vars['send_site']):?>
                <?php echo elgg_view("page/components/modal_remote", array('id'=> "publish-{$text->id}" ));?>
            <?php endif;?>
            <div class="col-md-12">
                <?php
                if($task_id && $vars['task_type'] == ClipitTask::TYPE_RESOURCE_DOWNLOAD):
                    if(array_pop(ClipitText::get_read_status($text->id, array($user_id)))):
                ?>
                <div class="pull-right margin-right-20 margin-top-5">
                    <i class="fa fa-eye blue" style="font-size: 16px;"></i>
                </div>
                <?php
                    endif;
                endif;
                ?>
                <?php if($vars['publish']): ?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/publish/{$text->id}".($task_id ? "?task_id=".$task_id: ""),
                        'title' => elgg_echo('select'),
                        'style' => 'background: #47a447;color: #fff;font-weight: bold;margin-left:10px;',
                        'class' => 'btn-sm btn pull-right btn-primary',
                        'text'  => elgg_view('page/components/tooltip', array('text' => elgg_echo('publications:select:tooltip')))
                                   .elgg_echo('select').'...'
                    ));
                    ?>
                <?php endif; ?>

                <?php if($vars['actions']):?>
                    <?php echo elgg_view("multimedia/owner_options", array(
                        'entity' => $text,
                        'type' => 'text',
                        'remove' => count(ClipitText::get_clones($text->id)) > 0 ? false:true,
                    ));
                    ?>
                <?php endif; ?>
                <div class="pull-right text-right">
                    <?php if($vars['send_site']):?>
                    <div class="margin-bottom-5">
                        <?php if(ClipitText::get_site($text->id, true)):?>
                            <strong class="green">
                                <i class="fa fa-check "></i> <?php echo elgg_echo('published');?>
                            </strong>
                        <?php else:?>
                            <?php echo elgg_view('output/url', array(
                                'href'  => "ajax/view/modal/publications/publish?id={$text->id}",
                                'class' => 'btn btn-sm btn-primary',
                                'text'  => '<i class="fa fa-globe"></i> '.elgg_echo('send:to_site'),
                                'data-toggle'   => 'modal',
                                'data-target' => '#publish-'.$text->id,
                            ));
                            ?>
                        <?php endif;?>
                    </div>
                    <?php endif; ?>
                    <?php if($unlinked):?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => 'action/multimedia/texts/remove?id='.$text->id.'&unlink=true',
                            'is_action' => true,
                            'class'  => 'btn btn-xs btn-border-red btn-primary margin-bottom-10 remove-object',
                            'title' => elgg_echo('task:remove_text'),
                            'text'  => '<i class="fa fa-trash-o"></i> '.elgg_echo('task:remove_text')
                        ));
                        ?>
                    <?php endif; ?>
                    <?php if($rating):?>
                        <?php echo elgg_view("performance_items/summary", array(
                            'entity' => $text,
                            'show_check' => true,
                        ));
                        ?>
                    <?php endif; ?>
                </div>
                <h4 class="text-truncate">
                    <?php echo elgg_view('output/url', array(
                        'href'  => $href_text,
                        'title' => $text->name,
                        'text'  => $text->name));
                    ?>
                </h4>
                <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tags, 'limit' => 3)); ?>
                <p class="hidden-xs">
                    <?php echo $description;?>
                </p>
                <div class="clearfix"></div>
                <small class="show">
                    <?php
                    if($vars['total_comments']):
                        $total_comments = array_pop(ClipitComment::count_by_destination(array($text->id), false));
                    ?>
                        <!-- Count total comments -->
                        <strong>
                        <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/view/{$text->id}#comments",
                        'title' => elgg_echo('comments'),
                        'class' => 'pull-right btn btn-xs btn-xs-5 btn-blue-lighter',
                        'text'  => $total_comments. ' <i class="fa fa-comments"></i>'))
                        ?>
                        </strong>
                        <!-- Count total comments end-->
                    <?php endif; ?>
                    <?php echo elgg_view("publications/owner_summary", array(
                        'entity' => $text,
                        'entity_class' => 'ClipitText',
                        'msg' => elgg_echo('multimedia:uploaded_by')
                    )); ?>
                    <i>
                        <?php echo elgg_view('output/friendlytime', array('time' => $text->time_created));?>
                    </i>
                </small>
            </div>
        </li>
    <?php endforeach;?>
</ul>