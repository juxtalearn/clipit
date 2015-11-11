<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/09/2015
 * Last update:     04/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entities = elgg_extract('entities', $vars);
$total_count = elgg_extract('total_count', $vars);
?>
<style>
    .container .content{
        background: #fff !important;
    }
    .tags{
        display: block;
    }
    #footer{
        margin-top: 30px;
    }
</style>
<ul>
<?php
foreach($entities as $entity):
    $remote_site = array_pop(ClipitRemoteSite::get_by_id(array($entity->remote_site)));
?>
    <li class="row list-item list-even">
        <div class="col-md-8">
            <h4 class="margin-0 margin-bottom-15 text-truncate">
                <?php echo elgg_view('output/url', array(
                    'href' => "videos/search?by=trickytopic&id=".$entity->id,
                    'title' => $entity->name,
                    'text'  => $entity->name
                ));
                ?>
            </h4>
            <div class="margin-top-10">
                <?php echo elgg_view("global/tags/view", array('tags' => $entity->tag_array, 'limit' => 5)); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="margin-bottom-10">
                <small class="show"><?php echo elgg_echo('educational:center');?></small>
                <?php echo elgg_view('output/url', array(
                    'href' => "videos/".elgg_get_friendly_title($remote_site->name)."/".$remote_site->id,
                    'class' => 'text-truncate',
                    'text'  => $remote_site->name,
                    'title' => $remote_site->name,
                ));
                ?>
            </div>
            <div>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href' => "videos/search?by=trickytopic&id=".$entity->id,
                        'title' => 'Ver videos',
                        'text'  => '<i class="fa fa-youtube-play"></i> '.elgg_echo('videos:related')
                    ));
                    ?>
<!--                    --><?php //echo elgg_view('output/url', array(
//                        'href' => $video_url,
//                        'class' => 'pull-right',
//                        'title' => 'Ver videos',
//                        'text'  => '<i class="fa fa-youtube-play"></i> '.'Ver videos'
//                    ));
//                    ?>
<!--                    --><?php //echo elgg_view('output/url', array(
//                        'href' => $video_url,
//                        'title' => $video->name,
//                        'text'  => '<i class="fa fa-list"></i> '.'Ver actividades'
//                        ));
//                    ?>
                </strong>
            </div>
        </div>
    </li>
<?php endforeach;?>
</ul>
<?php echo clipit_get_pagination(array('count' => $total_count)); ?>