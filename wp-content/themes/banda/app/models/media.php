<?php
class MediaModel extends GummModel {
    
    /**
     * @var array
     */
    public $inRelation = array('Post', 'PostMeta', 'Option');
    
    /**
     * @var bool
     */
    public $mergeOnSave = false;
    
    /**
     * @var array
     */
    private $_mimeTypes = array(
        'image' => array('image/png', 'image/jpeg', 'image/gif'),
        'video' => array('video/embed', 'video/vimeo', 'video/youtube', 'video/screenr'),
        'audio' => array('audio/mpeg', 'audio/x-realaudio', 'audio/wav', 'audio/ogg', 'audio/midi', 'audio/x-ms-wma', 'audio/x-ms-wax', 'audio/x-matroska'),
        'videoSelfHosted' => array(
        	'asf|asx' => 'video/x-ms-asf',
        	'wmv' => 'video/x-ms-wmv',
        	'wmx' => 'video/x-ms-wmx',
        	'wm' => 'video/x-ms-wm',
        	'avi' => 'video/avi',
        	'divx' => 'video/divx',
        	'flv' => 'video/x-flv',
        	'mov|qt' => 'video/quicktime',
        	'mpeg|mpg|mpe' => 'video/mpeg',
        	'mp4|m4v' => 'video/mp4',
        	'ogv' => 'video/ogg',
        	'webm' => 'video/webm',
        	'mkv' => 'video/x-matroska',
        ),
    );
    
    /**
     * @var array
     */
    private $_customSchema = array(
        'type' => '',
        'guid' => '',
    );
    
    public $wpFilters = array(
        'wp_get_attachment_url' => array('func' => 'getMediaUrl', 'priority' => 10, 'args' => 2),
    );
    
    /**
     * @param array $data
     * @return bool
     */
    public function updateMediaFields($data=null) {
        $id = isset($data['id']) ? $data['id'] : $this->id;
        if (isset($data['id'])) unset($data['id']);

        $errors = false;
        
        $post = $_post = get_post($id, ARRAY_A);

        if ( isset($data['post_content']) )
            $post['post_content'] = $data['post_content'];
        if ( isset($data['post_title']) )
            $post['post_title'] = $data['post_title'];
        if ( isset($data['post_excerpt']) )
            $post['post_excerpt'] = $data['post_excerpt'];
        if ( isset($data['menu_order']) )
            $post['menu_order'] = $data['menu_order'];

        $post = apply_filters('attachment_fields_to_save', $post, $data);

        if ( isset($data['image_alt']) ) {
            $image_alt = get_post_meta($id, '_wp_attachment_image_alt', true);
            if ( $image_alt != stripslashes($data['image_alt']) ) {
                $image_alt = wp_strip_all_tags( stripslashes($data['image_alt']), true );
                // update_meta expects slashed
                update_post_meta( $id, '_wp_attachment_image_alt', addslashes($image_alt) );
            }
        }
        
        if ( isset($data['url']) ) {
            $image_url = get_post_meta($id, '_gumm_attachment_image_link', true);
            if ( (!is_array($image_url)) || (is_array($image_url && !isset($image_url['url']))) ) {
                $image_url = array('url' => '', 'button' => '');
            }
            if (isset($data['link_button'])) {
                $image_url['button'] = stripslashes($data['link_button']);
            }
            
            if ( $image_url['url'] != stripslashes($data['url']) ) {
                $image_url['url'] = addslashes(wp_strip_all_tags( stripslashes($data['url']), true ));
                $image_url['button'] = addslashes(stripslashes($image_url['button']));
                
                // update_meta expects slashed
                update_post_meta( $id, '_gumm_attachment_image_link', $image_url );
            }
        }
        if (isset($data['postmeta'])) {
            update_post_meta($id, GUMM_THEME_PREFIX . '_postmeta', $data['postmeta']);
        }

        if ( isset($post['errors']) ) {
            $errors[$attachment_id] = $post['errors'];
            unset($post['errors']);
        }

        if ( $post != $_post )
            wp_update_post($post);

        foreach ( get_attachment_taxonomies($post) as $t ) {
            if ( isset($data[$t]) )
                wp_set_object_terms($id, array_map('trim', preg_split('/,+/', $data[$t])), $t, false);
        }
        
        return ($errors) ? false : true;
    }
    
