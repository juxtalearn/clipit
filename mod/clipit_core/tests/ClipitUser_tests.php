<?php

/**
 * Elgg Test Skeleton
 *
 * Plugin authors: copy this file to your plugin's test directory. Register an Elgg
 * plugin hook and function similar to:
 *
 * elgg_register_plugin_hook_handler('unit_test', 'system', 'my_new_unit_test');
 *
 * function my_new_unit_test($hook, $type, $value, $params) {
 *   $value[] = "path/to/my/unit_test.php";
 *   return $value;
 * }
 *
 * @package Elgg
 * @subpackage Test
 */
class ClipitCore_UserTest extends ElggCoreUnitTest {

    private $site_url = "http://juxtalearn.org/sandbox/pebs/clipit_dev";
    private $api_ending = "/services/api/rest/xml";
    private $api_key = "21d38973702649da57e8c186cf52aa69d6116fd1";

    /**
     * Called before each test object.
     */
    public function __construct() {
        parent::__construct();

    }

    /**
     * Called before each test method.
     */
    public function setUp() {
        
    }

    /**
     * Called after each test method.
     */
    public function tearDown() {
        // do not allow SimpleTest to interpret Elgg notices as exceptions
        $this->swallowErrors();
    }

    /**
     * Called after each test object.
     */
    public function __destruct() {
        // all __destruct() code should go above here
        parent::__destruct();
    }

    public function testGetUsers() {
        // user list retrieved from API call
        $api_ret_string = send_api_get_call(
            $this->site_url . $this->api_ending, array("method" => "clipit.user.getAllUsers",
            "api_key" => $this->api_key), array());
        $this->dump($api_ret_string);
        /*$xml_api_ret = simplexml_load_string($api_ret);
        //for($i=0; $i<$xml_api_ret->result->)*/
        
        // user list retrieved from PHP call
        $php_user_list = ClipitUser::getAllUsers();
        $this->dump($php_user_list);
        //$xml_php_user_list = ClipitUser
        //$this->dump($xml_php_user_list->asXML());
        //array_walk_recursive($php_user_list, array ($xml_php_user_list, 'addChild'));
        //$this->dump($xml_php_user_list->asXML());
        
        // compare results from both calls (should be equal)
        //$this->assertEqual($xml_api_user_list->result->asXML(), count($xml_php_user_list->asXML()));
        
    }

    public function testGetUsersByIds() {
        $api_ret_string = send_api_get_call(
            $this->site_url . $this->api_ending, array("method" => "clipit.user.getUserByIds",
            "id" => "870,29",
            "api_key" => $this->api_key), array());
        $this->dump($api_ret_string);
        $this->dump(simplexml_load_string($api_ret_string));
        
        $php_user = ClipitUser::getUsersByIds("870");
        $this->dump($php_user);
    }

}
