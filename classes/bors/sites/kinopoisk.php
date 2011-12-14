<?php

class bors_sites_kinopoisk extends bors_object
{
	function loaded()
	{
		if($this->__havefc())
			return $this->__lastc();

		$film_id = $this->id();
		$url = "http://www.kinopoisk.ru/level/1/film/{$film_id}/";
		$data = array(
			'kinopoisk_film_id' => $film_id,
			'kinopoisk_url' => $url,
		);

		$page = bors_lib_http::get_cached($url);

		if(preg_match('!<h1 style="margin: 0; padding: 0" class="moviename\-big"[^>]*>(.+?)</h1>!', $page, $m))
			$data['title'] = html_decode($m[1]);

		if(preg_match('!<span style="color: #666; font\-size: 13px">(.+?)</span>!', $page, $m))
			$data['original_title'] = html_decode($m[1]);
		if(preg_match('!itemprop="alternativeHeadline">(.+?)</span>!', $page, $m))
			$data['original_title'] = html_decode($m[1]);

		if(preg_match('!<table class="info">(.+?)</table>!s', $page, $t))
		{
			foreach(explode("</tr>", $t[1]) as $r)
			{
				if(preg_match('!<tr>[^<]*<td class="type"\s*>(.+?)</td>[^<]*<td[^>]*>(.+?)</td>!s', $r, $m))
					$data[$m[1]] = html_decode($m[2]);
			}
		}

		$roles = array();
		if(preg_match('!В главных ролях:</span>(.*?)(</td>|<span class="title">)!s', $page, $t))
		{
			foreach(explode("\n", $t[1]) as $r)
			{
				if(preg_match('!>(.*?)</a>!', $r, $m))
					$roles[] = html_decode($m[1]);
			}
			$data['роли'] = join(', ', $roles);
		}

		if(preg_match('!<a href="/level/\d+/film/'.$film_id.'/" class="continue"[^>]+>\s+<span>([\d\.]+)</span>!si', $page, $m))
			$data['рейтинг'] = floatVal($m[1]);
		elseif(preg_match('!<div class="div1"><a href=".+?" class="continue" style="background: url.+?; text-decoration: none">([\d\.]+)<span style=!si', $page, $m))
			$data['рейтинг'] = $m[1];
		elseif(preg_match('!<div style="color: #f60;.*?class="continue".*?xt-decoration: none">([\d\.]+)<span!si', $page, $m))
			$data['рейтинг'] = $m[1];
		elseif(preg_match('!<span>([\d\.]+)</span><span style="font:100 14px tahoma, verdana" itemprop="ratingCount">!si', $page, $m))
			$data['рейтинг'] = $m[1];

		if(preg_match('!IMDB:\s+([\d\.]+)\s+!si', $page, $m))
			$data['IMDB'] = floatVal($m[1]);

		foreach($data as $k => $v)
			$data[$k] = trim($v);

		$data['full_name'] = "{$data['title']} [".(empty($data['original_title']) ? '' : "{$data['original_title']}, ")."{$data['год']}]";

		$this->data = $data;

		return $this->__setc((bool) @$data['title']);
	}

	static function search($query, $year = NULL)
	{
		$query = urlencode(iconv('utf-8', 'windows-1251', $query));
	//	$search_page = iconv('windows-1251', 'utf-8', http_get("http://www.kinopoisk.ru/index.php?level=7&from=forma&result=adv&m_act%5Bfrom%5D=forma&m_act%5Bwhat%5D=content&m_act%5Bfind%5D=$query&m_act%5Byear%5D={$year}&m_act%5Bfrom_year%5D=&m_act%5Bto_year%5D=&m_act%5Bcountry%5D=0&m_act%5Bgenre%5D=&m_act%5Bcompany%5D=&m_act%5Bmpaa%5D=&m_act%5Bactor%5D=&m_act%5Bcast%5D=&m_act%5Bpremier_month%5D=&m_act%5Bpremier_year%5D=&m_act%5Bpremier_type%5D=&m_act%5Bbox_vector%5D=&m_act%5Bbox%5D=&m_act%5Bbox_type%5D=&m_act%5Bcontent_find%5D="));

		if($year)
			$search_page = bors_lib_http::get_cached("http://s.kinopoisk.ru/index.php?level=7&from=forma&result=adv&m_act%5Bfrom%5D=forma&m_act%5Bwhat%5D=content&m_act%5Bfind%5D=$query&m_act%5Byear%5D=$year");
		else
			$search_page = bors_lib_http::get_cached("http://s.kinopoisk.ru/index.php?first=no&kp_query=$query");

		if(preg_match('!id_film = (\d+)!', $search_page, $m))
		{
			$kinopoisk_id = intval($m[1]);
		}
//		<p class="header">Скорее всего, вы ищете:</p>...href="http://www.kinopoisk.ru/level/1/film/424266/sr/1/">Книга Илая</a> <span class="year">2009</span></p>
		elseif(preg_match('!Скорее всего, вы ищете:.+?href="http://www.kinopoisk.ru/level/1/film/(\d+)/sr/1/">([^<].+?)</a>.+?class="year">(\d{4})</span>.+?<span class="gray">(.+?)</span>!s', $search_page, $m))
		{
			$kinopoisk_id = intval($m[1]);
			echo html_decode("{$m[2]} [".($m[4] ? "{$m[4]}, " : '' ) . "{$m[3]}]? [y/n/id]").' ';
			$cho = trim(read());
			if(is_numeric($cho))
				$kinopoisk_id = $cho;
			elseif(trim($cho) != 'y')
				exit();
		}
		elseif(preg_match('!Скорее всего, вы ищете:.+?href="http://www.kinopoisk.ru/level/1/film/(\d+)/sr/1/">(.+?)</a>.+?/(\d{4})/".+?<font color="#999999">\.\.\. (.*?)</font>!s', $search_page, $m))
		{
			$kinopoisk_id = intval($m[1]);
			echo html_decode("{$m[2]} [".($m[4] ? "{$m[4]}, " : '' ) . "{$m[3]}]? [y/n/id]").' ';
			$cho = trim(read());
			if(is_numeric($cho))
				$kinopoisk_id = $cho;
			elseif(trim($cho) != 'y')
				exit();
		}
		elseif(preg_match('!Скорее всего, вы ищете:.+?href="/level/1/film/(\d+)/sr/1/">(.+?)</a>.+?class=orange>(\d{4})</a></td>!s', $search_page, $m))
		{
			$kinopoisk_id = intval($m[1]);
			echo html_decode("{$m[2]} [{$m[3]}]? [y/n/id]").' ';
			$cho = trim(read());
			if(is_numeric($cho))
				$kinopoisk_id = $cho;
			elseif(trim($cho) != 'y')
				exit();
		}
		elseif(preg_match('!Скорее всего, вы ищете:.*?<p class="pic"><a href="/level/1/film/(\d+)/sr/1/">.*?<p class="name"><a href="/level/1/film/\1/sr/1/">(.*?)</a>.*?<span class="year">(\d+)</span></p>!s', $search_page, $m))
		{
			$kinopoisk_id = intval($m[1]);
			echo html_decode("{$m[2]} [{$m[3]}]? [y/n/id]").' ';
			$cho = trim(read());
			if(is_numeric($cho))
				$kinopoisk_id = $cho;
			elseif(trim($cho) != 'y')
				exit();
		}
		else
		{
			echo "Не найдено: $search_page";
			exit();
		}

		return $kinopoisk_id;
	}
}
