<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/06/14
 * Last update:     30/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entities = elgg_extract('entities', $vars);
if($entities):
    foreach($entities as $video):
        $tags = $video->tag_array;
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
                'href'  => "explore/view/{$video->id}",
                'text' => "<strong>{$video->name}</strong>",
                'class' => 'text-truncate margin-bottom-5',
            ));
            ?>

            <?php echo elgg_view('output/url', array(
                'href'  => "explore/view/{$video->id}",
                'text'  => elgg_view('output/img', array(
                    'src' => $video->preview,
                    'class' => 'pull-left image-block',
                    'style' => 'width:40%;height:auto'
                )),
            ));
            ?>
            <div class="text" style="
    overflow: hidden;
">
                <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tags, 'limit' => 1, 'width' => "85%")); ?>
                <small class="show"><?php echo elgg_view('output/friendlytime', array('time' => $video->time_created));?></small>
            </div>

        </div>
    <?php endforeach;?>
<?php else: ?>
    <div class="wrapper">
        <small><strong><?php echo elgg_echo('videos:recommended:none');?></strong></small>
    </div>
<?php endif;?>