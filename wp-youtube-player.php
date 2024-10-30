<?php

/*
  Plugin Name: Modus YouTube Channel & Playlist widget
  Plugin URI: https://www.modus.ie/
  Description: This nice plugin will display your YouTube Channel, Playlist, or both in responsive rows and columns which you set, you can also modify the amount of thumb nails per page. There is paging added so you can have as many clips as you like.
  Version: 2.1.18
  Author: Modus
  Author URI: https://www.modus.ie/
  License: This plugin is licensed under the GNU General Public License.
 */

// ASSIGN VERSION
global $wpdb;


// DEFINE VARIABLE
define('YT_PLUGIN_NAME', 'modus-youtube-channel');
define('YT_MAIN_TITLE_PLUGIN', 'Modus YouTube Channel & Playlist widget');
define('YT_MAIN_DESCRIPTION_PLUGIN', 'This nice plugin will display your YouTube Channel, Playlist, or both in responsive rows and columns which you set, you can also modify the amount of thumb nails per page. There is paging added so you can have as many clips as you like.');

define("YT_ROOT_DIR", ABSPATH . 'wp-content/plugins/' . YT_PLUGIN_NAME . "/");
define("YT_ROOT_WWW", get_option('home') . '/wp-content/plugins/' . YT_PLUGIN_NAME . "/");

define("YT_PLUGIN_DIR", YT_ROOT_DIR);
define("YT_PLUGIN_WWW", YT_ROOT_WWW);

define("YT_IMAGES_DIR", YT_PLUGIN_DIR . "images/");
define("YT_IMAGES_WWW", YT_PLUGIN_WWW . "images/");

define("YT_CSS_DIR", YT_PLUGIN_DIR . "css/");
define("YT_CSS_WWW", YT_PLUGIN_WWW . "css/");

define("YT_JS_DIR", YT_PLUGIN_DIR . "js/");
define("YT_JS_WWW", YT_PLUGIN_WWW . "js/");

define("YT_ADMIN_FILES_DIR", YT_PLUGIN_DIR . "admin/");
define("YT_ADMIN_FILES_WWW", YT_PLUGIN_WWW . "admin/");

define("YT_FRONT_FILES_DIR", YT_PLUGIN_DIR . "pages/");
define("YT_FRONT_FILES_WWW", YT_PLUGIN_WWW . "pages/");

define("YT_INC_FILES_DIR", YT_PLUGIN_DIR . "inc/");
define("YT_INC_FILES_WWW", YT_PLUGIN_WWW . "inc/");

//INSTALL SOURCE
include_once('install-class.php');

//INCLUDE CLASS	
include_once(YT_ADMIN_FILES_DIR . 'admin-class.php');
include_once(YT_INC_FILES_DIR . 'inc-class.php');
?>
