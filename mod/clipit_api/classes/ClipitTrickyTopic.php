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
 * Class ClipitTrickyTopic
 *
 */
class ClipitTrickyTopic extends UBItem{
    const SUBTYPE = "clipit_trickytopic";

    public $country = "";

    public $tag_array = array();


    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->country = (bool)$elgg_object->country;
        $this->tag_array = (bool)$elgg_object->tag_array;
    }

    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->country = (bool)$this->country;
        $elgg_object->tag_array = (bool)$this->tag_array;
    }
}