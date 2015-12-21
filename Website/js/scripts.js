$(document).ready(function() {
	$("#colorb").hide();
	$("#delay").hide();
	$("#repeat").hide();
	$("#length").hide();

	var menu = jQuery('#menu');
	var select = this.value;

	menu.change(function () {
		$("#colorb").hide();
		$("#delay").hide();
		$("#repeat").hide();
		$("#length").hide();
		if ($(this).val() == 'rnb') {
	    	$('#delay').show();
		}

		else if($(this).val() == 'cwp') {
			$("#colorb").show();
			$("#delay").show();
		}
		else if($(this).val() == 'rbc') {
			$("#delay").show();
		}
		else if($(this).val() == 'trc') {
			$("#colorb").show();
			$("#delay").show();
		}
		else if($(this).val() == 'glo') {
			$("#colorb").show();
			$("#repeat").show();
		}
		else if($(this).val() == 'kal') {
			$("#colorb").show();
			$("#delay").show();
			$("#repeat").show();
		}
		else if($(this).val() == 'cmt') {
			$("#colorb").show();
			$("#delay").show();
			$("#repeat").show();
			$("#length").show();
		}
	});
});