<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/10/2014
 * Last update:     10/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<li>
    <?php echo elgg_view('output/url', array(
        'href'  => "admin",
        'title' => elgg_echo('admin:page'),
        'text'  => elgg_echo('admin:page')
    ));
    ?>
</li>
<li class="separator">|</li>