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
$text = elgg_extract("entity", $vars);
?>
<style>
    .multimedia-text{
        padding: 20px;
        max-height: 600px;
        overflow-y: auto;
    }
</style>
<div class="multimedia-text">
    <?php echo $text->description;?>
</div>