<?php

class ActivityStreamer {
    static function get_metric($metric_id, $return_id, $context) {
        global $con;
        global $CONFIG;
        $return_url = elgg_get_site_url() . "services/api/rest/xml/?method=clipit.la.save_metric";
        $sql = "SELECT json FROM ".$CONFIG->dbprefix."activitystreams";
        $filter = "";
        $parameter_string = "";
        //If $context is not an array, we will simply initialize an empty array
        if (!is_array($context)) {
            $context = array();
        }
        if (isset($context['actor_id']) && ($context['actor_id'] != 0)) {
            $filter = $filter."('actor_id' = ?)";
        }
        else {
            $filter = $filter."('actor_id' = ? OR TRUE)";
            $context['actor_id'] = 0;
        }
        if (isset($context['object_id']) && ($context['object_id'] != 0)) {
            $filter = $filter." AND ('object_id' = ?)";
        }
        else {
            $filter = $filter." AND ('object_id' = ? OR TRUE)";
            $context['object_id'] = 0;
        }
        if (isset($context['group_id']) && ($context['group_id'] != 0)) {
            $filter = $filter." AND ('group_id' = ?)";
        }
        else {
            $filter = $filter." AND ('group_id' = ? OR TRUE)";
            $context['group_id'] = 0;
        }
        if (isset($context['activity_id']) && ($context['activity_id'] != 0)) {
            $filter = $filter." AND ('activity_id' = ?)";
        }
        else {
            $filter = $filter." AND ('activity_id' = ? OR TRUE)";
            $context['activity_id'] = 0;
        }
        if (isset($context['verb']) && ($context['verb'] != "")) {
            $filter = $filter." AND ('verb' = ?)";
        }
        else {
            $filter = $filter." AND ('verb' = ? OR TRUE)";
            $context['verb'] = "";
        }
        if (isset($context['role']) && ($context['role'] != "")) {
            $filter = $filter." AND ('role' = ?)";
        }
        else {
            $filter = $filter." AND ('role' = ? OR TRUE)";
            $context['role'] = "";
        }
        if (isset($context['lowerbound']) && ($context['lowerbound'] != 0)) {
            $filter = $filter." AND ('timestamp' >= ?)";
        }
        else {
            $filter = $filter." AND ('timestamp' >= ? OR TRUE)";
            $context['lowerbound'] = 0;
        }
        if (isset($context['upperbound']) && ($context['upperbound'] != 0)) {
            $filter = $filter." AND ('timestamp' <= ?)";
        }
        else {
            $filter = $filter." AND ('timestamp' <= ? OR TRUE)";
            $context['upperbound'] = 0;
        }
        if ($filter != "") {
            $sql = $sql." WHERE ". $filter;
        }
        $sql = $sql." ORDER BY stream_id;";
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

        define('AnalysisData', $json);
        $data = array('TemplateId' => $metric_id, 'ReturnId' => $return_id, 'ReturnURL' => $return_url, 'AnalysisData' => base64_encode(AnalysisData));

// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $request_context  = stream_context_create($options);
        $runId = file_get_contents($server_url, false, $request_context);

        return $runId;
    }
}
