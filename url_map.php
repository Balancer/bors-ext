<?php

bors_url_map(array(
	'/_bors/data/lists/\?(.+) => bors_data_lists_json(1)',
	'/_bors/data/lists/(\w+?)\.json => bors_data_lists_json(1)',
//	'(/_bors/hactions/)(.*)/? => include(bors_)',
	'.* => bors_htdocs_loader',

	'/_bors/ajax/actionmod/(.+) => bors_ajax_actionmod_actor(1)',

	'/_bors/callback/(\w+)/? => bors_external_callback(1)',
	'/_bors/act/(\w+)/(\w+)/? => bors_ext_action(1,target=2)',
//	'/_bors/act/(\w+)/? => bors_ext_action(1,NULL)',

	'/_cg/f2f/([\w\-]+\.\w+\.\w+)$ => bors_cg_f2f(1)',
));
