<?php

bors_page::merge_template_data_array('css_list', array("/_bors-ext/css/ext.css"));

function template_jquery_cloud_zoom()
{
	// from http://www.professorcloud.com/mainsite/cloud-zoom.htm
	template_css('/_bors-ext/css/jquery/cloud-zoom.css');
	template_jquery();
	template_js_post('if(!top.me_need_trafic_save) { document.write("<script src=\'/_bors-ext/js/jquery/cloud-zoom.1.0.2.min.js\'></scr"+"ipt>")}');

	// See also:
	//	http://www.nihilogic.dk/labs/mojozoom/
	//	http://www.xiper.net/collect/js-plugins/ui/zoomy.html

//	template_jquery_js_post("if(1) { $('.cloud-zoom-check').CloudZoom() }");
//	template_jquery_document_ready('$(".cloud-zoom-check").CloudZoom()');
}
