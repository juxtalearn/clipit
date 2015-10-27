<?php

class RecommendationHelper
{


    public static function findClosestLabel($label, $language)
    {

//        error_log($label);
        $stemmedWords = array();
        $labelToStem = explode(" ", $label);

        if (count($labelToStem) > 1) {
            foreach ($labelToStem as $toStem) {
                $stemmed = PorterStemmer::Stem($toStem);
                array_push($stemmedWords, $stemmed);
            }
            $stemmedConcept = implode(" ", $stemmedWords);
        } else {
            $stemmedConcept = PorterStemmer::Stem($label);
        }

//        error_log($stemmedConcept);

        $query = ' PREFIX jxl:<http://www.juxtalearn.org/>
                   PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
                   PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>

                    SELECT distinct ?stemmedLabel ?concept
                    WHERE { ?concept <http://www.juxtalearn.org/stemmedName> ?stemmedLabel.
                           FILTER(langMatches(lang(?stemmedLabel),"' . $language . '") && regex(str(?stemmedLabel), "' . $stemmedConcept . '")) }';

        $store = RecommendationHelper::getNewSesameInstance();
        $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', 'true');
        $output = $response->getRows();
        //  error_log(print_r($response->getRows(), true));

        if (count($output) < 2 && count($output) > 0) {
            //error_log($output[0]);
            $closestConcept = $output[0]['comparelabel'];
        } elseif (count($output) < 2) {
            $minLev = 1000;
            foreach ($output as $possibleConcept) {
                $lev = levenshtein($stemmedConcept, $possibleConcept['stemmedLabel']);
                if ($lev < $minLev) {
                    $closestConcept = $possibleConcept['concept'];
                    $minLev = $lev;
                }
            }
        } else {
            # no matches found
        }

        return $closestConcept;

    }

    public static function checkOntology($label, $language)
    {

        $query = 'PREFIX jxl:<http://www.juxtalearn.org>
                  PREFIX ns0:<foaf:>
                  PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                  PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>

                  SELECT ?sb
             WHERE {?sb rdfs:label ?label.
             FILTER ((UCASE(str(?label)) = UCASE("' . $label . '")) && langMatches(lang(?label), "' . $language . '")) }';

        $store = RecommendationHelper::getNewSesameInstance();
        $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', 'true');

        if ($response->getRows() != NULL) {
            return true;
        } else {
            return false;
        }
    }

    public static function getNewSesameInstance()
    {
        $sesame_server = elgg_get_plugin_setting('sesameserver', 'z100_tt_rec');
        $store = new phpSesame("${sesame_server}/openrdf-sesame", "jxlstore_clean_Stem");
        return $store;
    }

    public static function checkOntologyCI($label, $language)
    {

        $returnArray = array();

        $query = 'PREFIX jxl:<http://www.juxtalearn.org/>
                  PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                  PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>

                  SELECT ?concept
                  WHERE {?concept rdfs:label ?label.
                  ?concept rdf:BelongsTo ?tt.
                  ?tt rdf:type <http://www.juxtalearn.org/Tricky_Topic>.
                  FILTER ((UCASE(str(?label)) = UCASE("' . $label . '")) && langMatches(lang(?label), "' . $language . '")) }';

        $store = RecommendationHelper::getNewSesameInstance();
        $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', 'true');

        $returnValues = $response->getRows();
        foreach ($returnValues as $returnValue) if (in_array($returnValue['concept'], $returnArray) == FALSE) {
            array_push($returnArray, $returnValue['concept']);
        }

        if ($response->getRows() != NULL) {
            return true;
        } else {
            return false;
        }
    }

    public static function normalizeValue($value, $min, $max)
    {

        if ($min == $max) {
            $normalized = 0;
            return $normalized;
        } else {
            $normalized = ($value - $min) / ($max - $min);
            if ($normalized != false) {
                return $normalized;
            } else {
                $normalized = 0;
                return $normalized;
            }
        }
    }


