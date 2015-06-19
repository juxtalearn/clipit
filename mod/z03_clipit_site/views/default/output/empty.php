<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
if($vars['type']):
    switch($vars['type']){
        case 'error':
            $class = 'bg-danger';
            break;
    }
    echo '<div class="'.$class.'">
        '.$vars['value'].'
        </div>';
else:
?>
<div class="clearfix"></div>
<h4 class="empty"><?php echo $vars['value'];?></h4>
<?php endif;?>