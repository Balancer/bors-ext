<?php

bors_url_map(array(
//	'(/_bors/hactions/)(.*)/? => include(bors_)',
	'.* => bors_htdocs_loader',
));
