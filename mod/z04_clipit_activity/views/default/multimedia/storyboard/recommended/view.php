<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/06/14
 * Last update:     30/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract('entities', $vars);
if($entities):
    foreach($entities as $storyboard):
        $tags = $storyboard->tag_array;
        $file = array_pop(ClipitFile::get_by_id(array($storyboard->file)));
        ?>
        <style>
            .elgg-module.videos-summary .tags{
                margin-bottom: 0;
            }
            .elgg-module-aside .wrapper{
                border-bottom: 1px solid #bae6f6;
            }
            .elgg-module-aside .wrapper:last-child{
                border-bottom: 0;
            }
        </style>
        <div class="wrapper separator" style="
    overflow: hidden;
    border-radius: 0;
">
            <?php echo elgg_view('output/url', array(
                'href'  => "explore/view/{$storyboard->id}",
                'text' => "<strong>{$storyboard->name}</strong>",
                'class' => 'text-truncate margin-bottom-5',
            ));
            ?>
            <div class="multimedia-preview image-block">
                <?php echo elgg_view('output/url', array(
                    'href'  => "{$href}/view/".$storyboard->id,
                    'title' => $storyboard->name,
                    'text'  => elgg_view("multimedia/file/preview", array('file'  => $file))));
                ?>
            </div>
            <div class="text" style="
    overflow: hidden;
">
                <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tags, 'limit' => 1, 'width' => "85%")); ?>
                <small class="show"><?php echo elgg_view('output/friendlytime', array('time' => $storyboard->time_created));?></small>
            </div>

        </div>
    <?php endforeach;?>
<?php else: ?>
    <div class="wrapper">
        <small><strong><?php echo elgg_echo('storyboards:recommended:none');?></strong></small>
    </div>
<?php endif;?>