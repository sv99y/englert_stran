jQuery(document).ready(function($){
	
	var valid_url;
	var result;
	var slide_count = $('.form-table').length;
	var save_notices = 0;
	
	$('.hss-image-preview').each(function(){
		if( $(this).attr('src') != '' ){
			$(this).css('display', 'block')
		}
	});
	
	$('#wpbody-content form').sortable({
   		items: '> .form-table',
		update: function( event, ui ) { reorder(); }
	});
	
	function is_valid_url( url, target ){
		valid_url = url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
		if( valid_url !== null ){ target.css('display', 'none'); }
		else{ target.css('display', 'block'); }
	}
	
	function reorder(){
		var $i = 1;
		$('#wpbody-content .form-table').find('.hss-order').each(function(){
			$(this).text($i);
			$i++;
		});
	}
	
	$('.hss-link').change(function() {
		if( $(this).val() != '' ){
			$(this).next('.hss-link-preview').attr( 'href', $(this).val() );
			$(this).next('.hss-link-preview').css('visibility', 'visible');
			is_valid_url( $(this).val(), $(this).siblings('.hss-link-error') );
		}
		else{
			$(this).next('.hss-link-preview').css('visibility', 'hidden');
			$(this).siblings('.hss-link-error').css('display', 'none');
		}
	});
	
	$('.hss-new-slide').click(function(e) {
		var slide_clone = $(this).closest('.form-table').clone(true);
		var current_index = $(this).siblings('.hss-index').val();
		slide_count++;
		slide_clone.find('input').each(function() {
			 this.name = this.name.replace(current_index, slide_count); 
        });
		slide_clone.find('input').val('');
		slide_clone.find('.hss-image-preview').attr('src', '').css('display', 'none');
		slide_clone.find('.hss-index').val(slide_count);
		slide_clone.find(':button').val('Select Image');
		slide_clone.css('display', 'none');
		slide_clone.insertBefore( $(this).closest('.form-table') );
		slide_clone.fadeIn(900);
		reorder();
	});
	
	$('.hss-clear').click(function(e) {
		e.preventDefault();
		var current_order = $(this).closest('.form-table').find('.hss-order').text();
		if ( confirm('Clear Slide ' + current_order + '?') ) {
			target = $(this).closest('.form-table')
			target.find('input').not('.hss-index, .button').val('');
			target.find('.hss-image-preview').attr('src', '');
			if( save_notices == 0 ){
				alert('Save changes to commit edit(s).');
				save_notices++;
			}
		}
	});
	
	$('.hss-delete').click(function(e) {
		e.preventDefault();
		var current_order = $(this).closest('.form-table').find('.hss-order').text();
		if (confirm('Delete Slide ' + current_order + '?')) {
			$(this).closest('.form-table').fadeOut('slow', function() {
				$(this).remove();
				reorder();
				if( save_notices == 0 ){
					alert('Save changes to commit edit(s).');
				save_notices++;
				}
			});
		return false;
    	}
		
	});
 
	$('.hss-select-image').click(function(e) {
		e.preventDefault();
		
		current_id = 'slide-' + $(this).closest('tr').prev().find('.hss-index').val();
		var current_slide = $(this).closest('.form-table');
		
		var insertImage = wp.media.controller.Library.extend({
			defaults :  _.defaults({
					id: 'insert-image',
					title: 'Select Image',
					// allowLocalEdits: true,
					displaySettings: true,
					displayUserSettings: true,
					multiple: false,
					type: 'image' //audio, video, application/pdf, ... etc
			  }, wp.media.controller.Library.prototype.defaults )
		});
		
		//Setup media frame
		var frame = wp.media({
			button: { text : 'Select' },
			state: 'insert-image',
			states: [ new insertImage() ]
		});
		
		
		frame.on( 'select',function() {
			var state = frame.state('insert-image');
			var selection = state.get('selection');
		
			if ( !selection ) return;

			selection.each(function( attachment ) {
				var display = state.display(attachment).toJSON();
				var img_info = attachment.toJSON();
				var selected_img = wp.media.string.props(display, img_info);
				var img_src = selected_img['src'];
				var link_url = selected_img['linkUrl'];
				var current_slide_url = current_slide.find('.hss-link').val();
				
				current_slide.find('.hss-image').val(img_src);
				current_slide.find('.hss-image-preview').attr('src', img_src);
				current_slide.find('.hss-image-preview').css('display', 'block');
				
				if( link_url != '' ){
					current_slide.find('.hss-link').val(link_url);
					current_slide.find('.hss-link-preview').attr('href', link_url);
					current_slide.find('.hss-link-preview').css('visibility', 'visible');
					is_valid_url( link_url, current_slide.find('.hss-link-error') );
				}
				else if (current_slide_url != ''){
					var r = confirm('Clear current slide link?');
					if (r == true) {
						current_slide.find('.hss-link').val('');
						current_slide.find('.hss-link-preview').css('visibility', 'hidden');
					}
				}
				// current_slide.find('.hss-link-preview').css('visibility', 'hidden');
			});
		});
		
		//reset selection in popup, when open the popup
		frame.on('open',function() {
			var selection = frame.state('insert-image').get('selection');
		
			//remove all the selection first
			selection.each(function(image) {
				var attachment = wp.media.attachment( image.attributes.id );
				attachment.fetch();
				selection.remove( attachment ? [ attachment ] : [] );
			});
			
		});
		
		//now open the popup
		frame.open();
	
	});
 
});