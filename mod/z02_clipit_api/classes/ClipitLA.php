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
class ClipitLA extends UBFile {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitLA";
    public $return_id = 0;
    public $status_code = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggFile $elgg_file Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_file) {
        parent::load_from_elgg($elgg_file);
        $this->return_id = (int)$elgg_file->get("return_id");
        $this->status_code = (int)$elgg_file->get("status_code");
    }

    /**
     * Copy $this file parameters into an Elgg File entity.
     *
     * @param ElggFile $elgg_file Elgg object instance to save $this to
     */
    protected function save_to_elgg($elgg_file) {
        parent::save_to_elgg($elgg_file);
        $elgg_file->set("return_id", $this->return_id);
        $elgg_file->set("status_code", $this->status_code);
    }

    /*
     * @todo request_metrics function to ask the LA API for metrics
     */
    static function request_metrics($category, $type, $name) {
        $return_id = 0;
        return $return_id;
    }

    static function send_metrics($returnId, $data, $statuscode) {
        $la = new ClipitLA();
        $prop_value_array["return_id"] = (int)$returnId;
        $prop_value_array["data"] = $data;
        $prop_value_array["status_code"] = (int)$statuscode;
        $id = $la->save();
        ClipitLA::set_properties($id, $prop_value_array);
        return $id;
    }
}