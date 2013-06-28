<?php

$dir=dirname(dirname(__FILE__));
require_once("$dir/commons/command/ConnectCommand.php");
require_once('ClientConnector.php');
require_once("$dir/commons/command/TSResponse.php");
require_once("$dir/commons/Version.php");
require_once("$dir/commons/command/GetVersionsCommand.php");
require_once("$dir/commons/command/QueryCommand.php");
require_once("$dir/commons/Field.php");
require_once("$dir/commons/Space.php");
require_once("$dir/commons/Tuple.php");
require_once("$dir/commons/Rights.php");
require_once("$dir/commons/command/WriteCommand.php");
require_once("$dir/commons/command/UpdateCommand.php");
require_once("$dir/commons/command/SetVersionCommand.php");
require_once("$dir/commons/command/GetAllUsersCommand.php");
require_once("$dir/commons/command/GetAllSpacesCommand.php");
require_once("$dir/commons/command/GetRightsCommand.php");
require_once("$dir/commons/command/LockCommand.php");
require_once('XMLClientConnector.php');
require_once('LocalConnector.php');


class TupleSpace
{
	const DEFAULT_SPACE = "defaultspace";
	const DEFAULT_PASSWORD = "sqlspaces";
	const DEFAULT_USER = "sqlspaces";

	private $connector;
	private $username;
	private $spaces;

	function __construct($spaces=self::DEFAULT_SPACE,$host= null,$port= null,$username=self::DEFAULT_USER,$password=self::DEFAULT_PASSWORD)
	{
		try {

			ini_set('include_path', $this->getProperty('pear').'pear' . PATH_SEPARATOR . ini_get('include_path'));
			if($host==null && $port==null)
			{
				$clientCon= new XMLClientConnector($this->getProperty('host'), $this->getProperty('port'), true);
			}
			else
			{
				$clientCon= new XMLClientConnector($host, $port, true);
			}

	 	$this->connector=$clientCon;
	 	if($spaces =='defaultspace' || !is_array($spaces))
	 	{
	 		$spaces= array($spaces);
	 	}

	 	$ccommand=new ConnectCommand($spaces,$username, $password);
	 	$tsresponse =$this->connector->sendReceive($ccommand);

	 	$tupleArray=$tsresponse->getTuples();
	 	$this->username=$username;

	 	$this->spaces=array();

	 	$versionArray=array();
	 	for ($i = 0; $i < count($tupleArray); $i++)
	 	{
	 		$fieldsArray=$tupleArray[$i]->getFields();
	 		$version = new Version($fieldsArray[2]->getValue(), $fieldsArray[3]->getValue(), $fieldsArray[4]->getValue(), $fieldsArray[5]->getValue(), $fieldsArray[6]->getValue(), $fieldsArray[7]->getValue(), $fieldsArray[8]->getValue(), $fieldsArray[9]->getValue());
	 		$spaceId=$fieldsArray[1]->getValue();
	 		$spaceName=$fieldsArray[0]->getValue();

	 		array_push($versionArray,$version);

	 		$newSpace= new Space($spaceName, $spaceId, $versionArray);
	 		array_push($this->spaces,$newSpace);
	 	}

	 	for ($i = 0; $i < count($this->spaces); $i++)
	 	{
	 		$setSpaceVersion=$this->spaces[$i];
	 		$vec=$this->getAllVersions($this->spaces[$i]);
	 		$setSpaceVersion->setAllVersion($vec);

	 		$ver =$this->getCurrentUserVersion($this->spaces[$i]);
	 		$this->spaces[$i]->setVersion($ver);
	 	}

		} catch (Exception $e) {
			echo 'Ausnahme gefangen TS1: ',  $e->getMessage(), "\n";
		}

	}

	public function getProperty($propertie)
	{
		$properties=parse_ini_file(dirname(dirname(__FILE__))."/config.ini");
		return $properties[$propertie];
	}

	public function closeSocket()
	{
		$this->connector->close();
	}

