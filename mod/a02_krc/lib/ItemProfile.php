<?php

/**
 * Created by PhpStorm.
 * User: Oliver
 * Date: 05.02.2015
 * Time: 14:53
 */
class ItemProfile
{
    const USER = "user";
    const RESOURCE = "resource";
    const TRICKY_TOPIC = "tricky_topic";

    private $listedProfile = array();
    private $type = "";
    private $name = "";
    private $guid = 0;
    private $entity;


    private function determineEntityType() {
        $subtype = $this->entity->getSubtype();
        switch ($subtype) {
            case ClipitUser::SUBTYPE:
                $this->type = USER;
                break;
            case ClipitTrickyTopic::SUBTYPE:
                $this->type = TRICKY_TOPIC;
                break;
            default:
                $this->type = RESOURCE;
                break;
        }
    }

    public function __construct($entity_id = 0)
    {
        $this->guid = $entity_id;
        $this->entity = get_entity($entity_id);
        if ($this->entity instanceof ElggEntity) {
            $entity = $this->entity;
            $this->name = $entity->name;

            if ($entity_id != 0) {
                $this->determineEntityType();
                switch ($this->type) {
                    case USER:
                        break;
                    case RESOURCE:
                        $entity_tags = UBCollection::get_items($entity_id, $entity->getSubtype()."-".ClipitTag::SUBTYPE);
                        foreach ($entity_tags AS $tag) {
                            $this->listedProfile[] = $tag->name;
                        }
                        break;
                    case TRICKY_TOPIC:
                        $stumbling_blocks = UBCollection::get_items($entity_id, $entity->getSubtype()."-".ClipitTag::SUBTYPE);
                        foreach ($stumbling_blocks AS $tag) {
                            $this->listedProfile[] = $tag->name;
                        }
                        break;
                }
            }
        }
        else {
            register_error("Tried to load non-existing entity for ItemProfile, no entity found for id ".$entity_id);
        }

    }

    public function getList() {
        return $this->listedProfile;
    }
    public function getType() {
        return $this->type;
    }


}