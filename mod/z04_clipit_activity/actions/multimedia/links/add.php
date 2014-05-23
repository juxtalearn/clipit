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
$url = get_input('web-url');
if(filter_var($url, FILTER_VALIDATE_URL)){
    $prex = '/\b(https?):\/\/([\-A-Z0-9.]+)(\/[\-A-Z0-9+&@#\/%=~_|!:,.;]*)?(\?[A-Z0-9+&@#\/%=~_|!:,.;]*)?/i';
    preg_match_all($prex, $url, $string_regex, PREG_PATTERN_ORDER);
    print_r($string_regex);

    $metatags = get_meta_tags($url);
    // Title
    $string = file_get_contents($url);
    $title_regex = "/<title>(.*?)<\/title>/si";
    preg_match_all($title_regex, $string, $title, PREG_PATTERN_ORDER);
    $url_title = $title[1];
    if(trim($url_title[0]) == ""){ $url_title[0] = $string_regex[0][0]; }
    echo $url_title[0];
    // Description
    $description = $metatags['description'];
    if(trim($description) == ""){
        $description = "Sin descripcion disponible";
    }
    echo $description;
    // favicon
    echo "<img src='http://www.google.com/s2/favicons?domain={$string_regex[2][0]}'>";

    //////
    $xml = simplexml_load_string($string);
    echo "\n\n";
    // Title
    $title = $xml->head->title;

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
    $body = $dom->getElementsByTagName('body')->item(0);
    $body = trim($body->textContent);
    if(mb_strlen($body)>280){
        $body = substr($body, 0, 280)."...";
    }
    $output = array(
        'title' => $title,
        'description' => $body,
        'favicon' => $favicon
    );
    print_r(json_encode($output));
}
die();