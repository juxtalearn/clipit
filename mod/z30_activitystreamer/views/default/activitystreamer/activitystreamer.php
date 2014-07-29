<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");

admin_gatekeeper();
elgg_set_context('admin');
// Set admin user for user block
elgg_set_page_owner_guid($_SESSION['guid']);
//Vars required for action gatekeeper
$ts = time();
$token = generate_action_token($ts);

?>

<p><?php echo elgg_echo('activitystreamer:warningmessage'); ?></p>

<form action="<?php echo $vars['url']; ?>action/activitystreamer/rebuild" method="post">
    <p>
        <?php
        echo elgg_view('input/hidden',array('internalname' => "affirmative", 'value' => true));
        ?>
    </p>
    <p>
        <?php
        echo elgg_view('input/hidden',array('internalname' => '__elgg_token', 'value' => $token));
        echo elgg_view('input/hidden',array('internalname' => '__elgg_ts', 'value' => $ts));
        ?>
    </p>
    <p>
        <input type="submit" value="<?php echo elgg_echo('activitystreamer:rebuild'); ?>" />
    </p>


</form>

<h1>Summary for logging activities:</h1>
<p><br />
    <?php
    global $CONFIG;
    $log_table = $_SESSION['logging_table'];
    $con=mysqli_connect($CONFIG->dbhost,$CONFIG->dbuser,$CONFIG->dbpass,$CONFIG->dbname);
    $result = mysqli_query($con,"SELECT * FROM ".$log_table.";");
    $ext_log_entries = mysqli_num_rows($result);
    echo("Extended log contains <strong>".$ext_log_entries."</strong>.");

    ?>
</p>
