<?php
/**
 * Plugin Name: goo1 Videos Dancestudio
 * Plugin URI: https://github.com/andreaskasper/
 * Description: Important functions for goo1 websites
 * Author: Andreas Kasper
 * Version: 0.1.13
 * Author URI: https://github.com/andreaskasper/
 * Network: True
 * Text Domain: goo1-wc-videos
 */

spl_autoload_register(function ($class_name) {
	if (substr($class_name,0,23) != "plugins\\goo1\\wc\\videos\\") return false;
	$files = array(
		__DIR__."/classes/".str_replace("\\", DIRECTORY_SEPARATOR,substr($class_name, 23)).".php"
	);
	foreach ($files as $file) {
		if (file_exists($file)) {
			include($file);
			return true;
		}
	}
	return false;
});

add_action( 'plugins_loaded', function() {
    load_plugin_textdomain( 'goo1-wc-videos', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
});
add_action("goo1_omni_loaded", ["\\plugins\\goo1\\wc\\videos\\core", "goo1_loaded"]);
\plugins\goo1\wc\videos\core::init();

if (!class_exists("Puc_v4_Factory")) {
	require_once(__DIR__."/plugin-update-checker/plugin-update-checker.php");
}
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    "https://raw.githubusercontent.com/andreaskasper/wordpress-wc-videos/main/dist/updater.json",
    __FILE__, //Full path to the main plugin file or functions.php.
    "goo1-wc-videos"
);

