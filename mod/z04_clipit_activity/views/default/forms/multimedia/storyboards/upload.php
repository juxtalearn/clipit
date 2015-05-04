<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/05/14
 * Last update:     16/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
elgg_load_js("file:upload");
echo elgg_view("multimedia/file/templates/upload", array('entity' => $entity, 'type' => 'storyboard'));
?>
<div class="block" style="margin-bottom: 10px;">
    <a class="btn btn-default fileinput-button" style="position: relative; overflow: hidden">
        <?php echo elgg_echo("multimedia:storyboards:add");?>
        <input type="file" name="files" id="uploadfilebutton" multiple>
    </a>
</div>
<?php
$body .= '<div class="files"></div>';
$body .= $vars['create_form'];
$footer = '
<div class="fileupload-buttonbar row">
        <div class="col-md-6">
            <!-- The global file processing state -->
            <span class="fileupload-process"></span>
            <!-- The global progress state -->
            <div class="fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <div class="col-md-6">
            <span class="btn btn-success fileinput-button">
                <i class="fa fa-plus"></i>
                <span>'.elgg_echo("multimedia:storyboards:add").'...</span>
                <input type="file" name="files" multiple>
            </span>
            <button type="submit" class="btn btn-primary start">
                <span>'.elgg_echo("send").'</span>
            </button>
        </div>
</div>';
echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg files-list",
        "target"    => "add-file",
        "title"     => elgg_echo("multimedia:storyboards:add"),
        "form"      => true,
        "body"      => $body,
        "footer"      => $footer,
        "cancel_button" => false,
        "ok_button" => false,
    ));
