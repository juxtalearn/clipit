<?php

require_once('TupleID.php');
class Tuple
{
	private $fieldsArray;//array

	const DELIMITER = "_";

	private  $space;

	private $creationTimestamp ;

	private $lastModificationTimestamp;

	private $expiration=-1;

	private $tupleID;

	private $username = null;

	private $major;

	private $minor;

	private $version;

	public function __construct($fields=null)
	{
		$this->tupleID = new TupleID();
		$this->tupleID->initialize(false);
		if($fields!=null)
		{
			$this->fieldsArray=$fields;
		}
		if($fields==null)
		{
			$this->fieldsArray=array();
		}
	}


	public function setTupleInXML($tupleNode,$doc)
	{
		$fieldNodess=$tupleNode->getElementsByTagName('field');
		foreach($fieldNodess as $field)
		{

			$newField=new Field();
			$newField->fromXML($field,$doc);
			array_push($this->fieldsArray,$newField);

		}
		if ($tupleNode->getAttribute('id') != null) {
			$tupleID = new TupleID();
			$tupleID->setIdStr($tupleNode->getAttribute('id'));
			$this->tupleID=$tupleID;
		}
		if ($tupleNode->getAttribute('creationTimestamp')  != null) {
			$this->creationTimestamp = intval($tupleNode->getAttribute('creationTimestamp'));
		}
		if ($tupleNode->getAttribute('lastModificationTimestamp') != null) {
			$this->lastModificationTimestamp = intval($tupleNode->getAttribute('lastModificationTimestamp'));
		}
		if ($tupleNode->getAttribute('expiration')  != null) {
			$this->expiration =$tupleNode->getAttribute('expiration');
		}
		if ($tupleNode->getAttribute('username')!= null) {
			$this->username = $tupleNode->getAttribute('username');
		}
		if ($tupleNode->getAttribute('major') != null) {
			$this->major = intval($tupleNode->getAttribute('major'));
		}
		if ($tupleNode->getAttribute('minor')  != null) {
			$this->minor = intval($tupleNode->getAttribute('minor'));
		}
		if ($tupleNode->getAttribute('version')  != null) {
			$this->version = intval($tupleNode->getAttribute('version'));
		}
	}

	public function addActualFields($objectFields,$types=null)
	{
		for ($i = 0; $i < count($objectFields); $i++)
		{
			if (is_object($objectFields[$i]) && get_Class($objectFields[$i])=='Field') {
				array_push($this->fieldsArray,$objectFields[$i]);
			}
			else
			{
				$newField=new Field($objectFields[$i],$types[$i]);
				array_push($this->fieldsArray,$newField);
			}
		}
	}
	 
	public function addActualField($objectField,$type=null)
	{
		if (get_Class($objectField)=='Field')
		{
			array_push($this->fieldsArray,$objectField);
		}
		else
		{
			$newField=new Field($objectField,$type);
			array_push($this->fieldsArray,$newField);
		}
	}
	
	public function addField($field)
	{
		array_push($this->fieldsArray,$field);
	}
	 
	public function addFormalFields($dataTypes)
	{
		for ($i = 0; $i < count($dataTypes); $i++)
		{
			$field=new Field();
			$field->setType($dataTypes[$i]);
			array_push($this->fieldsArray,$field);
		}
	}

	public function addFormalField($dataType)
	{
		$field=new Field();
		$field->setType($dataType);
		array_push($this->fieldsArray,$field);
	}
	
	public function addWildcardField()
	{
		$field=new Field();
		$field->setFieldType('WILDCARD');
		array_push($this->fieldsArray,$field);
	}
	
	public function addSemiformalField($value)
	{
		$field=new Field($value, "string");
		$field->setFieldType('SEMIFORMAL');
		array_push($this->fieldsArray,$field);
	}
	
	public function addInverseField($value)
	{
		$field=new Field($value, "string");
		$field->setFieldType('INVERSE');
		array_push($this->fieldsArray,$field);
	}
	
	public function getFields()
	{
		return $this->fieldsArray;
	}
	
	public function getField($i)
	{
		return $this->fieldsArray[$i];
	}
	
	public function getExpiration()
	{
		return $this->expiration;
	}

	public function getExpirationTimestamp()
	{
		if ( $this->expiration == -1) {
			return $this->expiration;
		} else {
			return microtime(TRUE) + $this->expiration;
		}
	}
	
	public function toXML($dom)
	{
		$tuple = $dom->createElement("tuple");
		if ($this->tupleID->isTupleInitialized()) {
			$tuple->setAttribute("id",$this->tupleID->getTupleId());
		}
		if ($this->creationTimestamp != null) {
			$tuple->setAttribute("creationTimestamp", $this->creationTimestamp);
		}
		if ($this->lastModificationTimestamp != null) {
			$tuple->setAttribute("lastModificationTimestamp", $this->lastModificationTimestamp);
		}
		if ($this->expiration != -1) {
			$tuple->setAttribute("expiration", $this->expiration);
		}
		if ($this->major != null) {
			$tuple->setAttribute("major",$this->major);
		}
		if ($this->minor != null) {
			$tuple->setAttribute("minor", $this->minor);
		}
		if ($this->version != null) {
			$tuple->setAttribute("version",  $this->version);
		}
		if ($this->username != null) {
			$tuple->setAttribute("username", $this->username);
		}
		for ($index = 0; $index < sizeof($this->fieldsArray); $index++) {
				
			$tuple->appendChild($this->fieldsArray[$index]->toXML($dom));
		}
		return $tuple;
	}
	
	public function getTupleID()
	{
		return $this->tupleID;
	}
	
	public function setTupleID($tupleID)
	{
		$this->tupleID=$tupleID;
	}

}

?>
