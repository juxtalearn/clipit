<?php

ini_set('include_path', getProperty('pear').'pear' . PATH_SEPARATOR . ini_get('include_path'));
function getProperty($propertie)
{
	$properties=parse_ini_file(dirname(dirname(__FILE__))."/config.ini");
	return $properties[$propertie];
}

require_once("Net/Socket.php");

class XMLClientConnector
{
	var $socket;
	var $response;
	var $lastEvents;

	private $host;
	private $port;

	function __construct($host, $port, $daemonMode)
	{
		//Neues Objekt ableiten
		$this->socket = new Net_Socket() ;

		// Verbindung zum Zeit-Server aufbauen
		$result=$this->socket->connect($host, $port);
		// Ist ein Fehler beim Verbindungsaufbau aufgetreten?
		if (true===PEAR::isError($result))
		{
			die ($result->getMessage());
		}

	}

	public function sendReceive($c)
	{
		$stringIn = $c->toXML();
		$stringIn = substr($stringIn, 39);
			
		$this->socket->write($stringIn);
			
		$resp =$this->read();
		if ($resp->getType() == $resp->responseType['ERROR'] ) {

			throw new Exception('TupleSpaceException');
		}
		return $resp;
			
	}

	public function read()
	{
		$result = $this->socket->readLine();

		// Fehler aufgetreten?
		if (true===PEAR::isError($result))
		{
			die ($result->getMessage());
		}

		if($result!=null)
		{
			$doc = new DOMDocument();

			$response=utf8_encode($result);
			$doc->loadXML($response);
			$doc->preserveWhiteSpace=false;
				
			$responses=$doc->getElementsByTagName('response');
			$tsResponse= new TSResponse($responses->item(0),$doc);
			return $tsResponse;
		}
	}

	public function change($response)
	{
		$newResonse=str_replace("&#10","\n",$response);
		$newResonse=str_replace("&#xC4;","�",$response);
		$newResonse=str_replace("&#xE4;","�",$response);
		$newResonse=str_replace("&#xDC;","�",$response);
		$newResonse=str_replace("&#xFC;","�",$response);
		$newResonse=str_replace("&#xF6;","�",$response);
		$newResonse=str_replace("&#xD6;","�",$response);
		return $newResonse;
	}

	public function close()
	{
		$this->socket->disconnect();
	}

}
?>
