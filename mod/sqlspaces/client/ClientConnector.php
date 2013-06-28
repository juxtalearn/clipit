<?php
// require_once('XMLClientConnector.php');
// require_once('LocalConnector.php');
abstract class ClientConnector
{

	public static function getClientConnector($host=null, $port=null, $daemonMode=true)
	{
		if($host==null&&$port==null)
		{
			return new XMLClientConnector($this->getProperty('host'), $this->getProperty('port'), $daemonMode);
		}
		else
		{
			return new XMLClientConnector($host, $port, $daemonMode);
		}
	}

	function setTupleSpace($TSpace)
	{
		$this->tSpace=$TSpace;
	}

	abstract public function sendReceive($c);
}
?>
