<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/09/2014
 * Last update:     25/09/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$resources = elgg_extract('entities', $vars);
$href = elgg_extract('href', $vars);
?>
<?php if($vars['create']): ?>
    <?php
    $modal = elgg_view("page/components/modal",
        array(
            "dialog_class"     => "modal-md",
            "target"    => "add-resource",
            "title"     => elgg_echo("resource:add"),
            "form"      => true,
            "body"      => elgg_view('multimedia/resource/add', array('entity'  => $entity)),
            "cancel_button" => true,
            "ok_button" => elgg_view('input/submit',
                array(
                    'value' => elgg_echo('add'),
                    'class' => "btn btn-primary"
                ))
        ));

    ?>
    <?php echo elgg_view_form('multimedia/resources/add', array(
            'data-validate'=> "true",
            'body' => $modal,
        ),
        array('entity'  => $entity)
    );
    ?>
    <div class="block" style="margin-bottom: 20px;">
        <button type="button" data-toggle="modal" data-target="#add-resource" class="btn btn-default"><?php echo elgg_echo("resource:add");?></button>
    </div>
<?php endif; ?>
<?php
foreach($resources as $resource_id):
    $resource = array_pop(ClipitResource::get_by_id(array($resource_id)));
    $tags = ClipitResource::get_tags($resource->id);
    $resource_text = trim(elgg_strip_tags($resource->description));
    // Message text truncate max length 280
    if(mb_strlen($resource_text)>280){
        $resource_text = substr($resource_text, 0, 280)."...";
    }
    // Get owner user object
    $owner = array_pop(ClipitUser::get_by_id(array($resource->owner_id)));
    // Owner options (edit/delete)
    $owner_options = "";
    if($resource->owner_id == elgg_get_logged_in_user_guid()){
        $options = array(
            'entity' => $resource,
            'edit' => array(
                "data-target" => "#edit-resource-{$resource->id}",
                "href" => elgg_get_site_url()."ajax/view/modal/multimedia/resource/edit?id={$resource->id}",
                "data-toggle" => "modal"
            ),
            'remove' => array("href" => "action/multimedia/resources/remove?id={$resource->id}"),
        );

        $owner_options = elgg_view("page/components/options_list", $options);
        // Remote modal, form content
        echo elgg_view("page/components/modal_remote", array('id'=> "edit-resource-{$resource->id}" ));
    }
    ?>
    <div class="row row-flex messages-discussion">
        <div class="col-md-12">
            <?php if($vars['publish']): ?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "{$href}/publish/{$resource->id}".($vars['task_id'] ? "?task_id=".$vars['task_id']: ""),
                    'title' => elgg_echo('publish'),
                    'style' => 'padding: 1px 5px;  background: #47a447;color: #fff;font-weight: bold;margin-left:10px;',
                    'class' => 'btn-xs btn pull-right',
                    'text'  => '<i class="fa fa-arrow-circle-up"></i> '.elgg_echo('publish')));
                ?>
            <?php endif; ?>
            <?php if($vars['actions'] !== false): ?>
                <?php echo $owner_options; ?>
            <?php endif; ?>
            <h4>
                <?php echo elgg_view('output/url', array(
                    'href' => "{$href}/view/{$resource->id}",
                    'title' => $resource->name,
                    'text' => $resource->name,
                    'is_trusted' => true, ));
                ?>
            </h4>
            <div class="content-block">
                <p>
                    <?php echo $resource_text; ?>
                </p>
                <small class="show">
                    <i>
                        <?php echo elgg_echo('resource:added_by');?>
                        <?php echo elgg_view('page/elements/user_summary', array('user' => $owner)) ?>
                        <?php echo elgg_view('output/friendlytime', array('time' => $resource->time_created));?>
                    </i>
                </small>
            </div>
        </div>
    </div>
<?php endforeach; ?>