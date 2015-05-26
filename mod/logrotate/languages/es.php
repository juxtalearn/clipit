<?php
/**
 * Elgg log rotator Spanish language pack.
 * Formal spanish version by LeonardoA
 *
 * @package ElggLogRotate
 */

$spanish = array(
	'logrotate:period' => '¿Con qué frecuencia desea archivar los registros?',

	'logrotate:weekly' => 'Semanal',
	'logrotate:monthly' => 'Mensual',
	'logrotate:yearly' => 'Anual',

	'logrotate:logrotated' => "Registro archivado\n",
	'logrotate:lognotrotated' => "Error al archivar los registros\n",
	
	'logrotate:delete' => 'Borrar los registros archivados hace más de',

	'logrotate:week' => 'una semana',
	'logrotate:month' => 'un mes',
	'logrotate:year' => 'un año',
		
	'logrotate:logdeleted' => "Registro borrado\n",
	'logrotate:lognotdeleted' => "Error al borrar los registros\n",
);

add_translation("es", $spanish);
