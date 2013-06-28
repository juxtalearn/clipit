<?php

class UpdateCommand extends TSCommand
{
	var $tupleId;
	var $tuple;

	public function __construct($tupleId, $tuple)
	{
		parent::__construct();
		$this->tupleId=$tupleId;
		$this->tuple=$tuple;
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
		$update=$dom->createElement('update');

		if ($this->id != null) {
			$update->setAttribute("id",$this->id);
		}
		$update->appendChild($this->tuple->toXML($dom));
		$update->appendChild($this->tupleId->toXML($dom));
		 
		$dom->appendChild($update);
		$string=$dom->saveXML();
		return $string;
	}
}
?>
