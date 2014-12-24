<?php

class bors_search_sphinx
{
	static function search($query, $params=array())
	{
		$query = trim($query);

		if(!$query)
			return false;

		$host = config('search_sphinx_host', 'localhost');
		$port = config('search_sphinx_port', 9312);

		$indexes = popval($params, 'indexes', '*');

		$filtervals = array();
		$distinct = "";

		static $instance = false;

		if(!$instance || empty($params['persistent_instance']))
			$cl = $instance = new SphinxClient();
		else
			$cl = $instance;

		$cl->SetServer($host, $port);
		$cl->SetConnectTimeout(1);

		if($weights = popval($params, 'field_weights'))
			$cl->SetFieldWeights($weights);

		if($weights = popval($params, 'index_weights'))
			$cl->SetIndexWeights($weights);

		if($is_exact = popval($params, 'exactly'))
			$cl->SetMatchMode (SPH_MATCH_PHRASE);
		else
			$cl->SetMatchMode (SPH_MATCH_ALL);

        switch(popval($params, 'mode'))
        {
            case 'e':
            case '1':
                $cl->SetMatchMode(SPH_MATCH_PHRASE);
                break;
            case 'b':
            case 'bool':
                $cl->SetMatchMode(SPH_MATCH_BOOLEAN);
                break;
            case 'x':
                $cl->SetMatchMode(SPH_MATCH_EXTENDED);
                break;
            case 'a':
            case 'any':
                $cl->SetMatchMode(SPH_MATCH_ANY);
                break;
            default:
                $cl->SetMatchMode(SPH_MATCH_ALL);
                break;
        }

//		$page = defval($params, 'page', 1)-1;
//		$per_page = defval($params, 'per_page', 50);
		$limit = popval($params, 'limit', '50');
//		$cl->SetLimits($page * $per_page, $per_page, config('search_sphinx_max_matches', 5000));
		$cl->SetLimits(0, $limit, config('search_sphinx_max_matches', 5000));

//	$cl->SetMaxQueryTime(bors()->user() ? 10000 : 3000);

		switch(popval($params, 'sort_order'))
		{
			case 'c':
				$cl->SetSortMode(SPH_SORT_ATTR_DESC, 'create_time');
				break;
			case 'u': // От обновлённых
				$cl->SetSortMode(SPH_SORT_ATTR_DESC, 'modify_time');
				break;
			case 'co':
				$cl->SetSortMode(SPH_SORT_ATTR_ASC, 'create_time');
				break;
			case 'r':
				$cl->SetSortMode(SPH_SORT_RELEVANCE);
			case 't':
			default:
				$cl->SetSortMode(SPH_SORT_TIME_SEGMENTS, 'create_time');
				break;
		}

		$target_classes = popval($params, 'target_classes', array());

		$only_objects = popval($params, 'only_objects');

		$filters = popval($params, 'filter');
		if(!$filters)
			$filters = $params;

//		var_dump($filters);

		if($filters)
		{
			// Фильтры, оказывается, работают с массивами.
			foreach($filters as $name => $val)
			{
				if(preg_match('/^(\w+)<>$/', $name, $m))
					$cl->SetFilter($m[1], array($val), true);
				elseif(preg_match('/^(\w+) NOT IN$/', $name, $m))
				{
//					foreach($val as $id)
					{
//						echo "{$m[1]}<>$id<br/>\n";
						$cl->SetFilter($m[1], $val, true);
					}
				}
				else
					$cl->SetFilter($name, array($val));
			}
		}

//	if($this->u())
//	{
//		$user = objects_first('forum_user', array('username' => $this->u()));
//		if($user)
//		$cl->SetFilter('owner_id', array($user->id()));
//	}

//	if($this->t())
//		$cl->SetFilter('topic_id', array(intval($this->t())));

//	echo $cl->GetSortMode();

//	$ranker = SPH_RANK_PROXIMITY_BM25;
//	$ranker = SPH_RANK_BM25;
//	$ranker = SPH_RANK_NONE;
//	$cl->SetRankingMode($ranker);

//	$cl->SetArrayResult(true);

//var_dump($query);
		$res = $cl->Query(dc($query), $indexes);

//		var_dump($res);

		$data = array();

		$data['q'] = $query;
		$data['res'] = &$res;
		$data['total'] = $res['total'];

		if($res === false)
			echo $data['error'] = $cl->GetLastError();
		else
		{
			if ( $cl->GetLastWarning() )
				$data['warning'] = $cl->GetLastWarning();

			if(empty($res['matches']))
				return false;

			$objects = array();

			foreach($res['matches'] as $x)
			{
				if(($object = object_load($x['attrs']['class_id'], $x['attrs']['object_id'])))
				{
					if(!$target_classes || in_array($object->class_name(), $target_classes))
					{
						$object->set_search_weight($x['weight'], false);
						$objects[] = $object;
					}
				}
				else
					bors_debug::syslog('search_warning', "Unknown object {$x['attrs']['class_id']}({$x['attrs']['object_id']}) in query {$query}($indexes)");
			}

			if($only_objects)
				return $objects;

			$docs = array();
			$loop = 0;
			foreach($objects as $x)
			{
				if(!($source = $x->get('snipped_source')))
					$source = join("<br/>\n", array($x->get('description'), $x->get('source')));

				$docs[$loop] = dc(strip_tags($source));
				$docs_map[$loop] = $x;
				$loop++;
			}

			if($docs)
			{
				$opts = array (
					'before_match'		=> '<b>',
					'after_match'		=> '</b>',
					'chunk_separator'	=> ' ... ',
					'limit'				=> config('search_snippet_length', 500),
					'around'			=> 5,
 				);

				$opts['exact_phrase'] = $is_exact;

				$exc = $cl->BuildExcerpts($docs, 'news', dc($query), $opts);

				if (!$exc)
					$data['error'] = $cl->GetLastError();
				else
				{
					$loop = 0;
					foreach($exc as $s)
					{
						$obj = $docs_map[$loop];
						$obj->set_snipped_body(ec($exc[$loop]), false);
						$loop++;
					}
				}
			}

			$data['objects'] = $objects;

			return $data;
		}

		return false;
	}
}
