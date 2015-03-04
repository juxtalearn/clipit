<?php

admin_gatekeeper();
include_once(elgg_get_plugins_path() . "a02_krc/lib/KnowledgeRepresentationComponent.php");
$ts = time();
$token = generate_action_token($ts);

//First we need to find the ElggObject that contains our setting already.
//If it doesn't exist we need to create it.
$entities = elgg_get_entities(array("types" => "object", "subtypes" => "modkrc", "owner_guids" => '0', "order_by" => "", "limit" => 0));
if (!isset($entities[0])) {
    $entity = $entities[0];
    $entity = new ElggObject;
    $entity->subtype = 'modkrc';
    $entity->owner_guid = $_SESSION['user']->getGUID();
    $entity->store_url = "";
    $entity->repo_name = "jxl_store";
    $entity->prefix = "jxl";
    $entity->namespace = "http://www.juxtalearn.org/";
    $entity->access_id = 2;    //Make sure this object is public.

} else {
    $entity = $entities[0];
    $store_url_value = $entity->store_url;
    $repo_name_value = $entity->repo_name;
}
?>



<div class="col-md-12">
    <p><?php echo elgg_echo('krc:title'); ?></p>


    <form action="<?php echo $vars['url']; ?>action/krc/modify" method="post">
        <label>
            <?php echo elgg_echo('krc:storeurl'); ?>
            <br/>
            <?php echo elgg_view('input/text', array(
                'name' => 'store_url',
                'value' => $store_url_value
            ));
            ?>
        </label>
        <label>
            <?php echo elgg_echo('krc:reponame'); ?>
            <br/>
            <?php echo elgg_view('input/text', array(
                'name' => 'repo_name',
                'value' => $repo_name_value
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
            <input type="submit" value="<?php echo elgg_echo('krc:submit'); ?>"/>
        </p>

    </form>

    <form action="<?php echo $vars['url']; ?>action/krc/test" method="post">
        <p>
            <?php
            echo elgg_view('input/hidden', array('name' => '__elgg_token', 'value' => $token));
            echo elgg_view('input/hidden', array('name' => '__elgg_ts', 'value' => $ts));
            ?>
        </p>

        <p>
            <input type="submit" value="<?php echo elgg_echo('krc:test'); ?>"/>
        </p>

    </form>

    <h1><?php echo elgg_echo('krc:summary'); ?></h1>

    <p><br/>
        <?php
        global $sesame_store;
        global $krc_connected;
        if (!$krc_connected) {
            echo(elgg_echo('krc:noconnection'));
        } else {
//            echo(elgg_echo('krc:namespace') . ":<strong>" . $sesame_store->getNS()."<br />");
            echo(elgg_echo('krc:triples') . ":<strong>" . $sesame_store->size() . "<br />");
            echo(elgg_echo('krc:contexts') . ":<strong>" . print_r($sesame_store->contexts(), true) . "<br />");
        }
        ?>
    </p>
</div>
