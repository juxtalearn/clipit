<?php

class GetAllUsersCommand extends TSCommand
{
	var $versionsid;

	public function __construct($versionsid)
	{
		parent::__construct();
		$this->versionsid=$versionsid;
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
		$users=$dom->createElement('users');

		if ($this->id != null) {
			$users->setAttribute("id",$this->id);
		}
		if ($this->versionsid != null) {
			$users->setAttribute("versionsid",$this->versionsid);
		}

		$dom->appendChild($users);
		$string=$dom->saveXML();
		return $string;
		 
	}
}
?>
