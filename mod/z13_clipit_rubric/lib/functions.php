<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/06/2015
 * Last update:     23/06/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
function rubric_filter_search($query){
    $item_ids = array();
    $query_ar = json_decode($query);
    foreach($query_ar as $s => $value){
        switch($s){
            case 'name':
                $item_search = array();
                $rubrics = ClipitRubric::get_from_search($value);
                foreach ($rubrics as $rubric) {
                    $item_ids[] = $rubric->id;
                }
                break;
            case 'author':
                $item_search = array();
                $authors = ClipitUser::get_from_search($value);
                foreach ($authors as $author) {
                    foreach(array_pop(ClipitRubric::get_by_owner(array($author->id))) as $rubric){
                        $item_search[] = $rubric->id;
                    }
                }
                if(empty($item_ids)) {
                    $item_ids = array_merge($item_ids, $item_search);
                } else {
                    $item_ids = array_intersect($item_ids, $item_search);
                }
                break;
        }
    }
    return $item_ids;
}