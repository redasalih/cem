(function( $ ){

if (typeof wp === 'undefined') return false; // Awesome wordpress is awesome, as we cannot load this simply with js if not post editor, return false
if (typeof wp.media === 'undefined') return false; // Awesome wordpress is awesome, as we cannot load this simply with js if not post editor, return false

$(document).ready(function(){
    // var pluploadDefaultFilters = null;
    $(document).on('click', '.gumm-insert-media', function(e){
        e.preventDefault();
        
        var frameOptions = {
            gummOptions: {
                fileExtensions: false,
                frameTitle: l10n.insertMediaTitle
            }
        };
        if ($(this).data('multiple') !== undefined) {
            frameOptions.multiple = Boolean($(this).data('multiple'));
        }
        if ($(this).data('fileTypes') !== undefined) {
            frameOptions.library = {
                type: $(this).data('fileTypes')
            }
        }
        if ($(this).data('fileExtensions') !== undefined) {
            frameOptions.gummOptions.fileExtensions = $(this).data('fileExtensions');
        }
        if ($(this).data('frameTitle') !== undefined) {
            frameOptions.gummOptions.frameTitle = $(this).data('frameTitle');
        }
        
        var uploadsContainer    = $(this).parent().parent('.gumm-media-manager').find('.media-uploads-container');
        var inputCointainer     = $(this).next('input.gumm-input');
        var optionId            = $(this).data('option-id');
        var mode                = 'preview';
        
        if ($(this).data('preview-mode') !== undefined) {
            mode = $(this).data('preview-mode');
        }
        var uploadsLayout = $(this).data('uploadsLayout');
        
        var frame = new gummMedia.view(frameOptions);
        
        frame.open();
        if ($(this).data('fileExtensions') !== undefined) {
            frame.uploader.uploader.uploader.settings.filters = [];
            frame.uploader.uploader.uploader.settings.filters.push($(this).data('fileExtensions'));
        }
        
		frame.on('insert', function(selection) {
			var state = frame.state();

			selection = selection || state.get('selection');

			if (!selection)
				return;

			$.when.apply( $, selection.map( function( attachment ) {
			    switch (mode) {
			     case 'preview':
                    return attachment.id;
                 case 'url-input':
                    return {id: attachment.id, url: attachment.attributes.url};
			    }
                return attachment.id;
			}, this ) ).done( function() {
			    switch (mode) {
			     case 'preview':
                     $.ajax({
                         url: ajaxurl,
                         data: {
                             gummcontroller: 'media',
                             action: 'gumm_index',
                             gummadmin: true,
                             gummMedia: arguments,
                             optionId: optionId,
                             uploadsLayout: uploadsLayout
                         },
                         type: 'post',
                         success: function(data, textStatus, jqXHR) {
                             uploadsContainer.prepend(data);
                         }
                     });
			         break;
			     case 'url-input':
                    inputCointainer.val(arguments[0].url);
			        break;
			    }
			});
		}, this);
    });
 
});

var gummMedia = {},
    media = wp.media,
	l10n = media.view.l10n = typeof _wpMediaViewsL10n === 'undefined' ? {} : _wpMediaViewsL10n;

gummMedia.view = media.view.MediaFrame.Post.extend({
    initialize: function() {
        _.defaults( this.options, {
            multiple: true,
            editing:  false,
            state:    'insert'
        });

        media.view.MediaFrame.Select.prototype.initialize.apply( this, arguments );
	},
	createStates: function() {
		var options = this.options;
		
		// Add the default states.
		this.states.add([
			// Main states.
			new media.controller.Library({
				id:         'insert',
				title:      options.gummOptions.frameTitle,
				priority:   20,
				toolbar:    'main-insert',
				filterable: 'all',
				library:    media.query( options.library ),
				multiple:   options.multiple ? 'reset' : false,
				editable:   true,

				// If the user isn't allowed to edit fields,
				// can they still edit it locally?
				allowLocalEdits: true,

				// Show the attachment display settings.
				displaySettings: true,
				// Update user settings when users adjust the
				// attachment display settings.
				displayUserSettings: true
			}),

			// Embed states.
            // new media.controller.Embed()
		]);

	},
	mainInsertToolbar: function( view ) {
		var controller = this;

		this.selectionStatusToolbar( view );

		view.set( 'insert', {
			style:    'primary',
			priority: 80,
			text:     'Add Media',
			requires: { selection: true },

			click: function() {
				var state = controller.state(),
					selection = state.get('selection');

				controller.close();
				state.trigger( 'insert', selection ).reset();
			}
		});
	}
});

})( jQuery );