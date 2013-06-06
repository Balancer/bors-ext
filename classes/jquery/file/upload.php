<?php

class jquery_file_upload extends bors_module
{
	function body_data()
	{
		$path = config('jquery.file_upload.path');
		twitter_bootstrap::load();
		bors_use("$path/css/jquery.fileupload-ui.css");
		jquery::plugin("$path/js/vendor/jquery.ui.widget.js");
		jquery::plugin("$path/js/jquery.iframe-transport.js");
		jquery::plugin("$path/js/jquery.fileupload.js");
//		jquery::plugin("$path/js/jquery.fileupload-process.js");
//		jquery::plugin("$path/js/jquery.fileupload-resize.js");
//		jquery::plugin("$path/js/jquery.fileupload-validate.js");
//		jquery::plugin("$path/js/jquery.fileupload-ui.js");


//		jquery::plugin("$path/js/main.js");

//		$attrs = blib_json::encode_jsfunc($attrs);
//		jquery::on_ready("$({$el}).typeahead($attrs)\n");

		return parent::body_data();
	}
}
