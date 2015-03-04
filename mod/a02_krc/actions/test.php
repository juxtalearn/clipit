<?php
admin_gatekeeper();
action_gatekeeper("test");
global $krc_connected;
$new_krc = false;
if (!$krc_connected) {
    $krc = new KnowledgeRepresentationComponent();
    $new_krc = true;
}
if ($krc_connected) {
    system_message("Successfully connected to OpenSesame!");
    if (KnowledgeRepresentationComponent::checkWriteAccess()) {
        system_message("Successfully written and deleted test tupel!");
    }
}
if ($new_krc) {
    unset($krc);
}
forward('pg/admin/settings/krc');
?>
