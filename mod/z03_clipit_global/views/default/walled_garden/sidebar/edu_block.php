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
?>
<div style="margin-bottom: 60px">
    <div class="content-block">
        <h3 class="margin-0">
            <?php
            echo elgg_view('output/url', array(
                'href' => "videos/".elgg_get_friendly_title($entity->name)."/".$entity->id,
                'text'  => $entity->name,
                'title' => $entity->name,
            ));
            ?>
        </h3>
        <p class="margin-top-10">
            <?php
            echo elgg_view('output/url', array(
                'href' => $entity->url,
                'class' => 'btn btn-sm btn-primary',
                'text'  => elgg_echo('connect'),
                'target' => '_blank',
                'title' => $entity->name,
            ));
            ?>
        </p>
    </div>
</div>