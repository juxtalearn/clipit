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
 * Class ClipitTask
 */
class ClipitTask extends UBItem{
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "ClipitTask";

    // Task types
    const TYPE_QUIZ_ANSWER = "quiz_answer";
    const TYPE_STORYBOARD_UPLOAD = "storyboard_upload";
    const TYPE_STORYBOARD_FEEDBACK = "storyboard_feedback";
    const TYPE_VIDEO_UPLOAD = "video_upload";
    const TYPE_VIDEO_FEEDBACK = "video_feedback";
    const TYPE_OTHER = "other";

    public $task_type = "";
    public $start = 0;
    public $end = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function load_from_elgg($elgg_entity){
        $save_after_load = false;
        parent::load_from_elgg($elgg_entity);
        $this->task_type = (string)$elgg_entity->get("task_type");
        // if $this->type not one of the valid types, then type = other
        if(array_search((string)$this->task_type, array(
                static::TYPE_QUIZ_ANSWER,
                static::TYPE_STORYBOARD_UPLOAD,
                static::TYPE_STORYBOARD_FEEDBACK,
                static::TYPE_VIDEO_UPLOAD,
                static::TYPE_VIDEO_FEEDBACK,
                static::TYPE_OTHER))
            === false){
            $this->task_type = static::TYPE_OTHER;
            $save_after_load = true;
        }
        $this->start = (int)$elgg_entity->get("start");
        if((int)$this->start == 0){
            $this->start = (int)$elgg_entity->time_created;
            $save_after_load = true;
        }
        $this->end = (int)$elgg_entity->get("end");
        if($this->end == 0){
            $activity_id = static::get_activity($this->id);
            if(!empty($activity_id)){
                $prop_value_array = (int) ClipitActivity::get_properties($activity_id, array("deadline"));
                $this->end = $prop_value_array["deadline"];
                $save_after_load = true;
            }
        }
        if($save_after_load){
            $this->save();
        }
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity){
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("task_type", (string)$this->task_type);
        $elgg_entity->set("start", (int)$this->start);
        $elgg_entity->set("end", (int)$this->end);
    }

    /**
     * Get the Activity Id in which a Task is contained in.
     *
     * @param int $task_id Id of the Task to get Activity from.
     *
     * @return int Returns an the Activity Id for the Task.
     */
    static function get_activity($task_id){
        $activity = UBCollection::get_items($task_id, ClipitActivity::REL_ACTIVITY_TASK, true);
        return array_pop($activity);
    }
} 