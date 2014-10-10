<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/09/2014
 * Last update:     22/09/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

$vendors_dir = elgg_get_plugins_path() . "z04_clipit_activity/vendors/fileupload/";
include("{$vendors_dir}tmpl.min.js");
include("{$vendors_dir}load-image.min.js");
include("{$vendors_dir}iframe-transport.js");
include("{$vendors_dir}fileupload.js");
include("{$vendors_dir}fileupload-process.js");
include("{$vendors_dir}fileupload-image.js");
include("{$vendors_dir}fileupload-validate.js");
include("{$vendors_dir}fileupload-ui.js");