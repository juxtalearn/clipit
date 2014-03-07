<?php

class ChangeVersionsCommand extends TSCommand {

	var $spaceid;
	var $versionsId;
	var $major;
	var $minor;
	var $branch;
	var $name;

	public function __construct($spaceid, $versionsId, $major, $minor, $branch, $name)
	{
		parent::__construct();
		$this->major = $major;
		$this->minor = $minor;
		$this->branch = $branch;
		$this->spaceid = $spaceid;
		$this->versionsId = $versionsId;
		$this->name = $name;
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0');
		$dom->preserveWhiteSpace=false;
		$changeVersion=$dom->createElement("change-version");
		if ($this->id != null)
		{
			$changeVersion->setAttribute("id",$this->id);
		}
		$changeVersion->setAttribute("spaceid", $this->spaceid);
		$changeVersion->setAttribute("major", $this->major);
		$changeVersion->setAttribute("minor", $this->minor);
		$changeVersion->setAttribute("branch",$this->branch);
		$changeVersion->setAttribute("versionsId", $this->versionsId);
		$changeVersion->setAttribute("name", $this->name);
		$dom->appendChild($changeVersion);
		$string=$dom->saveXML();

		return $string;
	}
}
?>
