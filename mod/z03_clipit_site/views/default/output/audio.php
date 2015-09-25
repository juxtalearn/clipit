<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/09/2015
 * Last update:     18/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$src = elgg_extract('src', $vars);
$type = elgg_extract('type', $vars);
elgg_load_js('mediaelement');
?>
<script>
    $(document).ready(function() {
        if(!(/firefox/i.test(navigator.userAgent))) {
            $('audio').mediaelementplayer({
                alwaysShowControls: true,
                iPadUseNativeControls: false,
                // force iPhone's native controls
                iPhoneUseNativeControls: false,
                // force Android's native controls
                AndroidUseNativeControls: false,
                features: ['playpause','volume','progress','duration', 'current'],
                audioVolume: 'vertical'
            });
        }
    });
</script>
<div style="margin: 10px;position: relative;background: #fff;">
    <audio controls="controls" preload="auto" style="width: 100%" id="audio">
        <source src="<?php echo $src;?>" type="<?php echo $type;?>">
        Your Browser does not support the new HTML5 Audio-Tag
    </audio>
</div>
<div class="clearfix"></div>