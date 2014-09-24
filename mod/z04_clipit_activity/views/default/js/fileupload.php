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
require_once("{$vendors_dir}tmpl.min.js");
require_once("{$vendors_dir}load-image.min.js");
require_once("{$vendors_dir}iframe-transport.js");
require_once("{$vendors_dir}fileupload.js");
require_once("{$vendors_dir}fileupload-process.js");
require_once("{$vendors_dir}fileupload-image.js");
require_once("{$vendors_dir}fileupload-validate.js");
require_once("{$vendors_dir}fileupload-ui.js");