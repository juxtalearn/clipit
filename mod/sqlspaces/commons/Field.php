<?php

class Field
{
	 
	var $FieldType=array('ACTUAL'=>'ACTUAL','FORMAL'=>'FORMAL','SEMIFORMAL'=>'SEMIFORMAL','WILDCARD'=>'WILDCARD');
	private  $value;
	private  $type;
	private  $fieldType;
	private  $lowerBound;
	private  $upperBound;

	public function __construct($value=null,$type=null)
	{
		if(($value!=null||$value=="0"))
		{
			$fieldValue=$value;
			$fieldValue=str_replace("&","&#38;",$fieldValue);
			$fieldValue=str_replace("\n","&#10;",$fieldValue);
			$fieldValue=str_replace("\r","&#13;",$fieldValue);
			$fieldValue=str_replace("\t","&#9;;",$fieldValue);
			$newFieldValue=utf8_decode($fieldValue);

			$this->value=$newFieldValue;
			$this->type=$type;
			$this->fieldType = $this->FieldType['ACTUAL'];
		}
	}

	public function fromXML($nodeField,$doc)
	{
		$fieldTypeStr=$nodeField->getAttribute('fieldtype');
		$this->fieldType=strtoupper($fieldTypeStr);
		if($this->fieldType!=$this->FieldType['WILDCARD'])
		{
			$className=$nodeField->getAttribute('type');
			if(strnatcmp($className,"xml")!=0)
			{
				$this->type=$className;
				$ubStr=$nodeField->getAttribute('upper-bound');
				$lbStr=$nodeField->getAttribute('lower-bound');
				if ($this->fieldType!=$this->FieldType['FORMAL']|| $ubStr!=null || $lbStr!=null)
				{
					$this->value=$nodeField->nodeValue;
				}
				else
				{
					if($ubStr!=null)
					{
						$this->upperBound=$ubStr;
					}
					if($lbStr!=null)
					{
						$this->lowerBound=$lbStr;
					}
				}
			}
			elseif(strnatcmp($className,"xml")==0)
			{
				$this->type ="Document";
				if (!($this->fieldType == $this->FieldType['FORMAL']))
				{
					$doc = new DOMDocument();
					$doc->loadXML($nodeField->nodeValue);
					$this->value=$doc;
				}
			}
			elseif (strnatcmp($className,"binary")==0)
			{
				$this->type =$className;
				if ($this->fieldType == $this->FieldType['FORMAL']) {
					$base64String = $nodeField->nodeValue;
					$this->value = sqlite_udf_decode_binary($base64String);
				}
			}
			elseif (strnatcmp($className,"boolean")==0)
			{
				$this->type =$className;
				if ($this->fieldType == $this->FieldType['FORMAL']) {
					 
					$this->value = $nodeField->nodeValue;
				}
			}
		}
	}
	
	public function setType($type,$lowerBound=null,$upperBound=null)
	{
		$this->value = null;
		$this->type = $type;
		$this->lowerBound = $lowerBound;
		$this->upperBound = $upperBound;
		$this->fieldType = $this->FieldType['FORMAL'];
	}

	public function createWildCardField()
	{
		$this->setFieldType('WILDCARD');
		$this->type = null;
	}

	public function setFieldType($fieldType) {
		$this->fieldType = $fieldType;
		if ($this->isFormal() || $this->isWildcard()) {
			$this->value = null;
		}
	}

	public function getValue()
	{
		return $this->value;
	}
	
	public function getType()
	{
		return $this->type;
	}

	public function isWildcard()
	{
		return $this->fieldType == $this->FieldType['WILDCARD'];
	}

	public function isFormal()
	{
		return $this->fieldType == $this->FieldType['FORMAL'];
	}

	public function toXML($dom)
	{
		if($this->fieldType!=$this->FieldType['WILDCARD'])
		{
			if (!$this->isFormal()) {
				if($this->type=="Document")
				{
					$field = $dom->createElement("field");

					$cdata=$dom->createCDATASection(sqlite_udf_encode_binary($this->value));
					$field->appendChild($cdata);
				}
				elseif($this->type=="binary")
				{
					$field = $dom->createElement("field");
					$cdata=$dom->createCDATASection(sqlite_udf_encode_binary($this->value));
					$field->appendChild($cdata);
				}
				else
				{
					$field = $dom->createElement("field");
					$cdata=$dom->createCDATASection($this->value);
					$field->appendChild($cdata);
				}
			}
			else{
				$field = $dom->createElement("field");
			}
		}
		else{
			$field = $dom->createElement("field");
		}
			
		$field->setAttribute("fieldtype", strtolower($this->fieldType));
		 
		switch ($this->fieldType)
		{
			case $this->FieldType['WILDCARD']:
				return $field;
			default:
				if ($this->lowerBound != null) {
					$field->setAttribute("lower-bound", $this->lowerBound);
				}
				if ($this->upperBound != null) {
					$field->setAttribute("upper-bound", $this->upperBound);
				}

				if ($this->type=="Document") {
					$field->setAttribute("type", "xml");

				}
				else
				{
					$field->setAttribute("type", strtolower($this->type));
				}
				return $field;
		}
	}
		
}
?>
