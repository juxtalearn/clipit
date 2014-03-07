<?php

abstract class TSCommand
{
	var $id;

	function __construct()
	{

		if(!isset($my_random_id))
		{
			$my_random_id = uniqid();
			$this->id=$my_random_id;
		}

	}

	function getId()
	{
		return $this->id;
	}

	function toString()
	{
	}

	abstract function toXML();

}
?>
