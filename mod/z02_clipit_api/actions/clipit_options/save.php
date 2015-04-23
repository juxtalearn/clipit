<?php
/**
 * Created by PhpStorm.
 * User: pebs74
 * Date: 16/04/2015
 * Time: 12:59
 */

// Save posted options
set_config("allow_registration", (bool)get_input("allow_registration"));
set_config("timezone", (string)get_input("timezone"));
set_config("clipit_site_type", (string)get_input("clipit_site_type"));
set_config("clipit_global_url", (string)get_input("clipit_global_url"));
set_config("clipit_global_login", (string)get_input("clipit_global_login"));
set_config("clipit_global_password", (string)get_input("clipit_global_password"));
set_config("clipit_global_published", (bool)get_input("clipit_global_published"));
set_config("performance_palette", (bool)get_input("performance_palette"));
set_config("example_types", (bool)get_input("example_types"));
set_config("fixed_performance_rating", (bool)get_input("fixed_performance_rating"));
set_config("quiz_results_after_task_end", (bool)get_input("quiz_results_after_task_end"));
system_message("The options have been saved correctly");
