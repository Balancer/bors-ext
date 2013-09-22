<?php

/*
	==============================================================
	fancyBox is a tool that offers a nice and elegant way to add
	zooming functionality for images, html content and multi-media
	on your webpages.
	==============================================================

	Красивый jQ-плагин для просмтра картинок с зумом.

	http://fancyapps.com/fancybox/

	Посмотреть на тему прямых ссылок: http://wordpress.org/support/topic/plugin-easy-fancybox-display-direct-link-in-title

	Альтернативы на изучение:
	http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/#prettyPhoto
	http://habrahabr.ru/search/?q=%5Blightbox%5D&target_type=posts
	http://planetozh.com/projects/lightbox-clones/
	http://lokeshdhakar.com/projects/lightbox2/
	http://www.jacklmoore.com/colorbox/example1/
	http://codecanyon.net/item/jackbox-responsive-lightbox/full_screen_preview/3078222
	http://codecanyon.net/item/jackbox-responsive-lightbox/3078222
	http://floatboxjs.com/demo
*/

class jquery_fancybox
{
	static function load()
	{
/*
	<script type="text/javascript" src="../lib/jquery-1.9.0.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="../lib/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="../source/jquery.fancybox.js?v=2.1.4"></script>
	<link rel="stylesheet" type="text/css" href="../source/jquery.fancybox.css?v=2.1.4" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="../source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="../source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="../source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="../source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="../source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>
*/

		bors_use(config('bower.path').'/fancybox/source/jquery.fancybox.css');
		jquery::plugin(config('bower.path').'/fancybox/lib/jquery.mousewheel-3.0.6.pack.js');
		jquery::plugin(config('bower.path').'/fancybox/source/jquery.fancybox.js');

//		bors_use(config('bower.path').'/fancybox/source/helpers/jquery.fancybox-buttons.css');
//		jquery::plugin(config('bower.path').'/fancybox/source/helpers/jquery.fancybox-buttons.js');

		bors_use(config('bower.path').'/fancybox/source/helpers/jquery.fancybox-thumbs.css');
		jquery::plugin(config('bower.path').'/fancybox/source/helpers/jquery.fancybox-thumbs.js');
	}

	static function appear($el, $attrs)
	{
		self::load();

		$attrs = blib_json::encode_jsfunc($attrs);
//		var_dump($attrs);
		jquery::on_ready("$({$el}).fancybox($attrs)\n");
	}

	static function appear_all($attrs = array())
	{
		self::load();

		$attrs['helpers'] = array(
			'title' => array('type' => 'outside'),
			'thumbs' => array(
				'width' => 50,
				'height' => 50,
			),
		);

		$jsattrs = blib_json::encode_jsfunc($attrs);
		// Пример применения на все картинки: http://jsfiddle.net/bG4gR/
		// $("a[href$='.jpg'],a[href$='.png'],a[href$='.gif']").attr('rel', 'gallery').fancybox();
//		jquery::on_ready("$(\"a[href\$='.jpg'],a[href\$='.png'],a[href\$='.gif']\").attr(\"rel\", \"gallery\").fancybox(".($attrs?$jsattrs:'').")", $attr);
		jquery::on_ready("$('.thumbnailed-image-link').attr(\"rel\", \"gallery\").fancybox(".($attrs?$jsattrs:'').")");
	}
}
