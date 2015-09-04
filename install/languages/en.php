<?php
/**
 * Installer English Language
 *
 * @package ElggLanguage
 * @subpackage Installer
 */

$english = array(
	'install:title' => 'ClipIt Install',
	'install:welcome' => 'Welcome',
	'install:requirements' => 'Requirements check',
	'install:database' => 'Database installation',
	'install:settings' => 'Configure site',
	'install:admin' => 'Create admin account',
	'install:complete' => 'Finished',

	'install:next' => 'Next',
	'install:refresh' => 'Refresh',

	'install:welcome:instructions' => "Installing ClipIt has 6 simple steps and reading this welcome is the first one!

If you haven't already, read through the installation instructions included with ClipIt (or click the instructions link at the bottom of the page).

If you are ready to proceed, click the Next button.",
	'install:requirements:instructions:success' => "Your server passed the requirement checks.",
	'install:requirements:instructions:failure' => "Your server failed the requirements check. After you have fixed the below issues, refresh this page. Check the troubleshooting links at the bottom of this page if you need further assistance.",
	'install:requirements:instructions:warning' => "Your server passed the requirements check, but there is at least one warning. We recommend that you check the install troubleshooting page for more details.",

	'install:require:php' => 'PHP',
	'install:require:rewrite' => 'Web server',
	'install:require:settings' => 'Settings file',
	'install:require:database' => 'Database',

	'install:check:root' => 'Your web server does not have permission to create an .htaccess file in the root directory of ClipIt. You have two choices:

		1. Change the permissions on the root directory

		2. Copy the file htaccess_dist to .htaccess',

	'install:check:php:version' => 'ClipIt requires PHP %s or above. This server is using version %s.',
	'install:check:php:extension' => 'ClipIt requires the PHP extension %s.',
	'install:check:php:extension:recommend' => 'It is recommended that the PHP extension %s is installed.',
	'install:check:php:open_basedir' => 'The open_basedir PHP directive may prevent ClipIt from saving files to its data directory.',
	'install:check:php:safe_mode' => 'Running PHP in safe mode is not recommened and may cause problems with ClipIt.',
	'install:check:php:arg_separator' => 'arg_separator.output must be & for ClipIt to work and your server\'s value is %s',
	'install:check:php:register_globals' => 'Register globals must be turned off.',
	'install:check:php:session.auto_start' => "session.auto_start must be off for ClipIt to work. Either change the configuration of your server or add this directive to ClipIt's .htaccess file.",

	'install:check:enginedir' => 'Your web server does not have permission to create the settings.php file in the engine directory. You have two choices:

		1. Change the permissions on the engine directory

		2. Copy the file settings.example.php to settings.php and follow the instructions in it for setting your database parameters.',
	'install:check:readsettings' => 'A settings file exists in the engine directory, but the web server cannot read it. You can delete the file or change the read permissions on it.',

	'install:check:php:success' => "Your server's PHP satisfies all of ClipIt's requirements.",
	'install:check:rewrite:success' => 'The test of the rewrite rules was successful.',
	'install:check:database' => 'The database requirements are checked when ClipIt loads its database.',

	'install:database:instructions' => "If you haven't already created a database for ClipIt, do that now. Then fill in the values below to initialize the ClipIt database.",
	'install:database:error' => 'There was an error creating the ClipIt database and installation cannot continue. Review the message above and correct any problems. If you need more help, visit the Install troubleshooting link below or post to the ClipIt community forums.',

	'install:database:label:dbuser' =>  'Database Username',
	'install:database:label:dbpassword' => 'Database Password',
	'install:database:label:dbname' => 'Database Name',
	'install:database:label:dbhost' => 'Database Host',
	'install:database:label:dbprefix' => 'Database Table Prefix',

	'install:database:help:dbuser' => 'User that has full privileges to the MySQL database that you created for ClipIt',
	'install:database:help:dbpassword' => 'Password for the above database user account',
	'install:database:help:dbname' => 'Name of the ClipIt database',
	'install:database:help:dbhost' => 'Hostname of the MySQL server (usually localhost)',
	'install:database:help:dbprefix' => "The prefix given to all of ClipIt's tables (usually elgg_)",

	'install:settings:instructions' => 'We need some information about the site as we configure ClipIt. If you haven\'t <a href="http://docs.elgg.org/wiki/Data_directory" target="_blank">created a data directory</a> for ClipIt, you need to do so now.',

	'install:settings:label:sitename' => 'Site Name',
	'install:settings:label:siteemail' => 'Site Email Address',
	'install:settings:label:wwwroot' => 'Site URL',
	'install:settings:label:path' => 'ClipIt Install Directory',
	'install:settings:label:dataroot' => 'Data Directory',
	'install:settings:label:language' => 'Site Language',
	'install:settings:label:siteaccess' => 'Default Site Access',
    'install:settings:label:timezone' => 'Site Time Zone',

    'install:settings:label:clipit_global_url' => "ClipIt Global URL",
    'install:settings:label:clipit_global_login' => "ClipIt Global Login",
    'install:settings:label:clipit_global_password' => "ClipIt Global Password",

    'install:settings:label:jxl_secret' => "JuxtaLearn Secret Key",
    'install:settings:label:la_metrics_class' => "LA Metrics Class",
    'install:settings:label:recommendations_class' => "Recommendations Class",
    'install:settings:label:clipit_site_type' => "ClipIt Site Type (site, demo or global)",

    'install:label:combo:dataroot' => 'ClipIt creates data directory',

	'install:settings:help:sitename' => 'The name of your new ClipIt site',
	'install:settings:help:siteemail' => 'Email address used by ClipIt for communication with users',
	'install:settings:help:wwwroot' => 'The address of the site (ClipIt usually guesses this correctly)',
	'install:settings:help:path' => 'The directory where you put the ClipIt code (ClipIt usually guesses this correctly)',
	'install:settings:help:dataroot' => 'The directory that you created for ClipIt to save files (the permissions on this directory are checked when you click Next). It must be an absolute path.',
	'install:settings:help:dataroot:apache' => 'You have the option of ClipIt creating the data directory or entering the directory that you already created for storing user files (the permissions on this directory are checked when you click Next).',
	'install:settings:help:language' => 'The default language for the site.',
	'install:settings:help:siteaccess' => 'The default access level for new user created content.',
    'install:settings:help:timezone' => 'The Time Zone for the site (see: <a href="http://www.php.net/manual/en/timezones.php" target="_blank">PHP Time Zones</a>).',

    'install:settings:help:clipit_global_url' => "The URL of the ClipIt Global Site (clear to avoid global publishing)",
    'install:settings:help:clipit_global_login' => "Login name to access ClipIt Global Site",
    'install:settings:help:clipit_global_password' => "Password to access ClipIt Global Site",

    'install:settings:help:jxl_secret' => 'The JuxtaLearn secret key for interoperability between components.',
    'install:settings:help:la_metrics_class' => 'Name of the Learning Analytics metrics class (default: ActivityStreamer)',
    'install:settings:help:recommendations_class' => 'Name of the Recommendations class (default: RecommendationEngine)',
    'install:settings:help:clipit_site_type' => "Define whether this will be a normal site, a demo site, or a global site",

	'install:admin:instructions' => "It is now time to create an administrator's account.",

	'install:admin:label:displayname' => 'Display Name',
	'install:admin:label:email' => 'Email Address',
	'install:admin:label:username' => 'Username',
	'install:admin:label:password1' => 'Password',
	'install:admin:label:password2' => 'Password Again',

	'install:admin:help:displayname' => 'The name that is displayed on the site for this account',
	'install:admin:help:email' => '',
	'install:admin:help:username' => 'Account username used for logging in',
	'install:admin:help:password1' => "Account password must be at least %u characters long",
	'install:admin:help:password2' => 'Retype password to confirm',

	'install:admin:password:mismatch' => 'Password must match.',
	'install:admin:password:empty' => 'Password cannot be empty.',
	'install:admin:password:tooshort' => 'Your password was too short',
	'install:admin:cannot_create' => 'Unable to create an admin account.',

	'install:complete:instructions' => 'Your ClipIt site is now ready to be used. Click the button below to be taken to your site.<p><b>!!! REMEMBER TO ACTIVATE ALL PLUGINS !!!</b>',
	'install:complete:gotosite' => 'Go to site',

	'InstallationException:UnknownStep' => '%s is an unknown installation step.',

	'install:success:database' => 'Database has been installed.',
	'install:success:settings' => 'Site settings have been saved.',
	'install:success:admin' => 'Admin account has been created.',

	'install:error:htaccess' => 'Unable to create an .htaccess',
	'install:error:settings' => 'Unable to create the settings file',
	'install:error:databasesettings' => 'Unable to connect to the database with these settings.',
	'install:error:database_prefix' => 'Invalid characters in database prefix',
	'install:error:oldmysql' => 'MySQL must be version 5.0 or above. Your server is using %s.',
	'install:error:nodatabase' => 'Unable to use database %s. It may not exist.',
	'install:error:cannotloadtables' => 'Cannot load the database tables',
	'install:error:tables_exist' => 'There are already ClipIt tables in the database. You need to either drop those tables or restart the installer and we will attempt to use them. To restart the installer, remove \'?step=database\' from the URL in your browser\'s address bar and press Enter.',
	'install:error:readsettingsphp' => 'Unable to read engine/settings.example.php',
	'install:error:writesettingphp' => 'Unable to write engine/settings.php',
	'install:error:requiredfield' => '%s is required',
	'install:error:relative_path' => 'We don\'t think "%s" is an absolute path for your data directory',
	'install:error:datadirectoryexists' => 'Your data directory %s does not exist.',
	'install:error:writedatadirectory' => 'Your data directory %s is not writable by the web server.',
	'install:error:locationdatadirectory' => 'Your data directory %s must be outside of your install path for security.',
	'install:error:emailaddress' => '%s is not a valid email address',
	'install:error:createsite' => 'Unable to create the site.',
	'install:error:savesitesettings' => 'Unable to save site settings',
	'install:error:loadadmin' => 'Unable to load admin user.',
	'install:error:adminaccess' => 'Unable to give new user account admin privileges.',
	'install:error:adminlogin' => 'Unable to login the new admin user automatically.',
	'install:error:rewrite:apache' => 'We think your server is running the Apache web server.',
	'install:error:rewrite:nginx' => 'We think your server is running the Nginx web server.',
	'install:error:rewrite:lighttpd' => 'We think your server is running the Lighttpd web server.',
	'install:error:rewrite:iis' => 'We think your server is running the IIS web server.',
	'install:error:rewrite:allowoverride' => "The rewrite test failed and the most likely cause is that AllowOverride is not set to All for ClipIt's directory. This prevents Apache from processing the .htaccess file which contains the rewrite rules.
				\n\nA less likely cause is Apache is configured with an alias for your ClipIt directory and you need to set the RewriteBase in your .htaccess. There are further instructions in the .htaccess file in your ClipIt directory.",
	'install:error:rewrite:htaccess:write_permission' => 'Your web server does not have permission to create the .htaccess file in ClipIt\'s directory. You need to manually copy htaccess_dist to .htaccess or change the permissions on the directory.',
	'install:error:rewrite:htaccess:read_permission' => 'There is an .htaccess file in ClipIt\'s directory, but your web server does not have permission to read it.',
	'install:error:rewrite:htaccess:non_elgg_htaccess' => 'There is an .htaccess file in ClipIt\'s directory that was not not created by ClipIt. Please remove it.',
	'install:error:rewrite:htaccess:old_elgg_htaccess' => 'There appears to be an old ClipIt .htaccess file in ClipIt\'s directory. It does not contain the rewrite rule for testing the web server.',
	'install:error:rewrite:htaccess:cannot_copy' => 'A unknown error occurred while creating the .htaccess file. You need to manually copy htaccess_dist to .htaccess in ClipIt\'s directory.',
	'install:error:rewrite:altserver' => 'The rewrite rules test failed. You need to configure your web server with ClipIt\'s rewrite rules and try again.',
	'install:error:rewrite:unknown' => 'Oof. We couldn\'t figure out what kind of web server is running on your server and it failed the rewrite rules. We cannot offer any specific advice. Please check the troubleshooting link.',
	'install:warning:rewrite:unknown' => 'Your server does not support automatic testing of the rewrite rules and your browser does not support checking via JavaScript. You can continue the installation, but you may experience problems with your site. You can manually test the rewrite rules by clicking this link: <a href="%s" target="_blank">test</a>. You will see the word success if the rules are working.',
);

add_translation("en", $english);
