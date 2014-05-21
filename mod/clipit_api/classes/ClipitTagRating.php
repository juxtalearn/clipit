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

class ClipitTagRating extends UBItem {

    const SUBTYPE = "ClipitTagRating";

    public $tag_id = 0;
    public $is_used = null;

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->tag_id = (int)$elgg_object->tag_id;
        $this->is_used = (bool)$elgg_object->is_used;
    }

    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->tag_id = (int)$this->tag_id;
        $elgg_object->is_used = (bool)$this->is_used;
    }
}