    /**
     * @return array
     */
    public function getMediaMimeTypes() {
        
        $mimeTypes = array();
        foreach ($this->_mimeTypes as $key => $mimeTypeValues) {
            $mimeTypes = array_merge($mimeTypes, $mimeTypeValues);
        }
        
        return $mimeTypes;
    }
    
    /**
     * @param key
     * @return array
     */
    public function getMediaMimeType($key) {
        $key = strtolower($key);
        $mimeTypes = $this->getMediaMimeTypes();
        
        return (isset($this->_mimeTypes[$key])) ? $this->_mimeTypes[$key] : array();
    }
    
    public function isVideo($attachment) {
        $result = false;
        if ($attachment) {
            $result = in_array($attachment->post_mime_type, $this->_mimeTypes['video']);
        }
        return $result;
    }
    
    public function isSelfHostedVideo($attachment) {
        return in_array($attachment->post_mime_type, $this->_mimeTypes['videoSelfHosted']);
    }
    
    public function isImage($attachment) {
        return in_array($attachment->post_mime_type, $this->_mimeTypes['image']);
    }
    
    public function isAudio($attachment) {
        return in_array($attachment->post_mime_type, $this->_mimeTypes['audio']);
    }
    
    /**
     * Setter
     * 
     * @param object $attachment
     * @return void
     */
    public function setMediaFieldsByType(&$attachment) {
        if (isset($attachment->permalink) && $attachment->permalink === $attachment->post_excerpt) {
            return $attachment;
        }
        
        $_fields                = $this->_customSchema;
        $_fields['guid']        = $attachment->guid;
        $_fields['permalink']   = $attachment->guid;
        
        foreach ($this->_mimeTypes as $mediaType => $mimeTypes) {
            if (in_array($attachment->post_mime_type, $mimeTypes)) {
                if ($mediaType == 'video' && $this->isVideo($attachment) && $attachment->post_content) {
                    $_fields['guid'] = $attachment->post_content;
                    $_fields['permalink'] = $attachment->post_excerpt;
                    $_fields['post_content'] = '';
                }
                $_fields['type'] = $mediaType;
                break;
            }
        }
        $attachment = (object) Set::merge($attachment, $_fields);
    }
    
    /**
     * Attempt to save an embedded attachment
     * 
     * @param string $embedString
     * @return int post id on success | 0 on failure
     */
    public function saveVideo($embedString) {
        $data = $this->getVideoData($embedString);
        
        $attachmentData = array(
            'post_mime_type' => $data['mimeType'],
            'post_content' => $data['embedCode'],
            'post_status' => 'inherit',
            'post_excerpt' => $data['guid'],
            'post_title' => $data['provider'] && $data['id'] ? $data['provider'] . '-' . $data['id'] : 'external-video-' . uniqid()
        );

        $result = wp_insert_attachment($attachmentData);
        
        if ($result && $data['thumbnail']) {
            update_post_meta($result, '_gummThumbnail', $data['thumbnail']);
        }
        
        return $result;
    }
    
    /**
     * @param int $id
     * @return void
     */
    public function delete($id) {
        return wp_delete_attachment($id);
    }
    
