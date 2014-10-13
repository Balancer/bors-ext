<?php

// Тестировать можно на http://admin.aviaport.wrk.ru/job/vacancies/3737/

class jquery_markitup
{
	static function appear($id, $settings = 'mySettings')
	{
		self::load();

		jquery::on_ready("
m=jQuery('$id').markItUp($settings).css('height', function() {
	var h = jQuery(this).css('line-height').match(/(\d+)(.*)/)
	return (h[1]*jQuery(this).attr('rows'))+h[2]
})
p=m.parents('td')
m.css('width', p.width())");

//	jQuery('#bbcode').height(300);
	}

	static function load()
	{
		template_jquery();
		$base = config('jquery.markitup.base');
		$set  = config('jquery.markitup.sets.bbcode');
		$set_js  = config('jquery.markitup.set.js', "$set/set.js");

		template_css("$base/skins/simple/style.css");
		template_css("$set/style.css");

		template_js_include("$base/jquery.markitup.js");
		template_js_include($set_js);
	}
}
