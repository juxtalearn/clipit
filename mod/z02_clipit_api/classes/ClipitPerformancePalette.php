<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 20/05/14
 * Time: 11:25
 */

class ClipitPerformancePalette{
    const SUBTYPE = "ClipitPerformancePalette";

    public $performance_items = array();

    /**
     * Constructor
     *
     * @throws APIException
     */
    function __construct(){
        global $CONFIG;
        if(empty($CONFIG->performance_palette_id)){
            return null;
        } else{
            $elgg_entity = new ElggObject($CONFIG->performance_palette_id);
        }
        $this->id = (int)$elgg_entity->get("guid");
        $this->name = (string)$elgg_entity->get("name");
        $this->description = (string)$elgg_entity->get("description");
        $this->url = (string)$elgg_entity->get("url");
        $this->owner_id = (int)$elgg_entity->getOwnerGUID();
        $this->time_created = (int)$elgg_entity->getTimeCreated();
        $this->performance_items = (array)$elgg_entity->get("performance_items");
        return $this->id;
    }

    protected function save(){
        global $CONFIG;
        if(empty($CONFIG->performance_palette_id)){
            return null;
        } else{
            $elgg_entity = new ElggObject($CONFIG->performance_palette_id);
        }
        $elgg_entity->set("performance_items", (array)$this->performance_items);
        return $elgg_entity->save();
    }

    static function get_performance_palette(){
        return new static();
    }

    static function add_performance_items($performance_items){
        $performance_palette = new static();
        $performance_palette->performance_items = array_merge($performance_palette->performance_items, $performance_items);
        return $performance_palette->save();
    }

} 