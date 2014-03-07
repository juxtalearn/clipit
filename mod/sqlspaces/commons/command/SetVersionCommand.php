<?php

class SetVersionCommand extends TSCommand
{
	var $oldID;
	var $myVersion;

	var $major;
	var $minor;
	var $branch;
	var $group;
	var $name;

	var $spaceid;
	var $createNewVersion;

	public function __construct($oldID, $myVersion, $spaceid, $createNewVersion)
	{
		parent::__construct();
		$this->oldID=$oldID;
		$this->myVersion=$myVersion;
		if($myVersion!=null)
		{
			$this->major = $myVersion->getMajor();
			$this->minor = $myVersion->getMinor();
			$this->branch = $myVersion->getVersion();
			$this->group = $myVersion->getGroup();
			$this->name = $myVersion->getNameV();
		}
		$this->spaceid=$spaceid;

		$this->createNewVersion="true";
	}

	public function toXML()
	{
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
		$setVersion=$dom->createElement("set-version");

		if ($this->id != null)
		{
			$setVersion->setAttribute("id",$this->id);
		}
		$setVersion->setAttribute("old-versionsid", $this->oldID);
		$setVersion->setAttribute("major", $this->major);
		$setVersion->setAttribute("minor", $this->minor);
		$setVersion->setAttribute("branch", $this->branch);
		$setVersion->setAttribute("group", $this->group);
		$setVersion->setAttribute("name", $this->name);
		$setVersion->setAttribute("new-version", $this->createNewVersion);
		$setVersion->setAttribute("spaceid", $this->spaceid);

		$dom->appendChild($setVersion);
		$XMLSetVersionString=$dom->saveXML();
		return $XMLSetVersionString;
	}
}
?>
