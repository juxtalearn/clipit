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
 * Learning Analytics instance and interface class, for working with the external Learning Analytics Toolkit.
 */
class ClipitLA extends UBFile {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitLA";
    public $return_id = 0;
    public $status_code = 0;
    public $metric_received = false;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggFile $elgg_file Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_file) {
        parent::copy_from_elgg($elgg_file);
        $this->return_id = (int)$elgg_file->get("return_id");
        $this->status_code = (int)$elgg_file->get("status_code");
        $this->metric_received = (bool)$elgg_file->get("metric_received");
    }

    /**
     * Copy $this file parameters into an Elgg File entity.
     *
     * @param ElggFile $elgg_file Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_file) {
        parent::copy_to_elgg($elgg_file);
        $elgg_file->set("return_id", $this->return_id);
        $elgg_file->set("status_code", $this->status_code);
        $elgg_file->set("metric_received", $this->metric_received);
    }

    /*
     */
    static function get_metric($metric_id, $context) {
        $la_id = new static();
        set_config('la_metrics_class', "ActivityStreamer", elgg_get_site_entity()->getGUID());
        set_config('recommendations_class', "RecommendationEngine", elgg_get_site_entity()->getGUID());
//        $la_metrics_class = elgg_get_config("la_metrics_class");
//        $la_metrics_class::get_metric($metric_id, $la_id, $context);
        return $la_id;
    }

    static function save_metric($return_id, $data, $status_code) {
        $la = new ClipitLA();
        $prop_value_array["return_id"] = (int)$return_id;
        $prop_value_array["data"] = $data;
        $prop_value_array["status_code"] = (int)$status_code;
        $prop_value_array["metric_received"] = true;
        $id = $la->save();
        ClipitLA::set_properties($id, $prop_value_array);
        return $id;
    }
}