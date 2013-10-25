<?php namespace clipit\comment;
    /**
     * JuxtaLearn ClipIt Web Space
     * PHP version:     >= 5.2
     * Creation date:   2013-10-10
     * Last update:     $Date$
     *
     * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
     * @version         $Version$
     * @link            http://juxtalearn.org
     * @license         GNU Affero General Public License v3
     *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
     *                  This program is free software: you can redistribute it and/or modify
     *                  it under the terms of the GNU Affero General Public License as
     *                  published by the Free Software Foundation, version 3.
     *                  This program is distributed in the hope that it will be useful,
     *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
     *                  GNU Affero General Public License for more details.
     *                  You should have received a copy of the GNU Affero General Public License
     *                  along with this program. If not, see
     *                  http://www.gnu.org/licenses/agpl-3.0.txt.
     */

/**
 * Class ClipitComment
 *
 * @package clipit\comment
 */
class ClipitComment{

    // Class properties
    public $id = int;
    public $owner = ClipitUser;
    public $pedagogical_rating = int;
    public $performance_rating = int;
    public $taxonomy_tag_array = array(ClipitTaxonomyTag);
    public $text_body = string;
    public $video = ClipitVideo;
    public $creation_date = DateTime;

    static function getProperty($id, $prop){
        return "TO-DO"; // @todo
    }

    static function setProperty($id, $prop, $value){
        return "TO-DO"; // @todo
    }

    static function exposeFunctions(){
        expose_function("clipit.comment.getProperty", "ClipitComment::getProperty",
            array(
                "id" => array(
                    "type" => "integer",
                    "required" => true),
                "prop" => array(
                    "type" => "string",
                    "required" => true)),
            "TO-DO:description",
            'GET',
            true,
            false);

        expose_function("clipit.comment.setProperty", "ClipitComment::setProperty",
            array(
                "id" => array(
                    "type" => "integer",
                    "required" => true),
                "prop" => array(
                    "type" => "string",
                    "required" => true),
                "value" => array(
                    "type" => "string",
                    "required" => true)),
            "TO-DO:description",
            'GET',
            true,
            false);
    }

}