    public static function getAllTrickyTopicsClipIt($language)
    {

        $returnArray = array();

        $query = '  PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
                PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX jxl:<http://www.juxtalearn.org/>

                SELECT distinct ?concept ?tt
                WHERE{?concept rdf:BelongsTo ?tt.
                      ?concept rdfs:label ?label.
                      ?tt rdf:type <http://www.juxtalearn.org/Tricky_Topic>.
                      FILTER(langMatches(lang(?label), "' . $language . '"))
                      }';


        $store = RecommendationHelper::getNewSesameInstance();
        $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', 'true');
        $returnValues = $response->getRows();

        $strings = array();
        foreach ($returnValues as $output) {

            if ($output['tt'] != null && array_key_exists('<' . $output['concept'] . '>', $strings) == FALSE) {
                $strings[$output['tt']][] = '<' . $output['concept'] . '>';
            }
        }
        return $strings;
    }


    public static function getSBOntologyLink($label)
    {

        $allTagsArray = elgg_get_entities_from_metadata(
            array(
                'type' => CLipitTag::TYPE, 'subtype' => ClipitTag::SUBTYPE, 'metadata_names' => array("name"),
                'metadata_values' => array($label), 'limit' => 0
            )
        );

//    error_log(print_r($allTagsArray, true));


        foreach ($allTagsArray as $tagArray) {
            $ontologylink = $tagArray->ontologylink;
            return $ontologylink;
        }
    }

    public static function getConceptByLabel($label, $language)
    {
        $query = 'PREFIX jxl:<http://www.juxtalearn.org>
                PREFIX ns0:<foaf:>
                PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>

                SELECT ?concept
                WHERE{?concept rdfs:label ?label.
                FILTER ((UCASE(str(?label)) = UCASE("' . $label . '")) && langMatches(lang(?label), "' . $language . '")) }';


        $store = RecommendationHelper::getNewSesameInstance();
        $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', "true");

        $returnValue = $response->getRows();

        foreach ($returnValue as $value) {
            return '<' . $value['concept'] . '>';
        }
    }

    public static function getLabelByConcept($concept, $language)
    {


        if (strpos($concept, "<") === FALSE) {
            $concept = "<" . $concept . ">";
        }

        $query = 'PREFIX jxl:<http://www.juxtalearn.org>
                    PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                    PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>

                    SELECT ?label
                    WHERE{' . $concept . ' rdfs:label ?label.
                    FILTER(langMatches(lang(?label), "' . $language . '"))
                    }';

        // error_log($query);
        $store = RecommendationHelper::getNewSesameInstance();
        $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', "true");

        // error_log(print_r($response->getRows(), true));

        $returnValue = $response->getRows();
        return $returnValue[0]['label'];

    }

    public static function getLabelByConceptCI($concept, $language)
    {

        $allTags = ClipitTag::get_all();

        foreach ($allTags as $tags) {
            $tag = $tags->ontologylink;

            if (strcmp($tag, $concept) !== 0) {
            } else {
                $name = $tags->name;
            }
        }
        return $name;
    }

    public static function getSBID($label)
    {
        $allTagsArray = ClipitTag::get_all();
        foreach ($allTagsArray as $tagArray) {
            if ($tagArray->name == $label) {
                return $tagArray->id;
            }
        }
    }

    public static function getTeacherByConcept($concept)
    {

        $allTags = ClipitTag::get_all();

        foreach ($allTags as $tags) {
            $tag = $tags->ontologylink;


            if (strcmp($tag, $concept) !== 0) {
            } else {
                $id = $tags->owner_id;
            }
        }
        return $id;
    }

    public static function getSBOntologyLinkById($id)
    {
        $allTagsArray = ClipitTag::get_all();
        foreach ($allTagsArray as $tagArray) {
            if ($tagArray->id == $id) {
                $ontologylink = $tagArray->ontologylink;
//            $link = str_replace('<', '', $ontologylink);
//            $link = str_replace('>', '', $link);
                return $ontologylink;
            }
        }
    }

