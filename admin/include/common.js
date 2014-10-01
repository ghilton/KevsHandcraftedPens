function reload_win(){
	location.reload();
}
$(document).ready(function() {
	$("#mainchbx").click(function() {
		var checked_status = this.checked;
		var checkbox_name = this.name;
		$("input[name=" + checkbox_name + "[]]").each(function() {
			this.checked = checked_status;
		});
	});
	$("input[name='chk[]']").click(function() {
		$("#mainchbx").attr('checked', false);
	});
	setTimeout(function() {
		$('.success').fadeOut('fast');
	}, 3000);
	setTimeout(function() {
		$('.error').fadeOut('fast');
	}, 3000);
});
