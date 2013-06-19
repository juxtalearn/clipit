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
// English language file
$english = array(
		// Processing errors
		'veeplay:dbase:runerror' => "Error opening file",
		'veeplay:dbase:notvalid' => "File is an unknown type",
		// Skin options
		'veeplay:skin:options' => "VeePlay uses JW Player (http://www.longtailvideo.com) for both video and audio playback.<br /><p>Make sure that any other audio or video players are disabled while VeePlay is enabled. Also make sure that the plugin <em>File</em> is installed, enabled and above VeePlay. Although VeePlay attempts to play as many filetypes as possible, automagically falling back to either flash or HTML5, the matrix of filetypes to browsers successfully playing all filetypes is sadly still incomplete. <br /><p>Both the skin (<em>Glow</em>) and the visualization effect (<em>revolt-1</em>) are provided by longtailvideo the supplier of JW Player.<br /><p>Finally, I made this for my own benefit. Use it at your own risk - I make no guarantees. It works fine for me in the latest versions of Safari, Firefox, Chrome/Chromium and Opera using Elgg 1.8.3.<br /><p>Enjoy.",
		'veeplay:skin:title' => "Skins",
		'veeplay:skin:skins' => "Two skins are available, the default JW Player and Glow. You can apply either of these skins to either the video player or the audio player, independently.",
		'veeplay:skin:skina' => "Select the AUDIO skin you wish to apply:",
		'veeplay:skin:skinv' => "Select the VIDEO skin you wish to apply:",
		'veeplay:skin:default' => "Default",
		'veeplay:skin:glow' => "Glow",
		// Effect options
		'veeplay:effect:on' => "Visualization effect",
		'veeplay:effect:off' => "Without effect (H23xW560)",
		'veeplay:effect:visual' => "Audio Visualization",
		'veeplay:effect:select' => "Select audio visualization on or off:",
		'veeplay:effect:desc' => "A visualization effect is available for the audio player. This can be set independently from the player size. This means it is possible to set the visualization on with a minimized control bar. If you set the set the control bar to minimum height (23), switch off visualization to save bandwidth.",
		// Size options
		'veeplay:player:size:desc' => "The default player window size is H315 W560. The height for the audio control bar without visualization is H23, though you can set height and width to any value, to the point of ridiculousness.<p>The height and width of both the video and audio player can be set independently.<p><em>Note, if you select audio control bar to H23, it makes no sense to keep visualization set to on.</em>",
		'veeplay:player:size' => "Player Size",
		'veeplay:audio:size' => "Select audio player size (Default H315 x W560):",
		'veeplay:audio:size:height' => "Audio player height",
		'veeplay:audio:size:width' => "Audio player width",
		'veeplay:video:size' => "Select video player size (Default H315 x W560):",
		'veeplay:video:size:height' => "Video player height",
		'veeplay:video:size:width' => "Video player width",
		'veeplay:size:option' => "Note: To reset the height and width to default, empty the fields and save.",
		// Options
		'veeplay:yes' => "Yes",
		'veeplay:no' => "No",
		'veeplay:on' => "On",
		'veeplay:off' => "Off",
		// Screen size image
		'veeplay:screen' => "Different screen sizes, for reference.",
		// Autoplay
		'veeplay:autoplay:autoplay' => "Autoplay/Autostart",
		'veeplay:autoplay:desc' => "Both the video and audio players can be independently set to start automatically or require the user to manually start the media file. By default autoplay/autostart is set to <em>Off</em>.",
		'veeplay:autoplay:audio' => "Select Autoplay for Audio files:",
		'veeplay:autoplay:video' => "Select Autoplay for Video files:",
		'veeplay:autoplay:off' => "Off",
		'veeplay:autoplay:on' => "On",

);
add_translation("en", $english);
