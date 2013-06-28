<?php

require_once('TSCommand.php');
class ConnectCommand extends TSCommand
{
	var $spaceNames;
	var $user;
	var $password;

	function __construct($spaceName,$user=null,$password=null)
	{
		parent::__construct();
		$this->spaceNames=$spaceName;
		$this->user=$user;
		$this->password=$password;
	}

	function toXML()
	{
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
			
		$connect=$dom->createElement('connect');
		$dom->appendChild($connect);

		if($this->id != null)
		{
				
			$connect->setAttribute('id', $this->id);
		}
		$spaces=$dom->createElement("spaces");
		$connect->appendChild($spaces);
			
		if (($this->spaceNames != null) && (count($this->spaceNames) > 0))
		{
			$sName=$this->spaceNames;
			foreach($this->spaceNames as $name)
			{
				$space=$dom->createElement("space",$name);
				$spaces->appendChild($space);
			}
		}
		if ($this->user != null)
		{
			$user=$dom->createElement("user",$this->user);
			$connect->appendChild($user);
		}
		if ($this->password != null)
		{
			$password=$dom->createElement("password",$this->password);
			$connect->appendChild($password);
		}
			
		$string=$dom->saveXML();
		return $string;
	}

}
?>
