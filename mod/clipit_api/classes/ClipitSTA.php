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
 * Class ClipitSTA
 *
 */
class ClipitSTA extends UBFile{
    const SUBTYPE = "clipit_sta";

    public $resource_url = "";
    public $tricky_topic = 0;
    public $tag_array = array();

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->resource_url = (string)$elgg_object->resource_url;
        $this->tricky_topic = (int)$elgg_object->tricky_topic;
        $this->tag_array = (array)$elgg_object->tag_array;
    }

    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->resource_url = (string)$this->resource_url;
        $elgg_object->tricky_topic = (int)$this->tricky_topic;
        $elgg_object->tag_array = (array)$this->tag_array;
    }

}