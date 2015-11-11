<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/04/14
 * Last update:     28/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
// Get the guid

if($file_id = get_input("id")) {
    if ($task_id = get_input('task_id')) {
        ClipitFile::set_read_status($file_id, true, array(elgg_get_logged_in_user_guid()));
    }
    $file = array_pop(ClipitFile::get_by_id(array($file_id)));
    $file_name = $file->name;
    $file_name = ClipitFile::sanitize_filename($file->name);

    if(!empty($file->mime_ext)){
        $file_name .= '.' . $file->mime_ext;
    }
    $file_path = $file->file_path;
    // Audio files, not buffer content
    if(strpos($file->mime_full, 'audio/') !== false){
        $fp = @fopen($file_path, 'rb');
        $size   = filesize($file_path); // File size
        $length = $size;           // Content length
        $start  = 0;               // Start byte
        $end    = $size - 1;
        header("Content-Disposition: attachment; filename=\"$file_name\"");
        header("Content-Type: ". $file->mime_full);
        if (isset($_SERVER['HTTP_RANGE'])) {
            $c_start = $start;
            $c_end   = $end;
            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }
            if ($range == '-') {
                $c_start = $size - substr($range, 1);
            }else{
                $range  = explode('-', $range);
                $c_start = $range[0];
                $c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
            }
            $c_end = ($c_end > $end) ? $end : $c_end;
            if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $start-$end/$size");
                exit;
            }
            $start  = $c_start;
            $end    = $c_end;
            $length = $end - $start + 1;
            fseek($fp, $start);
            header('HTTP/1.1 206 Partial Content');
        }
        header("Content-Range: bytes $start-$end/$size");
        header("Content-Length: ".$length);
        $buffer = 1024 * 8;
        while(!feof($fp) && ($p = ftell($fp)) <= $end) {
            if ($p + $buffer > $end) {
                $buffer = $end - $p + 1;
            }
            set_time_limit(0);
            echo fread($fp, $buffer);
            flush();
        }
        fclose($fp);
        exit();
    }

} elseif($entity_id = get_input('entity_id')){
    $object = ClipitSite::lookup($entity_id);
    // Trigger hook
    $file_download = elgg_trigger_plugin_hook('file:download', 'file', array(
        'entity_id' => $entity_id,
        'entity_class' => $object['subtype']
    ), null);
    $file_path = $file_download['path'];
    $file_name = $file_download['name'];
}

if($file_path) {
    header("Pragma: public");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename=\"$file_name\"");
    ob_clean();
    flush();
    readfile($file_path);
    exit;
}