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

    private $site_url = "http://juxtalearn.org/sandbox/miguel/clipit_dev";
    private $api_ending = "/services/api/rest/xml";
    private $api_key = "01ce6c5b8e208de5a0e5a34b7171c4c577163b24";
    private $test_guid = 30;
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
        $this->object = new ClipitUser();
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
    
    public function testLoad(){
        $attributes = array();
		$attributes['guid'] = NULL;
		$attributes['type'] = 'user';
		$attributes['subtype'] = NULL;
		$attributes['owner_guid'] = elgg_get_logged_in_user_guid();
		$attributes['container_guid'] = elgg_get_logged_in_user_guid();
		$attributes['site_guid'] = NULL;
		$attributes['access_id'] = ACCESS_PRIVATE;
		$attributes['time_created'] = NULL;
		$attributes['time_updated'] = NULL;
		$attributes['last_action'] = NULL;
		$attributes['enabled'] = 'yes';
		$attributes['tables_split'] = 2;
		$attributes['tables_loaded'] = 0;
		$attributes['name'] = NULL;
		$attributes['username'] = NULL;
		$attributes['password'] = NULL;
		$attributes['salt'] = NULL;
		$attributes['email'] = NULL;
		$attributes['language'] = NULL;
		$attributes['code'] = NULL;
		$attributes['banned'] = 'no';
		$attributes['admin'] = 'no';
		ksort($attributes);
        
        $us = new ElggUserTest();
		$entity_attributes = $us->expose_attributes();
		ksort($entity_attributes);
		$this->assertIdentical($entity_attributes, $attributes);
        
    }
    public function testSave(){
        $elgg_user = new ElggUser();
//        $elgg_user->set("avatar", $this->avatar);
//        $elgg_user->set("description", $this->description);
//        $elgg_user->set("email", $this->email);
//        $elgg_user->set("name", $this->name);
//        $elgg_user->set("username",$this->login);
//        $elgg_user->set("password", $this->password);
//        $elgg_user->set("role", $this->role);
    }
    public function testGetProperties(){
        
    }
    public function testSetProperties(){
        
    }
    public function testGetAllUsers() {
        // user list retrieved from API call
        $api_ret_string = send_api_get_call(
            $this->site_url . $this->api_ending, array("method" => "clipit.user.getAllUsers",
            "api_key" => $this->api_key), array());
      // $this->dump($api_ret_string);
        /*$xml_api_ret = simplexml_load_string($api_ret);
        //for($i=0; $i<$xml_api_ret->result->)*/
        
        // user list retrieved from PHP call
        $php_user_list = clipit_user_get_all_users();
      //  $this->dump($php_user_list);
        //$xml_php_user_list = ClipitUser
        //$this->dump($xml_php_user_list->asXML());
        //array_walk_recursive($php_user_list, array ($xml_php_user_list, 'addChild'));
        //$this->dump($xml_php_user_list->asXML());
        
        // compare results from both calls (should be equal)
        //$this->assertEqual($xml_api_user_list->result->asXML(), count($xml_php_user_list->asXML()));
        
       // $this->assertIdentical($php_user_list, $api_ret_string);
    }

    public function testGetUsersById() {
        
        // Si no hay usuario
        $user_null = clipit_user_get_users_by_id();
        $this->assertNull($user_null);
        
        // Usuarios que no existen en la plataforma
        $clipit_user = clipit_user_get_users_by_id(array("0","38"));
        for($i=0; $i<count($clipit_user); $i++){
            $this->assertNull($clipit_user[$i]);
        }
        
        // Solamente 1 usuario
        $clipit_user = clipit_user_get_users_by_id(array($this->test_guid));
        $elgg_user = new ClipitUser($this->test_guid);
        $this->assertEqual($clipit_user, array($elgg_user));
        
        // Más de 1 usuario que existan o no
        $clipit_user = clipit_user_get_users_by_id(array($this->test_guid, "400", "37"));
        for($i=0; $i<count($clipit_user); $i++){
            if($clipit_user[$i])
                $this->assertNotNull($clipit_user[$i]);
            else
                $this->assertNull($clipit_user[$i]);
        }
         
    }
    public function testGetUserByLogin(){
        
    }
    public function testGetUsersByEmail(){
        $this->dump(clipit_user_get_all_users());
    }
    public function testCreateUser(){
        $create_user = clipit_user_create_user(
                "", 
                $password = null, 
                $name = null, 
                $email = null, 
                $role = null, 
                $description = null
        );
        $this->dump($create_user);
        
    }
}
class ElggUserTest extends ElggUser {
	public function expose_attributes() {
		return $this->attributes;
	}
}