	public function getAllVersions($space)
	{
		try
		{
			$retValue = $this->getVersionTS($space,"true", "false");
			return $retValue;
		}
		catch (Exception $e)
		{
			echo 'Ausnahme gefangen TS2: ',  $e->getMessage(), "\n";
		}

	}
	public function getAllUserVersions($space)
	{
		try
		{
			$retValue = $this->getVersionTS($space,"true", "true");
			return $retValue;
		}
		catch (Exception $e)
		{
			echo 'Ausnahme gefangen TS2: ',  $e->getMessage(), "\n";
		}

	}
	function getCurrentUserVersion($space)
	{
		try {
			$retValue = $this->getVersionTS($space,"false","true");
			return $retValue[0];
		} catch (Exception $e) {
			echo 'Ausnahme gefangen TS3: ',  $e->getMessage(), "\n";
		}
	}

	function getCurrentVersion($space)
	{
		try {
			$retValue = $this->getVersionTS($space,"false","false");
			return $retValue[0];
		} catch (Exception $e) {
			echo 'Ausnahme gefangen TS3: ',  $e->getMessage(), "\n";
		}
	}


	function getVersionTS($space, $all, $user )
	{
		try {
			$retValue = array();
			$tmpversion=$space->getVersion();
			$resp = $this->connector->sendReceive(new GetVersionsCommand($space->getId(), $all, $user));
			if(strcasecmp($resp->getType(),  $resp->responseType['ANSWER']) == 0)
			{
				$tupleArray=array();
				$tupleArray=$resp->getTuples();
				for ($i = 0; $i < count($tupleArray); $i++)
				{
					$version=$tupleArray[$i]->getField(0)->getValue();
					$majVer=$tupleArray[$i]->getField(1)->getValue();
					$minVer=$tupleArray[$i]->getField(2)->getValue();
					$branch=$tupleArray[$i]->getField(3)->getValue();
					$name=$tupleArray[$i]->getField(4)->getValue();
					$group=$tupleArray[$i]->getField(5)->getValue();
					$lockedByUser=$tupleArray[$i]->getField(6)->getValue();
					$shared=$tupleArray[$i]->getField(7)->getValue();
					$version = new Version($version,$majVer, $minVer, $branch, $name, $group, $lockedByUser, $shared);
					array_push($retValue,$version);
				}
			}

			if ($tmpversion != null) {
				$space->setVersion($tmpversion);
			}
			return $retValue;
		} catch (Exception $e) {
			echo 'Ausnahme gefangen TS4: ',  $e->getMessage(), "\n";
		}
	}

	public function read($tuple, $readThisSpaces=null)
	{
		if($readThisSpaces==null)
		{
			$readThisSpaces=$this->getSpaceNames();
		}
		$spaceIds=$this->getSpaceIds($readThisSpaces);

		$resp = $this->connector->sendReceive(new QueryCommand($tuple, false, false, false, 0, $spaceIds));
		if ($resp->getType()==$resp->responseType['ANSWER'] && (count($resp->getTuples())!= 0))
		{
			$repsonse =$resp->getTuple(0);
			return $repsonse;
		}
		else
		{
			return null;
		}
	}

	public function readAll(Tuple $t, array $readThisSpaces=null)
	{
		if($readThisSpaces==null)
		{
			$readThisSpaces=$this->getSpaceNames();
		}
		$spaceIds=$this->getSpaceIds($readThisSpaces);

		$resp = $this->connector->sendReceive(new QueryCommand($t, true, false, false, 0, $spaceIds));

		if ($resp->getType()==$resp->responseType[ANSWER] && (count($resp->getTuples()) != 0)) {
			return $resp->getTuples();
		} else {
			return null;
		}
	}

	public function readTupleById($tupleId)
	{
		$tuple = new Tuple();
		$tuple->setTupleID($tupleId);
		return $this->read($tuple);
	}

