<?php

bors_url_map(array(
//	'(/_bors/hactions/)(.*)/? => include(bors_)',
	'.* => bors_htdocs_loader',

	'/_bors/ajax/actionmod/(.+) => bors_ajax_actionmod_actor(1)',
));
