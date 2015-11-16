<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/05/14
 * Last update:     9/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$files = elgg_extract("entities", $vars);
$files = ClipitFile::get_by_id($files);

$entity = elgg_extract('entity', $vars);
$rating = elgg_extract('rating', $vars);
$href = elgg_extract("href", $vars);
$task_id = elgg_extract("task_id", $vars);
$unlink = elgg_extract("unlink", $vars);

$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
if($unlink){
    $user_groups = ClipitUser::get_groups($user_id);
}
$list_options = array();
// File options
if(!empty($files)) {
    $list_options['options_values'] = array(
        '' => elgg_echo('bulk_actions'),
        'remove' => elgg_echo('file:delete'),
    );
}
?>
<style>
    .btn-options + .dropdown-menu{
        right: 0;
        left: auto;
    }
    .files-table fieldset{
        width: 100%;
    }
    .elements-list{
        /*overflow: hidden;*/
    }
    .elements-list > li{
        padding: 10px 0;
        margin-bottom: 0;
    }
    .elements-list > li:hover{
        background-color: #f5f5f5;
    }
    @media (max-width: 767px) {
        .elements-list > li .btn-options {
            display: none !important;
        }
    }
    .file-info{
        overflow: hidden;
    }
    .file-info h4{
        margin: 0;
    }
    .select-simple{
        vertical-align: top
    }
    #add-file .required-message{
        display: none;
    }
</style>
<?php if($vars['options'] !== false && $vars['create']):?>
    <?php echo elgg_view("page/elements/list/options", array('options' => $list_options));?>
    <hr>
<?php endif;?>
<div class="clearfix"></div>
<?php if(!empty($files)):?>
<ul class="elements-list margin-top-10 clearfix">
    <?php foreach($files as $file):
        $file_url = "{$href}/view/{$file->id}". ($task_id ? "?task_id=".$task_id: "");
        $unlinked = false;
        if($unlink && in_array(ClipitFile::get_group($file->id), $user_groups)){
            $unlinked = true;
        }
    ?>
        <li class="list-item col-md-12">
            <div class="col-xs-9">
                <div class="pull-left margin-right-10">
                    <?php if ($vars['options'] !== false && $vars['create']):?>
                    <span class="margin-right-10">
                        <input type="checkbox"
                               name="check-file[]"
                               value="<?php echo $file->id;?>"
                               <?php echo ($file->owner_id == $user_id || hasTeacherAccess($user->role))?'':'disabled';?>
                               class="select-simple">
                    </span>
                    <?php endif;?>
                    <div class="multimedia-preview" style="display: inline-block;">
                        <?php echo elgg_view('output/url', array(
                            'href'  => $file_url,
                            'title' => $file->name,
                            'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))));
                        ?>
                    </div>
                </div>
                <div class="file-info">
                    <?php echo elgg_view("multimedia/file/title_summary", array('entity' => $file, 'href' => $file_url));?>
                </div>
            </div>
            <div class="col-xs-3" style="vertical-align: middle">
                <?php if($vars['publish']):?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/publish/{$file->id}".($task_id ? "?task_id=".$task_id: ""),
                        'title' => elgg_echo('review'),
                        'style' => 'background: #47a447;color: #fff;font-weight: bold;margin-left:10px;',
                        'class' => 'btn-sm btn pull-right btn-primary',
                        'text'  => elgg_view('page/components/tooltip', array('text' => elgg_echo('publications:select:tooltip')))
                            .elgg_echo('select').'...'
                    ));
                    ?>
                <?php else:?>
                    <?php if($unlinked):?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => 'action/multimedia/files/remove?id='.$file->id.'&unlink=true',
                            'is_action' => true,
                            'class'  => 'btn btn-xs btn-border-red btn-primary margin-bottom-10 remove-object',
                            'title' => elgg_echo('task:remove_file'),
                            'text'  => '<i class="fa fa-trash-o"></i> '.elgg_echo('task:remove_file')
                        ));
                        ?>
                    <?php endif; ?>
                    <div style="width: 45px;display: inline-block;float: right;text-align: center;margin-left:10px;">
                        <?php echo elgg_view('output/url', array(
                            'href'  => "file/download/".$file->id. ($task_id ? "?task_id=".$task_id: ""),
                            'title' => $owner->name,
                            'class' => 'btn btn-default btn-icon',
                            'text'  => '<i class="fa fa-download"></i>'));
                        ?>
                        <small class="show text-truncate" title="<?php echo formatFileSize($file->size);?>" style="margin-top: 3px;">
                            <?php echo formatFileSize($file->size);?>
                        </small>
                    </div>
                    <?php if($rating):?>
                        <?php echo elgg_view("performance_items/summary", array(
                            'entity' => $file,
                            'show_check' => true,
                        ));
                        ?>
                    <?php endif; ?>
                <?php endif;?>
                <?php
                if($task_id && $vars['task_type'] == ClipitTask::TYPE_RESOURCE_DOWNLOAD):
                    if(array_pop(ClipitFile::get_read_status($file->id, array($user_id)))): ?>
                        <div class="pull-right margin-right-5 margin-top-5">
                            <i class="fa fa-eye blue" style="font-size: 16px;"></i>
                        </div>
                <?php
                    endif;
                endif;
                ?>
                <?php
                if($vars['options'] !== false || $vars['actions']):
                    $disabled = false;
                    if(count(ClipitFile::get_clones($file->id))){
                        $disabled = array('remove', 'edit');
                    }
                ?>
                    <?php echo elgg_view("multimedia/owner_options", array(
                        'entity' => $file,
                        'type' => 'file',
                        'remove' => count(ClipitFile::get_clones($file->id)) > 0 ? false:true,
                        'disabled' => $disabled
                    ));
                    ?>
                <?php endif;?>
            </div>
            <div class="clearfix"></div>
        </li>
    <?php endforeach;?>
</ul>
<?php endif;?>