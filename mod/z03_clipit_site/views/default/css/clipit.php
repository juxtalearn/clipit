<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/02/2015
 * Last update:     24/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$plugin_dir = elgg_get_plugins_path().'z03_clipit_site';
$plugin_url = elgg_get_site_url().'mod/z03_clipit_site';
$futurabold = 'futuralt-bold';
$futuralt = 'futuralt';
?>
    @font-face {
    font-family: 'Futura';
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralt;?>.eot');
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralt;?>.eot') format('embedded-opentype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralt;?>.woff') format('woff'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralt;?>.ttf') format('truetype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralt;?>.svg#FuturaLTRegular') format('svg');
    }
    @font-face {
    font-family: 'FuturaBoldRegular';
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabold;?>.eot');
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabold;?>.eot') format('embedded-opentype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabold;?>.woff') format('woff'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabold;?>.ttf') format('truetype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabold;?>.svg#FuturaLTBold') format('svg');
    }
<?php
require($plugin_dir . '/bootstrap/less/clipit/clipit_base.min.css');