    /**
     * Attempts to cleverly find and set data for embed string or url
     * Currently working providers: Vimeo, Youtube, Screenr
     * 
     * @return array
     */
    public function getVideoData($embedString) {
        $data = array(
            'id' => false,
            'provider' => false,
            'mimeType' => 'video/embed',
            'guid' => '',
            'embedCode' => $embedString,
            'thumbnail' => '',
        );

        /**
         * vimeo | youtube | screenr videos matching rules
         */
        if (preg_match_all("'player.vimeo.com/video/(.*)[\?|\"]'iU", $embedString, $out)) {
            $videoId = trim($out[1][0], '\\');
            $data = array(
                'id' => $videoId,
                'provider' => 'vimeo',
                'mimeType' => 'video/vimeo',
                'guid' => 'http://vimeo.com/' . $videoId,
                'embedCode' => $embedString,
                'thumbnail' => $this->fetchRemoteVideoThumbnail('vimeo', $videoId),
            );
        } elseif (preg_match_all("'youtube.com/embed/(.*)[\?|\"]'iU", $embedString, $out)) {
            $videoId = trim($out[1][0], '\\');
            $data = array(
                'id' => $videoId,
                'provider' => 'youtube',
                'mimeType' => 'video/youtube',
                'guid' => 'http://www.youtube.com/watch?v=' . $videoId,
                'embedCode' => $embedString,
                'thumbnail' => $this->fetchRemoteVideoThumbnail('youtube', $videoId),
            );
        } elseif (preg_match_all("'screenr.com/embed/(.*)[\?|\"]'iU", $embedString, $out)) {
            $videoId = $out[1][0];
            $data = array(
                'id' => $videoId,
                'provider' => 'screenr',
                'mimeType' => 'video/screenr',
                'guid' => 'http://www.screenr.com/' . $videoId,
                'embedCode' => $embedString,
            );
        } elseif (preg_match_all("'vimeo.com/(.*)(\?|$)'iU", $embedString, $out)) {
            $videoId = $out[1][0];
            $data = array(
                'id' => $videoId,
                'provider' => 'vimeo',
                'mimeType' => 'video/vimeo',
                'guid' => 'http://vimeo.com/' . $videoId,
                'embedCode' => '<iframe width="100%" height="100%" src="http://player.vimeo.com/video/' . $videoId . '?title=0&byline=0&portrait=0&badge=0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>',
                'thumbnail' => $this->fetchRemoteVideoThumbnail('vimeo', $videoId),
            );
        } elseif (preg_match_all("'youtube.com/watch\?v=(.*)(\&|$)'iU", $embedString, $out)) {
            $videoId = $out[1][0];
            $data = array(
                'id' => $videoId,
                'provider' => 'youtube',
                'mimeType' => 'video/youtube',
                'guid' => 'http://www.youtube.com/watch?v=' . $videoId,
                'embedCode' => '<iframe width="100%" height="100%" src="http://www.youtube.com/embed/' . $videoId . '" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>',
                'thumbnail' => $this->fetchRemoteVideoThumbnail('youtube', $videoId),
            );
        } elseif (preg_match_all("'screenr.com/(.*)(\?|$)'iU", $embedString, $out)) {
            $videoId = $out[1][0];
            $data = array(
                'id' => $videoId,
                'provider' => 'screenr',
                'mimeType' => 'video/screenr',
                'guid' => 'http://www.screenr.com/' . $videoId,
                'embedCode' => '<iframe width="100%" height="100%" src="http://www.screenr.com/embed/' . $videoId . '" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>',
            );
        }
        
        $data['error'] = (!$data['id']) ? true : false;
        
        return $data;
    }
    
    public function fetchRemoteVideoThumbnail($provider, $videoId, $cacheLocal = true) {
        $url = false;
        switch ($provider) {
         case 'vimeo':
            if ($transientGuid = get_transient($videoId . '-thumbnail')) {
                $url = $transientGuid;
            } else {
                $res = wp_remote_get('http://vimeo.com/api/v2/video/' . $videoId . '.php', array(
                    'timeout' => 120
                ));
                if (!is_wp_error($res)) {
                    $videoData = @unserialize($res['body']);
                    if ($videoData) {
                        $url = $videoData[0]['thumbnail_large'];
                        set_transient($videoId . '-thumbnail', $url, 60 * 1440);
                    }
                }
            }
            break;
         case 'youtube':
            $url = 'http://img.youtube.com/vi/' . $videoId . '/0.jpg';
            break;
        }
        
        if ($url && $cacheLocal) {
            $upload = $this->fetchRemoteFile($url, $provider . '-' . $videoId . '-thumbnail');
            if (!is_wp_error($upload)) {
                $url = $upload['url'];
            }
        }
        
        return $url;
        
    }
    
