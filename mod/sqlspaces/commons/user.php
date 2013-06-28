<?php

class User
{
	private $username;
	private $password;

	public function __construct($username,$password=null) {
		$this->$username = $username;
		$this->$password = $password;
	}
}
?>
