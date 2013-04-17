<?php

class jquery_markitup
{
	static function appear($id, $settings = 'mySettings')
	{
		template_jquery();
		$base = config('jquery.markitup.base');
		$set  = config('jquery.markitup.sets.bbcode');

		template_css("$base/skins/simple/style.css");
		template_css("$set/style.css");

		template_js_include("$base/jquery.markitup.js");
		template_js_include("$set/set.js");

		template_js("jQuery(document).ready(function() {
jQuery('$id').markItUp($settings).css('height', function() {
	var h = jQuery(this).css('line-height').match(/(\d+)(.*)/)
	return (h[1]*jQuery(this).attr('rows'))+h[2]
}) ; });");

//	jQuery('#bbcode').height(300);
	}
}
