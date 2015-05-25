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
switch(get_config('clipit_site_type')){
    case ClipitSite::TYPE_SITE:
    case ClipitSite::TYPE_DEMO:
        $plugin_dir = elgg_get_plugins_path().'z03_clipit_site';
        break;
    case ClipitSite::TYPE_GLOBAL:
        $plugin_dir = elgg_get_plugins_path().'z03_clipit_global';
        break;
}

$plugin_url = elgg_get_site_url().'mod/z03_clipit_site';
$futurabold = 'futuralt-bold';
$futuralt = 'futuralt';
$futurabook = 'FuturaLT-Book';
$futuralight = 'FuturaLT-Light';
?>
    /* FontAwesome library load */
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
    <?php if(get_config('clipit_site_type') == ClipitSite::TYPE_GLOBAL):?>
    @font-face {
    font-family: 'FuturaBook';
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabook;?>.eot');
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabook;?>.eot') format('embedded-opentype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabook;?>.woff') format('woff'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabook;?>.ttf') format('truetype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futurabook;?>.svg#FuturaLTBold') format('svg');
    }
    @font-face {
    font-family: 'FuturaLight';
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralight;?>.eot');
    src: url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralight;?>.eot') format('embedded-opentype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralight;?>.woff') format('woff'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralight;?>.ttf') format('truetype'),
    url('<?php echo $plugin_url.'/bootstrap/fonts/'.$futuralight;?>.svg#FuturaLTBold') format('svg');
    }
    <?php endif;?>
<?php
require($plugin_dir . '/bootstrap/less/clipit/clipit_base.min.css');
