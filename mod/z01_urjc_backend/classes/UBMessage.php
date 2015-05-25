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
 * @subpackage      urjc_backend
 */

/**
 * <Class Description>
 */
class UBMessage extends UBItem {
    /**
     * @const string Elgg entity SUBTYPE for this class
     */
    const SUBTYPE = "UBMessage";
    const REL_MESSAGE_DESTINATION = "UBMessage-destination";
    const REL_MESSAGE_FILE = "UBMessage-UBFile";
    public $read_array = array();
    public $destination = 0;
    public $file_array = array();

    /**
     * Loads object parameters stored in Elgg
     *
     * @param ElggEntity $elgg_entity Elgg Object to load parameters from.
     */
    protected function copy_from_elgg($elgg_entity) {
        parent::copy_from_elgg($elgg_entity);
        $this->read_array = (array)$elgg_entity->get("read_array");
        $this->destination = (int)static::get_destination($this->id);
        $this->file_array = (array)static::get_files($this->id);
    }

    /**
     * Copy $this object parameters into an Elgg entity.
     *
     * @param ElggEntity $elgg_entity Elgg object instance to save $this to
     */
    protected function copy_to_elgg($elgg_entity) {
        parent::copy_to_elgg($elgg_entity);
        $elgg_entity->set("read_array", (array)$this->read_array);
    }

    /**
     * Saves this instance to the system.
     * @param  bool $double_save if $double_save is true, this object is saved twice to ensure that all properties are
     *     updated properly. E.g. the time created property can only beset on ElggObjects during an update. Defaults to
     *     false!
     * @return bool|int Returns the Id of the saved instance, or false if error
     */
    protected function save($double_save = false) {
        parent::save($double_save);
        static::set_destination($this->id, $this->destination);
        static::add_files($this->id, $this->file_array);
        return $this->id;
    }

    /* STATIC FUNCTIONS */
    /**
     * Get Messages by Destination
     *
     * @param array $destination_array Array of Destination IDs
     * @param int $offset (default = 0 : begining)
     * @param int $limit (default = 0 : none)
     * @param bool $count_only (default = false : no)
     * @param string $order_by property to order results by
     * @param bool $ascending Whether to order ascending (true) or descending (false)
     *
     * @return static[] Array of Messages
     */
    static function get_by_destination($destination_array, $limit = 0, $offset = 0, $count_only = false, $order_by = "", $ascending = true) {
        $message_array = array();
        foreach ($destination_array as $destination_id) {
            $item_array = UBCollection::get_items($destination_id, static::REL_MESSAGE_DESTINATION, true);
            if($count_only) {
                $message_array[$destination_id] = count($item_array);
                continue;
            }
            $temp_array = array();
            foreach ($item_array as $item_id) {
                $temp_array[$item_id] = new static((int)$item_id);
            }
            if (empty($temp_array)) {
                $message_array[$destination_id] = null;
            } else {
                if(!empty($order_by)) {
                    $args = array("order_by" => $order_by, "ascending" => $ascending);
                    uasort($temp_array, function ($i1, $i2) use ($args) {
                        if (!$i1 && !$i2) {
                            return 0;
                        }
                        if ($i1->$args["order_by"] == $i2->$args["order_by"]) {
                            return 0;
                        }
                        if ((bool)$args["ascending"]) {
                            if (!$i1) {
                                return 1;
                            }
                            if (!$i2) {
                                return -1;
                            }
                            return (strtolower($i1->$args["order_by"]) < strtolower($i2->$args["order_by"]) ? -1 : 1);
                        } else {
                            if (!$i1) {
                                return -1;
                            }
                            if (!$i2) {
                                return 1;
                            }
                            return (strtolower($i2->$args["order_by"]) < strtolower($i1->$args["order_by"]) ? -1 : 1);
                        }
                    });
                }
                $message_array[$destination_id] = $temp_array;
                if (!empty($limit)) {
                    $message_array[$destination_id] = array_slice($message_array[$destination_id], $offset, $limit, true);
                } else {
                    $message_array[$destination_id] = array_slice($message_array[$destination_id], $offset, null, true);
                }
            }
        }
        return $message_array;
    }

    /**
     * Get Messages by Sender
     *
     * @param array $sender_array Array of Sender IDs
     *
     * @return static[] Array of Messages
     */
    static function get_by_sender($sender_array) {
        return static::get_by_owner($sender_array);
    }

    /**
     * Get the Destination of a Message
     *
     * @param int $id ID of Message
     *
     * @return int|null ID of Destination or null if error
     */
    static function get_destination($id) {
        $item_array = UBCollection::get_items($id, static::REL_MESSAGE_DESTINATION);
        if (empty($item_array)) {
            return 0;
        }
        return (int)array_pop($item_array);
    }

    /**
     * Set the Destination of a Message
     *
     * @param int $id Id of the Message
     * @param int $destination_id ID of the Destination
     *
     * @return bool True if OK, false if error
     */
    static function set_destination($id, $destination_id) {
        if ($destination_id > 0) {
            UBCollection::remove_all_items($id, static::REL_MESSAGE_DESTINATION);
            return UBCollection::add_items($id, array($destination_id), static::REL_MESSAGE_DESTINATION);
        }
        return false;
    }

    /**
     * Get Sender of a Message
     *
     * @param int $id ID of the Message
     *
     * @return int ID of the Sender
     */
    static function get_sender($id) {
        $message = new static($id);
        return $message->owner_id;
    }

