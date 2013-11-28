<?php
/**
 * ClipIt - JuxtaLearn Web Space
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
namespace clipit;


/**
 * Class ClipitComment
 *
 * @package clipit
 */
class ClipitComment{

    // Class properties
    public $id = int;
    public $author = int; // ClipitUser Id
    public $pedagogical_rating = int; // scale 1-5
    public $performance_rating = int; //scale 1-5
    public $taxonomy_tag_array = array(); // array of ClipitTaxonomyTag Ids
    public $text_body = string; // main comment text
    public $video = int; // ClipitVideo Id
    public $creation_date = int; // unix time


}

