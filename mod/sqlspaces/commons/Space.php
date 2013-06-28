<?php

class Space
{
	private $versions;
	private $id;
	private $name;
	private $currentVersion;

	function __construct($name=null, $id=null, $versions=null)
	{
		$this->id=$id;
		$this->name=$name;
		if($versions!=null)
		{
			$this->versions=$versions;
			$this->currentVersion=array_pop($versions);
		}
		elseif($versions==null)
		{
			$this->versions=array();
		}
	}

	function setAllVersion($v)
	{
		if($v!=null)
		{
			$this->versions=$v;
		}
	}

	public function setVersion(Version $v)
	{
		$this->currentVersion=$v;
	}

	public function getAllVersions()
	{
		return $this->versions;
	}

	public function getVersion()
	{
		if ($this->currentVersion == null)
		{

			return array_pop($this->versions);
		}
		else
		{
			return $this->currentVersion;
		}
	}

	public function getName()
	{
		return $this->name;
	}
	
	public function getId() {
		return $this->id;
	}

}
?>