    public static function getStumblingBlockLabelById($id)
    {
        $SBname = ClipitTag::get_by_id(array($id));
        $name = $SBname[$id]->name;
        return $name;
    }

//
//    public static function getOntologyDistance ($conceptA, $conceptB, $language){
//        $resultArray = array();
//
//        $query = 'PREFIX jxl:<http://www.juxtalearn.org>
//                  PREFIX ns0:<foaf:>
//                  PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
//                  PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
//
//                  SELECT ?a ?b ?super (count(?midA) as ?pfadA) (count(?midB) as ?pfadB){
//                        values (?a ?b) { (' . $conceptA . ' ' . $conceptB . ' )}
//
//                        ?a rdf:type+ ?super.
//                        ?b rdf:type+ ?super.
//                        { ?a rdf:type+ ?midA.
//                        ?midA rdf:type+ ?super.} UNION {?a rdf:type ?super}
//                        { ?b rdf:type+ ?midB.
//                        ?midB rdf:type+ ?super. } UNION {?b rdf:type ?super}
//                        } group by ?a ?b ?super
//
//                        }';
//
//        $store = new phpSesame("http://192.168.1.21:8080/openrdf-sesame", "jxlstore_clean_Stem");
//        $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', "false");
//        $output = $response->getRows();
//
//        var_dump($output);
//
//
//    }

    public static function getSiblingsByParent($parent)
    {


        $parentsChilds = array();

        $query = '    PREFIX jxl:<http://www.juxtalearn.org>
                        PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                        PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
                        PREFIX sesame:<http://www.openrdf.org/schema/sesame#>

                        SELECT distinct ?children WHERE{
                        {?children sesame:directType <' . $parent . '> } UNION {?children sesame:directSubClassOf <' . $parent . '> }
                        }';

        $store = RecommendationHelper::getNewSesameInstance();
        $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', "true");
        $childrens = $response->getRows();

        foreach ($childrens as $children) {
            if (strpos($children['children'], "<") == FALSE) {
                array_push($parentsChilds, "<" . $children . ">");
            }
            array_push($parentsChilds, $children['children']);
        }
        return $parentsChilds;
    }


