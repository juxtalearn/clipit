<?php
/**
 * User: malzahn
 * Date: 21.02.14
 * Time: 08:21
 */

define("LOGFILE","/tmp/clipitoutput.txt");
$returnId = $_POST['returnId']; //id of the request the following data is returned for.
                                //The Id has been submitted by ClipIt earlier. Thus it should know what to do with it.
$htmlData = $_POST['data']; //html snippet to be visualized. Currently a full HTML file including scripts etc.
                            // Can be viewed in a browser immediately.
$statusCoce = $_POST['statuscode']; //informs about the result of the process: if statuscode==3, the analysis process had no errors. data contains valid html.
                                       // if statuscode==5,  the analysis process had errors. data contains errormessage

$file = fopen(LOGFILE,"a");
fwrite($file,date("DMYY H:i:s "));
fwrite($file, $htmlData);
fwrite($file,"\n");
fclose($file);
