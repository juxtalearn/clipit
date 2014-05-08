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

class ClipitPost extends UBMessage{
    const SUBTYPE = "clipit_post";

    public $topic_id = 0;

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->topic_id = (int)$elgg_object->topic_id;
    }

    /**
     * @param ElggObject $elgg_object Elgg object instance to save Item to
     */
    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->topic_id = $this->topic_id;
    }

} 