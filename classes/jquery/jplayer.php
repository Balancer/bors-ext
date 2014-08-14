<?php

class jquery_jplayer
{
	static function html($attrs)
	{
		$path = config('jquery.jplayer.path');
		bors_use($css="$path/skin/blue.monday/jplayer.blue.monday.css");
		$html = bors_lcml::make_use('css', $css);

		jquery::plugin($jqp="$path/js/jquery.jplayer.min.js");
		$html .= bors_lcml::make_use('jqp', $jqp);

		$mp3 = @$attrs['mp3'];
		unset($attrs['mp3']);

		$url = @$attrs['url'];
		unset($attrs['url']);

		$video = @$attrs['video'];
		unset($attrs['video']);

		$title = popval($attrs, 'title');

//		var_dump($attrs); exit();

		$id = md5(rand());

		$control_css_class = 'jp-audio';
		$toggles = array();
		$video_play_icon = '';

		if(empty($attrs['ready']) && $mp3)
		{
			// http://www.balancer.ru/g/p3192588
			$attrs['ready'] = "function () {
			\$(this).jPlayer(\"setMedia\", {
				mp3:\"".addslashes($mp3)."\"
			})}\n";

			$attrs['play'] = "function() { \$(this).jPlayer(\"pauseOthers\")}";
			$attrs['cssSelectorAncestor'] = "#jp_container_$id";

			set_def($attrs, 'swfPath', "/_bors-3rd/opt/jQuery.jPlayer.2.4.0/js");
			set_def($attrs, 'supplied', "mp3");
			set_def($attrs, 'wmode', "window");
			set_def($attrs, 'smoothPlayBar', 'true');
			set_def($attrs, 'keyEnabled', 'true');
//			set_def($attrs, 'width', '640px');
		}
		elseif(empty($attrs['ready']) && $video)
		{
			// http://www.balancer.ru/g/p3312145
			$attrs['ready'] = "function () {
			\$(this).jPlayer(\"setMedia\", {
				{$video}:\"".addslashes($url)."\"
			})}\n";

			$attrs['play'] = "function() { \$(this).jPlayer(\"pauseOthers\")}";
			$attrs['cssSelectorAncestor'] = "#jp_container_$id";

			set_def($attrs, 'swfPath', "/_bors-3rd/bower_components/jplayer/jquery.jplayer");
			set_def($attrs, 'supplied', "flv");
			set_def($attrs, 'wmode', "window");
			set_def($attrs, 'smoothPlayBar', 'true');
			set_def($attrs, 'keyEnabled', 'true');
			set_def($attrs, 'size', array('cssClass' => 'jp-video-360p', 'width' => '640px', 'height' => '480px'));
			$control_css_class = 'jp-video';
			$toggles[] = '<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>';
			$video_play_icon = '<div class="jp-video-play"><a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a></div>';
		}

		$js_attrs = blib_json::encode_jsfunc($attrs);
//		if(config('is_developer')) { var_dump($js_attrs); exit(); }

		$ready_code = "$('#$id').jPlayer($js_attrs)";
		$html .= bors_lcml::make_use('ready', base64_encode($ready_code));

		if($title)
			$title = "<div class=\"jp-title\"><ul><li>{$title}</li></ul></div>";

		$toggles = join("\n", $toggles);

$html .= <<< __EOT__
<div class="clear">&nbsp;</div>
<div id="jp_container_$id" class="{$control_css_class}">
	<div class="jp-type-single">
		<div id="{$id}" class="jp-jplayer"></div>
		<div class="jp-gui">
			{$video_play_icon}
			<div class="jp-interface">
				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>
				<div class="jp-current-time"></div>
				<div class="jp-duration"></div>
				<div class="jp-controls-holder">
					<ul class="jp-controls">
						<li><a href="#" class="jp-play" tabindex="1">play</a></li>
						<li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
						<li><a href="#" class="jp-stop" tabindex="1">stop</a></li>
						<li><a href="#" class="jp-mute" tabindex="1" title="mute">mute</a></li>
						<li><a href="#" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
						<li><a href="#" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
					</ul>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
					<ul class="jp-toggles">
						{$toggles}
						<li><a href="#" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
						<li><a href="#" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
					</ul>
				</div>
				<div class="jp-title">
					<ul>
						<li>{$title}</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="jp-no-solution">
			<span>Update Required</span>
			To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
		</div>
	</div>
</div>
<div class="clear">&nbsp;</div>

__EOT__;

		return save_format($html);
	}
}
