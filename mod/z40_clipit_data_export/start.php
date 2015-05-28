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
 * Register the init method
 */
elgg_register_event_handler('init', 'system', 'clipit_data_export');
/**
 * Initialization method which loads objects, libraries, exposes the REST API, and registers test classes.
 */
function clipit_data_export() {
    // Expose REST API Methods
    expose_function(
        "clipit.data_export.export_all",
        "ClipitDataExport::export_all",
        null,
        "Export all ClipIt Data to an XMLS file",
        "GET",
        false,
        true
    );
}