    /**
     * Add Files attached to a Message
     *
     * @param int $id ID of the Message
     * @param array $file_array Array of File IDs
     *
     * @return bool True if OK, false if error
     */
    static function add_files($id, $file_array) {
        return UBCollection::add_items($id, $file_array, static::REL_MESSAGE_FILE, true);
    }

    /**
     * Set Files attached to a Message
     *
     * @param int $id ID of the Message
     * @param array $file_array Array of File IDs
     *
     * @return bool True if OK, false if error
     */
    static function set_files($id, $file_array) {
        return UBCollection::set_items($id, $file_array, static::REL_MESSAGE_FILE, true);
    }

    /**
     * Remove Files attached to a Message
     *
     * @param int $id ID of the Message
     * @param array $file_array Array of File IDs
     *
     * @return bool True if OK, false if error
     */
    static function remove_files($id, $file_array) {
        return UBCollection::remove_items($id, $file_array, static::REL_MESSAGE_FILE);
    }

    /**
     * Get Files attached to a Message
     *
     * @param int $id ID of the Message
     *
     * @return static[] Array of File IDs
     */
    static function get_files($id) {
        return UBCollection::get_items($id, static::REL_MESSAGE_FILE);
    }

    /**
     * Get a list of Users who have Read a Message, or optionally whether certain Users have read it
     *
     * @param int $id ID of the Message
     * @param null|array $user_array List of User IDs - optional
     *
     * @return static[] Array with key => value: user_id => read_status, where read_status is bool
     */
    static function get_read_status($id, $user_array = null) {
        $props = static::get_properties($id, array("read_array", "owner_id"));
        $read_array = $props["read_array"];
        $owner_id = $props["owner_id"];
        if (!$user_array) {
            return $read_array;
        } else {
            $return_array = array();
            foreach ($user_array as $user_id) {
                if ((int)$user_id == (int)$owner_id || in_array($user_id, $read_array)) {
                    $return_array[$user_id] = true;
                } else {
                    $return_array[$user_id] = false;
                }
            }
            return $return_array;
        }
    }

    /**
     * Set the Read status for a Message
     *
     * @param int $id ID of Message
     * @param bool $read_value Read status value: true = read, false = unread
     * @param array $user_array Array of User IDs
     *
     * @return bool|int ID of Message if Ok, false if error
     * @throws InvalidParameterException
     */
    static function set_read_status($id, $read_value, $user_array) {
        $read_array = static::get_properties($id, array("read_array"));
        $read_array = array_pop($read_array);
        $update_flag = false;
        foreach ($user_array as $user_id) {
            $index = array_search((int)$user_id, $read_array);
            if ($read_value === true && $index === false) {
                array_push($read_array, $user_id);
                $update_flag = true;
            } else {
                if ($read_value === false && $index !== false) {
                    array_splice($read_array, $index, 1);
                    $update_flag = true;
                }
            }
        }
        if ($update_flag) {
            $prop_value_array["read_array"] = $read_array;
            return static::set_properties($id, $prop_value_array);
        } else {
            return $id;
        }
    }

    /**
     * Count the number os Messages for each Destination specified
     *
     * @param array $destination_array List of Destination IDs
     * @param bool $recursive Whether to recurse
     *
     * @return array Returns array of destination => message_count elements.
     */
    static function count_by_destination($destination_array, $recursive = false) {
        $count_array = array();
        foreach ($destination_array as $dest_id) {
            $count_array[$dest_id] = UBCollection::count_items($dest_id,
                static::REL_MESSAGE_DESTINATION,
                true,
                $recursive);
        }
        return $count_array;
    }

    /**
     * Count number of Messages sent by Sender
     *
     * @param array $sender_array Array of User IDs
     *
     * @return array Array of sender => message_count elements
     */
    static function count_by_sender($sender_array) {
        $message_array = static::get_by_sender($sender_array);
        $count_array = array();
        foreach ($sender_array as $sender_id) {
            $count_array[$sender_id] = count((array)$message_array[$sender_id]);
        }
        return $count_array;
    }

    static function unread_by_destination($destination_array, $user_id, $recursive = false) {
        $destination_messages = static::get_by_destination($destination_array);
        $count_array = array();
        foreach ($destination_array as $destination_id) {
            $message_array = $destination_messages[$destination_id];
            if (!$message_array) {
                $count_array[$destination_id] = 0;
                continue;
            }
            $count = 0;
            foreach ($message_array as $message) {
                if (array_search((int)$user_id, $message->read_array) === false) {
                    $count++;
                }
                if ($recursive) {
                    $temp_count = static::unread_by_destination(array((int)$message->id), $user_id, $recursive);
                    $count += $temp_count[$message->id];
                }
            }
            $count_array[$destination_id] = $count;
        }
        return $count_array;
    }

    static function unread_by_sender($sender_array, $user_id) {
        $sender_messages = static::get_by_sender($sender_array);
        $count_array = array();
        foreach ($sender_array as $sender_id) {
            $count = 0;
            if (!empty($sender_messages[$sender_id])) {
                $message_array = $sender_messages[$sender_id];
                foreach ($message_array as $message) {
                    if (array_search((int)$user_id, $message->read_array) === false) {
                        $count++;
                    }
                }
            }
            $count_array[$sender_id] = $count;
        }
        return $count_array;
    }
}