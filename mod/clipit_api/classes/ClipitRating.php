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

/**
 * Class ClipitRating
 *
 */
class ClipitRating extends UBItem{
    /**
     * @const string Elgg entity subtype for this class
     */
    const SUBTYPE = "clipit_rating";

    public $target = 0;
    /**
     * @var int Overall rating opinionfrom 0 to 10
     */
    public $overall_rating = 0;
    /**
     * @var array Ratings in the form: rating_array["rating_name"]=>"rating_value"
     */
    public $rating_array = array();
    /**
     * @var array Comments about Tags used in target in the form: comment_array["comment_name"]=>"comment"
     */
    public $tag_comment_array = array();


    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->overall_rating = (int)$elgg_object->overall;
        $this->rating_array = (array)$elgg_object->rating_array;
        $this->tag_comment_array = (array)$elgg_object->tag_comment_array;
    }

    /**
     * @param ElggObject $elgg_object Elgg object instance to save Item to
     */
    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->overall_rating = (int)$this->overall_rating;
        $elgg_object->rating_array = (array)$this->rating_array;
        $elgg_object->tag_comment_array = (array)$this->tag_comment_array;
    }

}

