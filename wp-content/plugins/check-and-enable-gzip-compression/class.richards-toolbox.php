<?php

class Richards_Toolbox {
	function checkGZIPCompression($url) {
		$result = @file_get_contents('http://checkgzipcompression.com/js/checkgzip.json?url=' . $url);
		if(!$result) {
			return false;
		}
		return json_decode($result);
	}

	function enableGZIPCompression() {
		update_option( 'richards-toolbox-gzip-enabled', 1 );
		if(@$_GET['apache'] == '1') {
			update_option( 'richards-toolbox-htaccess-enabled', 1 );
			add_filter('mod_rewrite_rules', 'richards_toolbox_addHtaccessContent');
			save_mod_rewrite_rules();
		}
	}

	function disableGZIPCompression() {
		update_option( 'richards-toolbox-htaccess-enabled', 0 );
		update_option( 'richards-toolbox-gzip-enabled', 0 );
		remove_filter('mod_rewrite_rules', 'richards_toolbox_addHtaccessContent');
		save_mod_rewrite_rules();
	}
	function isApache() {
		return strtolower($_SERVER['SERVER_SOFTWARE']) == 'apache';
	}
}