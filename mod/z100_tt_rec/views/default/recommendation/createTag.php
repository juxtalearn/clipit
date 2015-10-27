<?php
include_once("/var/www/clipit_master/engine/start.php");
$file_dir = elgg_get_plugins_path() . 'z100_tt_rec';
include($file_dir . "/resultFormats.php");
include($file_dir . "/phpSesame.php");

/**
 * Created by PhpStorm.
 * User: cs
 * Date: 28.09.15
 * Time: 12:16 */




 createTag();


function createTag()
{
    error_log("begin create");

    # read
    $query = ' PREFIX jxl:<http://www.juxtalearn.org/>
               PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
               PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>


               SELECT distinct ?label ?concept
               WHERE { ?concept rdfs:label ?label.
               FILTER(langMatches(lang(?label),"de")) }';

    $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
    $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', 'true');
    $output = $response->getRows();

    global $SESSION;

    if (isset($SESSION)) {
        $SESSION['user'] = array_pop(elgg_get_entities(array('guid'=>24)));
    }
    foreach ($output as $concept) {

        $valueArray['name'] = $concept['label'];
        $valueArray['owner_id'] = "1";
        $valueArray['ontologylink'] = "<" . $concept['concept']. ">";
        ClipitTag::create($valueArray);

    }

    error_log("finished");
}
