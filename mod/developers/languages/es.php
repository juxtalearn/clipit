<?php
/**
 * Elgg developer tools Spanish language file.
 * Formal spanish version by LeonardoA
 *
 */

$spanish = array(
	// menu
	'admin:develop_tools' => 'Herramientas',
	'admin:develop_tools:preview' => 'Pruebas de Temas',
	'admin:develop_tools:inspect' => 'Inspeccionar',
	'admin:develop_tools:unit_tests' => 'Pruebas de unidad',
	'admin:developers' => 'Desarrolladores',
	'admin:developers:settings' => 'Configuración',

	// settings
	'elgg_dev_tools:settings:explanation' => 'Controle su desarrollo y configuración de pruebas, algunas de estas configuraciones también estan disponibles en otros menús.',
	'developers:label:simple_cache' => 'Utilizar cache simple',
	'developers:help:simple_cache' => 'Desactive este cache durante el desarrollo, o bien sus cambios a los CSS y Javascript serán ignorados.',
	'developers:label:system_cache' => 'Utilizar cache de sistema',
	'developers:help:system_cache' => 'Desactive esta opción durante el desarrollo, o bien los cambios en sus plugins serán ignorados.',
	'developers:label:debug_level' => "Nivel de rastreo",
	'developers:help:debug_level' => "Esto controla la cantidad de información registrada en el log, vea también elgg_log() para más información.",
	'developers:label:display_errors' => 'Anunciar errores fatales de PHP',
	'developers:help:display_errors' => "Por default, el archivo .htaccess de Elgg suprime el anuncio de errores fatales.",
	'developers:label:screen_log' => "Desplegar en pantalla",
	'developers:help:screen_log' => "Esto despliega el elgg_log() y elgg_dump() en la página web.",
	'developers:label:show_strings' => "Mostrar traducciones sin formato",
	'developers:help:show_strings' => "Esto despliega las traducciones utilizadas por elgg_echo().",
	'developers:label:wrap_views' => "Salto de página",
	'developers:help:wrap_views' => "Esto provoca saltos de página en casi todas las vistas con comentarios HTML, útil para encontrar algún HTML específico.",
	'developers:label:log_events' => "Registro de eventos y marcadores en plugins",
	'developers:help:log_events' => "Escriba eventos y marcadores de plugins al log. Atención, esto puede causar una gran cantidad de registros por página.",

	'developers:debug:off' => 'Apagado',
	'developers:debug:error' => 'Error',
	'developers:debug:warning' => 'Alerta',
	'developers:debug:notice' => 'Noticia',
	
	// inspection
	'developers:inspect:help' => 'Inspeccionar configuración del framework Elgg.',

	// event logging
	'developers:event_log_msg' => "%s: '%s, %s' en %s",

	// theme preview
	'theme_preview:general' => 'Introducción',
	'theme_preview:breakout' => 'Presentar fuera del iframe',
	'theme_preview:buttons' => 'Botones',
	'theme_preview:components' => 'Componentes',
	'theme_preview:forms' => 'Formularios',
	'theme_preview:grid' => 'Malla',
	'theme_preview:icons' => 'Iconos',
	'theme_preview:modules' => 'Módulos',
	'theme_preview:navigation' => 'Navegación',
	'theme_preview:typography' => 'Tipografía',
    'theme_preview:miscellaneous' => 'Misceláneo',

	// unit tests
	'developers:unit_tests:description' => 'Elgg contiene pruebas unitarias e integrales para detectar bugs en sus clases y funciones básicas.',
	'developers:unit_tests:warning' => 'Cuidado: no ejecute estas pruebas en su sitio productivo, ya que pueden corromper la base de datos.',
	'developers:unit_tests:run' => 'Ejecutar',

	// status messages
	'developers:settings:success' => 'Configuración salvada',
);

add_translation('es', $spanish);
