<?php

/**
 * Created by PhpStorm.
 * User: cs
 * Date: 23.10.15
 * Time: 14:43
 */




class CreateOntoEntry
{
    public static function createOntologyEntry($mail, $userLanguage, $subj, $eduLevel, $trickyTopic, $stumblingBlockArray)
    {

        error_log("begin create");

        $teacher = '<http://www.juxtalearn.org/Teacher/' . $mail . '>';

        $ttNoSpaces = str_replace(' ', '_', $trickyTopic);
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
    }
}