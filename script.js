// Uploading files
var file_frame;
var targetID;
  jQuery('.upload_image_button').live('click', function( event ){

    event.preventDefault();
	
	targetID = event.currentTarget.dataset.targetId;

    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      file_frame.open();
      return;
    }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery( this ).data( 'uploader_title' ),
      button: {
        text: jQuery( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
		
	  jQuery('#'+targetID).val(attachment.url);
	  jQuery('#'+targetID+'-preview').attr('src',attachment.url);
    });

    // Finally, open the modal
    file_frame.open();
  });
  
//Validate Fields
var filters = {
    validate_url : {
        re : /(http|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/,
        error : 'ERROR: Invalid URL.'
    }
};

var validate = function(klass, str) {
    var valid = true,
        error = '';
    for (var f in filters) {
        var re = new RegExp(f);
        if (re.test(klass)) {
            if (str && !filters[f].re.test(str)) {
                error = filters[f].error;
                valid = false;
            }
            break;
        }
    }
    return {
        error: error,
        valid: valid
    }
};

jQuery( document ).ready(function( $ ) {

	jQuery('.validate').blur(function() {
		var test = validate(
			jQuery(this).attr('class'),
			jQuery(this).val()
		);
		if (!test.valid) {
			//jQuery('#errors').append('<p>' + test.error + '</p>');
			alert (test.error);
		}
	});

});

