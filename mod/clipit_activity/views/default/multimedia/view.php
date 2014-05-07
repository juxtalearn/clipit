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
$file = elgg_extract("entity", $vars);
$user_loggedin = elgg_get_logged_in_user_guid();
$user_loggedin = new ElggUser($user_loggedin_id);
$owner_user = new ElggUser($file->owner_id);

// Owner options (edit/delete)
$owner_options = "";
if($file->owner_id == elgg_get_logged_in_user_guid()){
    $options = array(
        'entity' => $file,
        'edit' => array(
            "data-target" => "#edit-file-{$file->id}",
            "href" => elgg_get_site_url()."ajax/view/modal/multimedia/file/edit?id={$file->id}",
            "data-toggle" => "modal"
        ),
        'remove' => array("href" => "action/multimedia/files/remove?id={$file->id}"),
    );

    $owner_options = elgg_view("page/components/options_list", $options);
    // Remote modal, form content
    echo elgg_view("page/components/modal_remote", array('id'=> "edit-file-{$file->id}" ));
}
?>
<!-- File info + details -->
<div class="file-owner">
    <?php echo $owner_options; ?>
    <div class="file-preview">
        <?php echo elgg_view("multimedia/file/preview", array('file'  => $file));?>
    </div>
    <div class="block">
        <div class="header-file">
            <h2 class="title"><?php echo $file->name; ?></h2>
            <small class="show sub-title">
                <img class="user-avatar" src="<?php echo $owner_user->getIconURL("tiny");?>">
                <i>
                    Uploaded by
                    <?php echo elgg_view('output/url', array(
                        'href'  => "profile/".$owner_user->login,
                        'title' => $owner_user->name,
                        'text'  => $owner_user->name));
                    ?>
                    <?php echo elgg_view('output/friendlytime', array('time' => $file->time_created));?>
                </i>
            </small>
        </div>
        <div class="body-file">
            <div class="file-details">
                <div>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "file/download/".$file->id,
                        'title' => elgg_echo('download'),
                        'target' => '_blank',
                        'class' => 'btn btn-default',
                        'text'  => '<i class="fa fa-download"></i> '.elgg_echo('download')));
                    ?>
                    <div class="file-info">
                        <strong class="show"><?php echo elgg_echo("file:" . $file->mime_type['short']);?></strong>
                        <?php echo formatFileSize($file->size);?>
                    </div>
                </div>
                <?php echo elgg_view("multimedia/file/view", array(
                    'file'  => $file,
                    'size'  => 'original' ));
                ?>
            </div>
            <div>
                <?php echo $file->description; ?>
            </div>
        </div>
    </div>
</div>
<!-- File info + details end -->
