<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC JuxtaLearn Team
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 * @subpackage      clipit_api
 */

class ClipitPerformanceRating extends UBItem {

    const SUBTYPE = "ClipitPerformanceRating";

    public $performance_item = 0;
    public $star_rating = null;

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->performance_item = (int)$elgg_object->performance_item;
        $this->star_rating = (int)$elgg_object->star_rating;
    }

    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->performance_item = (int)$this->performance_item;
        $elgg_object->star_rating = (int)$this->star_rating;
    }

} 