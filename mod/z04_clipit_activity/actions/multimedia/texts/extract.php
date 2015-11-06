<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/10/2015
 * Last update:     16/10/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$url = get_input('q');

if(filter_var($url, FILTER_VALIDATE_URL)){
    $prex = '/\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i';
    preg_match_all($prex, $url, $string_regex, PREG_PATTERN_ORDER);

    // Favicon
    $favicon = "http://www.google.com/s2/favicons?domain={$string_regex[2][0]}";
    // DOMDocument
    $dom = new DOMDocument;
    $dom->loadHTMLFile($url);
    libxml_use_internal_errors(false);
    // Title
    $title = $dom->getElementsByTagName('title')->item(0);
    $title = trim($title->textContent);
    // Description
    // empty atm
    $body = $dom->getElementsByTagName('body')->item(0);
    $body = trim($body->textContent);

    if(mb_strlen($body)>150){
        $body = substr($body, 0, 150)."...";
    }
    $output = array(
        'title' => $title,
//        'description' => str_replace(array("\n", "\r", "\t"), '', $body),
//        'description' => trim($body),
        'favicon' => $favicon,
        'url' => $url,
        'url_min' => $string_regex[2][0],
        'image' => 'http://b.vimeocdn.com/ts/432/509/432509421_640.jpg'
    );
    $images = $dom->getElementsByTagName('img');
    foreach ($images as $image) {
        $src = $image->getAttribute('src');
        if(filter_var($src, FILTER_VALIDATE_URL)){
            list($width,$height) = getimagesize($src);
            if($width > 300 || $height > 300){
                $image_url[] =  $src;
            }
        }
    }
    ?>
    <div class="multimedia-block">
        <?php if(count($image_url) > 0):?>
        <div class="multimedia-preview">
            <div class="img-preview" style="
    width: 60px;
    height: 60px;
">
<!--                <img src="http://scottiestech.info/wp-content/uploads/2013/02/cookie_monster-300x254.jpg" style="width: 100%;">-->
                <img src="<?php echo $image_url[0];?>" style="width: 100%;">
            </div>
        </div>
        <?php endif;?>
        <div class="multimedia-details">
            <div class="pull-right margin-left-10">
                <a href="<?php echo $url;?>" target="_blank" class="btn btn-icon btn-primary" rel="nofollow"><i class="fa fa-external-link"></i></a>
            </div>
            <a href="<?php echo $url;?>" target="_blank" title="<?php echo $title;?>" class="text-truncate">
                <img src="<?php echo $favicon;?>" style="width: 16px;border-radius: 100%;display: none;">
                <strong><?php echo $title;?></strong>
            </a>
            <small class="show">
                <img src="<?php echo $favicon;?>" style="width: 16px;border-radius: 100%;vertical-align: text-bottom;background-color: #fff;">
                <?php echo $string_regex[2][0];?>
            </small>
            <p><?php echo trim($body);?></p>
        </div>
    </div>
    <?php
//    echo json_encode($output);
}
