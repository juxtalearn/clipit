<?php

class Version
{

	private $version;

	private $major;

	private $minor;

	private $branch;

	private $name;

	private $group;

	private $lockedByUser;

	private $shared;

	public function __construct($version,$majVer, $minVer, $branch, $name, $group, $lockedByUser, $shared)
	{
		$this->version=$version;
		$this->major=$majVer;
		$this->minor=$minVer;
		$this->branch=$branch;
		$this->name=$name;
		$this->group=$group;
		$this->lockedByUser=$lockedByUser;
		$this->shared=$shared;
	}

	public function getBranch() {
		return $this->branch;
	}

	public function getGroup() {
		return $this->group;
	}

	public function getMajor() {
		return $this->major;
	}

	public function getMinor() {
		return $this->minor;
	}

	public function getNameV() {
		return $this->name;
	}

	public function getVersion() {
		return $this->version;
	}
	public function isShared() {
		return $this->shared;
	}

	public function lockedByUser() {
		return $this->lockedByUser;
	}

	public function toString() {
		return $this->major.'.'. $this->minor;
	}

}
?>
