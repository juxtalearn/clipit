<?php

class WriteCommand extends TSCommand
{

	var $tuple;
	var $spaceid;

	public function __construct($tuple,$spaceid)
	{
		parent::__construct();
		 
		$this->tuple =$tuple;
		$this->spaceid = $spaceid;
		 
	}
	
	public function toXML()
	{
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
		$write=$dom->createElement('write');

		if ($this->id != null) {
			$write->setAttribute("id",$this->id);
		}
		$write->setAttribute("space",$this->spaceid);
		 
		$write->appendChild($this->tuple->toXML($dom));
		$dom->appendChild($write);
		$string=$dom->saveXML();
		return $string;
	}

}
?>
