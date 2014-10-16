<?php
/**
 * Elgg log rotator Portuguese language pack.
 *
 * @package ElggLogRotate
 */

$portuguese = array(
    'logrotate:period' => 'Com que regularidade devem ser guardados os registos do sistema?',

    'logrotate:weekly' => 'Semanalmente',
    'logrotate:monthly' => 'Mensalmente',
    'logrotate:yearly' => 'Anualmente',

    'logrotate:logrotated' => "Log rotated\n",
    'logrotate:lognotrotated' => "Error rotating log\n",

    'logrotate:delete' => 'Apagar os registos com mais de',

    'logrotate:week' => 'uma semana',
    'logrotate:month' => 'um mes',
    'logrotate:year' => 'um ano',
    'logrotate:never' => 'nunca',

    'logrotate:logdeleted' => "Registo apagado\n",
    'logrotate:lognotdeleted' => "Erro ao apagar os regstos\n",
);

add_translation("pt", $portuguese);