    public static function  getParentClass($concepts)
    {

        $listOfConcepts = "";
        $finalReturn = array();
        $finalQuery = "";
        $finalParentReturn = array();

        foreach ($concepts as $concept) {


            $newConcept = $concept . " sesame:directType ?parent. ";
            $listOfConcepts .= $newConcept;

        }
        $query = '        PREFIX jxl:<http://www.juxtalearn.org>
                        PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                        PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
                        PREFIX sesame:<http://www.openrdf.org/schema/sesame#>

                        SELECT distinct ?parent WHERE {
                        ' . $listOfConcepts . '  FILTER(?parent != <http://www.juxtalearn.org/Stumbling_Block> )}';

        $store = RecommendationHelper::getNewSesameInstance();
        $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', "true");
        $parents = $response->getRows();


        #überdenken != null
        if ($parents != null && empty($parents) == FALSE) {
            return $parents[0]['parent'];
//
//        if(strpos($parents[0]['parent'] , "<" ) == FALSE){
//            $parents[0]['parent'] = "<" . $parents[0]['parent'] . ">";
//        }else{
//            return $parents[0]['parent'];
//        }

        } else {

            $return = "";
            $countList = "";
            $conceptList = "";
            $directTypes = "";
            $directSubClass = "";
            $i = 1;
            foreach ($concepts as $concept) {

                $return .= " ?" . $i;
                $countList .= " (count(?mid" . $i . ") as ?pfad" . $i . ")";
                $conceptList .= $concept . " ";
                $valueList = "values (" . $return . ") {(" . $conceptList . ")}";
                $directTypes .= " ?" . $i . " sesame:directType ?super" . $i . ". {?super" . $i . " sesame:directSubClassOf+ ?super. FILTER(?super != rdfs:Class && ?super != rdfs:Resource && ?super != <http://www.juxtalearn.org/Domain_Concepts> && ?super != <http://www.juxtalearn.org/Stumbling_Block>)} UNION  {?super" . $i . " sesame:directType+ ?super. FILTER(?super != rdfs:Class && ?super != rdfs:Resource && ?super != <http://www.juxtalearn.org/Domain_Concepts> && ?super != <http://www.juxtalearn.org/Stumbling_Block>)}";
                $directSubClass .= "{?super" . $i . " sesame:directSubClassOf+ ?mid" . $i . ". ?mid" . $i . " sesame:directSubClassOf+ ?super. } UNION {?super" . $i . " sesame:directSubClassOf ?super} UNION {?super" . $i . " sesame:directType+ ?mid" . $i . ". ?mid" . $i . " sesame:directType+ ?super. } UNION {?super" . $i . " sesame:directType ?super} ";


                $queryprefix = 'PREFIX jxl:<http://www.juxtalearn.org>
                        PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                        PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>
                        PREFIX sesame:<http://www.openrdf.org/schema/sesame#>

                        SELECT distinct';

                $finalQuery = $queryprefix . " ?super " . $return . $countList . "{ " . $valueList . $directTypes . $directSubClass . " } group by " . $return . " ?super order by ASC (?pfad" . $i . ")";


                $i++;
            }
            $store = RecommendationHelper::getNewSesameInstance();
            $response = $store->query($finalQuery, phpSesame::SPARQL_XML, 'sparql', "true");
            $finalParents = $response->getRows();

            if ($finalParents != null && empty($finalParents) == FALSE) {

                return $finalParents[0]['super'];
//
//            if(strpos($finalParents[0]['super'] , "<" ) == FALSE){
//                $finalParents[0]['super'] = "<" . $finalParents[0]['super'] . ">";
//            }else {
//                return $finalParents[0]['super'];
//            }
            }
        }
    }


    public static function getOntologySiblings($concept, $language)
    {
        $resultArray = array();

        $query = 'PREFIX jxl:<http://www.juxtalearn.org>
                        PREFIX ns0:<foaf:>
                        PREFIX rdf:<http://www.w3.org/1999/02/22-rdf-syntax-ns#>
                        PREFIX rdfs:<http://www.w3.org/2000/01/rdf-schema#>

                        SELECT distinct ?sibling ?label ?parent
                        WHERE   {{' . $concept . ' rdfs:subClassOf ?parent.} UNION {' . $concept . ' rdf:type ?parent.}
                                {?sibling rdfs:subCLassOf ?parent} UNION {?sibling rdf:type ?parent}
                                ?sibling rdfs:label ?label.
                                FILTER(langMatches(lang(?label), "' . $language . '") && ?parent != <http://www.juxtalearn.org/Stumbling_Block>)} LIMIT 30';

        # evtl erweitern, dann aber die ausschließen, wo tricky topic das gemeinsame überthema ist

        $store = RecommendationHelper::getNewSesameInstance();
        $response = $store->query($query, phpSesame::SPARQL_XML, 'sparql', "false");
        $output = $response->getRows();


        foreach ($output as $outputItem) {
            if (empty($outputItem['sibling']) != true && $output != false && in_array($outputItem['sibling'], $resultArray) != true) {
                if (strpos($outputItem['sibling'], 'Stumbling_Block') == TRUE) {
                    if (strpos($concept, 'Stumbling_Block') == TRUE) {
                        array_push($resultArray, $outputItem['sibling']);
                    } else {
                    }
                } else {
                    array_push($resultArray, '<' . $outputItem['sibling'] . '>');
                }
            }
        }
        return $resultArray;
    }
}