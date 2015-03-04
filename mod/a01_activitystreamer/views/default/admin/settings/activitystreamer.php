<?php
// require_once(dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . "/engine/start.php");
session_start();
/*admin_gatekeeper();
elgg_set_context('activitystreamer');
// Set activitystreamer user for user block
elgg_set_page_owner_guid($_SESSION['guid']);*/
//Vars required for action gatekeeper
$ts = time();
$token = generate_action_token($ts);

//Vars required for configuration
$entities = elgg_get_entities(array("types" => "object", "subtypes" => "modactivitystreamer", "owner_guids" => '0', "order_by" => "", "limit" => 0));
if (!isset($entities[0])) {
    $entity = $entities[0];
    error_log(print_r($entity, true));
    $workbenchurl = "https://analyticstk.rias-institute.eu:1443/requestAnalysis";
    $entity = new ElggObject;
    $entity->subtype = 'modactivitystreamer';
    $entity->owner_guid = $_SESSION['user']->getGUID();
    $entity->workbenchurl = $workbenchurl;
    $entity->access_id = 2;    //Make sure this object is public.
} else {
    $entity = $entities[0];
    $workbenchurl = $entity->workbenchurl;
}
?>
<div class="col-md-12">
    <form action="<?php echo $vars['url']; ?>action/activitystreamer/modify" method="post">
        <label>
            <h2><?php echo elgg_echo('activitystreamer:workbenchurl'); ?></h2>
            <br/>

            <?php    echo elgg_view('input/text', array('style' => 'width:30em',
                'name' => 'workbenchurl',
                'value' => $workbenchurl
            ));
            ?>
        </label>

        <p>
            <?php
            echo elgg_view('input/hidden', array('name' => '__elgg_token', 'value' => $token));
            echo elgg_view('input/hidden', array('name' => '__elgg_ts', 'value' => $ts));
            ?>
        </p>

        <p>
            <input type="submit" value="<?php echo elgg_echo('activitystreamer:submit'); ?>"/>
        </p>

    </form>

    <p><?php echo elgg_echo('activitystreamer:warningmessage'); ?></p>

    <form action="<?php echo $vars['url']; ?>action/activitystreamer/rebuild" method="post">
        <p>
            <?php
            echo elgg_view('input/hidden', array('name' => "affirmative", 'value' => true));
            ?>
        </p>

        <p>
            <?php
            echo elgg_view('input/hidden', array('name' => '__elgg_token', 'value' => $token));
            echo elgg_view('input/hidden', array('name' => '__elgg_ts', 'value' => $ts));
            ?>
        </p>

        <p>
            <input type="submit" value="<?php echo elgg_echo('activitystreamer:rebuild'); ?>"/>
        </p>


    </form>

    <form action="<?php echo $vars['url']; ?>action/activitystreamer/request" method="post">
        <p>
            <?php
            echo elgg_view('input/hidden', array('name' => "affirmative", 'value' => true));
            ?>
        </p>

        <p>
            <?php
            echo elgg_view('input/hidden', array('name' => '__elgg_token', 'value' => $token));
            echo elgg_view('input/hidden', array('name' => '__elgg_ts', 'value' => $ts));
            ?>
        </p>

        <p>
            <input type="submit" value="<?php echo elgg_echo('activitystreamer:analysis'); ?>"/>
        </p>


    </form>

    <form action="<?php echo $vars['url']; ?>action/activitystreamer/flush" method="post">
        <p>
            <?php
            echo elgg_view('input/hidden', array('name' => "affirmative", 'value' => true));
            ?>
        </p>

        <p>
            <?php
            echo elgg_view('input/hidden', array('name' => '__elgg_token', 'value' => $token));
            echo elgg_view('input/hidden', array('name' => '__elgg_ts', 'value' => $ts));
            ?>
        </p>

        <p>
            <input type="submit" value="<?php echo elgg_echo('activitystreamer:flush'); ?>"/>
        </p>


    </form>

    <h2>Summary for logging activities:</h2>

    <p>
        <?php
        global $CONFIG;
        $log_table = $_SESSION['logging_table'];
        $con = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
        $result = mysqli_query($con, "SELECT * FROM " . $log_table . ";");
        $ext_log_entries = mysqli_num_rows($result);
        echo("Extended log contains <strong>" . $ext_log_entries . "</strong> entries.<br />");
        $activity_table = $_SESSION['activity_table'];
        $con = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
        $result = mysqli_query($con, "SELECT * FROM " . $activity_table . ";");
        $act_entries = mysqli_num_rows($result);
        echo("ActivityStream contains <strong>" . $act_entries . "</strong> entries.<br />");
        $analysis_table = $_SESSION['analysis_table'];
        $con = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
        $result = mysqli_query($con, "SELECT * FROM " . $analysis_table . ";");
        $analysis_entries = mysqli_num_rows($result);
        echo("Workbench results contains <strong>" . $analysis_entries . "</strong> entries.");

        ?>
    </p>

    <h2>Available templates:</h2>
    <ul>
        <?php
        $metrics = ActivityStreamer::get_available_metrics();
        foreach ($metrics as $metric) {
            echo("<li>");
            echo($metric['TemplateId'] . ": " . $metric['Name'] . " - " . $metric['Description']);
            echo("</li>");
        }
        ?>
    </ul>
</div>
