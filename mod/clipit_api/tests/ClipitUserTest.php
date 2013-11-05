<?php
namespace clipit\user;
    /**
     * JuxtaLearn ClipIt Web Space
     * PHP version:     >= 5.2
     * Creation date:   2013-10-10
     * Last update:     $Date$
     *
     * @category        Class
     * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, JuxtaLearn Project
     * @version         $Version$
     * @link            http://juxtalearn.org
     * @license         GNU Affero General Public License v3
     *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
     * This program is free software: you can redistribute it and/or modify
     * it under the terms of the GNU Affero General Public License as
     * published by the Free Software Foundation, version 3.
     * This program is distributed in the hope that it will be useful,
     * but WITHOUT ANY WARRANTY; without even the implied warranty of
     * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
     * GNU Affero General Public License for more details.
     * You should have received a copy of the GNU Affero General Public License
     * along with this program. If not, see
     * http://www.gnu.org/licenses/agpl-3.0.txt.
     */

/**
 * Class ClipitUserTest
 *
 * @package clipit\user
 */
class ClipitUserTest extends \ElggCoreUnitTest{
    /**
     * @var int Sample GUID exists
     */
    var $test_guid;
    /**
     * @var string Base URL
     */
    var $site_url = "http://juxtalearn.org/sandbox/miguel/clipit_dev";
    /**
     * @var string Path web services URl
     */
    var $api_ending = "/services/api/rest/xml";
    /**
     * @var SimpleXMLElement[] Oauth token
     */
    var $auth_token;

    /**
     * Called before each test object.
     */
    public function __construct(){
        parent::__construct();
        // Set test_guid from user session
        $this->test_guid = elgg_get_logged_in_user_guid();
        $postCall = send_api_post_call(
            $this->site_url.$this->api_ending, array("method" => "auth.gettoken",
                                                     "username" => "<USER>", "password" => "<PASSWORD>"), array());
        $this->auth_token = simplexml_load_string($postCall)->result;
    }

    /**
     * Called before each test method.
     */
    public function setUp(){

    }

    /**
     * Called after each test method.
     */
    public function tearDown(){
        // do not allow SimpleTest to interpret Elgg notices as exceptions
        $this->swallowErrors();
    }

    /**
     * Called after each test object.
     */
    public function __destruct(){
        // all __destruct() code should go above here
        parent::__destruct();
    }

    /**
     * Clipit_user functions from lib/
     */
    public function testLoad(){
        $attributes = array();
        $attributes['id'] = -1;
        $attributes['login'] = "";
        $attributes['password'] = "";
        $attributes['password_hash'] = "";
        $attributes['description'] = "";
        $attributes['email'] = "";
        $attributes['name'] = "";
        $attributes['role'] = "user";
        $attributes['time_created'] = -1;
        ksort($attributes);

        $clipit_attributes = clipit_user_list_properties();
        ksort($clipit_attributes);

        $this->assertIdentical($clipit_attributes, $attributes);

    }

    public function testGetAllUsers(){
        $clipit_all_users = clipit_user_get_all_users();

        for($i = 0; $i < count($clipit_all_users); $i++){
            // Is a ClipitUser object type
            $this->assertIsA($clipit_all_users[$i], "ClipitUser");
        }

    }

    /**
     * Test clipit_user_get_users_by_id()
     */
    public function testGetUsersById(){

        // Users that don't exist
        $clipit_user = clipit_user_get_users_by_id(array("0", "38"));
        for($i = 0; $i < count($clipit_user); $i++){
            $this->assertNull($clipit_user[$i]);
        }

        // Only 1 user
        $clipit_user = clipit_user_get_users_by_id(array($this->test_guid));
        $elgg_user = new ClipitUser($this->test_guid);
        $this->assertEqual($clipit_user, array($elgg_user));

        // More than 1 user, exists or not
        $clipit_user = clipit_user_get_users_by_id(array($this->test_guid, "400", "37"));
        for($i = 0; $i < count($clipit_user); $i++){
            if($clipit_user[$i])
                $this->assertNotNull($clipit_user[$i]);
            else
                $this->assertNull($clipit_user[$i]);
        }

    }

    /**
     * Test clipit_user_get_users_by_login()
     */
    public function testGetUserByLogin(){
        // 2 users exists but 1 not
        $username_array = array("antonio", "user_not_found", "miguel");
        $by_login = clipit_user_get_users_by_login($username_array);
        for($i = 0; $i < count($by_login); $i++){
            if($by_login[$i])
                $this->assertNotNull($by_login[$i]);
            else
                $this->assertNull($by_login[$i]);
        }

    }

    /**
     * Test clipit_user_get_users_by_email()
     */
    public function testGetUsersByEmail(){

        // check if exists or not the emails
        $by_email = clipit_user_get_users_by_email(array("exampleFail@example.es", "magutierrezmoreno@gmail.com"));
        for($i = 0; $i < count($by_email); $i++){
            if($by_email[$i])
                $this->assertNotNull($by_email[$i]);
            else
                $this->assertNull($by_email[$i]);
        }
    }

    /**
     * Test clipit_user_get_users_by_role()
     */
    public function testGetUsersByRole(){
        // Check when role exist and not exist
        $clipit_role = clipit_user_get_users_by_role(array("student", "no_exist"));
        for($i = 0; $i < count($clipit_role); $i++){
            if($clipit_role[$i])
                $this->assertNotNull($clipit_role[$i]);
            else
                $this->assertNull($clipit_role[$i]);
        }
    }

    /**
     * Test clipit_user_create_user()
     *
     * @expectedException InvalidParameterException
     */
    public function testCreateUser(){
        // Expected exception of type InvalidParameterException
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
     * Test Class methods
     */
    public function testSave(){
        // When param is empty
        $clipitUser = new ClipitUser();
        $save_user = $clipitUser->save();
        $this->assertTrue($save_user);
        // If GUID exists
        $clipitUser = new ClipitUser($this->test_guid);
        $save_user = $clipitUser->save();
        $this->assertTrue($save_user);
    }

    public function testDelete(){
        // When param is empty
        $clipitUser = new ClipitUser();
        $clipitUser->delete();
    }

    /**
     * Clipit_user API functions from lib/
     * Test API functions
     */
    public function testApiListProperties(){
        $list_properties_api = send_api_get_call(
            $this->site_url.$this->api_ending,
            array("method" => "clipit.user.list_properties",
                  "auth_token" => $this->auth_token), array()
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
            array("method" => "clipit.user.get_all_users",
                  "auth_token" => $this->auth_token), array()
        );
        $all_users = simplexml_load_string($all_users_api);
        $i = 0;
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