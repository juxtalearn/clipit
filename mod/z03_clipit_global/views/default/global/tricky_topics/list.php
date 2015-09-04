<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/09/2015
 * Last update:     04/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract('entities', $vars);
?>
<style>
    .container .content{
        background: #fff !important;
    }
    .tags{
        display: block;
    }
</style>
<ul>
<?php foreach($entities as $entity):?>
    <li class="row list-item list-even">
        <div class="col-md-8">
            <h4 class="margin-0 margin-bottom-15"><?php echo $entity->name;?></h4>
            <div class="margin-top-10">
                <?php echo elgg_view("global/tags/view", array('tags' => $entity->tag_array)); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="margin-bottom-10">
                <small class="show">Centro educativo</small>
                <a class="text-truncate">Usabilidad - Migu Usabilidad - Miguel Usabilidad - Miguelel</a>
            </div>
            <div>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href' => $video_url,
                        'class' => 'pull-right',
                        'title' => $video->name,
                        'text'  => '<i class="fa fa-youtube-play"></i> '.'Ver videos'
                    ));
                    ?>
                    <?php echo elgg_view('output/url', array(
                    'href' => $video_url,
                    'title' => $video->name,
                    'text'  => '<i class="fa fa-list"></i> '.'Ver actividades'
                    ));
                    ?>
                </strong>
            </div>
        </div>
    </li>
<?php endforeach;?>
</ul>