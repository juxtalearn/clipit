<?php

class ChangeCommand extends TSCommand
{
	private $changeType=array( "NEW_AND_CHANGED"=>"NEW_AND_CHANGED", "CHANGED"=>"CHANGED","DELETE"=>"DELETE");
	var $type;
	var $version1;
	var $version2;
	var $template;

	public function __constructs($type, $version1, $version2, $template)
	{
		parent::__construct();
		$this->type=$type;
		$this->version1=$version1;
		$this->version2=$version2;
		$this->template=$template;
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace=false;
		$getChanged=$dom->createElement('get-changed');
		if ($this->id != null)
		{
			$getChanged->setAttribute("id",$this->id);
		}
		$getChanged->setAttribute("type", strtolower((string)$this->type));
		$getChanged->setAttribute("version1",(string) $this->version1);
		$getChanged->setAttribute("version2",(string) $this->version2);
		$getChanged->appendChild($this->template->toXML($dom));
		$dom->appendChild($getChanged);
		$string=$dom->saveXML();
		return $string;
	}
}
?>
