<?php

class TSResponse
{
	private $tupleArray;
	private $id;
	private $type;
	public $responseType = array('ANSWER' => 'ANSWER', 'ERROR' => 'ERROR', 'OK' =>'OK');

	public function __construct($response,$doc)
	{
		try
		{
			$this->type=strtoupper($response->getAttribute('type'));
			$this->id=$response->getAttribute('id');
			$this->tupleArray=array();

			$tuples=$response->getElementsByTagName('tuple');

			foreach($tuples as $tuple)
			{
				$newTuple=new Tuple();
				$newTuple->setTupleInXML($tuple,$doc);
				array_push($this->tupleArray,$newTuple);
			}
		}
		catch (Exception $e)
		{
			echo 'Ausnahme gefangen TSResponse : ',  $e->getMessage(), "\n";
		}
	}

	public function setErrorResponse($type, $tuples, $id)
	{
		$this->type=$type;
		$this->tupleArray=array();
		$this->tupleArray=$tuples;
		$this->id=$id;
	}

	function getTuples()
	{
		return $this->tupleArray;
	}

	function getTuple($i)
	{
		return $this->tupleArray[$i];
	}

	function getType()
	{
		return $this->type;
	}

	public function getTupleCount() {
		return count($this->tupleArray);
	}

	function getId()
	{
		return $this->id;
	}

}
?>
