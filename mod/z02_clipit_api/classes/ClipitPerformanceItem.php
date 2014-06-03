<?php
/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 20/05/14
 * Time: 16:09
 */

class ClipitPerformanceItem extends UBItem{
    const SUBTYPE = "ClipitPerformanceItem";

    public $category = "";

    protected function load_from_elgg($elgg_object){
        parent::load_from_elgg($elgg_object);
        $this->category = (int)$elgg_object->get("category");
    }

    protected function copy_to_elgg($elgg_object){
        parent::copy_to_elgg($elgg_object);
        $elgg_object->set("category", (int)$this->category);
    }

} 