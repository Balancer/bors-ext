<?php

class bors_form_captcha_pear_image extends bors_forms_element
{
	static function html($params, &$form = NULL)
	{
		@unlink(config('webroot_cache_dir').'/'.md5(session_id()) . '.nocache.png');

		if(!$form)
			$form = bors_form::$_current_form;

		require_once 'Text/CAPTCHA.php';

		$width	= defval_ne($params, 'width', 200);
		$height	= defval_ne($params, 'height', 80);
		$font_size	= defval_ne($params, 'font_size', 24);

		// Set CAPTCHA options (font must exist!)
		$imageOptions = array(
			'font_size'		=> $font_size,
			'font_path'		=> '/usr/share/fonts/corefonts',
			'font_file'		=> 'cour.ttf',
			'text_color'	   => '#000000',
			'lines_color'	  => '#008888',
			'background_color' => '#ffffff',
			'antialias'			=> true,
		);

		// Set CAPTCHA options
		$options = array(
			'width' => $width,
			'height' => $height,
			'output' => 'png',
			'imageOptions' => $imageOptions
		);

		// Generate a new Text_CAPTCHA object, Image driver
		$c = Text_CAPTCHA::factory('Image');
		$retval = $c->init($options);
		if (PEAR::isError($retval))
			bors_throw(printf('Error initializing CAPTCHA: %s!', $retval->getMessage()));

		// Get CAPTCHA secret passphrase
		//TODO: доавить соль проекта
		$html = "<input type=\"hidden\" name=\"captcha_hash\" value=\"".md5($c->getPhrase())."\" />\n";

		// Get CAPTCHA image (as PNG)
		$png = $c->getCAPTCHAAsPNG();
		if(PEAR::isError($png))
			bors_throw(printf('Error generating CAPTCHA: %s!', $png->getMessage()));

		$file = md5(session_id()) . '.nocache.png';
		file_put_contents(config('cache.webroot_dir')."/$file", $png);
		$url = config('cache.webroot_url')."/$file";

		$form->append_attr('saver_prepare_classes', __CLASS__);

		return $html . "<img width=\"{$width}\" height=\"{$height}\" src=\"$url?\" /><br/>\n"
			.ec("<p>Введите, пожалуйста, буквы, написанные на картинке выше</p>\n")
			."<input type=\"text\" name=\"captcha_phrase\" style=\"width: {$width}px\" /><br/>\n";
	}

	static function saver_prepare(&$data)
	{
		unlink(config('webroot_cache_dir').'/'.md5(session_id()) . '.nocache.png');
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(!empty($data['captcha_phrase']) && md5($data['captcha_phrase']) == @$data['captcha_hash'])
			{
				// false — признак того, что мы ничего не обработали и нужно отрабатывать дальше.
				// то есть проверка пройдена
				return false;
			}

			return bors_message(ec('Вы ошиблись при вводе букв, попробуйте ещё раз'));
		}

		bors_throw(ec('Не POST запрос проверки CAPTCHA!'));
	}
}
