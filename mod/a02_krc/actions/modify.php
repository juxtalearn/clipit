<?php
admin_gatekeeper();
action_gatekeeper("modify");
$store_url = get_input('store_url');
$repo_name = get_input('repo_name');

if (isset($store_url) && isset($repo_name)) {
    //First we need to find the ElggObject that contains our setting already.
    //If it doesn't exist we need to create it.
    $entities = elgg_get_entities(array("types" => "object", "subtypes" => "modkrc", "owner_guids" => '0', "order_by" => "", "limit" => 10));
    if (!isset($entities[0])) {
        $entity = new ElggObject;
        $entity->subtype = 'modkrc';
        $entity->owner_guid = $_SESSION['user']->getGUID();
        $entity->store_url = "";
        $entity->repo_name = "jxl_store";
        $entity->access_id = 2;    //Make sure this object is public.
    } else {
        $entity = $entities[0];
        $entity->repo_name = $repo_name;
        if (!(strpos($store_url, "http://") !== FALSE)) {
            $store_url = 'http://' . $store_url;
        }
        $entity->store_url = $store_url;
        $entity->access_id = 2; //Make sure this object is public.
    }

    if ($entity->save()) {
        system_message(elgg_echo('krc:modify:success'));
        $entity->state = "active";
        forward('pg/admin/settings/krc');
    } else {
        register_error(elgg_echo('krc:modify:failed'));
        forward('pg/admin/settings/krc');
    }
} else {

    register_error(elgg_echo('krc:failed:noparams'));
    forward('pg/admin/settings/krc');
}
?>
