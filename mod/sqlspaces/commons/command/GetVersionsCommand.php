<?php

class GetVersionsCommand extends TSCommand
{
	protected $spaceid;
	protected $all;
	protected $user;

	function __construct($id, $all, $user )
	{
		parent::__construct();
		$this->spaceid=$id;
		$this->all=$all;
		$this->user=$user;
	}

	function toXML()
	{
			
		$dom = new DOMDocument('1.0','UTF-8');
		$dom->preserveWhiteSpace=false;
			
		$getVersion=$dom->createElement('get-versions');
			
			
		if ($this->id != null) {
			$getVersion->setAttribute('id', $this->id);
		}
		$getVersion->setAttribute('spaceid', $this->spaceid);
		$getVersion->setAttribute('user', $this->user);
		$getVersion->setAttribute('all', $this->all);
		 
		$dom->appendChild($getVersion);
			
		$XmlVersionString=$dom->saveXML();
		return $XmlVersionString;
	}

}
?>
