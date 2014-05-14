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


/**
 * Get format file size
 *
 * @param int $size
 * @return string
 */
function formatFileSize( $bytes, $precision = 0) {
    $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    $e = floor(log($bytes)/log(1024));

    $output = sprintf("%.{$precision}f ".$s[$e], ($bytes/pow(1024, floor($e))));

    return $output;
}

/**
 * @param $id
 * @param $message_destination
 * @return mixed
 */
function get_text_from_quote($id, $message_destination){
    $post = array_pop(ClipitPost::get_by_destination(array($message_destination)));
    return $post[$id-1];
}

/**
 * @param $text_message
 * @return mixed
 */
function text_reference($text_message){
    if(preg_match('/(^|[^a-z0-9_])#([0-9_]+)/i', $text_message)){
        $prex = '/#([0-9_]+)/i';
        preg_match_all($prex, $text_message, $string_regex, PREG_PATTERN_ORDER);
        $string_regexs = $string_regex[1];
        foreach($string_regexs as $string){
            $text_message = preg_replace(
                "/\#$string\b/",
                '<strong class="quote-ref" data-quote-ref="'.$string.'">
                    <a class="btn">#'.$string.'</a>
                </strong>',
                $text_message);
        }


    }

    if(preg_match('/(^|[^a-z0-9_])@([a-z0-9_]+)/i',$text_message)){
        $prex = '/@([a-z0-9_]+)/i';
        preg_match_all($prex, $text_message, $string_regex, PREG_PATTERN_ORDER);
        $string_regexs = $string_regex[1];
        foreach($string_regexs as $string){
            /// OLD: "/(^|[^a-z0-9_])@".$string."/i"
            $user = array_pop(ClipitUser::get_by_login(array($string)));
            if(!empty($user)){
                $url_link = elgg_view('output/url', array(
                    'href'  => "profile/".$user->login,
                    'title' => "@".$user->login,
                    'text'  => $user->name,
                    'style' => 'border-radius:3px; background: #bae6f6;padding: 1px 5px;font-weight: bold;',
                ));
                $text_message = preg_replace("/\@".$user->login."\b/",'$1'.$url_link, $text_message);
            }
        }
    }
    return $text_message;
}

/**
 * URL video parser
 *
 * @param $url
 * @return array|bool
 */
function video_url_parser($url){
    if(!isset($url) || !filter_var($url, FILTER_VALIDATE_URL)){
        return false;
    }
    $video_patterns = array('#(((http://)?)|(^./))(((www.)?)|(^./))youtube\.com/watch[?]v=([^\[\]()<.,\s\n\t\r]+)#i'
    ,'#(((http://)?)|(^./))(((www.)?)|(^./))youtu\.be/([^\[\]()<.,\s\n\t\r]+)#i'
    ,'/(http:\/\/)(www\.)?(vimeo\.com\/groups)(.*)(\/videos\/)([0-9]*)/'
    ,'/(http:\/\/)(www\.)?(vimeo.com\/)([0-9]*)/');
    $parse_url = parse_url($url);
    $favicon_url_base = "http://www.google.com/s2/favicons?domain=";
    foreach($video_patterns as $video_pattern){
        if (preg_match($video_pattern, $url) > 0){
            // Youtube
            if (strpos($url, 'youtube.com') != false || strpos($url, 'youtu.be') != false) {
                preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
                $data = file_get_contents("http://gdata.youtube.com/feeds/api/videos/$matches[0]?v=2&alt=jsonc");
                $data = json_decode($data);
                $data = $data->data;
                $video_id = $matches[0];
                $output = array(
                    'id' => $data->id,
                    'url'   => 'http://www.youtube.com/watch?v='.$data->id,
                    'title' => $data->title,
                    'description' => $data->description,
                    'preview' => "http://i1.ytimg.com/vi/{$video_id}/mqdefault.jpg",
                    'duration'      => $data->duration,
                    'favicon'   => $favicon_url_base.$parse_url['host']
                );
            // Vimeo
            } else if (strpos($url, 'vimeo.com') != false) {
                preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=vimeo.com/)[^&\n]+#", $url, $matches);
                $data = file_get_contents("http://vimeo.com/api/v2/video/$matches[0].json");
                $data = array_pop(json_decode($data));
                $output = array(
                    'id' => $data->id,
                    'url'   => $data->url,
                    'title' => $data->title,
                    'description' => $data->description,
                    'preview' => $data->thumbnail_large,
                    'duration'      => $data->duration,
                    'favicon'   => $favicon_url_base.$parse_url['host']
                );
            }
        }
    }
    // Video Data output
    return $output;
}
function get_video_url_embed($url){
    if (strpos($url, 'youtube.com') != false || strpos($url, 'youtu.be') != false) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
        $embed_url = "//youtube.com/embed/".$matches[0];
    } else if (strpos($url, 'vimeo.com') != false) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=vimeo.com/)[^&\n]+#", $url, $matches);
        $embed_url = "//player.vimeo.com/video/".$matches[0];
    }
    return $embed_url;
}
/**
 * Get formated time
 * @param int $seconds
 * @return string (hh:mm:ss|mm:ss)
 */
function get_format_time(int $seconds){
    $time = gmdate("i:s", $seconds);
    if($seconds >=  3600){
        $time = gmdate("H:i:s", $seconds);
    }
    return $time;
}