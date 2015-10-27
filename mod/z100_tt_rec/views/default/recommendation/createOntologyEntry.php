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

#.post(elgg.get_site_url() +  'ajax/view/recommendation/createOntologyEntry', {action: 'createOntology', input: inputArray, trickyTopic: trickyTopic }, function (data, status) {

//if (isset($_POST['action']) && !empty($_POST['action'])) {
//    $action = $_POST['action'];
//    $inputs = $_POST['input'];
//    $trickyTopic = $_POST['trickyTopic'];
//
//    if (strcmp($action, "createOntology") == 0) {
//
//        $sbArray = array();
//
//        foreach ($inputs as $input) {
//            $UCinput = ucfirst($input);
//            array_push($sbArray, $UCinput);
//        }
//        createOntologyEntry($user, $userLanguage, $subject, $eduLevel, $sbArray, $trickyTopic);
//    }
//}
$user = elgg_extract('user', $vars);
$teacher = ClipitUser::get_by_id(array(24));
$mail = $user->email;
$allTTs = array_pop(ClipitTrickyTopic::get_by_owner(array(24)));


foreach ($allTTs as $TT) {
    $trickyTopic = $TT->name;
    $subj = $TT->subject;
    $eduLevel = $TT->education_level;
    $tags = $TT->tag_array;
    $sbArray = array();

    foreach ($tags as $tag){
        $tagObject = array_pop(ClipitTag::get_by_id(array($tag)));
        $sbArray[$tagObject->ontologylink] = $tagObject->name;
    }
    CreateOntoEntry::createOntologyEntry($mail, "de", $subj, $eduLevel, $trickyTopic, $sbArray);

}


//$data = fopen("/home/cs/Schreibtisch/tt.txt", "r");
//$i = 0;
//
//if($data){
//    while(($datarow = fgets($data)) !== false && $i <65 ) {
//
//        $re = "/(.+?) (.+?) (.+)\\[(.*)\\]/";
//        $bool = preg_match($re, $datarow, $matches);
//
//        if ($bool == 1){
//            $userLanguage = "en";
//            $subject = $matches[1];
//
//            $eduLevel = $matches[2];
//
//            $trickyTopic = $matches[3];
//
//            $stumblingBlockArray = explode(".", $matches[4]);
//
//
//            createOntologyEntry($userLanguage, $subject, $eduLevel, $trickyTopic, $stumblingBlockArray);
//            $i++;
//
//
//        }else{
//            error_log("preg_match failed");
//        }
//    }
//}
//fclose($data);

