<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/07/2015
 * Last update:     13/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$object = ClipitSite::lookup($entity->id);
$href = elgg_extract('href', $vars);
switch($object['subtype']){
    case 'ClipitVideo':
        echo '<a style="position: relative" href="'.elgg_get_site_url().$href.'/view/'.$entity->id.'">
                <div class="image-background" style="background-image: url(\''.$entity->preview.'\');"></div>
            </a>';
        break;
    case 'ClipitFile':
        echo elgg_view("multimedia/file/view_summary", array(
            'file' => $entity,
            'title' => false
        ));
        break;
}