<?php
class JsHelper extends GummHelper {
	
	public $helpers = array('Wp', 'Html');
	
	public function registerScripts() {
		if (is_admin()) {
			add_action('init', array(&$this, 'registerAdminScripts'));
			add_action('admin_head', array(&$this, 'enqueueAdminScripts'));
		} else {
			add_action('init', array(&$this, 'registerPublicScripts'));
			add_action('wp_head', array(&$this, 'enqueuePublicScripts'));
		}
	}
	
	public function registerAdminScripts() {
	    $this->_registerScripts(Configure::read('Assets.js.admin'));
	    
		wp_register_script('gummbase', GUMM_THEME_JS_URL . 'gummbase.js');
		wp_register_script('gummAdmin', GUMM_THEME_JS_URL . 'gumm-admin.js');
		wp_register_script('ajaxupload', GUMM_THEME_JS_URL . 'ajaxupload.js');

        wp_register_script('colorPicker', GUMM_THEME_JS_URL . 'colorpicker/js/colorpicker.js');
        wp_register_script('jqueryTransit', GUMM_THEME_JS_URL . 'jquery.transit.min.js');
             
        wp_register_script('jquerySliderAccess', GUMM_THEME_JS_URL . 'jquery.timepicker/jquery-ui-sliderAccess.js');
        // wp_register_script('jqueryUiTimePicker', GUMM_THEME_JS_URL . 'jquery.timepicker/jquery-ui-timepicker-addon.js');
        
        // wp_register_script('gumm-media', GUMM_THEME_JS_URL . 'gumm.media.js', false, array('jquery', 'media-upload', 'thickbox'), false );
        
        wp_register_script('jquery-ui-effects', GUMM_THEME_JS_URL . 'jquery-ui-effects.min.js');
        wp_register_script('jquery-countdown', GUMM_THEME_JS_URL . 'jquery.countdown.js');
	}
	
	public function enqueueAdminScripts() {
	    $screen = get_current_screen();
        $this->_enqueueScripts(Configure::read('Assets.js.admin'));
        // Enqueue jQuery UI
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-effects');
        wp_enqueue_script('jquery-countdown');
        wp_enqueue_script('jquery-ui-widget');
        wp_enqueue_script('jquery-ui-mouse');
        if (strpos($screen->base, 'revslider') === false) wp_enqueue_script('jquery-ui-autocomplete');
        wp_enqueue_script('jquery-ui-slider');
        // wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-droppable');
        wp_enqueue_script('jquery-ui-position');
        wp_enqueue_script('jquery-ui-resizable');
        wp_enqueue_script('jquery-ui-selectable');
        
		wp_enqueue_script('gummbase');
		wp_enqueue_script('gummAdmin');
		wp_enqueue_script('ajaxupload');
		
        wp_enqueue_script('colorPicker');
        
        wp_enqueue_script('jqueryTransit');
        
        wp_enqueue_script('jquerySliderAccess', false, array('jquery-timepicker'), false, true);
        // wp_enqueue_script('jqueryUiTimePicker', false, array('jquery-timepicker'), false, true);
        
        wp_enqueue_media();
        wp_enqueue_script('gumm-media');
	}
	
