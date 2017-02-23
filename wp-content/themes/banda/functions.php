<?php
define('GUMM_TEMPLATEPATH', get_template_directory());
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!function_exists('wp_get_theme'))
    $gummCurrTheme = get_theme_data(GUMM_TEMPLATEPATH . DS . 'style.css');
else
    $gummCurrTheme = wp_get_theme();

//Define constants (framework specific):
define('GUMM_FW_PREFIX', 'gumm_');
define('GUMM_BASE', GUMM_TEMPLATEPATH . DS . 'app' . DS);
define('GUMM_LIBS', GUMM_BASE . 'libs' . DS);
define('GUMM_CONFIGS', GUMM_BASE . 'config' . DS);
define('GUMM_VIEWS', GUMM_BASE . 'views' . DS);
define('GUMM_LAYOUTS', GUMM_VIEWS . 'theme-layouts' . DS);
define('GUMM_MODELS', GUMM_BASE . 'models' . DS);
define('GUMM_ELEMENTS', GUMM_VIEWS . 'elements' . DS);
define('GUMM_LAYOUT_ELEMENTS', GUMM_ELEMENTS . 'layout-components' . DS);
define('GUMM_LAYOUT_ELEMENTS_SINGLE', GUMM_ELEMENTS . 'layout-components-single' . DS);
define('GUMM_CONTROLLERS', GUMM_BASE . 'controllers' . DS);
define('GUMM_LIB_COMPONENTS', GUMM_LIBS . 'controller' . DS . 'components' . DS);
define('GUMM_ASSETS', GUMM_BASE . 'assets' . DS);
define('GUMM_VENDORS', GUMM_BASE . 'vendors' . DS);
define('GUMM_WIDGETS', GUMM_BASE . DS . 'widgets' . DS);
define('GUMM_THEME_PAGE', 'gumm-administration');
define('GUMM_EXTERNAL_PLUGINS', GUMM_TEMPLATEPATH . DS . 'plugins' . DS);

//Define constants (theme specific):
define('GUMM_THEME', $gummCurrTheme['Name']);
define('GUMM_THEME_PREFIX', str_replace(' ', '', strtolower($gummCurrTheme['Name'])));
define('GUMM_THEME_URL', get_template_directory_uri());
define('GUMM_THEME_ASSETS_URL', GUMM_THEME_URL . '/app/assets/');
define('GUMM_THEME_JS_URL', GUMM_THEME_URL . '/app/assets/js/');
define('GUMM_THEME_CSS_URL', GUMM_THEME_URL . '/app/assets/css/');
define('GUMM_THEME_IMG_URL', GUMM_THEME_URL . '/app/assets/img/');
define('GUMM_COOKIE', '__gumm_' . GUMM_THEME_PREFIX . '_settings');

if ( function_exists('add_theme_support') ) { // Added in 2.9
	add_theme_support('post-thumbnails');
	add_image_size('homepage-thumb', 200, 146, true); //(cropped)
}

// Load Translation Text Domain
load_theme_textdomain('gummfw', GUMM_TEMPLATEPATH.'/languages');

// Set Max Content Width
if (!isset($content_width)) $content_width = 900;

//Nav Menus
if(function_exists('register_nav_menu')):
	register_nav_menu( 'prime_nav_menu', __('Prime Navigation Menu', 'gummfw'));
endif;

// Do the magic
require_once(GUMM_LIBS . 'bootstrap.php');

App::uses('TgmPluginActivation', 'Vendor/TgmPluginActivation');
$GummTgmPluginActivation = new TgmPluginActivation();

// add_filter('upload_mimes', 'custom_upload_mimes');
// function custom_upload_mimes() {
//     return array('mp3|m4a|m4b', 'audio/mpeg');
// }
// add_filter('plupload_default_settings', 'testingPlUpload');
// 
// function testingPlUpload() {
//     d(func_get_args());
// }

?>
