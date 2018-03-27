jQuery(document).ready(function($){
	$('#hss-nav a').click(function() {
		$(this).parent().prev('.cycle-slideshow').cycle('pause');
	});
	$('#hss-pager a').click(function() {
		$(this).parent().next('.cycle-slideshow').cycle('pause');
	});
	var long_cap_div = 0;
	function info_area_height() {
		if( long_cap_div == 0 ){ long_cap_div = $('#hss-long-caption'); }
		long_cap_div.show();
		var long_cap_height = (long_cap_div.height())+1;
		var long_cap_width = long_cap_div.width();
		long_cap_div.hide();
		// long_cap_div.prev('#hss-info').css({ 'min-height': long_cap_height, 'min-width': long_cap_width });
	}
	info_area_height();
	$(window).resize(function(){	
		if ($('#hss-info').css('position') == 'static'){
			info_area_height();
		}
	});
});