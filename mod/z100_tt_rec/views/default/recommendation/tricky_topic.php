<?php

# include path for sparql queries
$file_dir = elgg_get_plugins_path() . 'z100_tt_rec';
include($file_dir . "/resultFormats.php");
include($file_dir . "/phpSesame.php");


# request user data
$user = elgg_extract('user', $vars);
//var_dump($user);
$userName = $user->name;
$userId = $user->guid;
$userLanguage = $user->language;


# handle incoming requests
if (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    $inputs = $_POST['input'];

    $sbArray = array();

    if (strcmp($action, "getRecommendation") == 0) {

#for Stumbling Blocks
//        $object = array_pop(ClipitTag::get_by_id(array(52718)));
//        $link = "<http://www.juxtalearn.org/Stumbling_Block/Funktionsbegriff>";
//        $object->ontologylink=$link;
//        error_log($object->ontologylink);
//        $object->save();

#for Tricky Topics
//        $object = array_pop(ClipitTrickyTopic::get_by_id(array(18746)));
//        $link = "<http://www.juxtalearn.org/Tricky_Topic/ChemieTopic/55dd8526923a7>";
//        var_dump("* $object->ontologylink *");
//
//        $object->ontologylink=$link;
//        var_dump($object->ontologylink);
//        $object->save();

        $sbArray = array();

        foreach ($inputs as $input) {
            $UCinput = ucfirst($input);
            array_push($sbArray, $UCinput);
        }

//        $teacher = ClipitUser::get_by_id(array(24));
//        error_log(print_r($teacher, true));
//        $mail = $user->email;
//        $allTTs = array_pop(ClipitTrickyTopic::get_by_owner(array(24)));
//
//        foreach ($allTTs as $tt) {
//            error_log(print_r($tt->name, true));
//            $tagArray = $tt->tag_array;
//            foreach($tagArray as $tag){
////                error_log(print_r($tag, true));
//                $object =  array_pop(ClipitTag::get_by_id(array($tag)));
//                error_log(print_r($object->ontologylink,true));
//            }
//
//        }





//            foreach ($allTTs as $TT) {
//                $trickyTopic = $TT->name;
//                $subj = $TT->subject;
//                $eduLevel = $TT->education_level;
//                $tags = $TT->tag_array;
//                $sbArray = array();
//
//                foreach ($tags as $tag){
//                    $tagObject = array_pop(ClipitTag::get_by_id(array($tag)));
//                    $sbArray[$tagObject->ontologylink] = $tagObject->name;
//                }
//                CreateOntoEntry::createOntologyEntry($mail, "de", $subj, $eduLevel, $trickyTopic, $sbArray);
//
//            }



        recommend($userId, $userLanguage, $sbArray);
    }
}


