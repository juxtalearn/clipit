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
    public function testSave(){
        
    }
    public function testGetProperties(){
        
    }
    public function testSetProperties(){
        
    }
    public function testGetAllUsers() {
        $clipit_all_users = clipit_user_get_all_users();

        for($i=0; $i<count($clipit_all_users); $i++){
            // Es un objeto de tipo ClipitUser
            $this->assertIsA ($clipit_all_users[$i], "ClipitUser");
        }
        
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
        // Si no hay email
        $by_email = clipit_user_get_users_by_email();
        $this->dump($by_email);
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
}