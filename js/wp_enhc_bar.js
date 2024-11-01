function agile_process_ping(){
	//jQuery('#_agile_ping_msg').show();
	alert('Pinging Services, please wait....');
	var data = {
		action: 'agile_enhc_get',
		
	};
	
	jQuery.post(ajaxurl, data, function(r) {
		//jQuery('#_agile_ping_msg').show();
		alert(r);
	});
	
}

jQuery(document).ready(function() {
	var barhdr = jQuery('#agile_enhc_header').html();
	jQuery('#agile_enhc_header').html('');
	jQuery('#masthead').append(barhdr);
});