	public function take(Tuple $t, array $readThisSpaces=null)
	{
		if($readThisSpaces==null)
		{
			$readThisSpaces=$this->getSpaceNames();
		}
		$spaceIds=$this->getSpaceIds($readThisSpaces);

		$resp = $this->connector->sendReceive(new QueryCommand($t, false, true, false, 0, $spaceIds));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0 && ($resp->getTupleCount() != 0))
		{
			return $resp->getTuple(0);
		}
		else
		{
			return null;
		}
	}

	public function takeAll($tuple, array $readThisSpaces=null)
	{
		if($readThisSpaces==null)
		{
			$readThisSpaces=$this->getSpaceNames();
		}
		$spaceIds=$this->getSpaceIds($readThisSpaces);

		$resp = $this->connector->sendReceive(new QueryCommand($tuple, true, true, false, 0, $spaceIds));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0 && ($resp->getTupleCount() != 0)) {
			return $resp->getTuples();
		}
		else
		{
			return null;
		}
	}

	public function takeTupleById($tupleID)
	{
		$tuple = new Tuple();
		$tuple->setTupleID($tupleID);
		return $this->take($tuple);
	}

	public function waitToRead(Tuple $t, $timeout=0, array $readThisSpaces=null)
	{
		if($readThisSpaces==null)
		{
			$readThisSpaces=$this->getSpaceNames();
		}

		$spaceIds=$this->getSpaceIds($readThisSpaces);

		$resp = $this->connector->sendReceive(new QueryCommand($t, false, false, true, $timeout, $spaceIds));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0 && ($resp->getTupleCount() != 0))
		{
			return $resp->getTuple(0);
		}
		else
		{
			return null;
		}
	}

	public function waitToTake(Tuple $t, $timeout=0, array $readThisSpaces=null)
	{
		if($readThisSpaces==null)
		{
			$readThisSpaces=$this->getSpaceNames();
		}
		$spaceIds=$this->getSpaceIds($readThisSpaces);

		$resp = $this->connector->sendReceive(new QueryCommand($t, false, true, true, $timeout, $spaceIds));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0 && ($resp->getTupleCount() != 0))
		{
			return $resp->getTuple(0);
		}
		else
		{
			return null;
		}
	}

	private function getSpaceNames() {
		$spacesStr =array();
		for ($i = 0; $i < count($this->spaces); $i++) {
			array_push($spacesStr,$this->spaces[$i]->getName());
		}
		return $spacesStr;
	}

	private function getSpaceIds($readThisSpaces)
	{
		$spaceIds = array();
		$spaceStr=null;
		for ($index = 0; $index < count($readThisSpaces); $index++) {
			$spaceStr=$readThisSpaces[$index];

			$found=false;

			for ($j = 0; $j < count($this->spaces); $j++) {
				$space=$this->spaces[$j];

				if(strcmp($space->getName(),$spaceStr)==0)
				{
					$found=true;
					array_push($spaceIds,$space->getId());
				}
			}
			if (!$found) {
				throw new Exception( "not connected to space '" . $spaceStr. "'");
			}
		}
		return $spaceIds;

	}
	/**
	 * Gibt alle Spaces des TupleSpaces zur�ck
	 *
	 * @return alle Spaces
	 * @throws TupleSpaceException
	 */
	public function getSpaces()
	{
		// Aktualisieren der Space-Versionen
		foreach($this->spaces as $space)
		{
			$version=$space->getVersion();
			$space->setAllVersion($this->getAllUserVersions($space));
			$space->setVersion($version);
		}
		return $this->spaces;
	}

	function write($tuple, $spaceName=null)
	{

		if($spaceName==null)
		{
			if (count($this->spaces) == 1)
			{
				$spaceName=$this->spaces[0]->getName();
			}
			else
			{
				throw new Exception('no space given to write into (connected to multiple spaces)');
			}
		}
		$spaceId=0;
		for ($i = 0; ($i < count($this->spaces) && ($spaceId == 0)); $i++)
		{
			if (strcmp($this->spaces[$i]->getName(),$spaceName) ==0)
			{
				$spaceId =$this->spaces[$i]->getId();
			}
		}
		if ($spaceId == 0)
		{
			throw new Exception("not connected to space '" );
		}
		$resp = $this->connector->sendReceive(new WriteCommand($tuple, $spaceId));
		if (strcmp($resp->getType(),$resp->responseType['ANSWER'])==0)
		{
			try
			{
				$idStr = $resp->getTuple(0)->getField(0)->getValue();
				$upleId=new TupleID($idStr);

				return $upleId;
			}
			catch (Exception $e)
			{
				echo 'Ausnahme gefangen TS5: ',  $e->getMessage(), "\n";
				return null;
			}
		}
		else
		{
			return null;
		}
	}

	public function update($tupleId, $tuple)
	{
		$resp = $this->connector->sendReceive(new UpdateCommand($tupleId, $tuple));
		$boolean=strcmp($resp->getType(),$resp->responseType[OK])==0;
		return $boolean;
	}

	public function setUserRights($userArray,$rightTypeArray,$space=null)
	{
		if($space==null)
		{
			if (count($this->spaces) > 1)
			{
				throw new TupleSpaceException("no space given (connected to multiple spaces)");
			}
			else
			{
				$this->connector->sendReceive(new RightsCommand($userArray, new Rights($this->spaces[0]->getVersion()->getVersion(), $rightTypeArray)));
			}
		}
		else
		{
			$this->connector->sendReceive(new RightsCommand($userArray, new Rights($space->getVersion()->getVersion(), $rightTypeArray)));
		}
	}

	public function getMyRights($space=null)
	{

		if($space==null)
		{
			if (count($this->spaces) > 1)
			{
				throw new TupleSpaceException("no space given (connected to multiple spaces)");
			}
			else
			{
				$resp = $this->connector->sendReceive(new GetRightsCommand($this->spaces[0]->getVersion()->getVersion()));
				if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0)
				{
					$byteValue = $resp->getTuple(0)->getField(0)->getValue();
					$rights=new Rights();
					$rights->setRightByte($this->spaces[0]->getVersion(), $byteValue);
					return $rights;
				}
			}
		}
		if($space!=null)
		{
			$resp = $this->connector->sendReceive(new GetRightsCommand($this->spaces[0]->getVersion()->getVersion()));
			if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0)
			{
				$byteValue = $resp->getTuple(0)->getField(0)->getValue();
				$rights=new Rights();
				$rights->setRightByte($space->getVersion(), $byteValue);
				return $rights;
			}
		}
	}

	public function getChangedTuple($version1, $version2, $tupleTemplate)
	{

		$ret = array();

		$resp = $this->connector.sendReceive(new ChangeCommand(ChangeCommand::$changeType[CHANGED], $version1, $version2, $tupleTemplate));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0)
		{
			$tuples = $resp->getTuples();

			for ($i = 0; $i < count($tuples); $i++)
			{
				array_push($ret,$tuples[$i]);
			}
		}
		return $ret;
	}

	public function getDeletedTuple($version1, $version2, $tupleTemplate)
	{
		$ret = array();

		$resp = $this->connector.sendReceive(new ChangeCommand(ChangeCommand::$changeType[DELETE], $version1, $version2, $tupleTemplate));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0)
		{
			$tuples = $resp->getTuples();

			for ($i = 0; $i < count($tuples); $i++)
			{
				array_push($ret,$tuples[$i]);
			}
			return $ret;
		}
		else
		{
			return $ret;
		}
	}

	public function getNewAndChangedTuple($version1, $version2, $tupleTemplate)
	{
		$ret = array();

		$resp = $this->connector->sendReceive(new ChangeCommand(ChangeCommand::$changeType[NEW_AND_CHANGED], $version1, $version2, $tupleTemplate));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0)
		{
			$tuples = $resp->getTuples();

			for ($i = 0; $i < count($tuples); $i++)
			{
				array_push($ret,$tuples[$i]);
			}
		}
		return $ret;
	}

	public function changeSpaceVersion($space, $versionsId, $major, $minor, $branch, $name)
	{
		$resp = $this->connector->sendReceive(new ChangeVersionsCommand($space->getId(), $versionsId, $major, $minor, $branch, $name));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0)
		{
			$space->setAllVersion($this->getAllVersions($space));
		}
	}
	 
	public function getAllSpaces()
	{
		$resp = $this->connector->sendReceive(new GetAllSpacesCommand());
		$spacesArray = array();
		$tuples=$resp->getTuples();
		for ($i = 0; $i < count($tuples); $i++)
		{
			$tuple = $resp->getTuple($i);
			$space=new Space($tuple->getField(0)->getValue(), $tuple->getField(1)->getValue());
			array_push($spacesArray,$space);
		}
		return $spacesArray;
	}

	/**
	 * Gibt ein Array mit allen registrierten Benutzer zurueck
	 *
	 * @return Array mit Benutzernamen
	 */
	public function getUsers()
	{
		$userArray =array();
		$resp = $this->connector->sendReceive(new GetAllUsersCommand(-2147483648));
		if (strcmp($resp->getType(),$resp->responseType['ANSWER'])==0)
		{
			$tuples = $resp->getTuples();
			 
			for ($index = 0; $index < sizeof($tuples); $index++)
			{
				array_push($userArray,new User($tuples->getField(0)->getValue()));
			}
		}
		return $userArray;
	}
	/**
	 * Setzt einen Lock (true/false) auf die Version.
	 *
	 * @param version
	 *                Version die gesperrt/entsperrt werden soll
	 * @param lock
	 *                sperren/entsperren
	 *
	 * @return Erfolg des lock/unlock
	 * @throws TupleSpaceException
	 */
	public function setLock($version, $lock)
	{

		$resp = $this->connector->sendReceive(new LockCommand($version->getVersion(), $lock));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0)
		{
			$tuple = $resp->getTuple(0);
			return $tuple->getField(0)->getValue();
		}
		else
		{
			return false;
		}
	}

	public function createNewVersionForAllSpaces()
	{
		for ($index = 0; $index < sizeof($this->spaces); $index++)
		{
			$space=$this->spaces[$index];
			$this->createNewVersion($space);
		}
	}

	/**
	 * Es wird fuer einen Space des TupleSpaces eine neue Version angelegt. Die
	 * aktuellen Versionen werden dann aus dem SpaceManager geholt und lokal in
	 * spaces[] geschrieben.
	 *
	 * @return neue Version des TupelSpace
	 * @throws TupleSpaceException
	 */

	public function createNewVersion($mySpace=null)
	{
		$version = $mySpace->getVersion();
		$newVersion = new Version(0, $version->getMajor(), $version->getMinor(), $version->getBranch(), $version->getNameV(), $version->getGroup(), 0, "false");
		$resp = $this->connector->sendReceive(new SetVersionCommand($version->getVersion(), $newVersion, $mySpace->getId(), true));
		$tupleArray= $resp->getTuples();
		$fieldArray = $tupleArray[0]->getFields();
		$version = new Version( $fieldArray[0]->getValue(), $fieldArray[1]->getValue(), $fieldArray[2]->getValue(), $fieldArray[3]->getValue(), $fieldArray[4]->getValue(), $fieldArray[5]->getValue(), $fieldArray[6]->getValue(), $fieldArray[7]);

		for ($index = 0; $index < sizeof($this->spaces); $index++)
		{
			if ($this->spaces[$index]->getId() == $mySpace->getId())
			{
				$this->spaces[$index]->setVersion($version);
				break;
			}
		}
		return $version;
	}

	/**
	 * Setzt auf dem SpaceManager ist Version des Spaces. Die Version muss aber
	 * im Vector des Spaces vorhanden sein!
	 *
	 * @param mySpace
	 *                Space dessen Version gesetzt werden soll
	 * @param myVersion
	 *                Version die der Space erhalten soll
	 *
	 */
	public function setSpaceVersion($mySpace, $myVersion)
	{
		$resp = $this->connector->sendReceive(new SetVersionCommand($myVersion->getVersion(), null, $mySpace->getId(), "false"));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0)
		{
			$versionArray = $mySpace->getAllVersions();
			for ($index = 0; $index < sizeof($versionArray); $index++)
			{
				if ($myVersion->getVersion() == $versionArray[$index]->getVersion())
				{
					$mySpace->setVersion($myVersion);
				}
			}
		}
	}

	public function shareVersionWithUsers($users, $space)
	{
		$resp = $this->connector->sendReceive(new RightsCommand($users, new Rights($space->getVersion()->getVersion(), array(Rights::$RightType[WRITE],Rights::$RightType[READ]))));
		if (strcmp($resp->getType(),$resp->responseType[ANSWER])==0)
		{
			 
			for ($i = 0; $i < count($users); $i++)
			{
				$tuple=new Tuple();
				$tuple->addActualFields(array("Invitation", $users[$i], $space->getVersion()->getVersion()));
				$this->write($tuple,$space->getName());
			}
		}
		return TRUE;
	}
}

?>
