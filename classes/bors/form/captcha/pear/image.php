<?php

class bors_form_captcha_pear_image extends bors_forms_element
{
	static function html($params, &$form = NULL)
	{
		require_once 'Text/CAPTCHA.php';

		$width	= defval($params['width'], 200);
		$height	= defval($params['height'], 80);
		$font_size	= defval($params['font_size'], 24);

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
		$_SESSION['phrase'] = $c->getPhrase();

		// Get CAPTCHA image (as PNG)
		$png = $c->getCAPTCHAAsPNG();
		if(PEAR::isError($png))
			bors_throw(printf('Error generating CAPTCHA: %s!', $png->getMessage()));

		$file = md5(session_id()) . '.png';
		file_put_contents(config('webroot_cache_dir')."/$file", $png);
		$url = config('webroot_cache_url')."/$file";

		$form->append_attr('saver_prepare_classes', __CLASS__);

		return "<img width=\"{$width}\" height=\"{$height}\" src=\"$url\" /><br/>\n"
			.ec("<p>Введите, пожалуйста, буквы, написанные на картинке выше</p>\n")
			.ec("<input type=\"text\" name=\"captcha_phrase\" style=\"width: {$width}px\" /><br/>\n";
	}

	static function saver_prepare(&$data)
	{
		unlink(config('webroot_cache_dir').'/'.md5(session_id()) . '.png');
		session_start();
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if(isset($_POST['phrase']) && is_string($_POST['phrase'])
				&& isset($_SESSION['phrase']) && strlen($_POST['phrase']) > 0
				&& strlen($_SESSION['phrase']) > 0
				&& $_POST['phrase'] == $_SESSION['phrase'])
			{
				// false — признак того, что мы ничего не обработали и нужно отрабатывать дальше.
				// то есть проверка пройдена
				return false;
			}

			unset($_SESSION['phrase']);
			return bors_message(ec('Вы ошиблись при вводе букв, попробуйте ещё раз'));
		}

		bors_throw(ec('Не POST запрос проверки CAPTCHA!'));
	}
}
