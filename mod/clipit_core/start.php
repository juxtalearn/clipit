<?php namespace clipit;
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
 * Register the init method
 */
elgg_register_event_handler('init', 'system', 'clipit_core_init');

/**
 * Initialization method which loads libraries, exposes REST API, and registers test classes.
 */
function clipit_core_init(){
    loadLibs();
    exposeRestApi();
    elgg_register_plugin_hook_handler('unit_test', 'system', 'clipit_core_tests');
}

/**
 * Loads package libraries.
 * @throws InstallationException
 */
function loadLibs(){
    // load the library files from clipit_core/lib/
    $lib_files = array(
        "clipit_activity.php", "clipit_comment.php", "clipit_file.php", "clipit_group.php", "clipit_palette.php",
        "clipit_quiz.php", "clipit_quiz_question.php", "clipit_quiz_result.php", "clipit_site.php", "clipit_sta.php",
        "clipit_storyboard.php", "clipit_taxonomy.php", "clipit_taxonomy_sb.php", "clipit_taxonomy_tag.php",
        "clipit_taxonomy_tc.php", "clipit_user.php", "clipit_video.php"
    );

    foreach($lib_files as $file){
        $file = elgg_get_plugins_path()."clipit_core/lib/".$file;
        elgg_log("Loading $file...");
        if(!include_once($file)){
            $msg = "Could not load $file";
            throw new InstallationException($msg);
        }
    }
}

/**
 * Exposes the REST API functions.
 */
function exposeRestApi(){
    clipit_user_expose_functions();
    clipit_quiz_expose_functions();
}

/**
 * Method which runs and collects results for PHP Unit tests.
 *
 * @param $hook
 * @param $type
 * @param $value
 * @param $params
 *
 * @return array
 */
function clipit_core_tests($hook, $type, $value, $params){
    $test_files = array(
        "ClipitActivityTest.php", "ClipitCommentTest.php", "ClipitFileTest.php", "ClipitGroupTest.php",
        "ClipitPaletteTest.php", "ClipitQuizQuestionTest.php", "ClipitQuizResultTest.php",
        "ClipitQuizTest.php", "ClipitSTATest.php", "ClipitSiteTest.php", "ClipitStoryboardTest.php",
        "ClipitTaxonomyTest.php", "ClipitTaxonomySBTest.php", "ClipitTaxonomyTagTest.php",
        "ClipitTaxonomyTCTest.php", "ClipitUserTest.php"
    );
    foreach($test_files as $file){
        $file = elgg_get_plugins_path()."clipit_core/tests/".$file;
        $value[] = $file;
    }
    return $value;
}
