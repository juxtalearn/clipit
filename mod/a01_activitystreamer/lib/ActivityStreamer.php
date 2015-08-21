<?php

class ActivityStreamer
{



    static function get_metric($metric_id, $context)
    {

        if (empty($metric_id) && ActivityStreamer::valid_metric_id($metric_id)) {
            error_log("ActivityStreamer couldn't handle the get_metric request due to a missing or invalid metric_id!");
            return false;
        }
//        elseif (empty($return_id) && valid_return_id($return_id)) {
//            error_log("ActivityStreamer couldn't handle the get_metric request due to a missing or invalid clipit_la object!");
//            $clipit_la = false;
//        }
        else {
            //Retrieve the workbenchurl from the configuration
            $entities = elgg_get_entities(array("types" => "object", "subtypes" => "modactivitystreamer", "owner_guids" => '0', "order_by" => "", "limit" => 0));
            if (!isset($entities[0])) {
                $workbenchurl = "https://analyticstk.rias-institute.eu:1443";
                $entity = new ElggObject;
                $entity->subtype = 'modactivitystreamer';
                $entity->owner_guid = $_SESSION['user']->getGUID();
                $entity->workbenchurl = $workbenchurl;
                $entity->access_id = 2;    //Make sure this object is public.
            } else {
                $entity = $entities[0];
                $workbenchurl = $entity->workbenchurl;
            }


            $workbenchurl = $workbenchurl . "/requestAnalysis";
            $return_url = elgg_get_site_url() . "services/api/rest/xml/?method=clipit.la.save_metric";
            //$return_url = "http://176.28.14.94/~workbench/jxlDefinitions/clipItDriver.php";


            if (! ($json =  elgg_trigger_plugin_hook('activitystreamer',$metric_id, array('metric_id'=>$metric_id,'context' => $context), false))) {
              //Default behaviour
                $json = self::assemble_data($context);
            }
            $hashed_data = md5($json);
            $existing_id = check_for_existing_results($metric_id, $hashed_data);
            //TODO Check for missing return data
            if ($existing_id > 0) {
                //if we found an existing result, we will return its id
                return $existing_id;
            } else {
                //else we will create a new object, store this request in our database and return the id of the new object
                $return_id = ClipitLA::create(array());
//                $prop_value_array["return_id"] = (int)$return_id;
                $prop_value_array["metric_id"] = $metric_id;
                $prop_value_array["context"] = $context;
                $prop_value_array["metric_received"] = false;
                ClipitLA::set_properties($return_id, $prop_value_array);
                $timestamp = time();
                store_analysis_request($return_id, $metric_id, $hashed_data, $timestamp);
            }


            //Get the user auth token
            $user = elgg_get_logged_in_user_entity();
            $token_string = ClipitSite::get_token($user->username);

            //Create and make the request to the workbench
            define('AnalysisData', $json);
            $data = array('AuthToken' => $token_string, 'TemplateId' => $metric_id, 'ReturnId' => $return_id, 'ReturnURL' => $return_url, 'AnalysisData' => base64_encode(AnalysisData));
            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data),
                    'timeout' => 10,
                ),
            );
            $request_context = stream_context_create($options);
            //$json_size = strlen($json);
            //error_log($json_size);
            //error_log($return_url);
            file_get_contents($workbenchurl, false, $request_context);

        }
        return $return_id;
    }

    static function valid_metric_id($metric_id)
    {
        $valid = false;
        $metrics = ActivityStreamer::get_available_metrics();
        foreach ($metrics as $metric) {
            if ($metric["TemplateId"] == $metric_id) {
                $valid = true;
            }
        }
        return $valid;
    }


    static function valid_return_id($return_id)
    {
        $valid = false;
        $clipit_la = ClipitSite::lookup($return_id);
        if ($clipit_la instanceof ElggObject && $clipit_la->getSubtype() == ClipitLA::SUBTYPE) {
            $valid = true;
        }
        return $valid;
    }


    static function get_available_metrics()
    {
        $metrics = array();
        define('ENDPOINT', "requestAvailableTemplates");
        $entities = elgg_get_entities(array("types" => "object", "subtypes" => "modactivitystreamer", "owner_guids" => '0', "order_by" => "", "limit" => 0));
        if (!isset($entities[0])) {
            $workbenchurl = "https://analyticstk.rias-institute.eu:1443";
            $entity = new ElggObject;
            $entity->subtype = 'modactivitystreamer';
            $entity->owner_guid = $_SESSION['user']->getGUID();
            $entity->workbenchurl = $workbenchurl;
            $entity->access_id = 2;    //Make sure this object is public.
        } else {
            $entity = $entities[0];
            $workbenchurl = $entity->workbenchurl;
        }


        $workbenchurl = $workbenchurl . "/requestAvailableTemplates";
        $options = array(
            'http' => array(
                'method' => 'GET',
                'timeout' => 10,
            ),
        );
        $request_context = stream_context_create($options);

        # retrieve JSON-String
        $jsonArrayString = file_get_contents($workbenchurl, false, $request_context);
        # converst JSON-String to JSON data structure
        $jsonArray = json_decode($jsonArrayString, true);
        #output
        if (empty($jsonArray)) {
            echo "No Templates found! Please ensure that you have saved some in the Workbench!";
        } else { # if the array is not empty, every array item should contain all three of the variables below
            foreach ($jsonArray as $entry) {
                $templateId = $entry["TemplateId"]; //String
                $templateName = $entry["Name"]; //String
                $templateDescription = $entry["Description"]; //String
                $metrics[] = array("TemplateId" => $templateId, "Name" => $templateName, "Description" => $templateDescription);
            }
        }
        return $metrics;
    }

    /**
     * //Assemble the sql request based on the given context
     * @param $context
     * @param $CONFIG
     * @param $con
     * @param $json_entry
     * @return array
     */
    protected static function assemble_data($context, $CONFIG, $con, $json_entry)
    {
        global $con;
        global $CONFIG;

        $sql = "SELECT json FROM " . $CONFIG->dbprefix . "activitystreams";
        $filter = "";
        $parameter_string = "";
        //If $context is not an array, we will simply initialize an empty array
        if (!is_array($context)) {
            $context = array();
        }
        if (isset($context['actor_id']) && ($context['actor_id'] != 0)) {
            $filter = $filter . "(`actor_id` = ?)";
        } else {
            $filter = $filter . "(`actor_id` = ? OR TRUE)";
            $context['actor_id'] = 0;
        }
        if (isset($context['object_id']) && ($context['object_id'] != 0)) {
            $filter = $filter . " AND (`object_id` = ?)";
        } else {
            $filter = $filter . " AND (`object_id` = ? OR TRUE)";
            $context['object_id'] = 0;
        }
        if (isset($context['group_id']) && ($context['group_id'] != 0)) {
            $filter = $filter . " AND (`group_id` = ?)";
        } else {
            $filter = $filter . " AND (`group_id` = ? OR TRUE)";
            $context['group_id'] = 0;
        }
        if (isset($context['activity_id']) && ($context['activity_id'] != 0)) {
            $filter = $filter . " AND (`activity_id` = ?)";
        } else {
            $filter = $filter . " AND (`activity_id` = ? OR TRUE)";
            $context['activity_id'] = 0;
        }
        if (isset($context['verb']) && ($context['verb'] != "")) {
            $filter = $filter . " AND (`verb` = ?)";
        } else {
            $filter = $filter . " AND (`verb` = ? OR TRUE) AND (`verb` <> 'login') AND (`verb` <> 'logout')";
            $context['verb'] = "";
        }
        if (isset($context['role']) && ($context['role'] != "")) {
            $filter = $filter . " AND (`role` = ?)";
        } else {
            $filter = $filter . " AND (`role` = ? OR TRUE)";
            $context['role'] = "";
        }
        if (isset($context['lowerbound']) && ($context['lowerbound'] != 0)) {
            $filter = $filter . " AND (`timestamp` >= ?)";
        } else {
            $filter = $filter . " AND (`timestamp` >= ? OR TRUE)";
            $context['lowerbound'] = 0;
        }
        if (isset($context['upperbound']) && ($context['upperbound'] != 0)) {
            $filter = $filter . " AND (`timestamp` <= ?)";
        } else {
            $filter = $filter . " AND (`timestamp` <= ? OR TRUE)";
            $context['upperbound'] = 0;
        }
        if ($filter != "") {
            $sql = $sql . " WHERE " . $filter;
        }

        if (isset($context['debug']) && ($context['debug'] == true)) {
            $sql = $sql . " ORDER BY `stream_id` DESC LIMIT 100;";
        } else {
            $sql = $sql . " ORDER BY `stream_id`;";
        }

        //error_log($sql);
        $statement = $con->stmt_init();
        $statement->prepare($sql);
        $statement->bind_param("iiiissii",
            $context['actor_id'], $context['object_id'], $context['group_id'], $context['activity_id'],
            $context['verb'], $context['role'], $context['lowerbound'], $context['upperbound']);
        $statement->execute();
        $statement->store_result();
        $statement->bind_result($json_entry);
        $activities = "";
        while ($statement->fetch()) {
            /*                $json_array = json_decode($json_entry);
                            if (strlen($json_array['object']['content']) > 20) {
                                $json_array['object']['content'] = substr($json_array['object']['content'], 0, 19);
                            }*/
            $activities[] = $json_entry;
        }
        $statement->close();
        $json = json_encode($activities);
        return $json;
    }
}

function store_analysis_request($return_id, $metric_id, $hashed_data, $timestamp)
{
    global $con;
    global $store_analysis_statement;
    if ($store_analysis_statement instanceof mysqli_stmt) {
        $store_analysis_statement->bind_param('issi', $return_id, $metric_id, $hashed_data, $timestamp);
        $store_analysis_statement->execute();
    } else {
        error_log(mysqli_error($con));
    }
}


function check_for_existing_results($metric_id, $hashed_data)
{
    global $con;
    $get_analysis_statement = $con->prepare("SELECT return_id FROM `" . $_SESSION['analysis_table'] . "` " .
        "WHERE metric_id = ? AND hashed_data = ?;");
    $existing_id = 0;
    //Check whether there is an existing result matching the request
    if ($get_analysis_statement instanceof mysqli_stmt) {
        $get_analysis_statement->bind_param('ss', $metric_id, $hashed_data);
        $get_analysis_statement->execute();
        $get_analysis_statement->store_result();
        $get_analysis_statement->bind_result($id_entry);

        //if there is, we simply need the id, otherwise we will return 0
        if ($get_analysis_statement->fetch()) {
            $existing_id = $id_entry;
        }
    } else {
        error_log(mysqli_error($con));
    }
    return $existing_id;
}
