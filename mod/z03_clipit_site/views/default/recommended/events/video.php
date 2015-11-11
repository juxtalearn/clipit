<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/05/14
 * Last update:     29/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
?>
<a href="<?php echo elgg_get_site_url()."{$vars['href']}/view/{$entity->id}"; ?>" class="show">
    <div class="video-list">
        <div class="video-item">
            <strong><?php echo $entity->name; ?></strong>
            <div class="img-preview" style="margin-top: 10px;">
                <?php
                if($vars['rating']):
                    $rating_average = $entity->performance_rating_average;
                ?>
                    <div class="pull-right rating ratings readonly white-star" data-score="<?php echo $rating_average;?>">
                        <?php echo star_rating_view($rating_average);?>
                    </div>
                <?php endif; ?>
                <img src="<?php echo $entity->preview;?>">
            </div>
        </div>
    </div>
</a>