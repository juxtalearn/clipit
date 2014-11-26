<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/10/2014
 * Last update:     21/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$file = array_pop(ClipitFile::get_by_id(array(array_pop($entity->file_array))));
?>
<div style="margin-bottom: 60px">
    <?php echo elgg_view('output/img',array(
        'src' => $file->thumb_small['url'],
        'class' => 'image-block',
        'style' => 'width: 45px;',
    ));?>
    <div class="content-block">
        <h3 class="margin-0">
            <?php
            echo elgg_view('output/url', array(
                'href' => "videos/". $entity->description,
                'text'  => $entity->name,
                'title' => $entity->name,
            ));
            ?>
        </h3>
        <p class="margin-top-10">
            <?php
            echo elgg_view('output/url', array(
                'href' => $entity->url,
                'text'  => $entity->url,
                'target' => '_blank',
                'title' => $entity->name,
            ));
            ?>
        </p>
    </div>
</div>