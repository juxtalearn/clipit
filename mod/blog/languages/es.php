<?php

/**
  * Traducciones Blog
  */
$blog = array(
	'blog' => 'Vídeos',
	'blog:blogs' => 'Vídeos',
	'blog:revisions' => 'Revisiones',
	'blog:archives' => 'Archivos',
	'blog:blog' => 'Vídeos',
	'item:object:blog' => 'Vídeos',

	'blog:title:user_blogs' => 'Vídeos de %s',
	'blog:title:all_blogs' => 'Vídeos',
	'blog:title:friends' => 'Vídeos de amigos',

	'blog:group' => 'Vídeos de grupos',
	'blog:enableblog' => 'Habilitar vídeos para Grupos',
	'blog:write' => 'Escribir un vídeo',

	// Editing
	'blog:add' => 'Publicar un vídeo',
	'blog:edit' => 'Editar vídeo',
	'blog:excerpt' => 'Extracto',
	'blog:body' => 'Texto',
	'blog:save_status' => 'Último guardado: ',
	'blog:never' => 'Nunca',

	// Statuses
	'blog:status' => 'Estado',
	'blog:status:draft' => 'Borrador',
	'blog:status:published' => 'Publicado',
	'blog:status:unsaved_draft' => 'Borrador sin guardar',

	'blog:revision' => 'Revisión',
	'blog:auto_saved_revision' => 'Revisión autoguardada',

	// messages
	'blog:message:saved' => 'Vídeo guardado',
	'blog:error:cannot_save' => 'No se puede guardar el vídeo',
	'blog:error:cannot_write_to_container' => 'Acceso insuficiente para guardar el vídeo',
	'blog:messages:warning:draft' => 'Este es un borrador no guardado de este vídeo',
	'blog:edit_revision_notice' => '(Versión antigua)',
	'blog:message:deleted_post' => 'Vídeo borrado.',
	'blog:error:cannot_delete_post' => 'No se puede borrar el vídeo.',
	'blog:none' => 'No hay entradas',
	'blog:error:missing:title' => 'Por favor ingrese un título',
	'blog:error:missing:description' => 'Por favor ingrese contenido',
	'blog:error:cannot_edit_post' => 'Este vídeo no existe o no tiene permiso para verlo.',
	'blog:error:revision_not_found' => 'No se puede encontrar esta revisión.',

	// river
	'river:create:object:blog' => '%s ha publicado un vídeo en %s',
	'river:comment:object:blog' => '%s ha comentado en el vídeo %s',

	// notifications
	'blog:newpost' => 'Un nuevo vídeo',
	'blog:notification' =>
'
%s ha publicado un nuevo vídeo

%s
%s

Ver y comentar:
%s
',

	// widget
	'blog:widget:description' => 'Mostrar sus últimas entradas en Vídeos',
	'blog:moreblogs' => 'Más vídeos',
	'blog:numbertodisplay' => 'Número de Vídeos a mostrar',
	'blog:noblogs' => 'No hay vídeos'
);
add_translation('es', $blog);

?>