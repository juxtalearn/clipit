<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 28/02/14
 * Time: 15:13
 * To change this template use File | Settings | File Templates.
 */
$params = array(
    'title' => 'Loading content...',
    'body' => '<i class="fa fa-spinner fa-spin" style="font-size: 40px;color: #bae6f6"></i>',
    'target' => $vars['id']
);
echo elgg_view("page/components/modal", $params);
?>