	public function registerPublicScripts() {
	    // Register
	    $this->_registerScripts(Configure::read('Assets.js.public'));
	    
        // wp_register_script('validation', 'http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js', 'jquery');
        wp_register_script('flexslider', GUMM_THEME_JS_URL . 'jquery.flexslider.js', 'jquery');
		wp_register_script('gummbase', GUMM_THEME_JS_URL . 'gummbase.js');
        wp_register_script('gummCustom', GUMM_THEME_JS_URL . 'gumm-custom.js', 'gumm-custom');
        wp_register_script('modernizr', GUMM_THEME_JS_URL . 'modernizr.custom.79639.js');
    
        
        wp_register_script('jqueryTransit', GUMM_THEME_JS_URL . 'jquery.transit.min.js');
        wp_register_script('bootstrap', GUMM_THEME_JS_URL . 'bootstrap.min.js');
        
        // Sliders
        wp_register_script('windy', GUMM_THEME_JS_URL . 'jquery.windy.js');
        wp_register_script('iosSlider', GUMM_THEME_JS_URL . 'jquery.iosslider.min.js');
        
        wp_register_script('jquery-prettyPhoto', GUMM_THEME_JS_URL . 'prettyPhoto/js/jquery.prettyPhoto.js');
        
        wp_register_script('jquery-ui-effects', GUMM_THEME_JS_URL . 'jquery-ui-effects.min.js');
        
        wp_register_script('jquery-hammer-js', GUMM_THEME_JS_URL . 'jquery.hammer.min.js');
        
        wp_register_script('masonry', GUMM_THEME_JS_URL . 'masonry.pkgd.min.js');
        wp_register_script('jquery-sticky-kit', GUMM_THEME_JS_URL . 'jquery.sticky-kit.min.js');
        
        // Enqueue jquery in the header, as needed in some body functions
        wp_enqueue_script('jquery', false, array(), false, false);
        wp_enqueue_script('jquery-ui-effects', false, array('jquery'), false, true);
	}
	
	public function enqueuePublicScripts() {
        // Enqueue
        $this->_enqueueScripts(Configure::read('Assets.js.public'));
        
        wp_enqueue_script('flexslider', false, array('jquery'), false, true);
        
        wp_enqueue_script('gummbase', false, array('jquery'), false, true);
        wp_enqueue_script('gummCustom', false, array('jquery'), false, true);
        wp_enqueue_script('modernizr', false, array(), false, true);
        
        wp_enqueue_script('bootstrap', false, array(), false, true);
        
        // Sliders
        wp_enqueue_script('windy', false, array(), false, true);
        wp_enqueue_script('iosSlider', false, array(), false, true);
        
        wp_enqueue_script('jquery-prettyPhoto', false, array(), false, true);
        wp_enqueue_script('jquery-hammer-js', false, array(), false, true);
        wp_enqueue_script('masonry', false, array(), false, true);
        wp_enqueue_script('jquery-sticky-kit', false, array(), false, true);
        wp_enqueue_script('jquery-countdown');

        if (!$this->Wp->isPluginActive('LayerSlider/layerslider.php')) wp_enqueue_script('jqueryTransit', false, array(), false, true);
        if ( is_singular() ) wp_enqueue_script( "comment-reply", false, array(), false, true );
	}
	
	public function script($script) {
		$scriptUrl = (strpos($script, 'http://') !== false) ? $script : GUMM_THEME_JS_URL . $script;
		return '<script type="text/javascript" src="' . $scriptUrl . '"></script>';
	}
	
	private function _registerScripts($scripts=array()) {
	    $this->_registerOrEnqueueScripts($scripts, 'register');;
	}
	
	private function _enqueueScripts($scripts=array()) {
	    $this->_registerOrEnqueueScripts($scripts, 'enqueue');
	}
	
	private function _registerOrEnqueueScripts($scripts=array(), $action='enqueue') {
	    $func = ($action === 'enqueue') ? 'wp_enqueue_script' : 'wp_register_script';
	    
        foreach ($scripts as $scriptsBatch) {
            $deps = false;
            if (isset($scriptBatch['dependencies'])) {
                $deps = (array) $scriptBatch['dependencies'];
            }
            
            foreach ($scriptsBatch['url'] as $scriptId => $scriptPath) {
                if (!$scriptPath) {
                    continue;
                }
                if (strpos($scriptPath, GUMM_THEME_URL) === false) {
                    $scriptPath = GUMM_THEME_JS_URL . $scriptPath;
                }
                if ($action === 'enqueue') {
                    $scriptPath = false;
                }
                
                call_user_func_array($func, array($scriptId, $scriptPath, $deps, $this->Wp->getThemeVersion(), true));
            }
        }
	}
	
}
?>