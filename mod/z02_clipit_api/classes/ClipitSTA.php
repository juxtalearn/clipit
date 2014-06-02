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
class ClipitSTA extends ClipitFile{
    const SUBTYPE = "ClipitSTA";

    public $resource_url = "";
    public $tricky_topic = 0;

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->resource_url = (string)$elgg_object->get("resource_url");
        $this->tricky_topic = (int)$elgg_object->get("tricky_topic");
    }

    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->set("resource_url", (string)$this->resource_url);
        $elgg_object->set("tricky_topic", (int)$this->tricky_topic);
    }

}