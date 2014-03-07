<?php

class LockCommand extends TSCommand {

	private $versionId;
	private $lock;
	private $type;

	public function __construct($versionId, $lock)
	{
		parent::__construct();
			
		$this->versionId=$versionId;
		$this->lock=$lock;
		$this->type=0;
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
		$setLock=$dom->createElement("set-lock");

		if ($this->id != null) {
			$setLock->setAttribute("id",$this->id);
		}

		$setLock->setAttribute("type", $this->type);
		$setLock->setAttribute("lock", $this->lock);
		$setLock->setAttribute("versionsid",$this->versionId);
		$dom->appendChild($setLock);
		$XMLLockString=$dom->saveXML();
		return $XMLLockString;
	}
}

?>