function recommend($userId, $language, $stumblingBlockArray)
{
    $RecommendationList = array();
    $FinalRecommendationList = array();
    $ListForLevenshtein = array();
    $ListForOntology = array();
    $ResultListOntology = array();

    #are input fields empty?
    if (empty($stumblingBlockArray[0])) {
        echo "Keine Eingabe.<br />";
        return;
    } else {

        foreach ($stumblingBlockArray as $sb) {

            #can label be found in the ontology (in language the user selected)?
            if (RecommendationHelper::checkOntology($sb, $language) == FALSE) {


            } else {

                #has label been stated as a clip it tricky topic before?
                if (RecommendationHelper::checkOntologyCI($sb, $language) == TRUE) {
                    #at this point Stumbling block is already in Ontology and Clip It

                    #get the ontologylink and turn label into concept
                    if (RecommendationHelper::getSBOntologyLink($sb) != FALSE) {
                        $ontologylink = RecommendationHelper::getSBOntologyLink($sb);


                        if(in_array($ontologylink, $ListForLevenshtein) == FALSE){
                            array_push($ListForLevenshtein, $ontologylink);

                        }
                        if(in_array($ontologylink, $ListForOntology) == FALSE){
                            array_push($ListForOntology, $ontologylink);
                        }


                    } else {
                        #if concept cannot be found via cliptit, check in ontology, maybe ontolink is wrong
                        $concept = RecommendationHelper::getConceptByLabel($sb, $language);
                        if(in_array($concept, $ListForLevenshtein) == FALSE){
                            array_push($ListForLevenshtein, $concept);
                        }
                        if(in_array($concept,$ListForOntology) == FALSE){
                            array_push($ListForOntology, $concept);
                        }
                    }
                } else {
                    #label is fount in Onto but is not a ClipIt Stumbling Block
                    $ontoConcept = RecommendationHelper::getConceptByLabel($sb, $language);
                    if(in_array($ontoConcept, $ListForOntology) == FALSE){
                        array_push($ListForOntology, $ontoConcept);
                    }
                }
            }
        }

//        error_log("onto" . print_r($ListForOntology, true));
//        error_log("levensh" . print_r($ListForLevenshtein, true));
        $ResultListOntology = array();


        if(count($ListForOntology)> 1) {
            $parent = RecommendationHelper::getParentClass($ListForOntology);
            if($parent != "" && $parent != null){
//                error_log("parent" .  print_r($parent, true));
                $siblings = RecommendationHelper::getSiblingsByParent($parent, $language);
//                error_log("siblings", print_r($siblings, true));
//                $RecommendationList = RecommendationParameters::addParentsChildParameter($siblings, $ResultListOntology);
            }else{
//                foreach ($ListForOntology as $item) {
//                    $ResultListOntology = RecommendationHelper::getOntologySiblings($item, $language);
//                }
//                $RecommendationList = RecommendationParameters::addOntologyRelationParameter($ResultListOntology, $RecommendationList);
            }



        }elseif(count($ListForOntology) == 1){

            # get some siblings from the ontology (closely related concepts)

            foreach ($ListForOntology as $item) {
                $ResultListOntology = RecommendationHelper::getOntologySiblings($item, $language);
            }
                $RecommendationList = RecommendationParameters::addOntologyRelationParameter($ResultListOntology, $RecommendationList);

        }



                $allTrickyTopicsSet = RecommendationHelper::getAllTrickyTopicsClipIt($language);

                # muss noch prüfen, ob im tricky topic eine der eingaben überhaupt vorhanden ist

                $allTrickyTopics = array();


                foreach($allTrickyTopicsSet as $keyTT => $valueTT) {

                    foreach ($ListForLevenshtein as $ListForLevenshteinItem) {
                        if ($ListForLevenshteinItem != null && count($valueTT) > 0) {
                            if (in_array($ListForLevenshteinItem, $valueTT) != false) {
                                $allTrickyTopics[$keyTT] = $valueTT;
                            }
                        }
                    }
                }

                #find out, if any topic is used by the owner himself in other tricky topics
//        $ownerTopics = array();
//        $ownstrings = ClipitTag::get_by_owner(array($userId));
//        foreach ($ownstrings as $ownstring){
//            foreach ($ownstring as $own){
//                array_push($ownerTopics, $own->ontologylink);
//            }
//        }

//        if(empty($ListForLevenshtein) == FALSE) {
//            #adds owner parameter to arraylist
//            $RecommendationList = RecommendationParameters::addOwnerParameter($ownerTopics, $RecommendationList);
//        }

                $min = 0;
                $max_freq = 1;
                $countList = array();

                #sets a min and a max number of counts (total number of appearances in any tricky topic) for normalization
                foreach ($allTrickyTopics as $values) {

                    foreach ($values as $value) {
                        if (array_key_exists($value, $countList) == TRUE) {
                            $count = $countList[$value];
                            $countList[$value] = $count+1;
                            if ($count+1 > $max_freq) {
                                $max_freq = $count+1;
                            }
                        }else{
                            $countList[$value] = 1;
                        }
                    }
                }


                if(empty($ListForLevenshtein) == FALSE) {
                    #adds count parameter to arraylist
                    $RecommendationList = RecommendationParameters::addTrickyTopicCountParameter($countList, $RecommendationList, $min, $max_freq);
                }



                #definition of levenshtein values (costs for replace, insert and delete)
                $costReplace = 2;
                $costInsert = 1;
                $costDelete = 1;

                $levenMax = 0;
                $levenMin = 1000000000;
                $levenList = array();

                foreach ($allTrickyTopics as $string) {

                    #sorts values in array sets -> arrangement should not influence rating
                    sort($string, SORT_STRING);
                    sort($ListForLevenshtein, SORT_STRING);

                    #calculates the levenshtein value
                    $leven = LevenshteinCalculation::levArray($ListForLevenshtein, $string, $costReplace, $costInsert, $costDelete);

                    foreach ($string as $stringitem) {

                        if ($leven > $levenMax) {
                            $levenMax = $leven;
                        } elseif ($leven < $levenMin) {
                            $levenMin = $leven;
                        }
                        if(array_key_exists($stringitem, $levenList) != true){
                            $levenList[$stringitem] = $leven;
                        }
                    }
                }

                if(empty($ListForLevenshtein) == FALSE) {
                    #adds levenshtein parameter to arraylist
                    $RecommendationList = RecommendationParameters::addLevenshteinParameter($levenList, $RecommendationList, $levenMin, $levenMax);
                }
            }

            #preperation for calculation of stringlength value
            $minLength = 100000;
            $maxLength = 0;
            foreach ($RecommendationList as $key => $value) {

                if(strlen($key) > $maxLength){
                    $maxLength = strlen($key);
                }elseif(strlen($key) < $minLength){
                    $minLength = strlen($key);
                }
            }

            $RecommendationList = RecommendationParameters::addStringLengthParameter($RecommendationList, $minLength, $maxLength);

            #adds the summed up paramter
            $RecommendationList = RecommendationParameters::sumParameters($RecommendationList);

            #Sort final Array by the sum of its parameter values
            uasort($RecommendationList, function($a, $b){
                return ($a['sum'] > $b['sum']) ? -1 : 1;
            });


            // error_log(print_r($RecommendationList, true));

            #select the first 20 array values to transfer and turn concepts into labels
            $i = 0;
            foreach ($RecommendationList as $key => $value) {
                if ($i < 15 && is_null($key) == FALSE) {



                    if (in_array($key, $ListForLevenshtein) == FALSE && in_array($key, $ListForOntology) == FALSE) {

                        $recomm = new stdClass();
                        $recomm->label = RecommendationHelper::getLabelByConcept($key, $language);
                        $recomm->rank = $value['sum'];
                        $recomm->key = $key;
                        $FinalRecommendationList[$i] = $recomm;
                        $i++;
                    }
                } else {
                    break;
                }
            }


//    error_log("recommendationlist" . print_r($RecommendationList, true));
//    if (empty($recommendationList) == TRUE){
//
//        //TODO put in language files
//        if(strcmp($language, "en") == 0){
//            $finalRecommendationList = "No recommendations available";
//
//        }elseif(strcmp($language, "de") == 0){
//            $finalRecommendationList = "Keine Empfehlungen vorhanden";
//
//        }elseif(strcmp($language, "es") == 0){
//            $finalRecommendationList  = "No hay recomendaciones disponibles";
//
//        }elseif(strcmp($language, "sv") == 0){
//            $finalRecommendationList  = "Inga rekommendationer tillgängliga";
//
//        }elseif(strcmp($language, "pt") == 0){
//            $finalRecommendationList  = "Nao há recomendacoes disponíveis";
//        }
//    }


            //  error_log(print_r($FinalRecommendationList, true));
            # wraps final array
            echo json_encode($FinalRecommendationList);

        }


