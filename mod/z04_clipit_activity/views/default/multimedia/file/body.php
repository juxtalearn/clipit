<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/05/14
 * Last update:     13/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$file = elgg_extract('entity', $vars);
?>
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
<?php echo elgg_view('multimedia/file/view', array(
    'file'  => $file,
    'size' => 'original'));
?>