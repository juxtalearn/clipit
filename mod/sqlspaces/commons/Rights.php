<?php

class Rights
{
	public $RightType=array('READ'=>'READ','WRITE'=>'WRITE','MANAGE'=>'MANAGE','CREATE'=>'CREATE','ADMIN'=>'ADMIN');
	var $rightByte;
	var $version;

	public function __construct($version=null, $typesArray=null)
	{
		if($typesArray!=null)
		{
			$this->version=$version;
			$keys=array_keys(self::$RightType);
			for ($index = 0; $index < sizeof($typesArray); $index++)
			{
				foreach($keys as $key => $value)
				{
					if($value==$typesArray[$index])
					{
						$this->rightByte+=pow(2,$key);
					}
				}

			}
		}
	}

	public function setRightByte($version, $rightByte)
	{
		$this->version = $version;
		$this->rightByte=$rightByte;
	}

	public function hasRight($rightType)
	{
		$keys=array_keys(self::$RightType);
		foreach($keys as $key => $value)
		{
			if($value==$rightType)
			{
				return (($this->rightByte &  pow(2,$key)) != 0);
			}
		}
	}

	public function getByte($withGlobal)
	{
		$keys=array_keys(self::$RightType);
		if ($withGlobal)
		{
			return $this->rightByte;
		}
		else
		{
			$byte = $this->rightByte;
			if ($this->hasRight(self::$RightType[CREATE]))
			{
				foreach($keys as $key => $value)
				{
					if($value==self::$RightType[CREATE])
					{
						$byte -= pow(2,$key);
					}
				}
			}
			if ($this->hasRight(self::$RightType[ADMIN]))
			{
				foreach($keys as $key => $value)
				{
					if($value==self::$RightType[ADMIN])
					{
						$byte -= pow(2,$key);
					}
				}
			}
			return $byte;
		}
	}
	
	public function getVersion() {
		return $this->version;
	}
}

?>
