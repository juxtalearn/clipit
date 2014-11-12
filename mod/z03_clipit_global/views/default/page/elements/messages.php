<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/07/14
 * Last update:     22/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
echo '<ul class="elgg-system-messages">';

// hidden li so we validate
echo '<li class="hidden"></li>';

if (isset($vars['object']) && is_array($vars['object']) && sizeof($vars['object']) > 0) {
    foreach ($vars['object'] as $type => $list ) {
        switch($type){
            case "success":
                $icon_type = 'check';
                break;
            case "error":
                $icon_type = 'times';
                break;
        }
        $icon = '<div class="image-block"><i class="fa fa-'.$icon_type.'"></i></div>';
        foreach ($list as $message) {
            echo "<li class=\"elgg-message elgg-state-$type\">";
            echo $icon;
            echo "<div class='content-block'>";
            echo elgg_autop($message);
            echo '</div>';
            echo '</li>';
        }
    }
}

echo '</ul>';
