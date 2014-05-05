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

class ClipitLA extends UBFile{

    const SUBTYPE = "clipit_la";

    public $return_id = -1;
    public $status_code = -1;

    protected function load($elgg_object){
        parent::load($elgg_object);
        $this->return_id = (int)$elgg_object->return_id;
        $this->status_code = (int)$elgg_object->status_code;
    }

    /**
     * Saves this instance to the system
     * @param ElggFile $elgg_file Elgg file instance to save Item to
     */
    protected function copy_to_elgg($elgg_file){
        parent::copy_to_elgg($elgg_file);
        $elgg_file->return_id = $this->return_id;
        $elgg_file->status_code = $this->status_code;
    }

    static function send_metrics($returnId, $data, $statuscode){
        $la = new ClipitLA();
        $prop_value_array["return_id"] = (int)$returnId;
        $prop_value_array["data"] = $data;
        $prop_value_array["status_code"] = (int)$statuscode;
        $id = $la->save();
        ClipitLA::set_properties($id, $prop_value_array);
        return $id;
    }
}