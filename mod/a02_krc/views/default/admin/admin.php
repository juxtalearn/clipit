<?php
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");

admin_gatekeeper();
elgg_set_context('admin');
// Set admin user for user block
elgg_set_page_owner_guid($_SESSION['guid']);
//Vars required for action gatekeeper
$ts = time();
$token = generate_action_token($ts);

//First we need to find the ElggObject that contains our setting already.
//If it doesn't exist we need to create it.
$entities = elgg_get_entities(array("types" => "object", "subtypes" => "modkrc", "owner_guids" => '0', "order_by" => "", "limit" => 0));
if (isset($entities[0])) {
    $entity = $entities[0];
    $store_url_value = $entity->$store_url;
    $repo_name_value = $entity->$repo_name;
    error_log("store_url = ".$store_url_value);
    error_log("entity store_url = ".$entity->$store_url);
}
else {
    $store_url_value = "";
    $repo_name_value = "";
}
?>




<p><?php echo elgg_echo('krc:title'); ?></p>


<form action="<?php echo $vars['url']; ?>action/krc/modify" method="post">
    <label>
        <?php 	echo elgg_echo('krc:storeurl'); ?>
        <br />
        <?php	echo elgg_view('input/text',array(
            'internalname' => 'store_url',
            'value' => $store_url_value
        ));
        ?>
    </label>
    <label>
        <?php 	echo elgg_echo('krc:reponame'); ?>
        <br />
        <?php	echo elgg_view('input/text',array(
            'internalname' => 'repo_name',
            'value' => $repo_name_value
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
        <input type="submit" value="<?php echo elgg_echo('krc:submit'); ?>" />
    </p>

</form>
