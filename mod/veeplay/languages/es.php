<?php
/**
* Elgg VeePlay Plugin
* @package veeplay
* @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
* @author Roger Grice
* @copyright 2012 DesignedbyRoger 
* @link http://DesignedbyRoger.com
* @version 1.8.3.2
*/
// Spanish language file
$spanish = array(
		// Processing errors
		'veeplay:dbase:runerror' => "Error al abrir el archivo",
		'veeplay:dbase:notvalid' => "El archivo es un tipo desconocido",
		// Skin options
		'veeplay:skin:options' => "VeePlay usa JW Player (http://www.longtailvideo.com) tanto para la reproducción de vídeo y audio.<br /><p>Asegurese de que cualquier otro audio o reproductor de video esta deshabilitadoM mientras VeePlay está habilitado. Asegúrese también de que el plug-in <em>File</em> está instalado y habilitado. Although VeePlay attempts to play as many filetypes as possible, automagically falling back to either flash or HTML5, the matrix of filetypes to browsers successfully playing all filetypes is sadly still incomplete. <br /><p>Tanto el tema (<em>Glow</em>) y el efecto de visualización (<em>revolt-1</em>) son proporcionados por longtailvideo el proveedor de JW Player.<br /><p>Finalmente, hice esto para mi propio beneficio. Úselo bajo su propio riesgo - no hago ninguna garantía. Funciona bien para mí en las últimas versiones de Safari, Firefox, Chrome / Chromium y Opera utilizando Elgg 1.8.3.<br /><p>Disfrutalo.",
		'veeplay:skin:title' => "Temas",
		'veeplay:skin:skins' => "2 temas están disponibles, por defecto JW Player y Glow. You can apply either of these skins to either the video player or the audio player, independently.",
		'veeplay:skin:skina' => "Seleccione el tema del AUDIO que desea aplicar:",
		'veeplay:skin:skinv' => "Seleccione el tema del VÍDEO que desea aplicar:",
		'veeplay:skin:default' => "Por defecto",
		'veeplay:skin:glow' => "Glow",
		// Effect options
		'veeplay:effect:on' => "Efecto de visualización",
		'veeplay:effect:off' => "Sin efecto (H23xW560)",
		'veeplay:effect:visual' => "Visualización del audio",
		'veeplay:effect:select' => "Seleccione la visualización de audio activado o desactivado:",
		'veeplay:effect:desc' => "A visualization effect is available for the audio player. This can be set independently from the player size. This means it is possible to set the visualization on with a minimized control bar. If you set the set the control bar to minimum height (23), switch off visualization to save bandwidth.",
		// Size options
		'veeplay:player:size:desc' => "The default player window size is H315 W560. The height for the audio control bar without visualization is H23, though you can set height and width to any value, to the point of ridiculousness.<p>The height and width of both the video and audio player can be set independently.<p><em>Note, if you select audio control bar to H23, it makes no sense to keep visualization set to on.</em>",
		'veeplay:player:size' => "Tamaño del reproductor",
		'veeplay:audio:size' => "Seleccione el tamaño del reproductor de audio (Por defecto H315 x W560):",
		'veeplay:audio:size:height' => "Altura del reproductor de audio",
		'veeplay:audio:size:width' => "Ancho del reproductor de audio",
		'veeplay:video:size' => "Seleccione el tamaño del reproductor de video (Por defecto H315 x W560):",
		'veeplay:video:size:height' => "Altura del reproductor de video",
		'veeplay:video:size:width' => "Ancho del reproductor de video",
		'veeplay:size:option' => "Nota: Para restablecer la altura y el ancho por defecto, debe vaciar los campos y guardar.",
		// Options
		'veeplay:yes' => "Sí",
		'veeplay:no' => "No",
		'veeplay:on' => "Activado",
		'veeplay:off' => "Desactivado",
		// Screen size image
		'veeplay:screen' => "Los diferentes tamaños de pantalla, como referencia.",
		// Autoplay
		'veeplay:autoplay:autoplay' => "Reproducción automática/Inicio automático",
		'veeplay:autoplay:desc' => "Both the video and audio players can be independently set to start automatically or require the user to manually start the media file. By default autoplay/autostart is set to <em>Off</em>.",
		'veeplay:autoplay:audio' => "Select Autoplay for Audio files:",
		'veeplay:autoplay:video' => "Seleccionar reproducción automática para archivos de video:",
		'veeplay:autoplay:off' => "Desactivado",
		'veeplay:autoplay:on' => "Activado",

);
add_translation("es", $spanish);
