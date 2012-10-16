<?php

bors_url_map(array(
	'/_bors/data/lists/(\w+?)\.json => bors_data_lists_json(1)',
//	'(/_bors/hactions/)(.*)/? => include(bors_)',
	'.* => bors_htdocs_loader',
));
