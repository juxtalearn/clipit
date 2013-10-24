<?php namespace clipit\site;
/**
 * JuxtaLearn ClipIt Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, version 3. *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details. *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see
 * http://www.gnu.org/licenses/agpl-3.0.txt.
 */

/**
 * Class ClipitSite
 * @package clipit\site
 */
class ClipitSite{
    // Class properties
    public $description = string;
    public $id = int;
    public $name = string;
    public $quiz_array = array(ClipitQuiz);
    public $sta_array = array(ClipitSTA);
    public $storyboard_array = array(ClipitStoryboard);
    public $taxonomy_array = array(ClipitTaxonomy);
    public $user_array = array(ClipitUser);
    public $video_array = array(ClipitVideo);

    static function getProperty($id, $prop){
        return "TO-DO";
    }

    static function setProperty($id, $prop, $value){
        return "TO-DO";
    }

    static function exposeFunctions(){
        expose_function("clipit.site.getProperty", "ClipitSite::getProperty",
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

        expose_function("clipit.site.setPropertysetProperty", "ClipitSite::setProperty",
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