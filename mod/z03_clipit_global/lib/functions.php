<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 4/02/14
 * Time: 10:44
 * To change this template use File | Settings | File Templates.
 */

function format_file_size($bytes) {
    $bytes = (int)$bytes;
    if ($bytes >= 1000000000) {
        return round(($bytes / 1000000000), 2) . ' GB';
    }
    if ($bytes >= 1000000) {
        return round(($bytes / 1000000), 2) . ' MB';
    }
    return round(($bytes / 1000), 2) . ' KB';
}

/**
 * Obtain friendly time (past|future)
 *
 * @param $time
 * @return mixed|null|string
 */
function get_friendly_time($time){
    $params = array('time' => $time);
    $result = elgg_trigger_plugin_hook('format', 'friendly:time', $params, NULL);
    if ($result) {
        return $result;
    }

    if(time() > (int) $time){
        // Ago
        $translate = "friendlytime";
        $diff = time() - (int)$time;
    } else {
        $translate = "friendlytime:next";
        $diff = (int)$time - time();
    }


    $minute = 60;
    $hour = $minute * 60;
    $day = $hour * 24;

    if ($diff < $minute) {
        return elgg_echo("$translate:justnow");
    } else if ($diff < $hour) {
        $diff = round($diff / $minute);
        if ($diff == 0) {
            $diff = 1;
        }

        if ($diff > 1) {
            return elgg_echo("$translate:minutes", array($diff));
        } else {
            return elgg_echo("$translate:minutes:singular", array($diff));
        }
    } else if ($diff < $day) {
        $diff = round($diff / $hour);
        if ($diff == 0) {
            $diff = 1;
        }

        if ($diff > 1) {
            return elgg_echo("$translate:hours", array($diff));
        } else {
            return elgg_echo("$translate:hours:singular", array($diff));
        }
    } else {
        $diff = round($diff / $day);
        if ($diff == 0) {
            $diff = 1;
        }

        if ($diff > 1) {
            return elgg_echo("$translate:days", array($diff));
        } else {
            return elgg_echo("$translate:days:singular", array($diff));
        }
    }
}

/**
 * Convert Hex Color to RGB
 *
 * @param $hex
 * @return array
 */
function hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
    //return implode(",", $rgb); // returns the rgb values separated by commas
    return $rgb; // returns an array with the rgb values
}
function clipit_events_feed($entity){
    $vars['author'] = array_pop(ClipitUser::get_by_id(array($entity->performed_by_guid)));
    $vars['time'] = $entity->time_created;
    $relationship = get_relationship($entity->object_id);
    $explode_relation = explode("-", $relationship->relationship);

    if($explode_relation[1] != 'group'){
        switch($explode_relation[1]){
            case 'file':
                $vars['icon'] = "upload";
                $vars['message'] = "Upload the file";
                $object = array_pop(ClipitFile::get_by_id(array($relationship->guid_two)));
                $vars['item']['name'] = $object->name;
                $vars['item']['description'] = $object->description;
                $vars['item']['icon'] = $object->description;
                break;
            case 'user':
                $vars['icon'] = "user";
                $vars['message'] = "Se ha unido al grupo";
                $object = array_pop(ClipitGroup::get_by_id(array($relationship->guid_one)));
                $vars['item']['name'] = $object->name;
                break;

        }
    }
    // Message system
    if($explode_relation[1] == 'destination'){
        $vars['icon'] = "comment";
        $vars['message'] = "Ha creado una discussión";
        $object = array_pop(ClipitMessage::get_by_id(array($relationship->guid_one)));
        $vars['item']['name'] = $object->name;
        $vars['item']['description'] = $object->description;

    }
    if(!isset($vars['item'])){
        return false;
    }
    return $vars;
}

function register_clipit_event($type, $callback){
    global $CONFIG;
    $CONFIG->feed_callbacks[$type] = $callback;
}
function load_clipit_event($event, $relationship){
    global $CONFIG;
    $args = array($event, $relationship);
    foreach($CONFIG->feed_callbacks as $type => $callback){
        if($type == $relationship->relationship){
            if (!is_callable($callback) && (call_user_func_array($callback, $args) === false)) {
                return false;
            } else {
                return call_user_func_array($callback, $args);
            }
        }

    }
}

function get_group_activity($event){
    $object_rel = get_relationship($event->object_id);
    $activity_id = ClipitGroup::get_activity($object_rel->guid_one);
    $explode_rel = explode("-", $object_rel->relationship);
    if (strpos($object_rel->relationship, "message") !== false) {
        $activity_id = ClipitGroup::get_activity($object_rel->guid_two);
    }
    if($explode_rel[0] == 'activity'){
        $activity_id = $object_rel->guid_one;
    }
    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
    return $activity;
}


