<?php

/**
 * Created by PhpStorm.
 * User: Pablo Llinás
 * Date: 09/07/2015
 * Time: 15:48
 */
class ClipitNotification extends UBMessage
{
    const SUBTYPE = "ClipitNotification";

    const REL_MESSAGE_DESTINATION = "ClipitNotification-destination";
    const REL_MESSAGE_FILE = "ClipitNotification-ClipitFile";
    const REL_MESSAGE_USER = "ClipitNotification-ClipitUser";

    const REL_NOTIFICATION_TARGET = "ClipitNotification-target";
    const REL_NOTIFICATION_SCOPE = "ClipitNotification-scope";

    const TYPE_CREATED = "created";
    const TYPE_ADDED = "added";
    const TYPE_REMOVED = "removed";
    const TYPE_MODIFIED = "modified";

    public $notification_type = "";
    public $target_array = array();
    public $scope = 0;

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->notification_type = (string)$elgg_entity->get("notification_type");
        $this->scope = (int)static::get_scope($this->id);
        $this->target_array = (array)static::get_targets($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        if(empty($this->notification_type)){
            $this->notification_type = static::TYPE_CREATED;
        }
        $elgg_entity->set("notification_type", $this->notification_type);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save=false) {
        parent::save($double_save);
        static::set_scope($this->id, $this->scope);
        static::set_targets($this->id, $this->target_array);
        return $this->id;
    }

    // SCOPE
    static function get_scope($id){
        $scope_array = UBCollection::get_items($id, static::REL_NOTIFICATION_SCOPE);
        return array_pop($scope_array);
    }

    static function set_scope($id, $scope_id){
        return UBCollection::set_items($id, array($scope_id), static::REL_NOTIFICATION_SCOPE);
    }

    // TARGETS
    static function add_targets($id, $target_array) {
        return UBCollection::add_items($id, $target_array, static::REL_NOTIFICATION_TARGET);
    }

    static function set_targets($id, $target_array) {
        return UBCollection::set_items($id, $target_array, static::REL_NOTIFICATION_TARGET);
    }

    static function remove_targets($id, $target_array) {
        return UBCollection::remove_items($id, $target_array, static::REL_NOTIFICATION_TARGET);
    }

    static function get_targets($id) {
        return UBCollection::get_items($id, static::REL_NOTIFICATION_TARGET);
    }

}