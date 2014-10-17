<?php

class ActivityStreamer {
    static function get_metric($metric_id, $return_id, $context) {
        global $con;
        global $CONFIG;

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


        $workbenchurl = $workbenchurl."/requestAnalysis";
        $return_url = elgg_get_site_url() . "services/api/rest/xml/?method=clipit.la.save_metric";
        //$return_url = "http://176.28.14.94/~workbench/jxlDefinitions/clipItDriver.php";
        $sql = "SELECT json FROM ".$CONFIG->dbprefix."activitystreams";
        $filter = "";
        $parameter_string = "";
        //If $context is not an array, we will simply initialize an empty array
        if (!is_array($context)) {
            $context = array();
        }
        if (isset($context['actor_id']) && ($context['actor_id'] != 0)) {
            $filter = $filter."(`actor_id` = ?)";
        }
        else {
            $filter = $filter."(`actor_id` = ? OR TRUE)";
            $context['actor_id'] = 0;
        }
        if (isset($context['object_id']) && ($context['object_id'] != 0)) {
            $filter = $filter." AND (`object_id` = ?)";
        }
        else {
            $filter = $filter." AND (`object_id` = ? OR TRUE)";
            $context['object_id'] = 0;
        }
        if (isset($context['group_id']) && ($context['group_id'] != 0)) {
            $filter = $filter." AND (`group_id` = ?)";
        }
        else {
            $filter = $filter." AND (`group_id` = ? OR TRUE)";
            $context['group_id'] = 0;
        }
        if (isset($context['activity_id']) && ($context['activity_id'] != 0)) {
            $filter = $filter." AND (`activity_id` = ?)";
        }
        else {
            $filter = $filter." AND (`activity_id` = ? OR TRUE)";
            $context['activity_id'] = 0;
        }
        if (isset($context['verb']) && ($context['verb'] != "")) {
            $filter = $filter." AND (`verb` = ?)";
        }
        else {
            $filter = $filter." AND (`verb` = ? OR TRUE)";
            $context['verb'] = "";
        }
        if (isset($context['role']) && ($context['role'] != "")) {
            $filter = $filter." AND (`role` = ?)";
        }
        else {
            $filter = $filter." AND (`role` = ? OR TRUE)";
            $context['role'] = "";
        }
        if (isset($context['lowerbound']) && ($context['lowerbound'] != 0)) {
            $filter = $filter." AND (`timestamp` >= ?)";
        }
        else {
            $filter = $filter." AND (`timestamp` >= ? OR TRUE)";
            $context['lowerbound'] = 0;
        }
        if (isset($context['upperbound']) && ($context['upperbound'] != 0)) {
            $filter = $filter." AND (`timestamp` <= ?)";
        }
        else {
            $filter = $filter." AND (`timestamp` <= ? OR TRUE)";
            $context['upperbound'] = 0;
        }
        if ($filter != "") {
            $sql = $sql." WHERE ". $filter;
        }
        $sql = $sql." ORDER BY `stream_id`;";
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
            $activities[] = $json_entry;
        }
        $statement->close();
        $json = json_encode($activities);

        $user = elgg_get_logged_in_user_entity();
        create_user_token($user->name, 60);
        $token_array = get_user_tokens(elgg_get_logged_in_user_guid(), $CONFIG->site_id);
        $token = $token_array[0];
        $token_string = $token->token;

        define('AnalysisData', $json);
        $data = array('AuthToken' => $token_string, 'TemplateId' => $metric_id, 'ReturnId' => $return_id, 'ReturnURL' => $return_url, 'AnalysisData' => base64_encode(AnalysisData));
// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
                'timeout' => 15
            ),
        );
        $request_context  = stream_context_create($options);
        //$json_size = strlen($json);
        //error_log($json_size);
        //error_log($return_url);
        $runId = file_get_contents($workbenchurl, false, $request_context);

        return $runId;
    }


    static function get_available_metrics() {
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


        $workbenchurl = $workbenchurl."/requestAvailableTemplates";

        $options = array(
            'http' => array(
                'method'  => 'GET',
                'timeout' => 15
            ),
        );
        $request_context  = stream_context_create($options);


        # retrieve JSON-String
        $jsonArrayString = file_get_contents($workbenchurl, false, $request_context);
        # converst JSON-String to JSON data structure
        $jsonArray = json_decode($jsonArrayString,true);

        #output
        if (empty($jsonArray)) {
            echo "No Templates found! Please ensure that you have saved some in the Workbench!";
        } else { # if the array is not empty, every array item should contain all three of the variables below
            foreach ($jsonArray as $entry) {
                $templateId = $entry["TemplateId"]; //String
                $templateName = $entry["Name"]; //String
                $templateDescription = $entry["Description"]; //String
                $metrics[] = ["TemplateId" => $templateId, "Name" => $templateName, "Description" => $templateDescription];
            }
        }
        return $metrics;
    }
}

