<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/05/14
 * Last update:     9/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$files = elgg_extract("files", $vars);
$files = ClipitFile::get_by_id($files);

$entity = elgg_extract('entity', $vars);
$href = elgg_extract("href", $vars);

$user_id = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
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
        overflow: hidden;
    }
    .elements-list > li{
        padding: 10px 0;
        margin-bottom: 0;
        overflow: hidden;
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
</style>
<?php if($vars['create']):?>
    <?php echo elgg_view("page/elements/list/options", array('options' => $list_options));?>
    <hr>
<?php endif;?>
<div class="clearfix"></div>
<?php if(!empty($files)):?>
<ul class="elements-list margin-top-10">
    <?php foreach($files as $file):
        $file_url = "{$href}/view/{$file->id}". ($vars['task_id'] ? "?task_id=".$vars['task_id']: "");
    ?>
        <li class="list-item col-md-12">
            <?php
            // Owner options (edit/delete)
            $owner_options = "";
            if(($file->owner_id == $user_id || $user->role == ClipitUser::ROLE_TEACHER) && $vars['options'] !== false){
                $options = array(
                    'entity' => $file,
                    'edit' => array(
                        "data-target" => "#edit-file-{$file->id}",
                        "href" => elgg_get_site_url()."ajax/view/modal/multimedia/file/edit?id={$file->id}",
                        "data-toggle" => "modal"
                    )
                );
                if($file->owner_id == $user_id){
                    $options['remove'] = array("href" => "action/multimedia/files/remove?id={$file->id}");
                }
                $owner_options = elgg_view("page/components/options_list", $options);
                // Remote modal, form content
                echo elgg_view("page/components/modal_remote", array('id'=> "edit-file-{$file->id}" ));
            }
            ?>
            <div class="col-xs-9">
                <div class="pull-left margin-right-10">
                    <?php if ($vars['options'] !== false && $vars['create']):?>
                    <span class="margin-right-10">
                        <input type="checkbox"
                               name="check-file[]"
                               value="<?php echo $file->id;?>"
                               <?php echo ($file->owner_id == $user_id || $user->role == ClipitUser::ROLE_TEACHER)?'':'disabled';?>
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
                <div style="width: 45px;display: inline-block;float: right;text-align: center;margin-left:10px;">
                    <?php echo elgg_view('output/url', array(
                        'href'  => "file/download/".$file->id. ($vars['task_id'] ? "?task_id=".$vars['task_id']: ""),
                        'title' => $owner->name,
                        'class' => 'btn btn-default btn-icon',
                        'text'  => '<i class="fa fa-download"></i>'));
                    ?>
                    <small class="show text-truncate" title="<?php echo formatFileSize($file->size);?>" style="margin-top: 3px;">
                        <?php echo formatFileSize($file->size);?>
                    </small>
                </div>
                <?php
                if($vars['task_id']):
                    if(array_pop(ClipitFile::get_read_status($file->id, array($user_id)))): ?>
                        <div class="pull-right margin-right-5 margin-top-5">
                            <i class="fa fa-eye blue" style="font-size: 16px;"></i>
                        </div>
                <?php
                    endif;
                endif;
                ?>
                <?php echo $owner_options;?>
            </div>
        </li>
    <?php endforeach;?>
</ul>
<?php endif;?>