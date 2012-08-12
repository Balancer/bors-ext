$(function() {
	$("a.child_page_add").click(function(){
		$('a.child_page_add').hide("fast")
		$(this).parent().find('form.child_page_add').show("fast")
		return false;
	});
});
