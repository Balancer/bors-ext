<?php

class lcml_postpone_worker extends bors_object
{
	function execute($data)
	{
//		file_put_contents(__DIR__.'/dump.txt', print_r($data, true));
		$target = bors_load_uri($data['target']);
		if(!$target)
		{
			debug_hidden_log('__error_lcml_postpone_worker', "Can't load target ".print_r($data, true));
			return;
		}

//		config_set('lcml_cache_disable_full', true);
		config_set('lcml.postpone_full', true);

		$target->set_post_body(NULL, true);
		$target->cache_clean();
		$target->store();
		$target->body();

		$target->do_lcml_full_compile();

		$container = $target->container();
		$container->cache_clean();
		$container->set_modify_time(time(), true);
		$container->store();
	}
}
