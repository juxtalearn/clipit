<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/06/14
 * Last update:     24/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$storyboards = elgg_extract('storyboards', $vars);
$href = elgg_extract('href', $vars);
?>
<div class="row">
    <?php
    foreach($storyboards as $storyboard):
        $file = array_pop(ClipitFile::get_by_id(array($storyboard->file)));
    ?>
    <div class="col-md-6">
        <div class="storyboard-list">
            <div class="image-block">
                <div class="multimedia-preview">
                    <?php echo elgg_view('output/url', array(
                        'href'  => "{$href}/view/{$storyboard->id}",
                        'title' => $storyboard->name,
                        'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))
                    )); ?>
                </div>
            </div>
            <div class="content-block">
                <div style="width: 35px;display: inline-block;float: right;text-align: center;margin-left:10px;">
                    <?php echo elgg_view('output/url', array(
                        'href'  => "file/download/".$file->id,
                        'title' => $file->name,
                        'class' => 'btn btn-default btn-icon',
                        'text'  => '<i class="fa fa-download"></i>'));
                    ?>
                    <small class="show text-truncate" title="<?php echo formatFileSize($file->size);?>" style="margin-top: 3px;font-size: 75%">
                        <?php echo formatFileSize($file->size); ?>
                    </small>
                </div>
                <div>
                    <strong>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "{$href}/view/{$storyboard->id}",
                            'title' => $storyboard->name,
                            'text'  => $storyboard->name
                        )); ?>
                    </strong>
                    <small class="show">
                        <strong><?php echo elgg_echo("file:" . $file->mime_type['short']);?></strong>
                    </small>
                    <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $storyboard->tag_array, 'width' => 100, 'limit' => 2)); ?>
                    <small class="show" style="margin-top: -5px;">
                        <?php
                        $total_comments = array_pop(ClipitComment::count_by_destination(array($storyboard->id), true));
                        ?>
                        <!-- Count total comments -->
                        <strong>
                            <?php echo elgg_view('output/url', array(
                                'href'  => "{$href}/view/{$storyboard->id}#comments",
                                'title' => elgg_echo('comments'),
                                'class' => 'pull-right',
                                'text'  => $total_comments. ' <i class="fa fa-comments"></i>'))
                            ?>
                        </strong>
                        <?php echo elgg_view('output/friendlytime', array('time' => $storyboard->time_created));?>
                    </small>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>