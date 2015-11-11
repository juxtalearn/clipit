<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2013-10-10
 * Last update:     $Date$
 * @author          Pablo Llinás Arnaiz <pebs74@gmail.com>, URJC Clipit Team
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 * @subpackage      urjc_backend
 */

// check for PHP 4 before we do anything else
if (version_compare(PHP_VERSION, '5.0.0', '<')) {
	echo "Your server's version of PHP (" . PHP_VERSION . ") is too old to run Elgg.\n";
	exit;
}

require_once(dirname(__FILE__) . "/install/ElggInstaller.php");

$installer = new ElggInstaller();

$step = get_input('step', 'welcome');
$installer->run($step);
