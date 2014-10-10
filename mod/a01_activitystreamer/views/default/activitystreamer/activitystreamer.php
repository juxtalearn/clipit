<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");

admin_gatekeeper();
elgg_set_context('admin');
// Set admin user for user block
elgg_set_page_owner_guid($_SESSION['guid']);
//Vars required for action gatekeeper
$ts = time();
$token = generate_action_token($ts);

//Vars required for configuration
$entities = elgg_get_entities(array("types" => "object", "subtypes" => "modactivitystreamer", "owner_guids" => '0', "order_by" => "", "limit" => 0));
if (!isset($entities[0])) {
    $entity = $entities[0];
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
error_log("Retrieved config: ".$workbenchurl);
?>

    <form action="<?php echo $vars['url']; ?>action/activitystreamer/modify" method="post">
        <label>
            <?php 	echo elgg_echo('activitystreamer:workbenchurl'); ?>
            <br />
            <?php	echo elgg_view('input/text',array(
                'internalname' => 'workbenchurl',
                'value' => $workbenchurl
            ));
            ?>
        </label>
        <p>
            <?php
            echo elgg_view('input/hidden', array('internalname' => '__elgg_token', 'value' => $token));
            echo elgg_view('input/hidden', array('internalname' => '__elgg_ts', 'value' => $ts));
            ?>
        </p>
        <p>
            <input type="submit" value="<?php echo elgg_echo('activitystreamer:submit'); ?>" />
        </p>

    </form>

<p><?php echo elgg_echo('activitystreamer:warningmessage'); ?></p>

<form action="<?php echo $vars['url']; ?>action/activitystreamer/rebuild" method="post">
    <p>
        <?php
        echo elgg_view('input/hidden', array('internalname' => "affirmative", 'value' => true));
        ?>
    </p>

    <p>
        <?php
        echo elgg_view('input/hidden', array('internalname' => '__elgg_token', 'value' => $token));
        echo elgg_view('input/hidden', array('internalname' => '__elgg_ts', 'value' => $ts));
        ?>
    </p>

    <p>
        <input type="submit" value="<?php echo elgg_echo('activitystreamer:rebuild'); ?>"/>
    </p>


</form>

<form action="<?php echo $vars['url']; ?>action/activitystreamer/request" method="post">
    <p>
        <?php
        echo elgg_view('input/hidden', array('internalname' => "affirmative", 'value' => true));
        ?>
    </p>

    <p>
        <?php
        echo elgg_view('input/hidden', array('internalname' => '__elgg_token', 'value' => $token));
        echo elgg_view('input/hidden', array('internalname' => '__elgg_ts', 'value' => $ts));
        ?>
    </p>

    <p>
        <input type="submit" value="<?php echo elgg_echo('activitystreamer:analysis'); ?>"/>
    </p>


</form>

<h1>Summary for logging activities:</h1>

<p><br/>
    <?php
    global $CONFIG;
    $log_table = $_SESSION['logging_table'];
    $con = mysqli_connect($CONFIG->dbhost, $CONFIG->dbuser, $CONFIG->dbpass, $CONFIG->dbname);
    $result = mysqli_query($con, "SELECT * FROM " . $log_table . ";");
    $ext_log_entries = mysqli_num_rows($result);
    echo("Extended log contains <strong>" . $ext_log_entries . "</strong>.");

    ?>
</p>
