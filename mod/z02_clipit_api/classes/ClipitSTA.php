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

 */
class ClipitSTA extends ClipitFile {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitSTA";
    public $resource_url = "";
    public $tricky_topic = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggFile $elgg_file Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_file) {
        parent::load_from_elgg($elgg_file);
        $this->resource_url = (string)$elgg_file->get("resource_url");
        $this->tricky_topic = (int)$elgg_file->get("tricky_topic");
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggFile $elgg_file Elgg object instance to save $this to
     */
    protected function save_to_elgg($elgg_file) {
        parent::save_to_elgg($elgg_file);
        $elgg_file->set("resource_url", (string)$this->resource_url);
        $elgg_file->set("tricky_topic", (int)$this->tricky_topic);
    }
}