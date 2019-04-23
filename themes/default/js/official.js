/**
 * @Project NUKEVIET 4.x
 * @Author Ho Ngoc Trien (hongoctrien@2mit.org)
 * @Copyright (C) 2015 Ho Ngoc Trien. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 01:05:44 GMT
 */

$(document).ready(function(){
	if( $.fn.datepicker ){
		$("#from_date, #to_date").datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: !0,
			changeYear: !0,
			showOtherMonths: !0,
			showOn: "focus",
			yearRange: "-90:+0"
		});
	}
	$('#to-btn').click(function(){
		$("#to_date").datepicker('show');
	});
	$('#from-btn').click(function(){
		$("#from_date").datepicker('show');
	});
});

$('#openImageModal').click(function(){
	$('#sitemodal .modal-dialog').css({'width': 200+43});
	modalShow( $(this).attr('alt'), '<img src="' + $(this).attr('src') + '" width="200" />' );
});

function nv_print_page(url) {
	nv_open_browse(url + '?print=1', '', 740, 600, 'resizable=no,scrollbars=yes,toolbar=no,location=no,status=no');
	return false;
}
