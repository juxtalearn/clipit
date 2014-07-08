<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<li>
    <?php echo elgg_view('output/url', array(
        'href'  => "create_activity",
        'title' => elgg_echo('activity:create'),
        'text'  => elgg_echo('activity:create')
    ));
    ?>
</li>
<li class="separator">|</li>