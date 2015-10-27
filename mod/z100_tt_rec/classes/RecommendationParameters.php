<?php

class RecommendationParameters
{

    public static function addLevenshteinParameter($parameters, $resultArray, $min, $max){



        foreach ($parameters as $key=>$parameter) {

            $actualLeven = $parameter;
            //error_log($parameter);

            $normalized = RecommendationHelper::normalizeValue($actualLeven, $min, $max);
            //error_log($normalized);
            $invertedNormalized = 1.5-$normalized;
            $resultArray[ $key ]['leven'] = 2*$invertedNormalized;
        }
        return $resultArray;
    }


    public static function addOwnerParameter($parameters, $resultArray){
        foreach ($parameters as $parameter){
            if(array_key_exists($parameter, $resultArray) == FALSE) {

                # at the moment represented by fixed value, could be changed to dynamic?
                $resultArray[$parameter]['owner'] = 0.1;
            }
        }
        return $resultArray;
    }

    public static function addStringLengthParameter($parameters, $min, $max){

        foreach($parameters as $key => $value){

            $normalized = RecommendationHelper::normalizeValue(strlen($key), $min, $max);
            $invertedNormalized = 0.05-($normalized/10);
            if ($invertedNormalized > 0){
                $parameters[$key]['stringlenght'] = $invertedNormalized;
            }
        }

        return $parameters;


    }

    public static function addParentsChildParameter($siblings, $resultArray){

        if (empty($siblings) == FALSE) {
            foreach ($siblings as $sibling){
                $resultArray[$sibling]['SiblingByParent'] = 0.5;
            }
        }
        return $resultArray;
    }



    public static function addOntologyRelationParameter($parameters, $resultArray){

        if (empty($parameters) == FALSE) {
            foreach ($parameters as $parameter){
                # vary value depending on distance in graph structure!!!!

                # at the moment represented by fixed value, could be changed to dynamic depending on the path lenght of the relationship
                $resultArray[$parameter]['Ontology'] = 0.5;
            }
        }
        return $resultArray;
    }


    public static function addTrickyTopicCountParameter($parameters, $resultArray, $min, $max){

        foreach ($parameters as $key=>$value) {

            $actualCount = $parameters[$key];
            $normalized = RecommendationHelper::normalizeValue($actualCount, $min, $max);
            $resultArray[ $key]['count'] = $normalized/2;
        }
        return $resultArray;
    }


    public static function sumParameters($resultArray){

        foreach ($resultArray as $key=>$array){
            $sum = 0;
            foreach ($array as $value){
                $sum += $value;
            }
            $resultArray[$key]['sum'] = $sum;
        }
        return $resultArray;
    }

}