<?php

class GetAllSpacesCommand extends TSCommand
{

	public function __construct()
	{
		parent::__construct();
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
		$getAllSpaces=$dom->createElement("get-all-spaces");
		if ($this->id != null)
		{
			$getAllSpaces->setAttribute("id",$this->id);
		}
		$dom->appendChild($getAllSpaces);

		$string=$dom->saveXML();
		return $string;
	}

}
?>
