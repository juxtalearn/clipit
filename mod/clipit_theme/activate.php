<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 12/02/14
 * Time: 11:26
 * To change this template use File | Settings | File Templates.
 */
$default_params = array(
    'main_message'      => 'Create, learn and share',
    'second_message'    => 'Lorem ipsum sit amet constance ectetuer adipicin. Lorem ipsum sit ectetuer adipiscin ipsum sit.',
    'logo_img'          => 'clipit_logo.png',
    'bg_img'            => 'bg_img.jpg',
    'account_facebook'  => 'facebook',
    'account_twitter'   => 'twitter',
    'account_youtube'   => 'youtube',
    'account_vimeo'     => 'vimeo',
    'account_linkedin'  => 'linkedin',
    'email_contact'     => 'email',
);
foreach ($default_params as $k => $v) {
    if (!elgg_set_plugin_setting($k, $v, 'clipit_theme')) {
        register_error(sprintf(elgg_echo('plugins:settings:save:fail'), 'clipit_theme'));
    }
}
