<?php

class QueryCommand extends TSCommand
{

	var $tuple;
	var $all;
	var $remove;
	var $blocking;
	var $timeout;
	var $spaceIds;

	public function __construct($tuple, $all, $remove, $blocking, $timeout, $spaceIds)
	{
		parent::__construct();
		$this->tuple=$tuple;
		$this->all=$all;
		$this->remove=$remove;
		$this->blocking=$blocking;
		$this->timeout=$timeout;
		$this->spaceIds=$spaceIds;
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0','utf-8');
		$dom->preserveWhiteSpace=false;
			
		$query=$dom->createElement('query');
			

		if($this->id != null)
		{
				
			$query->setAttribute('id', $this->id);
		}
		if($this->remove)
		{
			if($this->all)
			{
				$query->setAttribute('type', 'takeAll');
			}
			elseif ($this->blocking) {

				$query->setAttribute('type', 'waitToTake');
				$query->setAttribute('timeout', $this->timeout);
			}
			else {
				$query->setAttribute('type', 'take');
			}
				
		}
		else {
			if ($this->all) {
				$query->setAttribute('type', 'readAll');
			} else if ($this->blocking) {
				$query->setAttribute("type", "waitToRead");
				$query->setAttribute("timeout", $this->timeout);
			} else {
				$query->setAttribute("type", "read");
			}
		}
		$concatSpaceIds=$this->spaceIds[0];
		for ($index = 1; $index < sizeof($this->spaceIds); $index++) {
			$concatSpaceIds.=','.$this->spaceIds[$index];
		}
		$query->setAttribute("space", $concatSpaceIds );
		$query->appendChild($this->tuple->toXML($dom));
		$dom->appendChild($query);
			
		$string=$dom->saveXML();
		return  $string;
	}

}
?>
