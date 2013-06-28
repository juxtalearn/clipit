<?php

class RightsCommand extends TSCommand
{
	var $users;
	var $rights;

	public function __construct($users, $rights)
	{
		parent::__construct();
		$this->users=$users;
		$this->rights=$rights;
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
		$rights=$dom->createElement('rights');
			
		if ($this->id != null) {
			$rights->setAttribute("id", $this->id);
		}
		if ($this->rights != null)
		{
			$rights->setAttribute("righst", $this->rights->getByte(FALSE));
			$rights->setAttribute("righst", $this->rights->getVersion);
		}

		for ($index = 0; $index < sizeof($this->users); $index++)
		{
			$userId=$dom->createElement('userid');
			$userId->setAttribute("name",$this->users[$index]);
			$dmom->appendChild($userId);
		}
		$dom->appendChild($rights);
		$string=$dom->saveXML();

		return $string;
	}
}
?>
