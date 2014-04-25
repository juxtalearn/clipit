<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$url = get_input('link-url');
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

    if(mb_strlen($body)>280){
        $body = substr($body, 0, 280)."...";
    }
    $output = array(
        'title' => $title,
//        'description' => str_replace(array("\n", "\r", "\t"), '', $body),
//        'description' => trim($body),
        'favicon' => $favicon,
        'url' => $url,
        'url_min' => $string_regex[2][0],
        'video_prev_url' => 'http://b.vimeocdn.com/ts/432/509/432509421_640.jpg'
    );
    echo json_encode($output);
}
die();