    public function getVideoThumbnail($attachment) {
        $guid = get_post_meta($attachment->ID, '_gummThumbnail', true);
        if (!$guid) {
            $guid = $attachment->guid;
            switch($attachment->post_mime_type) {
             case 'video/youtube':
                $videoId = str_replace('youtube-', '', $attachment->post_title);
                $guid = $this->fetchRemoteVideoThumbnail('youtube', $videoId, false);
                break;
             case 'video/vimeo':
                $videoId = str_replace('vimeo-', '', $attachment->post_title);
                $guid = $this->fetchRemoteVideoThumbnail('vimeo', $videoId, false);

                break;
            }
        }
        
        return $guid;
    }
    
    /**
     * Attempt to download a remote file attachment
     *
     * @param string $url URL of item to fetch
     * @param array $post Attachment details
     * @return array|WP_Error Local file location details on success, WP_Error otherwise
     */
    private function fetchRemoteFile( $url, $customFilename = null ) {
        // extract the file name and extension from the url
        $file_name = basename( $url );
        
        if ($customFilename) {
            $pi = pathinfo($file_name);
            $file_name = $customFilename . '.' . $pi['extension'];
        }

        // get placeholder file in the upload dir with a unique, sanitized filename
        $upload = wp_upload_bits( $file_name, 0, '', date('Y-m-d H:i:s') );
        if ( $upload['error'] )
            return new WP_Error( 'upload_dir_error', $upload['error'] );

        // fetch the remote url and write it to the placeholder file
        $headers = wp_get_http( $url, $upload['file'] );

        // request failed
        if ( ! $headers ) {
            @unlink( $upload['file'] );
            return new WP_Error( 'import_file_error', __('Remote server did not respond', 'wordpress-importer') );
        }

        // make sure the fetch was successful
        if ( $headers['response'] != '200' ) {
            @unlink( $upload['file'] );
            return new WP_Error( 'import_file_error', sprintf( __('Remote server returned error response %1$d %2$s', 'wordpress-importer'), esc_html($headers['response']), get_status_header_desc($headers['response']) ) );
        }

        $filesize = filesize( $upload['file'] );

        if ( isset( $headers['content-length'] ) && $filesize != $headers['content-length'] ) {
            @unlink( $upload['file'] );
            return new WP_Error( 'import_file_error', __('Remote file is incorrect size', 'wordpress-importer') );
        }

        if ( 0 == $filesize ) {
            @unlink( $upload['file'] );
            return new WP_Error( 'import_file_error', __('Zero size file downloaded', 'wordpress-importer') );
        }

        $max_size = (int) $this->max_attachment_size();
        if ( ! empty( $max_size ) && $filesize > $max_size ) {
            @unlink( $upload['file'] );
            return new WP_Error( 'import_file_error', sprintf(__('Remote file is too large, limit is %s', 'wordpress-importer'), size_format($max_size) ) );
        }

        // keep track of the old and new urls so we can substitute them later
        // $this->url_remap[$url] = $upload['url'];
        // $this->url_remap[$post['guid']] = $upload['url']; // r13735, really needed?
        // // keep track of the destination if the remote url is redirected somewhere else
        // if ( isset($headers['x-final-location']) && $headers['x-final-location'] != $url )
        //     $this->url_remap[$headers['x-final-location']] = $upload['url'];

        return $upload;
    }
    
    public function getAudioProvidersForAttachment($post) {
        $result = array();
        if ($providers = $this->PostMeta->find($post->ID, 'postmeta.provider')) {
            if ($providers = Set::filter($providers)) {
                foreach ($providers as $providerSlug => $providerUrl) {
                    $result[] = array(
                        'name'  => Inflector::humanize($providerSlug),
                        'url'   => $providerUrl,
                    );
                }
            }
        }
        
        return $result;
    }

    
    // ======= //
    // FILTERS //
    // ======= //
    
    /**
     * WordPress Filter Hook to get correct url for the custom video/embed mime type
     * 
     * @param string $url
     * @param int $postId
     * @return string
     */
    public function getMediaUrl($url, $postId) {
        if (!$url) {
            $post = $this->Post->findById($postId);
            if ($post->type == 'video') {
                $url = $post->guid;
            }
        }
        
        return $url;
    }

}
?>