function createOntologyEntry($mail, $userLanguage, $subj, $eduLevel, $trickyTopic, $stumblingBlockArray)
{

    error_log("begin create");

    $teacher = '<http://www.juxtalearn.org/Teacher/' . $mail . '>';

    $ttNoSpaces = str_replace(' ', '_', $trickyTopic);
    $ttNoSpaces = str_replace('ä', 'ae', $ttNoSpaces);
    $ttNoSpaces = str_replace('ö', 'oe', $ttNoSpaces);
    $ttNoSpaces = str_replace('ü', 'ue', $ttNoSpaces);
    $ttNoSpaces = str_replace('ß', 'ss', $ttNoSpaces);

    $tt = '<http://www.juxtalearn.org/Tricky_Topic/' . $ttNoSpaces . '>';

    $uniqueId = uniqid();
    $ttunique = '<http://www.juxtalearn.org/Tricky_Topic/' . $ttNoSpaces . '/' . $uniqueId . '>';

    $educationalLevel = '<http://www.juxtalearn.org/Educational_Level/' . $eduLevel . '>';
    $subject = '<http://www.juxtalearn.org/Subject/' . $subj . '>';

    #check if a trickyTopic with the same label is already in the ontology:
    $trickyTopic_query = '   PREFIX jxl:<http://www.juxtalearn.org>
                            PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>

                            ASK {' . $tt . ' rdf:type jxl:Tricky_Topic}';


    $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
    $response_trickyTopic_query = $store->query($trickyTopic_query, phpSesame::SPARQL_XML, 'sparql', 'true');


    if ($response_trickyTopic_query->getRows() != TRUE) {

        $trickyTopic_update_1 = 'PREFIX jxl:<http://www.juxtalearn.org>
                                PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>

                                INSERT DATA{' . $tt . ' rdf:type <http://www.juxtalearn.org/Tricky_Topic>}';

        $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
        $response_trickyTopic_update_1 = $store->update($trickyTopic_update_1, phpSesame::SPARQL_XML, 'sparql', 'true');


        $trickyTopic_update_2 = 'PREFIX rdfs:<http://www.w3.or-abg/2000/01/rdf-schema#>

                                INSERT {' . $tt . ' rdfs:label "' . $trickyTopic . '"@' . $userLanguage . '} WHERE{}';

        $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
        $response_trickyTopic_update_2 = $store->update($trickyTopic_update_2, phpSesame::SPARQL_XML, 'sparql', 'true');

    }


    $update_query_input = 'PREFIX jxl:<http://www.juxtalearn.org/>
                               PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                               PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>

                            INSERT DATA {' . $ttunique . ' rdf:usedBy ' . $teacher . ';
                                                       rdf:type  ' . $tt . '.
                                                       rdf:type rdf:Bag.
                                                       rdf:type jxl:Tricky_Topic.
                                                       rdf:subject ' . $subject . '.
                                                       rdf:educationalLevel ' . $educationalLevel . '.}';


    $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
    $response_query_input = $store->update($update_query_input, phpSesame::SPARQL_XML, 'sparql', 'true');

    error_log("tt finished");

    foreach ($stumblingBlockArray as $stumblingBlockLink => $label) {

        error_log($stumblingBlockLink);
        error_log($label);
        if($label != ""){


            $sb_query = '   PREFIX jxl:<http://www.juxtalearn.org>
                       PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>

                       ASK {' . $stumblingBlockLink . ' rdfs:label ?a}';

            $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
            $response_sb_query = $store->query($sb_query, phpSesame::SPARQL_XML, 'sparql', 'true');



            if ($response_sb_query->getRows() != TRUE) {

                $sb1_query = '   PREFIX jxl:<http://www.juxtalearn.org>
                           PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>

                           INSERT DATA {' . $stumblingBlockLink . ' rdf:type <http://www.juxtalearn.org/Stumbling_Block>;
                                                            rdf:BelongsTo  ' . $ttunique . '.}';

                $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
                $response_sb1_query = $store->update($sb1_query, phpSesame::SPARQL_XML, 'sparql', 'true');


                $sb2_query = '   PREFIX jxl:<http://www.juxtalearn.org>
                           PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>

                           INSERT{' . $stumblingBlockLink . ' rdfs:label "' . $label . '"@' . $userLanguage . '} WHERE {}';

                $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
                $response_sb1_query = $store->update($sb2_query, phpSesame::SPARQL_XML, 'sparql', 'true');

            } else {
                $sb3_query = '   PREFIX jxl:<http://www.juxtalearn.org>
                           PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>

                           INSERT DATA {' . $stumblingBlockLink . ' rdf:type <http://www.juxtalearn.org/Stumbling_Block>;
                                                            rdf:BelongsTo  ' . $ttunique . '.}';

                $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
                $response_sb1_query = $store->update($sb3_query, phpSesame::SPARQL_XML, 'sparql', 'true');

            }
        }
    }


//
//
//    $finalStumblingBlockArray = array();
//    foreach ($stumblingBlockArray as $stumblingBlock) {
//
//        $sbNoSpaces = str_replace(' ', '_', $stumblingBlock);
//
//        $stemmedStumblingBlocks = array();
//        $stumblingBlocksToStem = explode(" ", $stumblingBlock);
//
//        foreach ($stumblingBlocksToStem as $toStem) {
//            $stemmed = PorterStemmer::Stem($toStem);
//            array_push($stemmedStumblingBlocks, $stemmed);
//        }
//        $s_stumblingBlock = implode(" ", $stemmedStumblingBlocks);
//
//        $stumblingBlock_query = 'PREFIX jxl:<http://www.juxtalearn.org/>
//                                 PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
//                                 PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
//
//                                 SELECT distinct ?stemmedLabel ?concept WHERE{?concept <http://www.juxtalearn.org/stemmedName> ?stemmedLabel.
//                                          FILTER (regex(UCASE(str(?stemmedLabel)), UCASE("' . $s_stumblingBlock . '")) &&
//                                          langMatches(lang(?stemmedLabel), "' . $userLanguage . '"))}';
//
//        $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
//        $response_stumblingBlock_query = $store->query($stumblingBlock_query, phpSesame::SPARQL_XML, 'sparql', 'true');
//        $output_response_stumblingBlock_query = $response_stumblingBlock_query->getRows();
//
//
//        if (count($output_response_stumblingBlock_query) < 2 && count($output_response_stumblingBlock_query) > 0) {
//            $finalStumblingBlock = $output_response_stumblingBlock_query[0]['concept'];
//        } else {
//            $minLev = 1000;
//            foreach ($output_response_stumblingBlock_query as $possibleSB) {
//                $lev = levenshtein($s_stumblingBlock, $possibleSB['stemmedLabel']);
//                if ($lev < $minLev) {
//                    $finalStumblingBlock = $possibleSB['concept'];
//                    $minLev = $lev;
//                }
//            }
//        }
//        if ($finalStumblingBlock != null) {
//            array_push($finalStumblingBlockArray, $finalStumblingBlock);
//        } else {
//            $concept['concept'] = "http://www.juxtalearn.org/Stumbling_Block/" . $sbNoSpaces ;
//            $concept['stemmedName'] = $s_stumblingBlock;
//            $concept['label'] = $sbNoSpaces;
//            array_push($finalStumblingBlockArray, $concept);
//        }
//    }
//
//    error_log(print_r($finalStumblingBlockArray, true));
//
//    foreach ($finalStumblingBlockArray as $finalSB) {
//        if(is_array($finalSB) != true){
//
//            $stumblingBlock_update_1_a = 'PREFIX jxl:<http://www.juxtalearn.org/>
//                                          PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
//
//                                          INSERT DATA{<' . $finalSB . '> rdf:type <http://www.juxtalearn.org/Stumbling_Block>;
//                                                                       rdf:BelongsTo ' . $ttunique . '}';
//
//
//            $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
//            $response_stumblingBlock_update_1 = $store->update($stumblingBlock_update_1_a, phpSesame::SPARQL_XML, 'sparql', 'true');
//            error_log("finished SB 1a");
//
//
//        }else{
//
//            $stumblingBlock_update_1_b = 'PREFIX jxl:<http://www.juxtalearn.org/>
//                                          PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
//
//                                          INSERT DATA {<' . $finalSB['concept'] . '> rdf:type <http://www.juxtalearn.org/Stumbling_Block>;
//                                                                                    rdf:BelongsTo ' . $ttunique . '.}';
//
//
//            $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
//            $response_stumblingBlock_update_1 = $store->update($stumblingBlock_update_1_b, phpSesame::SPARQL_XML, 'sparql', 'true');
//            error_log("finished SB 1b");
//            error_log($stumblingBlock_update_1_b);
//
//
//
//            $stumblingBlock_update_1_c = 'PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
//                                            PREFIX jxl:<http://www.juxtalearn.org/>
//
//                                          INSERT {<' . $finalSB['concept'] . '> rdfs:label "' . $finalSB['label'] . '"@en.} WHERE{}';
//
//
//            $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
//            $response_stumblingBlock_update_2 = $store->update($stumblingBlock_update_1_c, phpSesame::SPARQL_XML, 'sparql', 'true');
//
//            error_log("finished SB 1c");
//            error_log($stumblingBlock_update_1_c);
//
//            $stumblingBlock_update_1_d = 'PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
//                                            PREFIX jxl:<http://www.juxtalearn.org/>
//
//                                          INSERT {<' . $finalSB['concept'] . '>  <http://www.juxtalearn.org/stemmedName>  "' . $finalSB['stemmedName'] . '"@en.} WHERE{}';
//
//
//            $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
//            $response_stumblingBlock_update_2 = $store->update($stumblingBlock_update_1_d, phpSesame::SPARQL_XML, 'sparql', 'true');
//            error_log("finished SB 1d");
//            error_log($stumblingBlock_update_1_d);
//
//        }
//
//    }


}
