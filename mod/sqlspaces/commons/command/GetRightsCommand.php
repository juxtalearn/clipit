<?php

class GetRightsCommand extends TSCommand
{
	var $version;

	public function __construct($version)
	{
		parent::__construct();
		$this->version=$version;
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
		$getRights=$dom->createElement('get-rights');

		if ($this->id != null)
		{
			$getRights->setAttribute("id", $this->id);
		}
		if ($this->id != null)
		{
			$getRights->setAttribute("version", $this->version);
		}

		$dom->appendChild($getRights);
		$string=$dom->saveXML();

		return $string;
	}
}
?>
