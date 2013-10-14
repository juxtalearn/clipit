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

        // all __construct() code should come after here
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
        //$this->swallowErrors();
    }

    /**
     * Called after each test object.
     */
    public function __destruct() {
        // all __destruct() code should go above here
        //parent::__destruct();
    }
    
    
    public function testGetUsers(){
        
        /*$url_string =  $this->site_url.
            $this->api_ending.
            "?method=clipit.getUsers".
            "&api_key=".$this->api_key;
        
        $this->dump($url_string);
        
        $user_list = file_get_contents($url_string);*/
        
        $user_list = send_api_get_call(
            $this->site_url.$this->api_ending,
            array("method"=>"clipit.getUsers",
                "api_key"=>$this->api_key),
            array()
        );
        
        $this->dump($user_list);
        
        $user_list = simplexml_load_string($user_list);
        
        $user_list->
        
        $this->dump($user_list->result);

        
        $test_user_list = getUsers();
        
        $this->dump($test_user_list);
        
        $this->assertEqual((array)$user_list->result, $test_user_list);

       
        $this->dump("fin_tests");
        $this->assertTrue(TRUE);
    }
}
