<?php
/**
 * Gets an environment variable from available sources, and provides emulation
 * for unsupported or inconsistent environment variables (i.e. DOCUMENT_ROOT on
 * IIS, or SCRIPT_NAME in CGI mode).  Also exposes some additional custom
 * environment information.
 *
 * @param  string $key Environment variable name.
 * @return string Environment variable setting.
 * @link http://book.cakephp.org/view/1130/env
 */
	function gumm_env($key) {
		if ($key == 'HTTPS') {
			if (isset($_SERVER['HTTPS'])) {
				return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
			}
			return (strpos(gumm_env('SCRIPT_URI'), 'https://') === 0);
		}

		if ($key == 'SCRIPT_NAME') {
			if (gumm_env('CGI_MODE') && isset($_ENV['SCRIPT_URL'])) {
				$key = 'SCRIPT_URL';
			}
		}

		$val = null;
		if (isset($_SERVER[$key])) {
			$val = $_SERVER[$key];
		} elseif (isset($_ENV[$key])) {
			$val = $_ENV[$key];
		} elseif (getenv($key) !== false) {
			$val = getenv($key);
		}

		if ($key === 'REMOTE_ADDR' && $val === gumm_env('SERVER_ADDR')) {
			$addr = gumm_env('HTTP_PC_REMOTE_ADDR');
			if ($addr !== null) {
				$val = $addr;
			}
		}

		if ($val !== null) {
			return $val;
		}

		switch ($key) {
			case 'SCRIPT_FILENAME':
				if (defined('SERVER_IIS') && SERVER_IIS === true) {
					return str_replace('\\\\', '\\', gumm_env('PATH_TRANSLATED'));
				}
			break;
			case 'DOCUMENT_ROOT':
				$name = gumm_env('SCRIPT_NAME');
				$filename = gumm_env('SCRIPT_FILENAME');
				$offset = 0;
				if (!strpos($name, '.php')) {
					$offset = 4;
				}
				return substr($filename, 0, strlen($filename) - (strlen($name) + $offset));
			break;
			case 'PHP_SELF':
				return str_replace(gumm_env('DOCUMENT_ROOT'), '', gumm_env('SCRIPT_FILENAME'));
			break;
			case 'CGI_MODE':
				return (PHP_SAPI === 'cgi');
			break;
			case 'HTTP_BASE':
				$host = gumm_env('HTTP_HOST');
				if (substr_count($host, '.') !== 1) {
					return preg_replace('/^([^.])*/i', null, gumm_env('HTTP_HOST'));
				}
			return '.' . $host;
			break;
		}
		return null;
	}
	
	if (!function_exists('debug')) {
    	function debug($data) {
    		$trace = debug_backtrace();
    		echo '<pre>';
    		echo '<p style="color:red;">File: ' . $trace[0]['file'] . '</p>';
    		echo '<p style="color:red;">Line: <strong>' . $trace[0]['line'] . '</strong></p>';
    		var_dump($data);
    		echo '</pre>';
    	}
	}

    if (!function_exists('d')) {
    	function d($data) {
    		$trace = debug_backtrace();
    		echo '<pre>';
    		echo '<p style="color:red;">File: ' . $trace[0]['file'] . '</p>';
    		echo '<p style="color:red;">Line: <strong>' . $trace[0]['line'] . '</strong></p>';
    		var_dump($data);
    		echo '</pre>';
    		exit;
    	}
    }
	
	function gumm_request_action($callback) {
	    if (!class_exists('GummObject')) require_once(GUMM_LIBS . 'gumm_object.php');
	    
	    return GummObject::_requestAction($callback);
	}
	
	function gummWasThemeActivated() {
	    global $gummWpHelper;
	    
	    $themeVersion = $gummWpHelper->getThemeVersion();
	    $activationOptionId = GUMM_THEME_PREFIX . '_theme_activated';
        $activated = !get_option($activationOptionId);
        if ($activated === true) {
            update_option($activationOptionId, $themeVersion);
            return true;
        } else {
            return false;
        }
	}
	
	if (!function_exists('is_ajax')) {
    	function is_ajax() {
    	    return GummRegistry::get('Component', 'RequestHandler')->isAjax();
    	}
	}

	if (!function_exists('__difplural')) {
    	function __difplural($singular, $plural, $count, $args) {
    	    $val = $plural;
    	    if ($count == 1) $val = $singular;

            return sprintf($val, $count);
    	}
	}
	
	// ========================== //
	// MB STR FUNCTIONS FALLBACKS //
	// ========================== //
	
    if (!function_exists('mb_strlen')) {
        function mb_strlen() {
            $args = func_get_args();
            return call_user_func_array('strlen', $args);
        }
    }
    if (!function_exists('mb_substr')) {
        function mb_substr() {
            $args = func_get_args();
            return call_user_func_array('substr', $args);
        }
    }
    if (!function_exists('mb_strrpos')) {
        function mb_strrpos() {
            $args = func_get_args();
            return call_user_func_array('strrpos', $args);
        }
    }

?>