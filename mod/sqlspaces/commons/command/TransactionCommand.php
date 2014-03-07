<?php

class TransactionCommand extends TSCommand {

	var $TransactionType=array('BEGIN'=>'BEGIN','COMMIT'=>'COMMIT','ABORT'=>'ABORT');

	var $type;

	public function __construct($type)
	{
		parent::__construct();
		$this->type=$type;
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
		$transaction=$dom->createElement('transaction');

		if ($this->id != null) {
			$transaction->setAttribute("id",$this->id);
		}
		$transaction->setAttribute("type",$this->type);
			
		$dom->appendChild($transaction);
		$string=$dom->saveXML();
		return $string;
	}
}
?>
