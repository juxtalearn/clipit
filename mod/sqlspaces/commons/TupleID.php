<?php

class TupleID
{
	const FIRST_ID = 0;
	private $tupleId;

	public function __construct($id=null)
	{
		if($id!=null)
		{
			$this->tupleId = $id;
		}
	}

	public function initialize($initialize)
	{
		if ($initialize)
		{
			$this->tupleId = self::FIRST_ID;
		}
		else
		{
			$this->tupleId = self::FIRST_ID - 1;
		}
	}

	public function setIdStr($idStr)
	{
		$this->tupleId = $idStr;
	}

	public function getTupleId() {
		return $this->tupleId;
	}

	public function hashCode() {
		return $this->tupleId;
	}

	public function isTupleInitialized() {
		return ($this->tupleId != (self::FIRST_ID - 1));
	}

	public function toString() {
		return $this->tupleId."";
	}

	public function toXML($dom)
	{
		$tupleId=$dom->createElement('tupleid');
		$tupleId->setAttribute("id",$this->tupleId);
		return $tupleId;
	}
}
?>