/**
 * Forward to $location.
 *
 * @param $delimiter
 * @param null $to
 * @return string
 */
function custom_forward_referer($delimiter, $location = null){
    $referer = $_SERVER['HTTP_REFERER'];
    $path = explode($delimiter, $referer);
    if(strpos($referer, $delimiter) !== false){
        return $path[0] . $location;
    } else {
        return $referer;
    }

}

function clipit_get_offset(){
    return get_input("offset", 0);
}
function clipit_get_limit($limit = 15){
    return get_input("limit", $limit);
}
function clipit_get_pagination($params){
    $defaults = array(
        'offset' => clipit_get_offset(),
        'limit' => clipit_get_limit()
    );
    $params = array_merge($defaults, $params);
    return elgg_view("navigation/pagination", $params);
}
/**
 * Get all countries list names
 */
function get_countries_list($key = ''){
    $countries = array(
        ""   => elgg_echo('country:select'),
        "AF" => "Afghanistan",
        "AL" => "Albania",
        "DZ" => "Algeria",
        "AS" => "American Samoa",
        "AD" => "Andorra",
        "AO" => "Angola",
        "AI" => "Anguilla",
        "AQ" => "Antarctica",
        "AG" => "Antigua and Barbuda",
        "AR" => "Argentina",
        "AM" => "Armenia",
        "AW" => "Aruba",
        "AU" => "Australia",
        "AT" => "Austria",
        "AZ" => "Azerbaijan",
        "BS" => "Bahamas",
        "BH" => "Bahrain",
        "BD" => "Bangladesh",
        "BB" => "Barbados",
        "BY" => "Belarus",
        "BE" => "Belgium",
        "BZ" => "Belize",
        "BJ" => "Benin",
        "BM" => "Bermuda",
        "BT" => "Bhutan",
        "BO" => "Bolivia",
        "BA" => "Bosnia and Herzegovina",
        "BW" => "Botswana",
        "BV" => "Bouvet Island",
        "BR" => "Brazil",
        "BQ" => "British Antarctic Territory",
        "IO" => "British Indian Ocean Territory",
        "VG" => "British Virgin Islands",
        "BN" => "Brunei",
        "BG" => "Bulgaria",
        "BF" => "Burkina Faso",
        "BI" => "Burundi",
        "KH" => "Cambodia",
        "CM" => "Cameroon",
        "CA" => "Canada",
        "CT" => "Canton and Enderbury Islands",
        "CV" => "Cape Verde",
        "KY" => "Cayman Islands",
        "CF" => "Central African Republic",
        "TD" => "Chad",
        "CL" => "Chile",
        "CN" => "China",
        "CX" => "Christmas Island",
        "CC" => "Cocos [Keeling] Islands",
        "CO" => "Colombia",
        "KM" => "Comoros",
        "CG" => "Congo - Brazzaville",
        "CD" => "Congo - Kinshasa",
        "CK" => "Cook Islands",
        "CR" => "Costa Rica",
        "HR" => "Croatia",
        "CU" => "Cuba",
        "CY" => "Cyprus",
        "CZ" => "Czech Republic",
        "CI" => "Côte d’Ivoire",
        "DK" => "Denmark",
        "DJ" => "Djibouti",
        "DM" => "Dominica",
        "DO" => "Dominican Republic",
        "NQ" => "Dronning Maud Land",
        "DD" => "East Germany",
        "EC" => "Ecuador",
        "EG" => "Egypt",
        "SV" => "El Salvador",
        "GQ" => "Equatorial Guinea",
        "ER" => "Eritrea",
        "EE" => "Estonia",
        "ET" => "Ethiopia",
        "FK" => "Falkland Islands",
        "FO" => "Faroe Islands",
        "FJ" => "Fiji",
        "FI" => "Finland",
        "FR" => "France",
        "GF" => "French Guiana",
        "PF" => "French Polynesia",
        "TF" => "French Southern Territories",
        "FQ" => "French Southern and Antarctic Territories",
        "GA" => "Gabon",
        "GM" => "Gambia",
        "GE" => "Georgia",
        "DE" => "Germany",
        "GH" => "Ghana",
        "GI" => "Gibraltar",
        "GR" => "Greece",
        "GL" => "Greenland",
        "GD" => "Grenada",
        "GP" => "Guadeloupe",
        "GU" => "Guam",
        "GT" => "Guatemala",
        "GG" => "Guernsey",
        "GN" => "Guinea",
        "GW" => "Guinea-Bissau",
        "GY" => "Guyana",
        "HT" => "Haiti",
        "HM" => "Heard Island and McDonald Islands",
        "HN" => "Honduras",
        "HK" => "Hong Kong SAR China",
        "HU" => "Hungary",
        "IS" => "Iceland",
        "IN" => "India",
        "ID" => "Indonesia",
        "IR" => "Iran",
        "IQ" => "Iraq",
        "IE" => "Ireland",
        "IM" => "Isle of Man",
        "IL" => "Israel",
        "IT" => "Italy",
        "JM" => "Jamaica",
        "JP" => "Japan",
        "JE" => "Jersey",
        "JT" => "Johnston Island",
        "JO" => "Jordan",
        "KZ" => "Kazakhstan",
        "KE" => "Kenya",
        "KI" => "Kiribati",
        "KW" => "Kuwait",
        "KG" => "Kyrgyzstan",
        "LA" => "Laos",
        "LV" => "Latvia",
        "LB" => "Lebanon",
        "LS" => "Lesotho",
        "LR" => "Liberia",
        "LY" => "Libya",
        "LI" => "Liechtenstein",
        "LT" => "Lithuania",
        "LU" => "Luxembourg",
        "MO" => "Macau SAR China",
        "MK" => "Macedonia",
        "MG" => "Madagascar",
        "MW" => "Malawi",
        "MY" => "Malaysia",
        "MV" => "Maldives",
        "ML" => "Mali",
        "MT" => "Malta",
        "MH" => "Marshall Islands",
        "MQ" => "Martinique",
        "MR" => "Mauritania",
        "MU" => "Mauritius",
        "YT" => "Mayotte",
        "FX" => "Metropolitan France",
        "MX" => "Mexico",
        "FM" => "Micronesia",
        "MI" => "Midway Islands",
        "MD" => "Moldova",
        "MC" => "Monaco",
        "MN" => "Mongolia",
        "ME" => "Montenegro",
        "MS" => "Montserrat",
        "MA" => "Morocco",
        "MZ" => "Mozambique",
        "MM" => "Myanmar [Burma]",
        "NA" => "Namibia",
        "NR" => "Nauru",
        "NP" => "Nepal",
        "NL" => "Netherlands",
        "AN" => "Netherlands Antilles",
        "NT" => "Neutral Zone",
        "NC" => "New Caledonia",
        "NZ" => "New Zealand",
        "NI" => "Nicaragua",
        "NE" => "Niger",
        "NG" => "Nigeria",
        "NU" => "Niue",
        "NF" => "Norfolk Island",
        "KP" => "North Korea",
        "VD" => "North Vietnam",
        "MP" => "Northern Mariana Islands",
        "NO" => "Norway",
        "OM" => "Oman",
        "PC" => "Pacific Islands Trust Territory",
        "PK" => "Pakistan",
        "PW" => "Palau",
        "PS" => "Palestinian Territories",
        "PA" => "Panama",
        "PZ" => "Panama Canal Zone",
        "PG" => "Papua New Guinea",
        "PY" => "Paraguay",
        "YD" => "People's Democratic Republic of Yemen",
        "PE" => "Peru",
        "PH" => "Philippines",
        "PN" => "Pitcairn Islands",
        "PL" => "Poland",
        "PT" => "Portugal",
        "PR" => "Puerto Rico",
        "QA" => "Qatar",
        "RO" => "Romania",
        "RU" => "Russia",
        "RW" => "Rwanda",
        "RE" => "Réunion",
        "BL" => "Saint Barthélemy",
        "SH" => "Saint Helena",
        "KN" => "Saint Kitts and Nevis",
        "LC" => "Saint Lucia",
        "MF" => "Saint Martin",
        "PM" => "Saint Pierre and Miquelon",
        "VC" => "Saint Vincent and the Grenadines",
        "WS" => "Samoa",
        "SM" => "San Marino",
        "SA" => "Saudi Arabia",
        "SN" => "Senegal",
        "RS" => "Serbia",
        "CS" => "Serbia and Montenegro",
        "SC" => "Seychelles",
        "SL" => "Sierra Leone",
        "SG" => "Singapore",
        "SK" => "Slovakia",
        "SI" => "Slovenia",
        "SB" => "Solomon Islands",
        "SO" => "Somalia",
        "ZA" => "South Africa",
        "GS" => "South Georgia and the South Sandwich Islands",
        "KR" => "South Korea",
        "ES" => "Spain",
        "LK" => "Sri Lanka",
        "SD" => "Sudan",
        "SR" => "Suriname",
        "SJ" => "Svalbard and Jan Mayen",
        "SZ" => "Swaziland",
        "SE" => "Sweden",
        "CH" => "Switzerland",
        "SY" => "Syria",
        "ST" => "São Tomé and Príncipe",
        "TW" => "Taiwan",
        "TJ" => "Tajikistan",
        "TZ" => "Tanzania",
        "TH" => "Thailand",
        "TL" => "Timor-Leste",
        "TG" => "Togo",
        "TK" => "Tokelau",
        "TO" => "Tonga",
        "TT" => "Trinidad and Tobago",
        "TN" => "Tunisia",
        "TR" => "Turkey",
        "TM" => "Turkmenistan",
        "TC" => "Turks and Caicos Islands",
        "TV" => "Tuvalu",
        "UM" => "U.S. Minor Outlying Islands",
        "PU" => "U.S. Miscellaneous Pacific Islands",
        "VI" => "U.S. Virgin Islands",
        "UG" => "Uganda",
        "UA" => "Ukraine",
        "SU" => "Union of Soviet Socialist Republics",
        "AE" => "United Arab Emirates",
        "GB" => "United Kingdom",
        "US" => "United States",
        "ZZ" => "Unknown or Invalid Region",
        "UY" => "Uruguay",
        "UZ" => "Uzbekistan",
        "VU" => "Vanuatu",
        "VA" => "Vatican City",
        "VE" => "Venezuela",
        "VN" => "Vietnam",
        "WK" => "Wake Island",
        "WF" => "Wallis and Futuna",
        "EH" => "Western Sahara",
        "YE" => "Yemen",
        "ZM" => "Zambia",
        "ZW" => "Zimbabwe",
        "AX" => "Åland Islands",
    );
    $countries_code = array(
        'AF','AL','DZ','AS','AD','AO','AI','AQ','AG','AR','AM','AW','AU','AT','AZ','BS',
        'BH','BD','BB','BY','BE','BZ','BJ','BM','BT','BO','BA','BW','BV','BR','BQ','IO',
        'VG','BN','BG','BF','BI','KH','CM','CA','CT','CV','KY','CF','TD','CL','CN','CX',
        'CC','CO','KM','CG','CD','CK','CR','HR','CU','CY','CZ','CI','DK','DJ','DM','DO',
        'NQ','DD','EC','EG','SV','GQ','ER','EE','ET','FK','FO','FJ','FI','FR','GF','PF',
        'TF','FQ','GA','GM','GE','DE','GH','GI','GR','GL','GD','GP','GU','GT','GG','GN',
        'GW','GY','HT','HM','HN','HK','HU','IS','IN','ID','IR','IQ','IE','IM','IL','IT',
        'JM','JP','JE','JT','JO','KZ','KE','KI','KW','KG','LA','LV','LB','LS','LR','LY',
        'LI','LT','LU','MO','MK','MG','MW','MY','MV','ML','MT','MH','MQ','MR','MU','YT',
        'FX','MX','FM','MI','MD','MC','MN','ME','MS','MA','MZ','MM','NA','NR','NP','NL',
        'AN','NT','NC','NZ','NI','NE','NG','NU','NF','KP','VD','MP','NO','OM','PC','PK',
        'PW','PS','PA','PZ','PG','PY','YD','PE','PH','PN','PL','PT','PR','QA','RO','RU',
        'RW','RE','BL','SH','KN','LC','MF','PM','VC','WS','SM','SA','SN','RS','CS','SC',
        'SL','SG','SK','SI','SB','SO','ZA','GS','KR','ES','LK','SD','SR','SJ','SZ','SE',
        'CH','SY','ST','TW','TJ','TZ','TH','TL','TG','TK','TO','TT','TN','TR','TM','TC',
        'TV','UM','PU','VI','UG','UA','SU','AE','GB','US','ZZ','UY','UZ','VU','VA','VE',
        'VN','WK','WF','EH','YE','ZM','ZW','AX'
    );
    $countries = array("" => elgg_echo('country:select'));
    foreach($countries_code as $code){
        $countries[$code] = elgg_echo('country:'.$code);
    }
    $countries = array_change_key_case($countries);
    if($key){
        return $countries[$key];
    } else {
        return $countries;
    }
}