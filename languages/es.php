<?php
 /**
  * Core Spanish Language
  * @package Elgg.Core
  * @subpackage Languages.Spanish
  * Formal spanish version by LeonardoA
  */
 
$spanish = array(
/**
 * Sites
 */
  
	'item:site' => 'Sitios',
 
/**
 * Sessions
 */

	'login' => "Iniciar Sesión",
	'loginok' => "Bienvenido",
	'loginerror' => "Información incorrecta. Verifique sus credenciales e intente nuevamente",
	'login:empty' => "El nombre de usuario y contraseña son obligatorios",
	'login:baduser' => "No se puede ingresar a su cuenta de usuario",
	'auth:nopams' => "Error interno. No se encuentra un método de autenticación instalado",

	'logout' => "Cerrar sesión",
	'logoutok' => "Se ha cerrado la sesión",
	'logouterror' => "No se pudo cerrar la sesión, por favor intente nuevamente",

	'loggedinrequired' 	=> "Debe ingresar para poder ver esta página",
	'adminrequired' 	=> "Debe ser administrador para poder ver esta página",
	'membershiprequired' => "Debe ser miembro del grupo para poder ver esta página",
 
 
/**
 * Errors
 */
	'exception:title' 	=> "Error Fatal",
	'exception:contact_admin' => 'Se ha encontrado un error fatal al ingresar. Contacte al administrador con la siguiente información:',

	'actionundefined' 	=> "La acción (%s) solicitada no se encuentra definida en el sistema",
	'actionnotfound' 	=> "El log de acciones para %s no se ha encontrado",
	'actionloggedout' 	=> "Lo sentimos, no puede realizar esta acción sin ingresar",
	'actionunauthorized' => 'Usted no posee los permisos necesarios para realizar esta acción',

	'InstallationException:SiteNotInstalled' => 'No se pudo procesar la solicitud. El sitio '
		. ' no se encuentra configurado o la base de datos se encuentra caída',
	'InstallationException:MissingLibrary' => 'No se pudo cargar %s',
	'InstallationException:CannotLoadSettings' => 'No se pudo cargar el archivo de configuracion, puede que no exista o que se deba a un error de configuración de permisos',

	'SecurityException:Codeblock' => "Acceso denegado para la ejecución de bloque de código privilegiado",
	'DatabaseException:WrongCredentials' => "No se pudo conectar a la base de datos con las credenciales provistas. Verifique el archivo de configuración",
	'DatabaseException:NoConnect' => "No se puede consultar la base de datos '%s', por favor verifique que dicha base de datos exista y que posea permisos sobre la misma",
	'SecurityException:FunctionDenied' => "Acceso denegado a la función privilegiada '%s'",
	'DatabaseException:DBSetupIssues' => "Se encontraron los siguientes errores: ",
	'DatabaseException:ScriptNotFound' => "No se pudo encontrar el script de base de datos %s",
	'DatabaseException:InvalidQuery' => "Consulta inválida",
	'DatabaseException:InvalidDBLink' => "Se perdió la conexión a la BD.",

	'IOException:FailedToLoadGUID' => "Error al cargar una nueva %s de GUID: %d",
	'InvalidParameterException:NonElggObject' => "¡Pasando un Objeto no-Elgg a un constructor Elgg!",
	'InvalidParameterException:UnrecognisedValue' => "No se reconoce el valor enviado al constructor",

	'InvalidClassException:NotValidElggStar' => "GUID: %d no es un %s válido",

	'PluginException:MisconfiguredPlugin' => "%s (guid: %s) es un plugin desconfigurado que ha sido deshabilitado. Por favor revise la Wiki de Elgg para más información (http://docs.elgg.org/wiki/)",
	'PluginException:CannotStart' => '%s (guid: %s) no puede iniciarse. Motivo: %s',
	'PluginException:InvalidID' => "%s no es un ID de plugin válido",
	'PluginException:InvalidPath' => "%s es un path de plugin inválido",
	'PluginException:InvalidManifest' => 'Archivo de manifesto inválido para el plugin %s',
	'PluginException:InvalidPlugin' => '%s es un plugin no válido',
	'PluginException:InvalidPlugin:Details' => '%s es un plugin no válido: %s',
	'PluginException:NullInstantiated' => 'ElggPlugin no instanciado. Debe proveer un GUID, un ID de plugin o la ruta completa.',

	'ElggPlugin:MissingID' => 'No se encuentra el ID del plugin (guid %s)',
	'ElggPlugin:NoPluginPackagePackage' => 'ElggPluginPackage faltante para el plugin con ID %s (guid %s)',

	'ElggPluginPackage:InvalidPlugin:MissingFile' => 'Archivo %s faltante en el package',
	'ElggPluginPackage:InvalidPlugin:InvalidDependency' => 'Tipo de dependencia "%s" no válida',
	'ElggPluginPackage:InvalidPlugin:InvalidProvides' => 'Tipo "%s" provisto no válido',
	'ElggPluginPackage:InvalidPlugin:CircularDep' => 'Dependencia %s no válida "%s" en plugin %s. Los plugins no pueden entrar en conflicto con otros requeridos.',

	'ElggPlugin:Exception:CannotIncludeFile' => 'No puede incluirse %s para el plugin %s (guid: %s) en %s. Verifique los permisos.',
	'ElggPlugin:Exception:CannotRegisterViews' => 'No puede cargarse el directorio "views" para el plugin %s (guid: %s) en %s. Verifique los permisos.',
	'ElggPlugin:Exception:CannotRegisterLanguages' => 'No pueden registrarse lenguajes para el plugin %s (guid: %s) en %s.  Verifique los permisos.',
	'ElggPlugin:Exception:NoID' => 'No se encontró el ID para el plugin con guid %s.',

	'PluginException:ParserError' => 'Error procesando el manifiesto con versión de API %s en plugin %s',
	'PluginException:NoAvailableParser' => 'No se encuentra un procesador para el manifiesto de la versión de la API %s en plugin %s',
	'PluginException:ParserErrorMissingRequiredAttribute' => "Atributo '%s' faltante en manifiesto del plugin %s",

	'ElggPlugin:Dependencies:Requires' => 'Requiere',
	'ElggPlugin:Dependencies:Suggests' => 'Sugiere',
	'ElggPlugin:Dependencies:Conflicts' => 'Conflictos',
	'ElggPlugin:Dependencies:Conflicted' => 'En conflicto',
	'ElggPlugin:Dependencies:Provides' => 'Provee',
	'ElggPlugin:Dependencies:Priority' => 'Prioridad',

	'ElggPlugin:Dependencies:Elgg' => 'Versión de Elgg',
	'ElggPlugin:Dependencies:PhpExtension' => 'Extensión PHP: %s',
	'ElggPlugin:Dependencies:PhpIni' => 'Configuración PHP ini: %s',
 	'ElggPlugin:Dependencies:Plugin' => 'Plugin: %s',
	'ElggPlugin:Dependencies:Priority:After' => 'Después %s',
	'ElggPlugin:Dependencies:Priority:Before' => 'Ántes %s',
	'ElggPlugin:Dependencies:Priority:Uninstalled' => '%s no esta instalado',
	'ElggPlugin:Dependencies:Suggests:Unsatisfied' => 'No se encuentra',
	
	'ElggPlugin:InvalidAndDeactivated' => '%s no es un plugin válido y se ha deshabilitado',	

	'InvalidParameterException:NonElggUser' => "Pasando un no-ElggUser a un constructor ElggUser.",

	'InvalidParameterException:NonElggSite' => "Pasando un no-ElggSite a un constructor ElggSite.",

	'InvalidParameterException:NonElggGroup' => "Pasando un no-ElggGroup a un constructor ElggGroup.",

	'IOException:UnableToSaveNew' => "No se pudo guardar un nuevo %s",

	'InvalidParameterException:GUIDNotForExport' => "No se ha especificado un GUID durante la exportación, esto no debería ocurrir",
	'InvalidParameterException:NonArrayReturnValue' => "Función de serialización de entidad pasada a un parámetro de retorno no-array",

	'ConfigurationException:NoCachePath' => "¡Path de Cache seteado en Null!",
	'IOException:NotDirectory' => "%s no es un directorio",

	'IOException:BaseEntitySaveFailed' => "¡No se pudo guardar una nueva entidad!",
	'InvalidParameterException:UnexpectedODDClass' => "import() pasado a una clase ODD inesperado",
	'InvalidParameterException:EntityTypeNotSet' => "Debe setearse el tipo de entidad",

	'ClassException:ClassnameNotClass' => "%s no es un %s",
	'ClassNotFoundException:MissingClass' => "Clase '%s' no encontrada, hay algún plugin faltante?",
	'InstallationException:TypeNotSupported' => "No se reconoce el tipo %s. Esto indica un error en la instalación, seguramente causado por una actualización incompleta",

	'ImportException:ImportFailed' => "No pudo importarse el elemento %d",
	'ImportException:ProblemSaving' => "Se encontró un problema al guardar %s",
	'ImportException:NoGUID' => "Se creó una nueva entidad sin GUID, esto no debe ocurrir",

	'ImportException:GUIDNotFound' => "No se pudo encontrar la entidad '%d'",
	'ImportException:ProblemUpdatingMeta' => "Ocurrió un error al actualizar '%s' en la entidad '%d'",

	'ExportException:NoSuchEntity' => "GUID de entidad inválido: %d",

	'ImportException:NoODDElements' => "No se encontraron elementos OpenDD para la importación, la importación ha fallado",
	'ImportException:NotAllImported' => "No se importaron todos los elementos",

	'InvalidParameterException:UnrecognisedFileMode' => "Modo de archivo '%s' no reconocido",
	'InvalidParameterException:MissingOwner' => "¡El archivo %s (guid: %d) (guid del dueño: %d) no tiene un dueño!",
	'IOException:CouldNotMake' => "No puede realizarse %s",
	'IOException:MissingFileName' => "Debe especificar un nombre antes de abrir un archivo",
	'ClassNotFoundException:NotFoundNotSavedWithFile' => "No pudo cargarse la clase de repositorio %s para el archivo %u",
	'NotificationException:NoNotificationMethod' => "No se especificó un método de notificación",
	'NotificationException:NoHandlerFound' => "No se encuentra un controlador '%s' o no es ejecutable",
	'NotificationException:ErrorNotifyingGuid' => "Ocurrió un error al notificar %d",
	'NotificationException:NoEmailAddress' => "No pudo cargarse la dirección de E-mail para el GUID:%d",
	'NotificationException:MissingParameter' => "Parámetro requerido faltante: '%s'",

	'DatabaseException:WhereSetNonQuery' => "Donde no contenga WhereQueryComponent",
	'DatabaseException:SelectFieldsMissing' => "Campos faltantes en el estilo de consulta",
	'DatabaseException:UnspecifiedQueryType' => "Tipo de consulta no reconocido o no especificado",
	'DatabaseException:NoTablesSpecified' => "No se especificaron las tablas para la consulta",
	'DatabaseException:NoACL' => "No se especificó el control de acceso en la consulta",

	'InvalidParameterException:NoEntityFound' => "No se encuentra la entidad, puede que esta no exista o que no tenga los permisos necesarios sobre ella",

	'InvalidParameterException:GUIDNotFound' => "No se pudo encontrar el GUID: %s, o no tiene acceso a ella",
	'InvalidParameterException:IdNotExistForGUID' => "Lo sentimos, '%s' no existe para el guid: %d",
	'InvalidParameterException:CanNotExportType' => "Lo sentimos, no se encuentra implementada la exportación de '%s'",
	'InvalidParameterException:NoDataFound' => "No se encontraron resultados",
	'InvalidParameterException:DoesNotBelong' => "No pertenece a la entidad",
	'InvalidParameterException:DoesNotBelongOrRefer' => "No pertenece o se refiere a la entidad",
	'InvalidParameterException:MissingParameter' => "Parámetro faltante, debe proveer un GUID",
	'InvalidParameterException:LibraryNotRegistered' => '%s no es una librería registrada',
	'InvalidParameterException:LibraryNotFound' => 'No se pudo cargar la librería %s de %s',

	'APIException:ApiResultUnknown' => "Los resultados de la API no son conocidos, esto no debe ocurrir",
	'ConfigurationException:NoSiteID' => "No se especificó un ID del sitio",
	'SecurityException:APIAccessDenied' => "Lo sentimos, el acceso a la API ha sido deshabilitado para el administrador",
	'SecurityException:NoAuthMethods' => "No se encontraron métodos de autenticación para procesar la solicitud",
	'SecurityException:UnexpectedOutputInGatekeeper' => 'Salida inesperada en resultado gatekeeper. Deteniendo la ejecución por seguridad. Revise http://docs.elgg.org/ para más información',
	'InvalidParameterException:APIMethodOrFunctionNotSet' => "Método o función no especificado en el llamado a expose_method()",
	'InvalidParameterException:APIParametersArrayStructure' => "Estructuras de Array son inválidas en llamados a la función '%s'",
	'InvalidParameterException:UnrecognisedHttpMethod' => "Método http %s no reconocido para el método '%s' de la API",
	'APIException:MissingParameterInMethod' => "Parámetro %s faltante en método %s",
	'APIException:ParameterNotArray' => "%s no es un Array",
	'APIException:UnrecognisedTypeCast' => "Tipo no reconocido en casteo %s para la variable '%s' en el método '%s'",
	'APIException:InvalidParameter' => "Se encontró un parámetro inválido para '%s' en el método '%s'",
	'APIException:FunctionParseError' => "%s(%s) posee un error de procesamiento",
	'APIException:FunctionNoReturn' => "%s(%s) no retornó ningún valor",
	'APIException:APIAuthenticationFailed' => "El llamado al método falló en la autenticación de la API",
	'APIException:UserAuthenticationFailed' => "El llamado al método falló en la autenticación del usuario",
	'SecurityException:AuthTokenExpired' => "El token de autenticación no se encuentra o bien se encuentra expirado",
	'CallException:InvalidCallMethod' => "%s debe llamarse utilizando '%s'",
	'APIException:MethodCallNotImplemented' => "La llamada al método '%s' no se encuentra implementada",
	'APIException:FunctionDoesNotExist' => "La función para el método '%s' no es ejecutable",
	'APIException:AlgorithmNotSupported' => "No se soporta o se ha deshabilitado el algoritmo '%s'",
	'ConfigurationException:CacheDirNotSet' => "Directorio de Cache 'cache_path' no establecido",
	'APIException:NotGetOrPost' => "El método de Request debe ser GET o POST",
	'APIException:MissingAPIKey' => "Clave API faltante",
	'APIException:BadAPIKey' => "Clave API incorrecta",
	'APIException:MissingHmac' => "Encabezado X-Elgg-hmac faltante",
	'APIException:MissingHmacAlgo' => "Encabezado X-Elgg-hmac-algo faltante",
	'APIException:MissingTime' => "Encabezado X-Elgg-time faltante",
	'APIException:MissingNonce' => "Encabezado X-Elgg-nonce faltante",
	'APIException:TemporalDrift' => "X-Elgg-time es muy lejano en el pasado o en el futuro. Fallo Epoch",
	'APIException:NoQueryString' => "No hay datos en la query string",
	'APIException:MissingPOSTHash' => "Encabezado X-Elgg-posthash faltante",
	'APIException:MissingPOSTAlgo' => "Encabezado X-Elgg-posthash_algo faltante",
	'APIException:MissingContentType' => "Content type faltante para post data",
	'SecurityException:InvalidPostHash' => "Hash de POST data inválido - Se esperaba %s pero se recibió %s",
	'SecurityException:DupePacket' => "Firma de paquete ya vista",
	'SecurityException:InvalidAPIKey' => "Clave API inválida o faltante",
	'NotImplementedException:CallMethodNotImplemented' => "El llamado al método '%s' no es soportado",

	'NotImplementedException:XMLRPCMethodNotImplemented' => "Llamado al método XML-RPC '%s' no implementada",
	'InvalidParameterException:UnexpectedReturnFormat' => "La llamada al método '%s' devolvió un resultado inesperado",
	'CallException:NotRPCCall' => "La llamada no parece ser una llamada XML-RPC válida",

	'PluginException:NoPluginName' => "No se pudo encontrar el nombre del plugin",

	'SecurityException:authenticationfailed' => "No se pudo autenticar el usuario",

	'CronException:unknownperiod' => '%s no es un período reconocible',

	'SecurityException:deletedisablecurrentsite' => '¡No puede eliminar o deshabilitar el sitio que está viendo en este momento!',

	'RegistrationException:EmptyPassword' => 'Los campos de contraseñas son obligatorios',
	'RegistrationException:PasswordMismatch' => 'Las contraseñas deben coincidir',
	'LoginException:BannedUser' => 'Su ingreso ha sido bloqueado momentáneamente',
	'LoginException:UsernameFailure' => 'No pudo iniciarse la sesión. Por favor verifique su nombre de usuario',
	'LoginException:PasswordFailure' => 'No pudo iniciarse la sesión. Por favor verifique su contraseña',
	'LoginException:AccountLocked' => 'Su cuenta ha sido bloqueada por la cantidad de intentos fallidos de inicio de sesion',
	'LoginException:ChangePasswordFailure' => 'Falló el cambio de contraseña. Revise ambas contraseñas.',
	'LoginException:Unknown' => 'No pudo iniciarse la sesión. Error desconocido.',

	'deprecatedfunction' => 'Precaución: Este código utiliza la función obsoleta \'%s\' que no es compatible con esta versión de Elgg',

	'pageownerunavailable' => '¡Precaución: El administrador de página %d no se encuentra accesible!',
	'viewfailure' => 'Ocurrió un error interno en la vista %s',
	'changebookmark' => 'Por favor modifique su índice para esta vista',
	'noaccess' => 'El contenido no es accesible debido a que necesita haber iniciado sesión, fué removido o no tiene permiso para verlo.',
	'error:missing_data' => 'Faltan datos en su solicitud',
	
	'error:default' => 'Algo anda mal...',
	'error:404' => 'No se encontró la página o aplicación solicitada.',
	
 /**
  * API
  */
	'system.api.list' => "Lista todas las llamadas API disponibles en el sistema",
	'auth.gettoken' => "Esta llamada API le permite al usuario obtener un token de autenticación el cual puede ser utilizado para autenticar futuras llamadas a la API. Enviarlo como parámetro auth_token",
 
 /**
  * User details
  */

	'name' => "Nombre completo",
	'email' => "Dirección de E-mail",
	'username' => "Nombre de usuario",
	'loginusername' => "Usuario",
	'password' => "Contraseña",
	'passwordagain' => "Contraseña (nuevamente, para verificación)",
	'admin_option' => "¿Hacer administrador a este usuario?",
 
 /**
  * Access
  */
  
	'PRIVATE' => "Privado",
	'LOGGED_IN' => "Usuarios registrados",
	'PUBLIC' => 'Público',
	'access:friends:label' => "Amigos",
	'access' => "Nivel de seguridad de publicación",
	'access:limited:label' => "Limitado",
	'access:help' => "El nivel de seguridad de publicación",
	
 /**
  * Dashboard and widgets
  */
  
	'dashboard' => "Portada",
	'dashboard:nowidgets' => "La Portada permite ver la actividad y el contenido que le interesan",
 
        'dashboard:widget:group:title' => 'Actividad del Grupo',
	'dashboard:widget:group:desc' => 'Ver la actividad de uno de tus grupos',
	'dashboard:widget:group:select' => 'Selecciona un grupo',
	'dashboard:widget:group:noactivity' => 'No hay actividad en este grupo',
	'dashboard:widget:group:noselect' => 'Edita este widget para seleccionar un grupo',
    
	'widgets:add' => 'Agregar widget',
	'widgets:add:description' => "Haga click en el botón de algún widget para agregarlo a la página",
	'widgets:position:fixed' => '(Posición fija en la página)',
	'widget:unavailable' => 'Ya agregó este widget',
	'widget:numbertodisplay' => 'Cantidad de elementos para mostrar',
 
	'widget:delete' => 'Quitar %s',
	'widget:edit' => 'Personalizar este widget',
 
 	'widgets' => "Widgets",
 	'widget' => "Widget",
 	'item:object:widget' => "Widgets",
	'widgets:save:success' => "El widget se guardó correctamente",
	'widgets:save:failure' => "No se pudo guardar el widget, por favor intente nuevamente",
	'widgets:add:success' => "Se agregó correctamente el widget",
	'widgets:add:failure' => "No se pudo añadir el widget",
	'widgets:move:failure' => "No se pudo guardar la nueva posición del widget",
	'widgets:remove:failure' => "No se pudo quitar el widget",
 
 /**
  * Groups
  */
  
	'group' => "Grupo",
	'item:group' => "Grupos",
 
 /**
  * Users
  */
  
	'user' => "Usuario",
	'item:user' => "Usuarios",
 
 /**
  * Friends
  */

	'friends' => "Amigos",
	'friends:yours' => "Sus Amigos",
	'friends:owned' => "Amigos de %s",
	'friend:add' => "Añadir como amigo",
	'friend:remove' => "Quitar amigo",

	'friends:add:successful' => "Se ha añadido a %s como amigo",
	'friends:add:failure' => "No se pudo añadir a %s como amigo. Por favor intente nuevamente",

	'friends:remove:successful' => "Se quitó a %s de sus amigos",
	'friends:remove:failure' => "No se pudo quitar a %s de sus amigos. Por favor intente nuevamente",

	'friends:none' => "Aún no tiene amigos",
	'friends:none:you' => "No tiene amigos aún",

	'friends:none:found' => "No se encontraron amigos",

	'friends:of:none' => "Nadie ha agregado a este usuario como amigo aún",
	'friends:of:none:you' => "Nadie le ha agregado como amigo aún. Comience a añadir contenido y complete su perfil para que la gente le encuentre.",

	'friends:of:owned' => "Amigos de %s",

	'friends:of' => "Amigos de",
	'friends:collections' => "Colecciones de amigos",
	'collections:add' => "Nueva colección",
	'friends:collections:add' => "Nueva colección de amigos",
	'friends:addfriends' => "Seleccionar amigos",
	'friends:collectionname' => "Nombre de la colección",
	'friends:collectionfriends' => "Amigos en la colección",
	'friends:collectionedit' => "Editar esta colección",
	'friends:nocollections' => "No tiene colecciones aún",
	'friends:collectiondeleted' => "La colección ha sido eliminada",
	'friends:collectiondeletefailed' => "No se puede eliminar la colección",
	'friends:collectionadded' => "La colección se ha creado correctamente",
	'friends:nocollectionname' => "Debe darle un nombre a la colección antes de crearla",
	'friends:collections:members' => "Miembros de esta colección",
	'friends:collections:edit' => "Editar colección",
	'friends:collections:edited' => "Colección guardada",
	'friends:collection:edit_failed' => 'No se pudo guardar la colección',
 
 	'friendspicker:chararray' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
 
	'avatar' => 'Imagen de perfil',
	'avatar:create' => 'Cree su imagen de perfil',
	'avatar:edit' => 'Editar imagen de perfil',
	'avatar:preview' => 'Previsualizar',
	'avatar:upload' => 'Añadir imagen de perfil',
	'avatar:current' => 'Imagen de perfil actual',
	'avatar:remove' => 'Retirar su imagen de perfil y utilizar imagen default',
	'avatar:crop:title' => 'Herramienta de recorte de imagen de perfil',
	'avatar:upload:instructions' => "Su imagen de perfil se mostrará en la red. Podrá modificarla siempre que lo desee (Formatos de archivo aceptados: GIF, JPG o PNG)",
	'avatar:create:instructions' => 'Haga click y arrastre un cuadrado debajo para seleccionar el recorte de la imagen. Aparecerá una previsualización en la caja de la derecha. Cuando esté conforme con la previsualización, haga click en \'Crear imagen de perfil\'. La versión recortada será mostrada en la red',
	'avatar:upload:success' => 'Imagen de perfil subida correctamente',
	'avatar:upload:fail' => 'Falló la carga de la imagen de perfil',
	'avatar:resize:fail' => 'Error al modificar el tamaño de la imagen de perfil',
	'avatar:crop:success' => 'Recorte de la imagen de perfil finalizado correctamente',
	'avatar:crop:fail' => 'Error en el recorte de la imagen de perfil',
	'avatar:remove:success' => 'Se ha eliminado el avatar',
	'avatar:remove:fail' => 'Fallo al eliminar el avatar',

	'profile:edit' => 'Editar perfil',
	'profile:aboutme' => "Sobre mi",
	'profile:description' => "Sobre mi",
	'profile:briefdescription' => "Descripción corta",
	'profile:location' => "Ubicación",
	'profile:skills' => "Habilidades",
	'profile:interests' => "Intereses",
	'profile:contactemail' => "E-mail de contacto",
	'profile:phone' => "Teléfono",
	'profile:mobile' => "Móvil",
	'profile:website' => "Sitio Web",
	'profile:twitter' => "Usuario de Twitter",
	'profile:saved' => "Su perfil ha sido guardado correctamente",
	
	'profile:field:text' => 'Texto corto',
	'profile:field:longtext' => 'Area de texto largo',
	'profile:field:tags' => 'Etiquetas',
	'profile:field:url' => 'Dirección Web',
	'profile:field:email' => 'Dirección de E-mail',
	'profile:field:location' => 'Ubicación',
	'profile:field:date' => 'Fecha',

	'admin:appearance:profile_fields' => 'Editar campos de perfil',
	'profile:edit:default' => 'Editar campos de perfil',
	'profile:label' => "Etiqueta de perfil",
	'profile:type' => "Tipo de perfil",
	'profile:editdefault:delete:fail' => 'Error al eliminar campo seleccionado de perfil por defecto',
	'profile:editdefault:delete:success' => 'Item de perfil por defecto eliminado.',
	'profile:defaultprofile:reset' => 'Reinicio de perfil de sistema ',
	'profile:resetdefault' => 'Reiniciar perfil de sistema ',
        'profile:resetdefault:confirm' => '¿Está seguro de que desea eliminar los campos de perfil personalizados?',
	'profile:explainchangefields' => "Puede reemplazar los campos de perfil existentes con sus propios utilizando el formulario de abajo. \n\n Ingrese un nuevo nombre de campo de perfil, por ejemplo, 'Equipo favorito', luego seleccione el tipo de campo (eg. texto, url, etiquetas), y haga click en el botón de 'Agregar'. Para re ordenar los campos arrastre el control al lado de la etiqueta del campo. Para editar la etiqueta del campo haga click en el texto de la etiqueta para volverlo editable. \n\n Puede volver a la disposición original del perfil en cualquier momento, pero perderá la información creada en los campos personalizados del perfil hasta el momento",
	'profile:editdefault:success' => 'Elemento agregado al perfil correctamente',
	'profile:editdefault:fail' => 'No se pudo guardar el perfil',
	'profile:field_too_long' => 'No se pudo guardar la información del perfil debido a que la sección "%s" es demasiado larga.',
        'profile:noaccess' => "No tienes permiso para editar este perfil.",
	
	
 /**
  * Feeds
  */
	'feed:rss' => 'Canal RSS de esta página',
 /**
  * Links
  */
	'link:view' => 'Ver enlace',
	'link:view:all' => 'Ver todos',
 
 
 /**
  * River
  */
 	'river' => "Muro de Notas",
	'river:friend:user:default' => "%s ahora es amigo de %s",
	'river:update:user:avatar' => '%s tiene una nueva imagen de perfil',
	'river:update:user:profile' => '%s ha actualizado su perfil',
	'river:noaccess' => 'No posee permisos para visualizar este elemento',
	'river:posted:generic' => '%s publicado',
	'riveritem:single:user' => 'un usuario',
	'riveritem:plural:user' => 'algunos usuarios',
	'river:ingroup' => 'en el grupo %s',
	'river:none' => 'Sin actividad',
	'river:update' => 'Actualizaciones de %s',
	'river:delete:success' => 'El item en el Muro de Notas ha sido borrado',
	'river:delete:fail' => 'El item en el Muro de Notas no pudo ser borrado',
	
	'river:widget:title' => "Actividad",
	'river:widget:description' => "Mostrar la última actividad",
	'river:widget:type' => "Tipo de actividad",
	'river:widgets:friends' => 'Actividad de amigos',
	'river:widgets:all' => 'Toda la actividad del sitio',
 
 /**
  * Notifications
  */
	'notifications:usersettings' => "Configuración de notificaciones",
	'notifications:methods' => "Por favor, indique los métodos que desea habilitar",
	'notification:method:email' => 'Correo electrónico',
 
	'notifications:usersettings:save:ok' => "Su configuración de notificaciones se guardó correctamente",
	'notifications:usersettings:save:fail' => "Ocurrió un error al guardar la configuración de notificaciones",
 
	'user.notification.get' => 'Retornar la configuración de notificaciones para un usuario dado',
	'user.notification.set' => 'Establecer la configuración de notificaciones para un usuario dado',
 /**
  * Search
  */

	'search' => "Buscar ...",
	'searchtitle' => "Buscar: %s",
	'users:searchtitle' => "Buscar para usuarios: %s",
	'groups:searchtitle' => "Buscar para grupos: %s",
	'advancedsearchtitle' => "%s con coincidencias en resultados %s",
	'notfound' => "No se encontraron resultados",
	'next' => "Siguiente",
	'previous' => "Anterior",

	'viewtype:change' => "Modificar tipo de lista",
	'viewtype:list' => "Vista de lista",
	'viewtype:gallery' => "Galería",

	'tag:search:startblurb' => "Items con etiquetas que coincidan con '%s':",

	'user:search:startblurb' => "Usuarios que coincidan con '%s':",
	'user:search:finishblurb' => "Haga click aquí para ver más",

	'group:search:startblurb' => "Grupos que coinciden con '%s':",
	'group:search:finishblurb' => "Haga click aquí para ver más",
	'search:go' => 'Ir',
	'userpicker:only_friends' => 'Sólo amigos',
 
 /**
  * Account
  */
  
	'account' => "Cuenta",
	'settings' => "Preferencias",
	'tools' => "Herramientas",
	'settings:edit' => 'Editar preferencias',

	'register' => "Nuevo Usuario",
	'registerok' => "Se registró correctamente en %s",
	'registerbad' => "No se pudo registrar debido a un error desconocido",
	'registerdisabled' => "El registro se ha deshabilitado por el administrador del sistema",
	'register:fields' => 'Todos los campos son obligatorios',

	'registration:notemail' => 'No ha ingresado una dirección de E-mail válida',
	'registration:userexists' => 'El nombre de usuario ya existe',
	'registration:usernametooshort' => 'El nombre de usuario debe tener un mínimo de %u caracteres',
	'registration:usernametoolong' => 'Su nombre de usuario puede tener máximo %u caracteres.',
	'registration:passwordtooshort' => 'La contraseña debe tener un mínimo de %u caracteres',
	'registration:dupeemail' => 'Ya se encuentra registrada la dirección de E-mail',
	'registration:invalidchars' => 'Lo sentimos, su nombre de usuario posee los caracteres inválidos: %s. Estos son todos los caracteres que se encuentran invalidados: %s',
	'registration:emailnotvalid' => 'Lo sentimos, la dirección de E-mail que ha ingresado es inválida en el sistema',
	'registration:passwordnotvalid' => 'Lo sentimos, la contraseña que ha ingresado es inválida en el sistema',
	'registration:usernamenotvalid' => 'Lo sentimos, el nombre de usuario que ha ingresado es inválida en el sistema',

	'adduser' => "Añadir usuario",
	'adduser:ok' => "Agregó correctamente un nuevo usuario",
	'adduser:bad' => "No se pudo crear el usuario",

	'user:set:name' => "Configuración del nombre de cuenta",
	'user:name:label' => "Mi nombre para mostrar",
	'user:name:success' => "Se modificó correctamente su nombre",
	'user:name:fail' => "No se pudo modificar su nombre. Por favor, asegúrese de que no es demasiado largo e intente nuevamente",

	'user:set:password' => "Contraseña de la cuenta",
	'user:current_password:label' => 'Contraseña actual',
	'user:password:label' => "Nueva contraseña",
	'user:password2:label' => "Confirmar nueva contraseña",
	'user:password:success' => "Contraseña modificada",
	'user:password:fail' => "No se pudo modificar la contraseña",
	'user:password:fail:notsame' => "Las dos contraseñas no coinciden.",
	'user:password:fail:tooshort' => "La contraseña es demasiado corta.",
	'user:password:fail:incorrect_current_password' => 'La contraseña actual ingresada es incorrecta',
	'user:resetpassword:unknown_user' => 'Usuario inválido',
	'user:resetpassword:reset_password_confirm' => 'Al modificar la contraseña se le enviará la nueva a la dirección de E-mail registrada',

	'user:set:language' => "Configuración de lenguaje",
	'user:language:label' => "Su lenguaje",
	'user:language:success' => "Se actualizó su configuración de lenguaje",
	'user:language:fail' => "No se pudo actualizar su configuración de lenguaje",

	'user:username:notfound' => 'No se encuentra el usuario %s',

	'user:password:lost' => 'Olvidé mi Contraseña',
	'user:password:resetreq:success' => 'Solicitud de nueva contraseña confirmada, se le ha enviado un E-mail',
	'user:password:resetreq:fail' => 'No se pudo solicitar una nueva contraseña',
	
	'user:password:text' => 'Para solicitar una nueva contraseña, introduzca su Usuario',

	'user:persistent' => 'Recordarme',	
	
	'walled_garden:welcome' => 'Bienvenido a',
	
/**
 * Administration
 */
	'menu:page:header:administer' => 'Administrar',
	'menu:page:header:configure' => 'Configurar',
	'menu:page:header:develop' => 'Desarrollar',
	'menu:page:header:default' => 'Otro',

	'admin:view_site' => 'Ver el sitio',
	'admin:loggedin' => 'Sesión iniciada como %s',
	'admin:menu' => 'Menú',

	'admin:configuration:success' => "Configuración guardada",
	'admin:configuration:fail' => "No se pudo guardar su configuración",
	'admin:configuration:dataroot:relative_path' => 'No se puede configurar "%s" como el directorio de datos raiz ya que la ruta no es absoluta.',

	'admin:unknown_section' => 'Sección de administración no válida',

	'admin' => "Administración",
	'admin:description' => "El panel de administración le permite organizar todos los aspectos del sistema, desde la gestión de usuarios hasta el comportamiento de los plugins. Seleccione una opción debajo para comenzar",

	'admin:statistics' => "Estadísticas",
	'admin:statistics:overview' => 'Resumen',
	'admin:statistics:server' => 'Información del servidor',
	
	'admin:appearance' => 'Apariencia',
	'admin:administer_utilities' => 'Utilidades',
	'admin:develop_utilities' => 'Utilidades',
	
	'admin:users' => "Usuarios",
	'admin:users:online' => 'Conectados',
	'admin:users:newest' => 'Usuarios más recientes',
	'admin:users:admins' => 'Administradores',
	'admin:users:add' => 'Agregar Nuevo Usuario',
	'admin:users:description' => "Este panel de administración le permite gestionar la configuración de usuarios del sitio. Seleccione una opción debajo para comenzar",
	'admin:users:adduser:label' => "Haga click aquí para agregar un usuario..",
	'admin:users:opt:linktext' => "Configurar usuarios..",
	'admin:users:opt:description' => "Configurar usuarios e información de cuentas",
	'admin:users:find' => 'Buscar',

	'admin:settings' => 'Configuración',
	'admin:settings:basic' => 'Configuración Básica',
	'admin:settings:advanced' => 'Configuración Avanzada',
	'admin:site:description' => "Este panel de administración le permite gestionar la configuración global de la red. Selecciona una opción debajo para comenzar",
	'admin:site:opt:linktext' => "Configurar el sitio..",
	'admin:site:access:warning' => "Las modificaciones en el control de accesos sólo tendrá impacto en los accesos futuros",
	
	'admin:dashboard' => 'Panel de control',
	'admin:widget:online_users' => 'Usuarios conectados',
	'admin:widget:online_users:help' => 'Lista los usuarios conectados actualmente al sitio',
	'admin:widget:new_users' => 'Usuarios Nuevos',
	'admin:widget:new_users:help' => 'Lista los usuarios más nuevos',
	'admin:widget:content_stats' => 'Estadísticas de contenido',
	'admin:widget:content_stats:help' => 'Seguimiento del contenido creado por los usuarios del sitio',
	'widget:content_stats:type' => 'Tipo de contenido',
	'widget:content_stats:number' => 'Número',
 
	'admin:widget:admin_welcome' => 'Bienvenido',
	'admin:widget:admin_welcome:help' => "Esta es el área de administración",
 	'admin:widget:admin_welcome:intro' =>
'¡Bienvenido! Se encuentra viendo el panel de control de administración, es útil para administrar la configuración del sitio',
 
 	'admin:widget:admin_welcome:admin_overview' =>
"La navegación para el área de administración se encuentra en el menú de la derecha, y está organizada en"
. " tres secciones:
 	<dl>
		<dt>Administrar</dt><dd>Tareas diarias como: monitorear contenido reportado, verificar quién se encuentra conectado y visualizar estadísticas.</dd>
		<dt>Configurar</dt><dd>Tareas ocasionales como: establecer el nombre de la red social o activar y desactivar plugins.</dd>
		<dt>Desarrollar</dt><dd>Para desarrolladores quienes construyen plugins o diseñan temas personalizados. (Requiere el plugin de desarrollador.)</dd>
 	</dl>
 	",
 
 	// argh, this is ugly
	'admin:widget:admin_welcome:outro' => '<br />¡Asegúrese de verificar los recursos disponibles en los enlaces del pié de página y gracias por utilizar Elgg!',

	'admin:widget:control_panel' => 'Panel de control',
	'admin:widget:control_panel:help' => "Provee un acceso directo a los principales controles",
 
	'admin:cache:flush' => 'Limpiar Cache',
	'admin:cache:flushed' => "La cache del sitio ha sido limpiada",

	'admin:footer:faq' => 'FAQs de Administración',
	'admin:footer:manual' => 'Manual de Administración',
	'admin:footer:community_forums' => 'Foros de la Comunidad Elgg',
	'admin:footer:blog' => 'Blog Elgg',

	'admin:plugins:category:all' => 'Todos los plugins',
	'admin:plugins:category:active' => 'Plugins activos',
	'admin:plugins:category:inactive' => 'Plugins inactivos',
 	'admin:plugins:category:admin' => 'Admin',
	'admin:plugins:category:bundled' => 'Incluído',
	'admin:plugins:category:nonbundled' => 'No integrado',
	'admin:plugins:category:content' => 'Contenido',
	'admin:plugins:category:development' => 'Desarrollo',
	'admin:plugins:category:enhancement' => 'Mejoras',
	'admin:plugins:category:api' => 'Servicio/API',
	'admin:plugins:category:communication' => 'Comunicación',
	'admin:plugins:category:security' => 'Seguridad y Spam',
 	'admin:plugins:category:social' => 'Social',
 	'admin:plugins:category:multimedia' => 'Multimedia',
	'admin:plugins:category:theme' => 'Temas',
 	'admin:plugins:category:widget' => 'Widgets',
	'admin:plugins:category:utility' => 'Utilidades',
 
	'admin:plugins:sort:priority' => 'Prioridad',
	'admin:plugins:sort:alpha' => 'Alfabético',
	'admin:plugins:sort:date' => 'Por fecha',
 
	'admin:plugins:markdown:unknown_plugin' => 'Plugin desconocido',
	'admin:plugins:markdown:unknown_file' => 'Archivo desconocido',
 
 
	'admin:notices:could_not_delete' => 'Notificación: no se pudo eliminar',
        'item:object:admin_notice' => 'Notificación de Admin',
 
	'admin:options' => 'Opciones de Admin',
 
 
 /**
  * Plugins
  */
	'plugins:disabled' => 'No se cargaron plugins porque se encontró archivo "disabled" en el directorio mod.',
	'plugins:settings:save:ok' => "Configuración para el plugin %s guardada correctamente",
	'plugins:settings:save:fail' => "Ocurrió un error al intentar guardar la configuración para el plugin %s",
	'plugins:usersettings:save:ok' => "Configuración del usuario para el plugin %s guardada",
	'plugins:usersettings:save:fail' => "Ocurrió un error al intentar guardar la configuración del usuario para el plugin %s",
 	'item:object:plugin' => 'Plugins',
	
 	'admin:plugins' => "Plugins",
	'admin:plugins:activate_all' => 'Activar todos',
	'admin:plugins:deactivate_all' => 'Desactivar todos',
	'admin:plugins:activate' => 'Activar',
	'admin:plugins:deactivate' => 'Desactivar',
	'admin:plugins:description' => "Este panel le permite controlar y configurar las herramientas instaladas en su sitio",
	'admin:plugins:opt:linktext' => "Configurar herramientas..",
	'admin:plugins:opt:description' => "Configurar las herramientas instaladas. ",
	'admin:plugins:label:author' => "Autor",
 	'admin:plugins:label:copyright' => "Copyright",
	'admin:plugins:label:categories' => 'Categorías',
	'admin:plugins:label:licence' => "Licencia",
 	'admin:plugins:label:website' => "URL",
	'admin:plugins:label:repository' => "Codigo",
	'admin:plugins:label:bugtracker' => "Reportar problema",
	'admin:plugins:label:donate' => "Donar",
	'admin:plugins:label:moreinfo' => 'mas información',
	'admin:plugins:label:version' => 'Versión',
	'admin:plugins:label:location' => 'Ubicacion',
	'admin:plugins:label:dependencies' => 'Dependencias',

	'admin:plugins:warning:elgg_version_unknown' => 'Este plugin utiliza un archivo de manifiesto obsoleto y no especifica una versión de Elgg compatible. Es muy probable que no funcione.',
	'admin:plugins:warning:unmet_dependencies' => 'Este plugin tiene dependencias desconocidas y no se activará. Consulte las dependencias debajo para más información',
	'admin:plugins:warning:invalid' => '%s no es un plugin Elgg válido. Visite <a href="http://docs.elgg.org/Invalid_Plugin">la Documentación Elgg</a> para consejos de solución de problemas',
	'admin:plugins:warning:invalid:check_docs' => 'Revisa la <a href="http://docs.elgg.org/Invalid_Plugin">documentación de Elgg</a> para consejos de resolución de problemas.',
	'admin:plugins:cannot_activate' => 'no se puede activar',
	
	'admin:plugins:set_priority:yes' => "Reordenar %s",
	'admin:plugins:set_priority:no' => "No se pudo reordenar %s.",
	'admin:plugins:set_priority:no_with_msg' => "No se pudo reordenar %s. Error: %s",
	'admin:plugins:deactivate:yes' => "Desactivar %s",
	'admin:plugins:deactivate:no' => "No se puede desactivar %s",
	'admin:plugins:deactivate:no_with_msg' => "Mo se pudo desactivar %s. Error: %s",
	'admin:plugins:activate:yes' => "Activado %s",
	'admin:plugins:activate:no' => "No se puede activar %s",
	'admin:plugins:activate:no_with_msg' => "No se pudo activar %s. Error: %s",
	'admin:plugins:categories:all' => 'Todas las categorías',
	'admin:plugins:plugin_website' => 'Sitio de plugins',
 	'admin:plugins:author' => '%s',
	'admin:plugins:version' => 'Versión %s',
	'admin:plugin_settings' => 'Configuración',
	'admin:plugins:warning:unmet_dependencies_active' => 'El plugin se encuentra activo pero posee dependencias desconocidas. Puede que se encuentren problemas en su funcionamiento. Vea "mas información" debajo para más detalles',

	'admin:plugins:dependencies:type' => 'Tipo',
	'admin:plugins:dependencies:name' => 'Nombre',
	'admin:plugins:dependencies:expected_value' => 'Valor Esperado',
	'admin:plugins:dependencies:local_value' => 'Valor Actual',
	'admin:plugins:dependencies:comment' => 'Comentario',

	'admin:statistics:description' => "Este es un resumen de las estadísticas del sitio. Si necesita estadísticas mas avanzadas, hay dispoinble una funcionalidad de administración profesional",
	'admin:statistics:opt:description' => "Ver información estadística sobre usuarios y objetos en el sitio",
	'admin:statistics:opt:linktext' => "Ver estadísticas.",
	'admin:statistics:label:basic' => "Estadísticas básicas del sitio",
	'admin:statistics:label:numentities' => "Entidades del sitio",
	'admin:statistics:label:numusers' => "Cantidad de usuarios",
	'admin:statistics:label:numonline' => "Cantidad de usuarios conectados",
	'admin:statistics:label:onlineusers' => "Usuarios conectados en este momento",
	'admin:statistics:label:admins'=>"Admins",
	'admin:statistics:label:version' => "Versión de Elgg",
 	'admin:statistics:label:version:release' => "Release",
	'admin:statistics:label:version:version' => "Versión",

	'admin:server:label:php' => 'PHP',
	'admin:server:label:web_server' => 'Servidor Web',
	'admin:server:label:server' => 'Servidor',
	'admin:server:label:log_location' => 'Localización de los registros',
	'admin:server:label:php_version' => 'Versión de PHP',
	'admin:server:label:php_ini' => 'Ubicación del archivo PHP ini',
	'admin:server:label:php_log' => 'Registros de PHP',
	'admin:server:label:mem_avail' => 'Memoria disponible',
	'admin:server:label:mem_used' => 'Memoria utilizada',
	'admin:server:error_log' => "Registro de errores del servidor Web",
	'admin:server:label:post_max_size' => 'Tamaño máximo de las peticiones POST',
	'admin:server:label:upload_max_filesize' => 'Tamañ máximo de archivos',
	'admin:server:warning:post_max_too_small' => '(Nota: post_max_size debe ser mayor que el tamañ indicado aquí para habilitar las subidas)',

	'admin:user:label:search' => "Encontrar usuarios:",
	'admin:user:label:searchbutton' => "Buscar",

	'admin:user:ban:no' => "No puede bloquear al usuario",
	'admin:user:ban:yes' => "Usuario bloqueado",
	'admin:user:self:ban:no' => "No puede bloquearse a usted mismo",
	'admin:user:unban:no' => "No puede desbloquear al usuario",
	'admin:user:unban:yes' => "Usuario desbloqueado",
	'admin:user:delete:no' => "No puede eliminar al usuario",
	'admin:user:delete:yes' => "El usuario %s ha sido eliminado",
	'admin:user:self:delete:no' => "No puede eliminarse a usted mismo",

 	'admin:user:resetpassword:yes' => "Contraseña restablecida, se notifica al usuario",
	'admin:user:resetpassword:no' => "No se puede restablecer la contraseña",

	'admin:user:makeadmin:yes' => "El usuario ahora es administrador",
	'admin:user:makeadmin:no' => "No se pudo establecer al usuario como administrador",

	'admin:user:removeadmin:yes' => "El usuario ya no es administrador",
	'admin:user:removeadmin:no' => "No se pueden quitar los privilegios de administrador de este usuario",
	'admin:user:self:removeadmin:no' => "No puede quitarse sus propios privilegios de administrador",

	'admin:appearance:menu_items' => 'Elementos del Menú',
	'admin:menu_items:configure' => 'Configurar los elementos del menú principal',
	'admin:menu_items:description' => 'Seleccione qué elementos del menú desea mostrar como enlaces favoritos. Los elementos no mostrados se guardarán en el "Mas" al final de la lista',
	'admin:menu_items:hide_toolbar_entries' => 'Quitar enlaces del menú de la barra de herramientas?',
	'admin:menu_items:saved' => 'Elementos del menú guardados',
	'admin:add_menu_item' => 'Agregar un elemento del menú personalizado',
	'admin:add_menu_item:description' => 'Complete el nombre para mostrar y la dirección url para agregar un elemento de menú personalizado',

	'admin:appearance:default_widgets' => 'Widgets por defecto',
	'admin:default_widgets:unknown_type' => 'Tipo de widget desconocido',
	'admin:default_widgets:instructions' => 'Agregar, quitar, mover y configurar los widgets por defecto en la página de widget seleccionada'
		. ' Estos cambios sólo tendrán impacto en los nuevos usuarios',
 
 /**
  * User settings
  */
	'usersettings:description' => "El panel de configuración permite parametrizar sus preferencias personales. Seleccione una opción debajo para comenzar",
 
	'usersettings:statistics' => "Sus estadísticas",
	'usersettings:statistics:opt:description' => "Ver información estadística de usuarios y objectos en la red",
	'usersettings:statistics:opt:linktext' => "Estadísticas de la cuenta",
 
	'usersettings:user' => "Sus preferencias",
	'usersettings:user:opt:description' => "Esto le permite establecer sus preferencias",
	'usersettings:user:opt:linktext' => "Modificar sus preferencias",
 
	'usersettings:plugins' => "Herramientas",
	'usersettings:plugins:opt:description' => "Preferencias de Configuración para sus herramientas activas",
	'usersettings:plugins:opt:linktext' => "Configure sus herramientas",
 
	'usersettings:plugins:description' => "Este panel le permite establecer sus preferencias personales para las herramientas habilitadas por el administrador del sistema",
	'usersettings:statistics:label:numentities' => "Su contenido",
 
	'usersettings:statistics:yourdetails' => "Sus detalles",
	'usersettings:statistics:label:name' => "Nombre completo",
 	'usersettings:statistics:label:email' => "E-mail",
	'usersettings:statistics:label:membersince' => "Miembro desde",
	'usersettings:statistics:label:lastlogin' => "Último acceso",
 
 /**
  * Activity river
  */
	'river:all' => 'Actividad del Muro',
	'river:mine' => 'Mi Actividad',
	'river:friends' => 'Actividad de mis Amigos',
	'river:select' => 'Mostrar %s',
	'river:comments:more' => '%u más',
	'river:generic_comment' => 'comentado en %s %s',

	'friends:widget:description' => "Muestra algunos de sus amigos",
	'friends:num_display' => "Cantidad de amigos a mostrar",
	'friends:icon_size' => "Tamaño del icono",
	'friends:tiny' => "muy pequeño",
	'friends:small' => "pequeño",
 
 /**
  * Generic action words
  */
  
	'save' => "Guardar",
	'reset' => 'Reiniciar',
	'publish' => "Publicar",
	'cancel' => "Cancelar",
	'saving' => "Guardando ...",
	'update' => "Actualizar",
	'preview' => "Previsualizar",
	'edit' => "Editar",
	'delete' => "Eliminar",
	'accept' => "Aceptar",
	'load' => "Cargar",
	'upload' => "Subir",
	'ban' => "Bloquear",
	'unban' => "Desbloquar",
	'banned' => "Bloqueado",
	'enable' => "Habilitar",
	'disable' => "Deshabilitar",
	'request' => "Solicitar",
	'complete' => "Completa",
	'open' => 'Abrir',
	'close' => 'Cerrar',
	'reply' => "Responder",
	'more' => 'Más',
	'comments' => 'Comentarios',
	'import' => 'Importar',
	'export' => 'Exportar',
	'untitled' => 'Sin Título',
	'help' => 'Ayuda',
	'send' => 'Enviar',
	'post' => 'Publicar',
	'submit' => 'Enviar',
	'comment' => 'Comentar',
	'upgrade' => 'Actualizar',
	'sort' => 'Ordenar',
	'filter' => 'Filtrar',
	'new' => 'Nuevo',
	'add' => 'Añadir',
	'create' => 'Crear',
	'remove' => 'Eliminar',
	'revert' => 'Revertir',
	
	'site' => 'Sitio',
	'activity' => 'Actividad',
	'members' => 'Miembros',

	'up' => 'Arriba',
	'down' => 'Abajo',
	'top' => 'Primero',
	'bottom' => 'Último',
	'back' => 'Atrás',

	'invite' => "Invitar",

	'resetpassword' => "Restablecer contraseña",
	'makeadmin' => "Hacer administrador",
	'removeadmin' => "Quitar administrador",
 
	'option:yes' => "Sí",
 	'option:no' => "No",
 
	'unknown' => 'Desconocido',
 
	'active' => 'Activo',
 	'total' => 'Total',
 
	'learnmore' => "Haga click aquí para ver más",
 
	'content' => "contenido",
	'content:latest' => 'Última actividad',
	'content:latest:blurb' => 'Alternativamente, haga click aquí para ver el último contenido en toda la red',
 
	'link:text' => 'ver link',	
 /**
  * Generic questions
  */

	'question:areyousure' => '¿Está seguro?',
 
 /**
  * Generic data words
  */

	'title' => "Título",
	'description' => "Descripción",
 	'tags' => "Etiquetas",
	'spotlight' => "Destacado",
	'all' => "Todo",
	'mine' => "Mío",
 
	'by' => 'por',
	'none' => 'nada',
 
	'annotations' => "Notas",
	'relationships' => "Relaciones",
 	'metadata' => "Metadata",
	'tagcloud' => "Etiquetas",
	'tagcloud:allsitetags' => "Todas las etiquetas",
 
	'on' => 'Habilitado',
	'off' => 'Deshabilitado',
	
 /**
  * Entity actions
  */
	'edit:this' => 'Editar',
	'delete:this' => 'Eliminar',
	'comment:this' => 'Comentar',
 
 /**
  * Input / output strings
  */
  
	'deleteconfirm:plural' => "¿Seguro que deseas borrar estos elementos?",
	'deleteconfirm' => "¿Está seguro de eliminar este item?",
	'fileexists' => "El archivo ya se ha subido. Para reemplazarlo, seleccione:",
 
 /**
  * User add
  */
  
	'useradd:subject' => 'Cuenta de usuario creada',
 	'useradd:body' => '
 %s,
 
Su cuenta de usuario ha sido creada en %s. Para iniciar sesión visite:
 
 %s
 
E inicie sesión con las siguientes credenciales:
 
 Usuario: %s
 Password: %s
 
Una vez autenticado, le recomendamos que modifique su contraseña.
 ',
 
 /**
  * System messages
  **/

	'systemmessages:dismiss' => "haga click para cerrar",
 
 
 /**
  * Import / export
  */
	'importsuccess' => "Importación exitosa",
	'importfail' => "Error al importar datos de OpenDD",
 
 /**
  * Time
  */

	'friendlytime:justnow' => "justo ahora",
	'friendlytime:minutes' => "hace %s minutos",
	'friendlytime:minutes:singular' => "hace un minuto",
	'friendlytime:hours' => "hace %s horas",
	'friendlytime:hours:singular' => "hace una hora",
	'friendlytime:days' => "hace %s días",
	'friendlytime:days:singular' => "ayer",
 	'friendlytime:date_format' => 'j F Y @ g:ia',
 
	'date:month:01' => 'Enero %s',
	'date:month:02' => 'Febrero %s',
	'date:month:03' => 'Marzo %s',
	'date:month:04' => 'Abril %s',
	'date:month:05' => 'Mayo %s',
	'date:month:06' => 'Junio %s',
	'date:month:07' => 'Julio %s',
	'date:month:08' => 'Agosto %s',
	'date:month:09' => 'Septiembre %s',
	'date:month:10' => 'Octubre %s',
	'date:month:11' => 'Noviembre %s',
	'date:month:12' => 'Diciembre %s',
 
 
 /**
  * System settings
  */

	'installation:sitename' => "El nombre del sitio:",
	'installation:sitedescription' => "Breve descripción del sitio (opcional):",
	'installation:wwwroot' => "URL del sitio:",
	'installation:path' => "La ruta completa a la instalación de Elgg:",
	'installation:dataroot' => "La ruta completa al directorio de datos:",
	'installation:dataroot:warning' => "Debe crear este directorio manualmente y debe encontrarse en un directorio diferente al de la instalación de Elgg",
	'installation:sitepermissions' => "Permisos de nivel de seguridad de publicación por defecto:",
	'installation:language' => "Lenguaje por defecto para el sitio:",
	'installation:debug' => "El modo Debug provee información extra que puede utilizarse para evaluar eventualidades. Puede enlentecer el funcionamiento del sistema y debe utilizarse sólo cuando se detectan problemas:",
	'installation:debug:none' => 'Desactivar el modo Debug (recomendado)',
	'installation:debug:error' => 'Mostrar sólo errores críticos',
	'installation:debug:warning' => 'Mostrar sólo alertas críticas',
	'installation:debug:notice' => 'Mostrar todos los errores, alertas e informació de eventos',
 
 	// Walled Garden support
	'installation:registration:description' => 'El registro de usuarios se encuentra habilitado por defecto. Puede deshabilitarla para impedir que nuevos usuarios se registren por sí mismos',
	'installation:registration:label' => 'Permitir el registro de nuevos usuarios',
	'installation:walled_garden:description' => 'Habilitar al sitio para ejecutarse como una red privada. Esto impedirá a usuarios no registrados visualizar cualquier página del sitio, exceptuando las establecidas como públicas',
	'installation:walled_garden:label' => 'Restringir páginas a usuarios registrados',
 
	'installation:httpslogin' => "Habilitar esta opción para que los usuarios se autentiquen mediante HTTPS. Necesitará habilitar HTTPS en el server también para que esto funcione",
	'installation:httpslogin:label' => "Habilitar autenticación HTTPS",
	'installation:view' => "Ingrese la vista que se visualizará por defecto en el sitio o deje esto en blanco para la vista por defecto (si tiene dudas, déjelo por defecto):",
 
	'installation:siteemail' => "Dirección de E-mail del sitio (utilizada para enviar mails desde el sistema):",
 
	'installation:disableapi' => "Elgg provee una API para el desarrollo de servicios web de modo que aplicaciones remotas puedan interactuar con el sitio",
	'installation:disableapi:label' => "Habilitar la API de servicios web de Elgg",
 
	'installation:allow_user_default_access:description' => "Si se selecciona, se les permitirá a los usuarios establecer su propio nivel de seguridad de publicación",
	'installation:allow_user_default_access:label' => "Permitir al usuario establecer su propio nivel de seguridad de publicación por defecto",
 
	'installation:simplecache:description' => "La cache simple aumenta el rendimiento almacenando contenido estático, como hojas CSS y archivos JavaScript. Normalmente debe estar activado",
	'installation:simplecache:label' => "Utilizar cache simple (recomendado)",

	'installation:systemcache:description' => "El cache de sistema disminuye el tiempo de carga de Elgg mediante un buffer de datos en archivos.",
	'installation:systemcache:label' => "Utilizar cache de sistema (recomendado)",
 
	'upgrading' => 'Actualizando..',
	'upgrade:db' => 'La base de datos ha sido actualizada',
	'upgrade:core' => 'La instalación de Elgg ha sido actualizada',
        'upgrade:unlock' => 'Desbloquear actualizar',
	'upgrade:unlock:confirm' => "La base de datos está bloqueada por otra actualización. La ejecución de actualizaciones concurrentes es peligroso. Sólo debe seguir si usted sabe que no hay otra actualización en marcha. ¿Desbloquear?",
	'upgrade:locked' => "No se puede actualizar. Otra actualización se está ejecutando. Para eliminar el bloqueo de actualización, visite la sección de administración.",
	'upgrade:unlock:success' => "Actualizar desbloqueado con éxito.",
	'upgrade:unable_to_upgrade' => 'No se puede actualizar',
 	'upgrade:unable_to_upgrade_info' =>
		'La instalación no se puede actualizar debido a que se detectaron vistas antiguas
		en el directorio de views del core de Elgg. Estas vistas han quedado obsoletas y deben eliminarse
		para que Elgg funcione correctamente. Si no ha efectuado cambios al core de Elgg, puede
		simplemente eliminar el directorio de vistas y reemplazarlo con el del último paquete de instalación
		de Elgg descargado de <a href="http://elgg.org">elgg.org</a>.<br /><br />

		Si necesita instrucciones detalladas, por favor visite la <a href="http://docs.elgg.org/wiki/Upgrading_Elgg">
		documentación de actualización de Elgg</a>. Si necesita asistencia, por favor acuda a los
		<a href="http://community.elgg.org/pg/groups/discussion/">Foros de Soporte de la Comunidad</a>',
 
	'update:twitter_api:deactivated' => 'La API de Twitter (anteriormente Twitter Service) se ha desactivado durante la actualización. Por favor actívela manualmente si se requiere',
	'update:oauth_api:deactivated' => 'La API OAuth (anteriormente OAuth Lib) se ha desactivado durante la actualización. Por favor actívela manualmente si se requiere',
 
	'deprecated:function' => '%s() ha quedado obsoleta por %s()',
 
 /**
  * Welcome
  */
  
	'welcome' => "Bienvenido",
	'welcome:user' => 'Bienvenido %s',
 
 /**
  * Emails
  */
	'email:settings' => "Configuración de E-mail",
	'email:address:label' => "Dirección de E-mail",
 
	'email:save:success' => "Nueva dirección de E-mail guardada, se solicitó la verificación",
	'email:save:fail' => "No se pudo guardar la nueva dirección de E-mail",
 
	'friend:newfriend:subject' => "%s le ha añadido como amigo",
	'friend:newfriend:body' => "%s le ha añadido como amigo
 
Para visualizar su perfil haga click aquí:
 
 %s
 
Por favor no responda a este mail",
 
 
 
	'email:resetpassword:subject' => "¡Contraseña restablecida!",
	'email:resetpassword:body' => "Hola %s,
 
Su contraseña ha sido restablecida a: %s",
 
 
	'email:resetreq:subject' => "Solicitud de nueva contraseña",
	'email:resetreq:body' => "Hola %s,
 
Alguien (desde la dirección IP %s) solicitó una nueva contraseña para su cuenta.
 
Si usted realizó la solicitud, haga click en el link debajo, en caso contrario, por favor ignore este correo.
 
 %s
 ",

 /**
  * user default access
  */
  
'default_access:settings' => "Su nivel de seguridad de publicación por defecto",
'default_access:label' => "Nivel de seguridad de publicación por defecto",
'user:default_access:success' => "El nivel de seguridad de publicación por defecto ha sido guardado",
'user:default_access:failure' => "El nivel de seguridad de publicación por defecto no ha podido ser guardado",
 
 /**
  * XML-RPC
  */
	'xmlrpc:noinputdata'	=>	"Datos faltantes",
 
 /**
  * Comments
  */
  
	'comments:count' => "%s comentarios",
	
	'riveraction:annotation:generic_comment' => '%s comentó en %s',
 
	'generic_comments:add' => "Comentar",
	'generic_comments:post' => "Publicar",
	'generic_comments:text' => "Comentar",
	'generic_comments:latest' => "Últimos comentarios",
	'generic_comment:posted' => "Se ha publicado su comentario",
	'generic_comment:deleted' => "Se ha quitado su comentario",
	'generic_comment:blank' => "Lo sentimos, debe ingresar algún comentario antes de poder guardarlo",
	'generic_comment:notfound' => "Lo sentimos, no se pudo encontrer el item especificado",
	'generic_comment:notdeleted' => "Lo sentimos, no se pudo eliminar el comentario",
	'generic_comment:failure' => "Ocurrió un error inesperado al intentar agregar su comentario. Por favor intente nuevamente",
	'generic_comment:none' => 'Sin comentarios',
	'generic_comment:title' => 'Comentario de %s',
        'generic_comment:on' => '%s en %s',
 
	'generic_comment:email:subject' => 'Tiene un nuevo comentario.',
	'generic_comment:email:body' => "Tiene un nuevo comentario en el item \"%s\" de %s. Este es:
 
 
 %s
 
 
Para responder o ver el item original, haga click aquí:
 
 %s
 
Para ver el perfil de %s, haga click aquí:
 
 %s
 
Por favor no responda a este correo",
 
 /**
  * Entities
  */
	'byline' => 'Por %s',
	'entity:default:strapline' => 'Creado %s por %s',
	'entity:default:missingsupport:popup' => 'Esta entidad no puede mostrarse correctamente. Esto puede deberse a que el soporte provisto por un plugin ya no se encuentra instalado',
 
	'entity:delete:success' => 'La entidad %s ha sido eliminada',
	'entity:delete:fail' => 'La entidad %s no pudo ser eliminada',
 
 
 /**
  * Action gatekeeper
  */
	'actiongatekeeper:missingfields' => 'En el formulario faltan __token o campos __ts',
	'actiongatekeeper:tokeninvalid' => "Se encontró un error (no coincidencia de token). Esto probablemente indique que la página que se encontraba utilizando haya expirado. Por favor intente nuevamente",
	'actiongatekeeper:timeerror' => 'La página que se encontraba utilizando ha expirado. Por favor refresque la página e intente nuevamente',
	'actiongatekeeper:pluginprevents' => 'Una extensión de este formulario ha evitado que se envíe el formulario',
 	'actiongatekeeper:uploadexceeded' => 'El tamaño del(os) archivo(s) supera el límite establecido',
        'actiongatekeeper:crosssitelogin' => "Lo sentimos, accediendo desde un dominio diferente, no está permitido. Por favor, inténtelo de nuevo.",

	
/**
 * Word blacklists
 */
	'word:blacklist' => 'and, the, then, but, she, his, her, him, one, not, also, about, now, hence, however, still, likewise, otherwise, therefore, conversely, rather, consequently, furthermore, nevertheless, instead, meanwhile, accordingly, this, seems, what, whom, whose, whoever, whomever',

 /**
  * Tag labels
  */
  
 	'tag_names:tags' => 'Etiquetas',
	'tags:site_cloud' => 'Etiquetas del Sitio',
 
 /**
  * Javascript
  */
  
	'js:security:token_refresh_failed' => 'No se pudo contactar a %s. Puede experimentar problemas al guardar contenidos en el sitio',
	'js:security:token_refreshed' => '¡La conexión a %s ha sido restaurada!',

/**
 * Force add file js
 */ 
    'forceAddFile:title' => 'Debe rellenar el título.',
    'forceAddFile:filerequired' => 'Debe insertar al menos 1 archivo',   
 
 /**
 * Languages according to ISO 639-1
 */
	"aa" => "Afar",
	"ab" => "Abkhazian",
	"af" => "Afrikaans",
	"am" => "Amharic",
	"ar" => "Arabic",
	"as" => "Assamese",
	"ay" => "Aymara",
	"az" => "Azerbaijani",
	"ba" => "Bashkir",
	"be" => "Byelorussian",
	"bg" => "Bulgarian",
	"bh" => "Bihari",
	"bi" => "Bislama",
	"bn" => "Bengali; Bangla",
	"bo" => "Tibetan",
	"br" => "Breton",
	"ca" => "Catalan",
	"co" => "Corsican",
	"cs" => "Czech",
	"cy" => "Welsh",
	"da" => "Danish",
	"de" => "German",
	"dz" => "Bhutani",
	"el" => "Greek",
	"en" => "English",
	"eo" => "Esperanto",
	"es" => "Español",
	"et" => "Estonian",
	"eu" => "Basque",
	"fa" => "Persian",
	"fi" => "Finnish",
	"fj" => "Fiji",
	"fo" => "Faeroese",
	"fr" => "French",
	"fy" => "Frisian",
	"ga" => "Irish",
	"gd" => "Scots / Gaelic",
	"gl" => "Galician",
	"gn" => "Guarani",
	"gu" => "Gujarati",
	"he" => "Hebrew",
	"ha" => "Hausa",
	"hi" => "Hindi",
	"hr" => "Croatian",
	"hu" => "Hungarian",
	"hy" => "Armenian",
	"ia" => "Interlingua",
	"id" => "Indonesian",
	"ie" => "Interlingue",
	"ik" => "Inupiak",
    //"in" => "Indonesian",
	"is" => "Icelandic",
	"it" => "Italian",
	"iu" => "Inuktitut",
	"iw" => "Hebrew (obsolete)",
	"ja" => "Japanese",
	"ji" => "Yiddish (obsolete)",
	"jw" => "Javanese",
	"ka" => "Georgian",
	"kk" => "Kazakh",
	"kl" => "Greenlandic",
	"km" => "Cambodian",
	"kn" => "Kannada",
	"ko" => "Korean",
	"ks" => "Kashmiri",
	"ku" => "Kurdish",
	"ky" => "Kirghiz",
	"la" => "Latin",
	"ln" => "Lingala",
	"lo" => "Laothian",
	"lt" => "Lithuanian",
	"lv" => "Latvian/Lettish",
	"mg" => "Malagasy",
	"mi" => "Maori",
	"mk" => "Macedonian",
	"ml" => "Malayalam",
	"mn" => "Mongolian",
	"mo" => "Moldavian",
	"mr" => "Marathi",
	"ms" => "Malay",
	"mt" => "Maltese",
	"my" => "Burmese",
	"na" => "Nauru",
	"ne" => "Nepali",
	"nl" => "Dutch",
	"no" => "Norwegian",
	"oc" => "Occitan",
	"om" => "(Afan) Oromo",
	"or" => "Oriya",
	"pa" => "Punjabi",
	"pl" => "Polish",
	"ps" => "Pashto / Pushto",
	"pt" => "Portuguese",
	"qu" => "Quechua",
	"rm" => "Rhaeto-Romance",
	"rn" => "Kirundi",
	"ro" => "Romanian",
	"ru" => "Russian",
	"rw" => "Kinyarwanda",
	"sa" => "Sanskrit",
	"sd" => "Sindhi",
	"sg" => "Sangro",
	"sh" => "Serbo-Croatian",
	"si" => "Singhalese",
	"sk" => "Slovak",
	"sl" => "Slovenian",
	"sm" => "Samoan",
	"sn" => "Shona",
	"so" => "Somali",
	"sq" => "Albanian",
	"sr" => "Serbian",
	"ss" => "Siswati",
	"st" => "Sesotho",
	"su" => "Sundanese",
	"sv" => "Swedish",
	"sw" => "Swahili",
	"ta" => "Tamil",
	"te" => "Tegulu",
	"tg" => "Tajik",
	"th" => "Thai",
	"ti" => "Tigrinya",
	"tk" => "Turkmen",
	"tl" => "Tagalog",
	"tn" => "Setswana",
	"to" => "Tonga",
	"tr" => "Turkish",
	"ts" => "Tsonga",
	"tt" => "Tatar",
	"tw" => "Twi",
	"ug" => "Uigur",
	"uk" => "Ukrainian",
	"ur" => "Urdu",
	"uz" => "Uzbek",
	"vi" => "Vietnamese",
	"vo" => "Volapuk",
	"wo" => "Wolof",
	"xh" => "Xhosa",
	//"y" => "Yiddish",
	"yi" => "Yiddish",
	"yo" => "Yoruba",
	"za" => "Zuang",
	"zh" => "Chinese",
	"zu" => "Zulu",
 );
 
add_translation("es",$spanish);
