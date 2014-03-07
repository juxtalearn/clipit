<?php
/**
 * User: malzahn
 * Date: 20.02.14
 * Time: 16:47
 */
define('ENDPOINT', "requestAnalysis");
include_once('config.php');

define("TemplateId", '1cf6f7ec-8df2-483c-b23d-73fdfd10f73d');
define("ReturnId",'r1');
define('ReturnURL',"http://localhost:80/~malzahn/jxlDefinitions/clipItDriver.php");
#define('AnalysisData',"Logfile Data to be used - still has to be defined & agreed");

define('AnalysisData', file_get_contents("DNA2.net"));

$data = array('TemplateId' => TemplateId, 'ReturnId' => ReturnId, 'ReturnURL'=>ReturnURL, 'AnalysisData' => base64_encode(AnalysisData));

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$runId = file_get_contents($url, false, $context);

echo "RunId:$runId";


