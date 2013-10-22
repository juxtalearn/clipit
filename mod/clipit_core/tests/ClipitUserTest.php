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
class ClipitUserTest extends ElggCoreUnitTest {
    private $test_guid = 30;
    private $site_url = "http://xxx";
    private $api_ending = "/services/api/rest/xml";
    private $auth_token;
    
    /**
     * Called before each test object.
     */
    public function __construct() {
        parent::__construct();
        $postCall = send_api_post_call(
            $this->site_url . $this->api_ending, array("method" => "auth.gettoken",
            "username" => "miguel", "password" => "miguel1!"), array());
        $this->auth_token = simplexml_load_string($postCall)->result;
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
    /**
     * clipit_user library
     */
    public function testLoad(){
        $attributes = array();
		$attributes['id']       = -1;
		$attributes['login']    = "";
		$attributes['password'] = "";
		$attributes['password_hash'] = "";
		$attributes['description'] = "";
		$attributes['email']    = "";
        $attributes['name']     = "";
        $attributes['role']     = "user";
        $attributes['time_created'] = -1;
		ksort($attributes);

        $clipit_attributes = clipit_user_list_properties();
        ksort($clipit_attributes);

		$this->assertIdentical($clipit_attributes, $attributes);

    }

    public function testGetAllUsers() {
        $clipit_all_users = clipit_user_get_all_users();

        for($i=0; $i<count($clipit_all_users); $i++){
            // Es un objeto de tipo ClipitUser
            $this->assertIsA ($clipit_all_users[$i], "ClipitUser");
        }
        
    }

    public function testGetUsersById() {

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
        // 2 usuarios existen y uno no, intercalados
        $username_array=array("antonio", "user_not_found", "miguel");
        $by_login = clipit_user_get_users_by_login($username_array);
        for($i=0; $i<count($by_login); $i++){
            if($by_login[$i])
                $this->assertNotNull($by_login[$i]);
            else
                $this->assertNull($by_login[$i]);
        }
        
    }
    
    public function testGetUsersByEmail(){

        // si existe o no correos en la BD
        $by_email = clipit_user_get_users_by_email(array("exampleFail@example.es", "magutierrezmoreno@gmail.com"));
        for($i=0; $i<count($by_email); $i++){
            if($by_email[$i])
                $this->assertNotNull($by_email[$i]);
            else
                $this->assertNull($by_email[$i]);
        }
    }
    public function testGetUsersByRole(){
        // comprobacion con un rol que existe y otro que no existe
        $clipit_role = clipit_user_get_users_by_role(array("student","no_exist"));
        for($i=0; $i<count($clipit_role); $i++){
            if($clipit_role[$i])
                $this->assertNotNull($clipit_role[$i]);
            else
                $this->assertNull($clipit_role[$i]);
        }
    }
    /**
     * testCreateUser
     * 
     * @expectedException InvalidParameterException
     */
    public function testCreateUser(){
        // Se espera una excepcion de tipo InvalidParameterException
        $this->expectException('InvalidParameterException');
        clipit_user_create_user(
            "", 
            $password = null, 
            $name = null, 
            $email = null, 
            $role = null, 
            $description = null
        );
        
    }

    /**
     * ClipitUser Class
     *
     * @see ClipitUser
     */
    public function testSave(){
        // Si no se le pasa ninguna ID
//        $clipitUser = new ClipitUser();
//        $save_user = $clipitUser->save();
        // Si se le pasa una ID que exista
        $clipitUser = new ClipitUser($this->test_guid);
        $save_user = $clipitUser->save();
        $this->assertTrue($save_user);
    }
    public function testDelete(){
        // Si no se le pasa ninguna ID
        $clipitUser = new ClipitUser();
        $clipitUser->delete();
    }
    /**
     * clipit_user API library
     */
    public function testApiListProperties(){
        $list_properties_api = send_api_get_call(
            $this->site_url.$this->api_ending,
            array("method"=>"clipit.user.list_properties",
            "auth_token"=>$this->auth_token), array()
        );
        $list_properties = simplexml_load_string($list_properties_api);
        foreach($list_properties->result->children() as $property){
            $arrProperties_api[$property->getName()] = (string)$property;
        }
        $clipit_properties = clipit_user_list_properties();
        $this->assertEqual($arrProperties_api, $clipit_properties);
    }

    public function testApiGetAllUsers(){
        $all_users_api = send_api_get_call(
            $this->site_url.$this->api_ending,
            array("method"=>"clipit.user.get_all_users",
                "auth_token"=>$this->auth_token), array()
        );
        $all_users = simplexml_load_string($all_users_api);
        $i=0;
        foreach($all_users->result->array_item as $user){
            foreach($user->ClipitUser->children() as $user_property){
                $arrUserProperties_api[$i][$user_property->getName()] = (string)$user_property;
            }
            $i++;
        }

        $clipit_get_all_users = clipit_user_get_all_users();
        foreach($clipit_get_all_users as $clipit_get_user){
            $arrClipit_get_all_users[] = get_object_vars($clipit_get_user);
        }
        $this->assertEqual($arrUserProperties_api, $arrClipit_get_all_users);

    }
}